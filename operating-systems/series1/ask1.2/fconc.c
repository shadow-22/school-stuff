#include <unistd.h>
#include <stdio.h>
#include <string.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <stdlib.h>

// function that writes to the destination file(fd) the contents of 
// the buffer(buff)
void doWrite(int fd, const char* buff, int len) {
    ssize_t wcnt;
    int idx = 0;
    do {
        wcnt = write(fd, buff+idx, len-idx);
        if (wcnt == -1) {
            perror("write");
            return;
        }
        idx += wcnt;
    } while (idx < len);
}

// function that writes the contents of the source file(infile) to the
// destination file(fd) using doWrite
void write_file(int fd, const char* infile) {
    int file;
    ssize_t rcnt;
    char buff[1024];
//    char filename[50] = "./";
//    strcat(filename, infile);
    file = open(infile, O_RDONLY);
    rcnt = read(file, buff, sizeof(buff)-1);
    if (rcnt == 0)
        return;
    if (rcnt == -1) {
        perror("read");
        return;
    }
    buff[rcnt] = '\0';
    doWrite(fd, buff, strlen(buff));
}

// main function
int main(int argc, char* argv[]) {
     
    int fd, oflags, mode;
    oflags = O_CREAT | O_WRONLY | O_RDONLY | O_TRUNC;
    mode = S_IRUSR | S_IWUSR;

    if (argc < 3 || argc > 4) { // wrong input
        printf("Usage: ./fconc infile1 infile2 [outfile (default:fconc.out)]\n");
        return 1;
    }
    else if (argc == 3) { // default destination
        fd = open("./fconc.out", oflags, mode);
        if (fd == -1) {
            perror("open");
            exit(1);
        }
    }
    else { // user-defined destination
//        char dest[50] = "./";
//        strcat(dest, argv[3]);
        fd = open(argv[3], oflags, mode);
        if (fd == -1) {
            perror("open");
            exit(2);
        }
    }
    
    write_file(fd, argv[1]);
    write_file(fd, argv[2]);

    return 0;
}














//****************************************************************
/*    
    if (argc = 3) {
        FILE* fp1 = open(argv[1], "r");
    }
*/  

//    printf("Hello, number of arguments is: %d\n", argc);
/*  
   for (int i = 0; i < argc; i++) {
        printf("%d: %s\n", i, argv[i]);
    }
*/ 


/*
    char first_file[30] = "./";
    strcat(first_file, argv[1]);
    char second_file[30] = "./";
    strcat(second_file, argv[2]);
    
    char buff_1[1024], buff_2[1024];
    ssize_t rcnt;
    rcnt = read(first_file, buff_1, sizeof(buff_1)-1);
    if (rcnt == 0) // end of file
        return 10;
    if (rcnt == -1) { // error
        perror("read");
        return 11;
    }
    rcnt = read(second_file, buff_2, sizeof(buff_2)-1); 
*/    
