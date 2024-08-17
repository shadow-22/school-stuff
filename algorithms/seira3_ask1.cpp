#include <iostream>  
#include <stdlib.h>  
#include <stdio.h>  
#include <vector>  
#include <climits>  
  
//#define INF 0x3f3f3f3f  
#define INF INT_MAX  
  
using namespace std;  
  
typedef struct edge {  
    int src, dst, wt;  
} edge;  
edge *edges;  
  
typedef struct stack_pair {  
    int src, dst;  
} stack_pair;  
stack_pair *pairs;  
  
int N, M, Q, K;  
  
unsigned long long **dist;  
int **count_paths;  
  
void read_input() {  
    cin >> N >> M >> Q >> K;  
  
    dist = (unsigned long long**)malloc(N * sizeof(unsigned long long*));  
    count_paths = (int**)malloc(N * sizeof(int*));  
    for (int i = 0; i < N; i++) {  
        dist[i] = (unsigned long long*)malloc(N * sizeof(unsigned long long));  
        count_paths[i] = (int*)malloc(N* sizeof(int));  
    }  
  
    for (int i = 0; i < N; i++) {  
        for (int j = 0; j < N; j++) {   
            dist[i][j] = INF;  
            count_paths[i][j] = 0;  
            if (i == j)  
                dist[i][j] = 0;   
        }  
    }  
  
    edges = (edge*)malloc(M * sizeof(edge));  
  
    for (int i = 0; i < M; i++) {  
        cin >> edges[i].src;  
        cin >> edges[i].dst;  
        cin >> edges[i].wt;  
        dist[edges[i].src-1][edges[i].dst-1] = edges[i].wt;  
        dist[edges[i].dst-1][edges[i].src-1] = edges[i].wt;   
        count_paths[edges[i].src-1][edges[i].dst-1] = 1;  
        count_paths[edges[i].dst-1][edges[i].src-1] = 1;  
    }  
      
    pairs = (stack_pair*)malloc(Q * sizeof(stack_pair));  
    for (int i = 0; i < Q; i++) {  
        cin >> pairs[i].src;  
        cin >> pairs[i].dst;  
    }  
}  
  
void FloydWarshall() {  
    for (int k = 0; k < N; k++) {  
        for (int i = 0; i < N; i++) {  
            for (int j = 0; j < N; j++) {  
                if (dist[i][j] == dist[i][k] + dist[k][j])  
                    count_paths[i][j] += count_paths[i][k] * count_paths[k][j];  
                else if (dist[i][j] > dist[i][k] + dist[k][j]) {  
                    dist[i][j] = dist[i][k] + dist[k][j];  
                    count_paths[i][j] = count_paths[i][k] * count_paths[k][j];  
                }  
            }  
        }  
    }  
}  
  
void print_arr() {  
    for (int i = 0; i < N; i++) {  
        for (int j = 0; j < N; j++)  
            cout << dist[i][j] << "\t";  
        cout << endl;  
    }  
  
    cout << endl << endl << endl;  
    for (int i = 0; i < N; i++) {  
        for (int j = 0; j < N; j++)  
            cout << count_paths[i][j] << "\t";  
        cout << endl;  
    }  
  
}  
  
int main(int arc, char** argv) {  
    read_input();  
    FloydWarshall();  
  
    for (int i = 0; i < Q; i++)  
        cout << count_paths[pairs[i].src-1][pairs[i].dst-1] << endl;  
  
    return 0;  
}  