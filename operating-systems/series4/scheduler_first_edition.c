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
#define SCHED_TQ_SEC 2     /* time quantum */
#define TASK_NAME_SZ 60    /* maximum size for a task's name */

#define MAX_PROCESS 10

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

void print_list() {
	Process* node = list_head;
	while (node != NULL) {
		printf("%d ", node->pid);
		node = node->next;
	}
	printf("\n");
}

/*
 * SIGALRM handler
 */
static void sigalrm_handler(int signum) {
	kill((current_process)->pid, SIGSTOP);
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

		if (WIFEXITED(status)/* || WIFSIGNALED(status)*/) {
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
				printf("child %d stopped due to SIGSTOP\n", p);
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

int main(int argc, char *argv[]) {
	/*
	 * For each of argv[1] to argv[argc - 1],
	 * create a new child process, add it to the process list.
	 */

	int	nproc = argc-1; /* number of proccesses goes here */

	pid_t p;
	// create child processes
	for (int i = 1; i < argc; i++) {
		if ((p = fork()) < 0) {
			perror("fork");
			exit(i);
		}
		else if (p == 0) {
			raise(SIGSTOP);
			char *newargv[] = {argv[i], NULL, NULL, NULL};
			char *newenviron[] = {NULL};
			execve(argv[i], newargv, newenviron);
			perror("execve");
			exit(1);
		}
		add_process_to_list(argv[i], p, i);
	}
	
	// link last process to first process
	Process* node = list_head;
	while (node->next != NULL)
		node = node->next;
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

	/* loop forever  until we exit from inside a signal handler. */
	while (pause())
		;

	/* Unreachable */
	fprintf(stderr, "Internal error: Reached unreachable point\n");
	return 1;
}
