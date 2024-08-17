#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <string.h>

#include "proc-common.h"
#include "tree.h"

typedef struct tree_node tree_node;

void make_tree(tree_node* node, int* p) {
	int status;
	int number, number1, number2, result, i;
	int local_pipe[2];
	pid_t child_pid;

	change_pname(node->name);
	printf("process %s started...\n", node->name);
	
	if (node->nr_children == 0) {
		number = atoi(node->name);
		write(p[1], &number, sizeof(number));
		exit(50);
	}
	
	pipe(local_pipe);
	
	for (i = 0; i < node->nr_children; i++) {
		child_pid = fork();
		if (child_pid < 0) {
			perror("fork");
			exit(60);
		}
		if (child_pid == 0) {
			close(local_pipe[0]);
			make_tree(&node->children[i], local_pipe);
			exit(70);
		}
	}

	close(local_pipe[1]);
	read(local_pipe[0], &number1, sizeof(number1));
	read(local_pipe[0], &number2, sizeof(number2));
	
	wait(&status);
	wait(&status);

	if (strcmp(node->name, "*") == 0) {
		result = number1 * number2;
	}
	else if (strcmp(node->name, "+") == 0) {
		result = number1 + number2;
	}

	write(p[1], &result, sizeof(result));
	exit(0);
}

int main(int argc, char* argv[]) {
	pid_t root_pid;
	int status, result;
	int pfd[2]; // main pipe
	struct tree_node *root;
	root = get_tree_from_file(argv[1]);

	pipe(pfd);

	root_pid = fork();

	if (root_pid < 0) { // error-checking
		perror("fork error");
		exit(10);
	}
	else if (root_pid == 0) { // child
		close(pfd[0]);
		make_tree(root, pfd);
		exit(20);
	}
	
	// parent
	close(pfd[1]);
	read(pfd[0], &result, sizeof(result)); 
	printf("%d\n", result);
	
	root_pid = wait(&status);
	explain_wait_status(root_pid, status);
	return 0;
}
