#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <signal.h>
#include <sys/types.h>
#include <sys/wait.h>

#include "tree.h"
#include "proc-common.h"

typedef struct tree_node tree_node;

void make_tree(tree_node* node, int x) {
	int status, i;
	int chp[node->nr_children];

	for (i = 0; i < node->nr_children; i++) {
		chp[i] = fork();
		if (chp[i] < 0) {
			perror("fork");
			exit(1);
		}
		if (chp[i] == 0) {
			change_pname(node->children[i].name);
			make_tree(&node->children[i], x+1);
		//	exit(1);
		}
	}
	
	wait_for_ready_children(node->nr_children);
	raise(SIGSTOP);
//	printf("%s process with pid = ", node->name);
//	printf("%d starting...\n", getpid());
	for (i = 0; i < node->nr_children; i++) {
		kill(chp[i], SIGCONT);
		printf("%d woke %d\n", getpid(), chp[i]);
		chp[i] = wait(&status);
		explain_wait_status(chp[i], status);
	}
	exit(0);
}

int main(int argc, char *argv[]) {
	pid_t pid;
	int status;
	struct tree_node *root;

	if (argc < 2){
		fprintf(stderr, "Usage: %s <tree_file>\n", argv[0]);
		exit(1);
	}

	root = get_tree_from_file(argv[1]);
	pid_t root_pid = getpid();
	pid = fork();
	if (pid < 0) {
		perror("main: fork");
		exit(1);
	}
	if (pid == 0) {
		change_pname(root->name);
		make_tree(root, 0);
		exit(1);
	}

	wait_for_ready_children(1);
	show_pstree(pid);
	kill(pid, SIGCONT);

	wait(&status);
	explain_wait_status(pid, status);

	return 0;
}
