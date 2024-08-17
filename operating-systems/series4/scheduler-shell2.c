#include <errno.h>
#include <unistd.h>
#include <stdlib.h>
#include <stdio.h>
#include <signal.h>
#include <string.h>
#include <assert.h>

#include <sys/wait.h>
#include <sys/types.h>

#include "proc-common.h"
#include "request.h"

/* Compile-time parameters. */
#define SCHED_TQ_SEC 2                /* time quantum */
#define TASK_NAME_SZ 60               /* maximum size for a task's name */
#define SHELL_EXECUTABLE_NAME "shell" /* executable for shell */

int nproc;

typedef struct process {
	int id;
	pid_t pid;
	char name[TASK_NAME_SZ];
	struct process *next;
} Process;

Process *current_process;
Process *list_head = NULL;
Process *list_tail = NULL;

void add_process_to_list(char name[], pid_t pid, int i) {
	Process *neos = (Process*)malloc(sizeof(Process));
	neos->id = i;
	neos->pid = pid;
	strcpy(neos->name, name);
	neos->next = NULL;
	
	Process* node = list_tail;
	if (node == NULL) {
		list_head = neos;
		list_tail = neos;
		return;
	}
	node->next = neos;
	list_tail = neos;
}

void remove_process_from_list(Process *ptr) {
	Process *node = list_head;

	// if first process has exited...
	if (list_head == ptr) {
		list_head = ptr->next;
		current_process = list_head;
		free(ptr);
		return;
	}

	while (node->next != ptr) {
		node = node->next;
	}

	// if last process has exited...
	if (node->next == list_tail) {
		list_tail = node;
		current_process = node->next->next;
		free(node->next);
		return;
	}

	// else if some other process has exited...
	Process* previous_node = node;
	Process* next_node = node->next->next;
	free(node->next);
	previous_node->next = next_node;
	current_process = next_node;
}

/* Print a list of all tasks currently being scheduled.  */
static void sched_print_tasks(void) {
	assert(0 && "Please fill me!");
}

/* Send SIGKILL to a task determined by the value of its
 * scheduler-specific id.
 */
static int sched_kill_task_by_id(int id) {
//	assert(0 && "Please fill me!");
//	return -ENOSYS;
	Process *proc;
	for (proc = list_head; proc != NULL; proc = proc->next) {
		if (proc->id == id) {
			kill(proc->pid, SIGTERM);
			return id;
		}
	}
	return -1;
}


/* Create a new task.  */
static void sched_create_task(char *executable) {
	pid_t p;
	if ((p = fork()) < 0) {
		perror("fork");
		exit(1);
	}
	else if (p == 0) {
		raise(SIGSTOP);
		char *newargv[] = {executable, NULL, NULL, NULL};
		char *newenviron[] = {NULL};
		execve(executable, newargv, newenviron);
		perror("execve");
		exit(1);
	}
	add_process_to_list(executable, p, ++nproc);
}

/* Process requests by the shell.  */
static int process_request(struct request_struct *rq) {
	switch (rq->request_no) {
		case REQ_PRINT_TASKS:
			sched_print_tasks();
			return 0;

		case REQ_KILL_TASK:
			return sched_kill_task_by_id(rq->task_arg);

		case REQ_EXEC_TASK:
			sched_create_task(rq->exec_task_arg);
			return 0;

		default:
			return -ENOSYS;
	}
}

/* 
 * SIGALRM handler
 */
static void sigalrm_handler(int signum) {
	kill(current_process->pid, SIGSTOP);
}

/* 
 * SIGCHLD handler
 */
static void sigchld_handler(int signum) {
	int status;
	pid_t p;
	for (;;) {
		p = waitpid(-1, &status, WUNTRACED | WNOHANG);
		if (p < 0) {
			perror("waitpid");
			exit(1);
		}
		if (p == 0) break;

		explain_wait_status(p, status);

		if (WIFEXITED(status) || WIFSIGNALED(status)) {
			if (list_head == list_tail) {
				remove_process_from_list(current_process);
				printf("PROGRAM END.\n");
				exit(0);
			}
			remove_process_from_list(current_process);
			alarm(SCHED_TQ_SEC);
			kill(current_process->pid, SIGCONT);
		}

		if (WIFSTOPPED(status)) {
			if (list_head == list_tail) {
				printf("child %d stooped due to SIGSTOP\n", p);
				alarm(SCHED_TQ_SEC);
				kill(current_process->pid, SIGCONT);
			}
			else {
				printf("child %d stopped due to SIGSTOP\n", p);
				current_process = current_process->next;
				alarm(SCHED_TQ_SEC);
				kill(current_process->pid, SIGCONT);
			}
		}
	}
}

/* Disable delivery of SIGALRM and SIGCHLD. */
static void signals_disable(void) {
	sigset_t sigset;

	sigemptyset(&sigset);
	sigaddset(&sigset, SIGALRM);
	sigaddset(&sigset, SIGCHLD);
	if (sigprocmask(SIG_BLOCK, &sigset, NULL) < 0) {
		perror("signals_disable: sigprocmask");
		exit(1);
	}
}

/* Enable delivery of SIGALRM and SIGCHLD.  */
static void signals_enable(void) {
	sigset_t sigset;

	sigemptyset(&sigset);
	sigaddset(&sigset, SIGALRM);
	sigaddset(&sigset, SIGCHLD);
	if (sigprocmask(SIG_UNBLOCK, &sigset, NULL) < 0) {
		perror("signals_enable: sigprocmask");
		exit(1);
	}
}


/* Install two signal handlers.
 * One for SIGCHLD, one for SIGALRM.
 * Make sure both signals are masked when one of them is running.
 */
static void install_signal_handlers(void) {
	sigset_t sigset;
	struct sigaction sa;

	sa.sa_handler = sigchld_handler;
	sa.sa_flags = SA_RESTART;
	sigemptyset(&sigset);
	sigaddset(&sigset, SIGCHLD);
	sigaddset(&sigset, SIGALRM);
	sa.sa_mask = sigset;
	if (sigaction(SIGCHLD, &sa, NULL) < 0) {
		perror("sigaction: sigchld");
		exit(1);
	}

	sa.sa_handler = sigalrm_handler;
	if (sigaction(SIGALRM, &sa, NULL) < 0) {
		perror("sigaction: sigalrm");
		exit(1);
	}

	/*
	 * Ignore SIGPIPE, so that write()s to pipes
	 * with no reader do not result in us being killed,
	 * and write() returns EPIPE instead.
	 */
	if (signal(SIGPIPE, SIG_IGN) < 0) {
		perror("signal: sigpipe");
		exit(1);
	}
}

static void do_shell(char *executable, int wfd, int rfd) {
	char arg1[10], arg2[10];
	char *newargv[] = { executable, NULL, NULL, NULL };
	char *newenviron[] = { NULL };

	sprintf(arg1, "%05d", wfd);
	sprintf(arg2, "%05d", rfd);
	newargv[1] = arg1;
	newargv[2] = arg2;

	raise(SIGSTOP);
	execve(executable, newargv, newenviron);

	/* execve() only returns on error */
	perror("scheduler: child: execve");
	exit(1);
}

/* Create a new shell task.
 *
 * The shell gets special treatment:
 * two pipes are created for communication and passed
 * as command-line arguments to the executable.
 */
static pid_t sched_create_shell(char *executable, int *request_fd, int *return_fd) {
	pid_t p;
	int pfds_rq[2], pfds_ret[2];

	if (pipe(pfds_rq) < 0 || pipe(pfds_ret) < 0) {
		perror("pipe");
		exit(1);
	}

	p = fork();
	if (p < 0) {
		perror("scheduler: fork");
		exit(1);
	}

	if (p == 0) {
		/* Child */
		close(pfds_rq[0]);
		close(pfds_ret[1]);
		do_shell(executable, pfds_rq[1], pfds_ret[0]);
		assert(0);
	}
	/* Parent */
	close(pfds_rq[1]);
	close(pfds_ret[0]);
	*request_fd = pfds_rq[0];
	*return_fd = pfds_ret[1];
	return(p);
}

static void shell_request_loop(int request_fd, int return_fd) {
	int ret;
	struct request_struct rq;

	/*
	 * Keep receiving requests from the shell.
	 */
	for (;;) {
		if (read(request_fd, &rq, sizeof(rq)) != sizeof(rq)) {
			perror("scheduler: read from shell");
			fprintf(stderr, "Scheduler: giving up on shell request processing.\n");
			break;
		}

		signals_disable();
		ret = process_request(&rq);
		signals_enable();

		if (write(return_fd, &ret, sizeof(ret)) != sizeof(ret)) {
			perror("scheduler: write to shell");
			fprintf(stderr, "Scheduler: giving up on shell request processing.\n");
			break;
		}
	}
}

int main(int argc, char *argv[]) {
//	int nproc;
	/* Two file descriptors for communication with the shell */
	static int request_fd, return_fd;

	/* Create the shell. */
	pid_t p;
//	p = sched_create_shell(SHELL_EXECUTABLE_NAME, &request_fd, &return_fd);
//	add_process_to_list(SHELL_EXECUTABLE_NAME, p, 0);
	/* TODO: add the shell to the scheduler's tasks */

	/*
	 * For each of argv[1] to argv[argc - 1],
	 * create a new child process, add it to the process list.
	 */

	nproc = argc-1; /* number of proccesses goes here */
	
	for (int i = 1; i < nproc; i++) {
		if ((p = fork()) < 0) {
			perror("fork");
			exit(1);
		}
		else if (p ==0) {
			raise(SIGSTOP);
			char* newargv[] = {argv[i], NULL, NULL, NULL};
			char* newenviron[] = {NULL};
			execve(argv[i], newargv, newenviron);
			perror("execve");
			exit(1);
		}
		add_process_to_list(argv[i], p, i);
	}	

	Process* node = list_head;
	while (node->next != NULL) {
		node = node->next;
	}
	node->next = list_head;

	/* Wait for all children to raise SIGSTOP before exec()ing. */
	wait_for_ready_children(nproc);

	/* Install SIGALRM and SIGCHLD handlers. */
	install_signal_handlers();

	if (nproc == 0) {
		fprintf(stderr, "Scheduler: No tasks. Exiting...\n");
		exit(1);
	}
	
	alarm(SCHED_TQ_SEC);
	current_process = list_head;
	kill(current_process->pid, SIGCONT);
	

//	shell_request_loop(request_fd, return_fd);

	/* Now that the shell is gone, just loop forever
	 * until we exit from inside a signal handler.
	 */
	while (pause())
		;
	
	/* Unreachable */
	fprintf(stderr, "Internal error: Reached unreachable point\n");
	return 1;
}
