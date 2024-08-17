#include <stdio.h>
#include <unistd.h>

void zing(void) {
	char* hostname = getlogin();
	printf("What's up, %s?\n", hostname);
}

