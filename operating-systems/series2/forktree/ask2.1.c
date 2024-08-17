#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <sys/types.h>
#include <sys/wait.h>

#include "proc-common.h"

#define SLEEP_PROC_SEC 10
#define SLEEP_TREE_SEC 3

int main() {
	pid_t pidA, pidB, pidC, pidD, mypid, temp;
	pidA = pidB = pidC = pidD = mypid = temp = -100;
	int status;
	mypid = getpid();

// create node A
	pidA = fork();

	if (pidA < 0) {
		perror("error at node A");
		exit(1);
	}

// create tree with root at node A
	if (pidA == 0) {
	printf("Process A was created...\n");
	change_pname("A");
	pidB = fork();

	if (pidB < 0) {
		perror("error at node B");
		exit(2);
	}
	if (pidB == 0) {
		printf("Process B was created...\n");
		change_pname("B");
		pidD = fork();
		if (pidD < 0) {
			perror("error at node D");
			exit(3);
		}
		if (pidD == 0) {
			printf("Process D was created...\n");
			change_pname("D");
			sleep(5);
			exit(13);
		}
//		sleep(SLEEP_TREE_SEC);
		sleep(3);
		temp = wait(&status);
		explain_wait_status(temp, status);
		exit(19);
	}

// if process A is running, create also node C	
	if (pidB > 0) {
		pidC = fork();
		if (pidC < 0) {
			perror("error at node C");
			exit(2);
		}
		if (pidC == 0) {
			printf("Process C was created...\n");
			change_pname("C");
		//	show_pstree(mypid);	
			sleep(3);
			exit(17);
		}
	}

// what should process A do
//	show_pstree(mypid);
	sleep(SLEEP_TREE_SEC);
	temp = wait(&status);
	explain_wait_status(temp, status);
	sleep(SLEEP_TREE_SEC);
	temp = wait(&status);
	explain_wait_status(temp, status);
	exit(16);
	}
// what should the main program with child the node A(root of process tree) do
	sleep(1);
//	show_pstree(pidA);	
	show_pstree(getpid());
	temp = wait(&status);
	explain_wait_status(temp, status);
	return 0;
}
