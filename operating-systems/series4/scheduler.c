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
#define SCHED_TQ_SEC 2                
/* time quantum */ 
#define TASK_NAME_SZ 60               
/* maximum size for a task's name */ 
#define SLEEP_SEC 1

int nproc;
/*Queue implementation*/ 
typedef struct element { 
	pid_t pid; 
	int id; 
	struct element *next; 
} queueNode;

/*The front and the rear of our queue will be global variables*/ 
queueNode *front; 
queueNode *rear;

/*Create the new node that we will insert to the queue*/ 
queueNode *createNode(pid_t p, int i) {
	queueNode *newNode = (queueNode *) malloc(sizeof(queueNode)); 
	newNode->pid = p; 
	newNode->id = i; 
	newNode->next = NULL; 
	return newNode;
}

/*Insert a new node at the end of the linked list  
 *  
 *update rear pointer*/ 
void insertToQueue(pid_t p, int i) {
	queueNode *newNode = createNode(p, i);
	/*If queue is empty*/ 
	if ((front == NULL) && (rear == NULL)) { 
		front = newNode; rear = newNode; 
	} 
	else { 
	/*Link current list with the new node*/ 
		rear->next = newNode; 
	/*Update rear pointer*/ 
		rear = newNode; 
	}
}

/*Prints the PID of all the processes which are in the list*/ 
void printer () { 
	queueNode *current = front; 
	while (current!=NULL) { 
		printf("PID=%d  ",current->pid); 
		current=current->next; 
	} 
	printf("\n"); 
}

/*Move the First process in the list to the End of Queue (Used when (WIFSTOPPED(status))*/ 
void moveFrontToRear() { 
	queueNode *current = front; 
	front = current->next; 
	current->next=NULL; 
	rear->next = current; 
	rear = current; 
}

/*Extract from the Queue the process with pid=p (Used when (WIFEXITED(status) || WIFSIGNALED(status)) )*/ 
void extractPIDfromQueue (pid_t p) { 
	queueNode *current = front; 
	queueNode *previous = front; 
	while (current != NULL) { 
		if  (current->pid == p) { 
			if (current==front)  
				front=(front->next) ; 
			previous->next=current->next; 
			if (current==rear) 
				rear=previous; 
			free(current); 
			break;
		} 
	previous=current; 
	current = current->next;
	}
} 

/*SIGALRM handler*/ 
static void sigalrm_handler(int signum) { 
	/*assert(0 && "Please fill me!"); */ 
	if (signum != SIGALRM) { 
		fprintf(stderr, "Internal error: Called for signum %d, not SIGALRM\n",signum); 
		exit(1); 
	} 
	/*Stop currently running process, which is the one at the front of the queue*/
	if (front->next) { 
		printf("ALARM! %d seconds have passed. The child %d stops and the child %d continues\n",SCHED_TQ_SEC,front->pid,front->next->pid); 
		kill(front->pid, SIGSTOP); 
	} 
	if (alarm(SCHED_TQ_SEC) < 0) { 
		perror("alarm"); 
		exit(1); 
	} 
}

/*  *  * SIGCHLD handler *   */ 
static void sigchld_handler(int signum) { 
	/* assert(0 && "Please fill me!"); */ 
	int status; 
	pid_t p;
	if (signum != SIGCHLD) { 
		fprintf(stderr, "Internal error: Called for signum %d, not SIGCHLD\n", signum); 
		exit(1); 
	}
	for (;;) {
		p = waitpid(-1, &status, WUNTRACED | WNOHANG); 
		if (p < 0) { 
			perror("waitpid"); 
			exit(1); 
		}
		if (p==0) 
			break; 
		explain_wait_status(p, status); 

		/*If the child process was stopped then we wake up the next in line process. *  
		 *We move the first one to the rear of the queue*/ 
		if (WIFSTOPPED(status)) { 
			/* A child has stopped due to SIGSTOP/SIGTSTP, etc... */ 
			printf("Parent: Child has been stopped. Moving right along...\n"); 
			if (front==rear) { 
				continue; 
			} 
			moveFrontToRear(); 
			kill(front->pid, SIGCONT); 
			alarm(SCHED_TQ_SEC); 
		}
		/*The child process has exited so we remove this process from the queue,   
		 *and we wake up the now first in queue process*/ 
		if (WIFEXITED(status) || WIFSIGNALED(status) ) { 
			/* A child has died */ 
			printf("Parent: Received SIGCHLD, child is dead. Exiting.\n"); 
			extractPIDfromQueue (p); 
			if (front!=NULL) { 
				kill(front->pid, SIGCONT); 
				alarm(SCHED_TQ_SEC); 
			} 
			else { 
				printf("All the processes have finished their job. Exit to the parent!\n");
				exit(0);
			}
		}
	}
}


/* Install two signal handlers. 
 * One for SIGCHLD, one for SIGALRM.
 * Make sure both signals are masked when one of them is running. */ 

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
	/* Ignore SIGPIPE, so that write()s to pipes 
	 * with no reader do not result in us being killed, 
	 * and write() returns EPIPE instead. 
	 */ 
	if (signal(SIGPIPE, SIG_IGN) < 0) { 
		perror("signal: sigpipe"); 
		exit(1); 
	}
}

void initialize_child_process(char *exec) {
	char *newargv[] = { exec, NULL, NULL, NULL }; 
	char *newenviron[] = { NULL };
	printf("I am the child process with PID = %ld\n", (long)getpid()); 
	printf("About to replace myself with the executable %s...\n", exec); 
	raise(SIGSTOP); 
	execve(exec, newargv, newenviron); 
	/* execve() only returns on error */ 
	perror("execve"); 
	exit(1);
}

int main(int argc, char *argv[]) { 
	//int nproc; 
	///* * For each of argv[1] to argv[argc - 1], * create a new child process, add it to the process list. */
	//nproc = 0; /* number of proccesses goes here */ 
	int  i; 
	pid_t p;
	nproc = argc-1; /* number of proccesses goes here */
	
	if (nproc == 0) { 
		fprintf(stderr, "Scheduler: No tasks. Exiting...\n"); 
		exit(1); 
	}
	
	/*Queue Initialization*/ 
	front = NULL; 
	rear = NULL;
	
	/* For each of argv[1] to argv[argc - 1], 
	 * create a new child process, add it to the process list.*/ 
	for (i=0; i<nproc; i++) { 
		p = fork(); 
		if (p < 0) { perror("fork: error"); 
			exit(1); 
		} 
		if (p == 0) { 
			/*The child process goes to the child function*/ 
			initialize_child_process(argv[i+1]); 
			exit(1); 
		} else { 
			/*The parent inserts to the queue the new child process*/ 
			insertToQueue(p,i); 
		} 
	}
	/* Wait for all children to raise SIGSTOP before exec()ing. */ 
	wait_for_ready_children(nproc);

	/*At this point all child processes are in the queue and have raised SIGSTOP, 
	 *so they wait a SIGCONT signal to wake up.*/
	/* Install SIGALRM and SIGCHLD handlers. */ 
	install_signal_handlers();
	/*Wake up the child process in the front of the queue.*/ 
	kill(front->pid,SIGCONT);
	
	/*Set my alarm*/ 
	alarm(SCHED_TQ_SEC);
	/* loop forever  until we exit from inside a signal handler. */ 
	while (pause())
		;
	/* Unreachable */ 
	fprintf(stderr, "Internal error: Reached unreachable point\n"); 
	return 1; 
}
