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
} Process;

Process process_array[MAX_PROCESS];
Process *current_process;

void child_init(char name[], int i) {
	process_array[i].id = i;
	process_array[i].pid = getpid();
	strcpy(process_array[i].name, name);
}

void child(char name[]) {
	raise(SIGSTOP);
	char *newargv[] = {name, NULL, NULL, NULL};
	char *newenviron[] = {NULL};
	execve(name, newargv, newenviron);
	perror("execve");
	exit(1);
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
		if (WIFEXITED(status) || WIFSIGNALED(status)) {
			if (count-exited == nproc) {
				printf("No more processes...Exiting..\n");
				exit(0);
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
	int nproc;
	/*
	 * For each of argv[1] to argv[argc - 1],
	 * create a new child process, add it to the process list.
	 */

	nproc = argc-1; /* number of proccesses goes here */
	
	pid_t p;
	// create child processes
	for (int i = 1; i <= argc; i++) {
		if (p = fork() < 0) {
			perror("fork");
			exit(i);
		}
		else if (p == 0) {
			child_init(argv[i], i);
			child(argv[i]);
		}
	}

	/* Wait for all children to raise SIGSTOP before exec()ing. */
	wait_for_ready_children(nproc);

	/* Install SIGALRM and SIGCHLD handlers. */
	install_signal_handlers();

	if (nproc == 0) {
		fprintf(stderr, "Scheduler: No tasks. Exiting...\n");
		exit(1);
	}
	
	alarm(SCHED_TQ_SEC);
	current_process = &process_array[1];
	kill(current_process->pid, SIGCONT);

	/* loop forever  until we exit from inside a signal handler. */
	while (pause())
		;

	/* Unreachable */
	fprintf(stderr, "Internal error: Reached unreachable point\n");
	return 1;
}
