#include <iostream>    
#include <climits>    
#include <vector>    
#include <stdlib.h>  
using namespace std;    
        
long maxProfit(/*vector<int>*/int* cost, long N, int L) {    
      
    int** profit = NULL;  
    profit = (int**)malloc((L+1) * sizeof(int*));  
      
    for (int i = 0; i < L+1; i++)   
        profit[i] = (int*)malloc((N+1) * sizeof(int));  
  
    for (int i = 0; i <= L; i++) {    
        profit[i][0] = 0;    
    }    
        
    for (long j = 0; j <= N; j++) {    
        profit[0][j] = 0;    
    }    
        
    for (int i = 1; i <= L; i++) {    
        long prevDiff = LONG_MIN;    
        for (long j = 1; j < N; j++) {    
            if (prevDiff < profit[i-1][j-1]-cost[j-1])  
                prevDiff = profit[i-1][j-1]-cost[j-1];  
            if (cost[j]+prevDiff > profit[i][j-1])  
                profit[i][j] = cost[j]+prevDiff;  
            else  
                profit[i][j] = profit[i][j-1];  
        }   
    }    
        
    return profit[L][N-1];    
}    
        
int main(int argc, char* argv[]) {    
        
    long N;    
    int L;    
    cin >> N;    
    cin >> L;    
//    vector<int> cost(N);    
    int* cost = (int*)malloc(sizeof(int) * N);          
    for (long i = 0; i < N; i++) {    
        cin >> cost[i];    
    }    
            
    cout << maxProfit(cost, N, L) << endl;    
    free(cost);    
    return 0;    
}    