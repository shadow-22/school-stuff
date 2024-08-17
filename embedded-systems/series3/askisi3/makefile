test1: string_manipulation
	./string_manipulation rand_str_input_first
	./string_manipulation rand_str_input_sec

string_manipulation: string_manipulation.o strcat.o strcmp.o strlen.o strcpy.o
	gcc string_manipulation.o strcat.o strcmp.o strlen.o strcpy.o -o string_manipulation

string_manipulation.o: string_manipulation.c
	gcc -g -c string_manipulation.c

strcat.o: strcat.s
	gcc -g -c strcat.s

strcmp.o: strcmp.s
	gcc -g -c strcmp.s

strcpy.o: strcpy.s
	gcc -g -c strcpy.s

strlen.o: strlen.s
	gcc -g -c strlen.s
