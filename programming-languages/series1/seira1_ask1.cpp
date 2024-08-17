#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string>

using namespace std;
/*
void print_array(int *array, int size) {
    for (int i = 0; i < size; i++) {
//		cout << "array[" << i+1 << "]=" << array[i] << endl;
        cout << array[i] << " ";
    }
    cout << endl;
}
*/
int main(int argc, char** argv) {
    int size;

    if (argc < 2) {
        printf("No input.\n");
        exit(2);
    }

    FILE* fp = fopen(argv[1], "r");

//    FILE *fp = fopen("C:/Users/User/Desktop/h1000000.in", "r");
    fscanf(fp, "%d", &size);

//    unsigned long array[size];
      int *array = new int[size];

    for (int i=0; i<size; i++) {
        fscanf(fp, "%d", &array[i]);
    }
//    printf("Main: ");
//    print_array(array, size);
//    printf("Size=%d\n", size);

//    return 5;
// Making the sub-arrays...
//    unsigned long L[size];
//    unsigned long R[size];
    int *L = new int[size];
    int *R = new int[size];

    int min = array[0];
    L[0] = 0;
    int size_L = 1;

    int max = array[size-1];
    R[0] = size-1;
    int size_R = 1;

    for (int i = 1; i < size; i++) {
    	if (array[i] < min) {
    		L[size_L] = i;
    		min = array[i];
            size_L = size_L + 1;
    	}
    }
//    cout << "L: ";
//    print_array(L, size_L);
//    printf("Size_L=%d\n", size_L);

    for (int i = size-1; i >= 0; i--) {
    	if (array[i] > max) {
    		R[size_R] = i;
    		max = array[i];
    		size_R = size_R + 1;
    	}
    }
//    cout << "R: ";
//    print_array(R, size_R);
//    printf("Size_R=%d\n", size_R);

    max = 0;
    int i = 0;
    int j = size_R-1;

//    int tmp = 0;
// Main algorithm...
    while (i <= size_L-1) {
    	while ( (array[R[j]] >= array[L[i]]) && j >= 0) {
            if (R[j]-L[i] > max) {
               max = R[j] - L[i];
//               cout << "max=" << max << "----" << array[R[j]] << "->" << array[L[i]] << endl;
//               tmp = j;
            }
            j = j-1;
            if (j < 0) break;  // j<0 h j<=0 den eimai sigouros
        }
        i = i+1;
 //       if (i == size_L-1) break;
        if (j < 0) break;
 //       j = size_R-1;
    }

    cout << max;
    getchar();
    return 0;
}        