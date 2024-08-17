#include <stdio.h>
#include <stdlib.h>
#include <iostream>

using namespace std;

void print_input(int* array, int size) {
    for (int i = 0; i < size; i++)
        cout << array[i] << " ";
    return;
}

int fib(int n, int B, int K, int* b_array, int* k_array) {

    unsigned int* f = new unsigned int[n+1];

    for (int i = 0; i < n+1; i++)
    	f[i] = -1;

    for (int i = 0; i < B; i++) {
        f[b_array[i]] = 0;
    }

    f[0] = 0;
    f[1] = 1;

    for (int i = 2; i <= n; i++) {
        unsigned long long sum = 0;

        if (f[i] != 0) {
            for (int j = 0; j < K; j++) {
                if (i - k_array[j] >= 0) {
                   sum = ( sum + f[i-k_array[j]] ); 
                }
            }
        }
        f[i] = sum % 1000000009;
    }

    return f[n];
}

int main(int argc, char** argv) {
    int N, K, B;

    if (argc < 2) {
    	printf("No input.\n");
    	exit(2);
    }

    FILE* fp = fopen(argv[1], "r");

    fscanf(fp, "%d", &N);
    fscanf(fp, "%d", &K);
    fscanf(fp, "%d", &B);
    
    int* k_array = new int[K];
    int* b_array = new int[B];
    
    bool check = false;
    int a = -1;
    for (int i = 0; i < K; i++) {
    	fscanf(fp, "%d", &k_array[i]);
        if (k_array[i] == N) {
          check = true;
          a = k_array[i];
        }
    }

    for (int i = 0; i < B; i++) {
    	fscanf(fp, "%d", &b_array[i]);

    	if (b_array[i] == N)  {
    		cout << 0 << endl;
    		return 1;
    	}  
    }
    
    if (check == true && a != 1)
        cout << fib(N, B, K, b_array, k_array) + 1 << endl;
    else
        cout << fib(N, B, K, b_array, k_array) << endl;
    return 0;
}   