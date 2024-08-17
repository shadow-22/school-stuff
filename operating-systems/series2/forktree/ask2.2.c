#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/wait.h>
#include "proc-common.h"
#include "tree.h"
#include <string.h>

#define SLEEP_PROC_SEC 10
#define SLEEP_TREE_SEC 3

typedef struct tree_node* tree_node_ptr;

void make_tree(tree_node_ptr node) {
	pid_t pid_node;
	int status, i, j;
	if (node->nr_children > 0) {
//		printf("%s node waiting for children to terminate...\n", node->name);
		pid_t children_pid[node->nr_children];
		for (i = 0; i < node->nr_children; i++) {
			pid_t temp = fork();
			if (temp == 0) {
//				children_pid[i] = getpid();
				printf("%s child node created...\n", node->children[i].name);
				change_pname(node->children[i].name);
				make_tree(&node->children[i]);
//				break;
				printf("%s node exiting...\n", node->children[i].name);
				exit(2); // for testing only...if doesn't work use break;
			}
		}
		printf("%s node waiting for children to terminate...\n", node->name);	
		for (j = 0; j < node->nr_children; j++) {
			pid_node = wait(&status);
			explain_wait_status(pid_node, status);
		}
		printf("%s node exiting...\n", node->name);
		exit(10);
	}
	else {
		printf("%s node sleeping...\n", node->name);
		sleep(5);
		return;
	}
}

int main(int argc, char* argv[]) {
	struct tree_node *root;
	pid_t pid_node, root_pid;
	int status;

	if (argc != 2) {
		fprintf(stderr, "Usage: %s <input_tree_file>\n\n", argv[0]);
		exit(1);
	}
	
	root = get_tree_from_file(argv[1]);	
	root_pid = fork();
	if (root_pid == 0) {
		printf("%s node created...\n", root->name);
		change_pname(root->name);
		make_tree(root);
		printf("%s node exiting...\n", root->name);
		exit(0);
	}
	sleep(2); 			// vale 5 edw kai 10 sto return twn leaf kai douleui
//	printf("\n***************************\n\n");
	show_pstree(root_pid); 		// show tree
	printf("\n***************************\n");
	pid_node = wait(&status);
	explain_wait_status(pid_node, status);
	return 0;
}
