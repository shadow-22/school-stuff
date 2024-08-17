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

/*Queue implementation*/ 
typedef struct element {        
        pid_t pid;        
        int id;        
        char *name;        
        struct element *next; 
} queueNode;
/*The front and the rear of our queue will be global variables*/ 
queueNode *front; 
queueNode *rear;

/*Create the new node that we will insert to the queue*/ 
queueNode *createNode(pid_t p, int i, char *name) {
        queueNode *newNode = (queueNode *) malloc(sizeof(queueNode));
        newNode->pid = p;        
        newNode->id = i;        
        newNode->name = strdup(name);        
        newNode->next = NULL;
        return newNode; 
}

/*Insert a new node at the end of the linked list 
 *  *update rear pointer*/ 
void insertToQueue(pid_t p, int i, char *name) {
        queueNode *newNode = createNode(p, i, name);        
        /*If queue is empty*/        
        if ((front == NULL) && (rear == NULL)) {                
        	front = newNode;                
        	rear = newNode;        
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

void child(char *exec) {
        char *newargv[] = { exec, NULL, NULL, NULL };        
        char *newenviron[] = { NULL };
        printf("I am the child process with PID = %ld\n", (long)getpid());        
        printf("About to replace myself with the executable %s...\n", exec);        
        raise(SIGSTOP);        
        execve(exec, newargv, newenviron);        /* execve() only returns on error */       
        perror("execve");        
        exit(1); 
}

/*BUTTON p*/ 
/* Print a list of all tasks currently being scheduled.  */        
static void sched_print_tasks(void) {        
        //assert(0 && "Please fill me!");        
        queueNode *current = front;        
        printf("\nThe current tasks are:\n");
        while (current!=NULL) {                
                printf("[Task with NAME = %s ID = %d and PID = %d] -> ", current->name, current->id, current->pid);                
                current=current->next;        
        }        
        /*The currently running process is always the one at the front of the queue.*/        
        printf("\nThe current running task is the one with NAME = %s ID = %d and PID = %d \n ", front->name, front->id, front->pid); 
}

/*Helps Button k: Returns the PID of the process with a given id*/ 
pid_t searchID (int id) {        
        queueNode *current = front;        
        while (current != NULL) {                
                if  (current->id == id) {                        
                        return (current->pid);                
                }                
                        current = current->next;        
        }        
        return -1; 
}

/*BUTTON k*/ 
/* Send SIGKILL to a task determined by the value of its scheduler-specific id.*/ 
static int sched_kill_task_by_id(int id) {        
        // assert(0 && "Please fill me!");        
        //         return -ENOSYS;
        if (id == 0) { 
        //kill the shell                
                printf("I am killing myself!\n");                
                pid_t p=searchID(id);                
                kill(p, SIGKILL);                
                return(0);        
        }        
        pid_t p=searchID(id);        
        if (p==-1) {                
                printf("There is no task with id = %d", id);                
                return -1;        
        }        
        kill(p, SIGKILL);        
        return 0;
}

/*BUTTON e*/ 
/* Create a new task.  */ 
static void sched_create_task(char *executable) {        
        // assert(0 && "Please fill me!");        
        pid_t p;
        p = fork();        
        if (p < 0) {                
                perror("fork: error");                
                exit(1);        
        }   

        if (p == 0) {                
        	/*The child process goes to the child function*/                
        	child(executable);                
        	exit(1);        
        } 
		else {                
        	/*The parent inserts to the queue the new child process*/                
        	char name[60];                
        	strcpy(name, executable);                
        	insertToQueue(p, nproc, name);                
        	nproc++;
        } 
} 

/*Move to the End of Queue the process with pid=p (Used when (WIFSTOPPED(status))*/ 
void movePIDtoRear (pid_t p) {        
        queueNode *current = front;        
        queueNode *previous = front;    
        //The previous pointer        
        if (front!=rear) {                
        	while (current != NULL) {                        
                	if  (current->pid == p) {                                
                	/*Change the Front pointer if the first process in the list is moved to the End of Queue*/                                
                    	    if (current==front)  
                        	        front=(front->next) ;                            
                	/*Do not change the previous pointer of the process,if it is in the End of Queue (so it won't be moved)*/       
							if (current!=rear) {                                        
								previous->next=current->next;                                        
								current->next=NULL;                                        
								rear->next=current;                                        
								rear=current;                                
				   			}                                
							break;                        
					}                        
					previous=current;                        
					current = current->next;                
			}        
		} 
}

/*Extract from the Queue the process with pid=p (Used when (WIFEXITED(status) || WIFSIGNALED(status)) )*/
void extractPIDfromQueue ( pid_t p) {        
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

static void sigalrm_handler(int signum) {        
        //assert(0 && "Please fill me!");        
        if (signum != SIGALRM) {                
                fprintf(stderr, "Internal error: Called for signum %d, not SIGALRM\n",signum);                
                exit(1);        
        }        
        /* Stop currently running process,                 
		 * which is the one at the front of the queue*/
        if (front) {                 
                if ((front->id)!=0)                        
                        printf("ALARM! %d seconds have passed. The child %d stops.\n",SCHED_TQ_SEC,front->pid);                
                kill(front->pid, SIGSTOP);                
                alarm(SCHED_TQ_SEC);        
        }
}

/*     SIGCHLD handler    */ 
static void sigchld_handler(int signum) {        
        //assert(0 && "Please fill me!");        
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
                if (p == 0)             
                        break;                
                if ((front->id)!=0)                        
                        explain_wait_status(p, status);
                if (WIFSTOPPED(status)) {                        
                        /* A child has stopped due to SIGSTOP/SIGTSTP, etc... */                        
                        if ((front->id)!=0)                                
                                printf("Parent: Child has been stopped. Moving right along...\n");                        
                        movePIDtoRear(p);                        
                        kill(front->pid, SIGCONT);                }
                if (WIFEXITED(status) || WIFSIGNALED(status)) {                        
                /* A child has died */                        
                        printf("Parent: Received SIGCHLD, child is dead. Exiting.\n");
                        extractPIDfromQueue(p);                        
                        if (front != NULL) {                                
                                kill(front->pid, SIGCONT);                                
                                if  (WIFEXITED(status) ) {                                        
                                        alarm(SCHED_TQ_SEC);                                
                                }                        
                        }                        
                        else {                                
                                printf("All the processes have finished their job. Exit to the parent!\n");                                
                                exit(0);                        
                        }                
                }
        }
} 

/* print help */ 
void help(void) {        
        printf(" ?: print help\n"  
                " q: quit\n" 
                " p: print tasks\n" 
                " k <id> : kill task identified by id\n" 
                " e <program>: execute program\n" 
                " h <id>: set task identified by id to high priority\n"                        
                " l <id>     : set task identified by id to low priority\n"); 
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
        /*         
        * Ignore SIGPIPE, so that write()s to pipes         
        * with no reader do not result in us being killed,         
        * and write() returns EPIPE instead.         */        
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
* as command-line arguments to the executable. */      

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
        return p; 
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
        //int nproc;        
        /* Two file descriptors for communication with the shell */        
        static int request_fd, return_fd;        
        int i ;
        front = NULL;        
        rear = NULL;
        nproc = argc-1; /* number of proccesses goes here */
        /* Create the shell. */        
        pid_t p = sched_create_shell(SHELL_EXECUTABLE_NAME, &request_fd, &return_fd);
        /* We add the shell to the scheduler's queue*/        
        nproc ++;        
        /*We assume that the shell is the task with id = 0*/        
        insertToQueue(p,0,"shell");
        /*         
        *       
        * For each of argv[1] to argv[argc - 1],         
        *               
        * create a new child process, add it to the process list.         
        *                       
        */        
        for (i=1; i<nproc; i++) {                
                p = fork();                
                if (p < 0) {                        
                        perror("fork: error");                        
                        exit(1);                
                }
                if (p == 0) {                        
                /*The child process goes to the child function*/                        
                child(argv[i]);                        
                exit(1);                
                } else {                        
                /*The parent inserts to the queue the new child process*/                        
                        insertToQueue(p,i,argv[i]);                
                }        
        }
        /* Wait for all children to raise SIGSTOP before exec()ing. */        
        wait_for_ready_children(nproc);
        /* Install SIGALRM and SIGCHLD handlers. */        
        install_signal_handlers();
/*      if (nproc == 0) {                
                fprintf(stderr, "Scheduler: No tasks. Exiting...\n");                
                exit(1);        
        } 
*/        

        /*At this point the shell process which is the only one in the scheduler's queue         
        *      
        * has raised SIGSTOP.*/
        /*Wake up the child process in the front of the queue, which is the shell.*/                
        kill(front->pid,SIGCONT);
        alarm(SCHED_TQ_SEC);        
        shell_request_loop(request_fd, return_fd);
        /* Now that the shell is gone, just loop forever         * until we exit from inside a signal handler.         */        
        while (pause())                
                ;
        /* Unreachable */        
        fprintf(stderr, "Internal error: Reached unreachable point\n");        
        return 1; 
}
