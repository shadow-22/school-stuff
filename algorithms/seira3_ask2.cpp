#include <iostream>  
#include <stdlib.h>  
#include <algorithm>  
#include <climits>  
#include <vector>  
  
using namespace std;  
  
struct subset {  
    int parent, rank;  
};  
  
struct edge {  
    int src, dst, wt;  
};  
  
struct input_pair {  
    int src, dst;  
};  
  
typedef struct edge edge;  
typedef struct input_pair input_pair;  
  
int N, M, Q;  
edge *roads;  
input_pair *pairs;  
struct subset *subsets;  
int idx = 0;  
  
int min_max = 0;  
int **distance_arr;  
  
// to check if this edge is included in the mst  
bool *edge_check;   
  
void read_input() {  
    cin >> N >> M;    
    roads = (edge*)malloc(M * sizeof(edge));  
      
    for (int i = 0; i < M; i++) {  
        cin >> roads[i].src;  
        cin >> roads[i].dst;  
        cin >> roads[i].wt;  
    }  
      
    cin >> Q;  
    pairs = (input_pair*)malloc(Q * sizeof(input_pair));  
      
    for (int i = 0; i < Q; i++) {  
        cin >> pairs[i].src;  
        cin >> pairs[i].dst;  
    }  
}  
  
bool mycmp(edge a, edge b) {  
    return (a.wt < b.wt);  
}  
  
int find(struct subset subsets[], int i) {  
    if (subsets[i].parent != i)  
        subsets[i].parent = find(subsets, subsets[i].parent);  
    return subsets[i].parent;  
}  
  
void Union(struct subset subsets[], int x, int y) {  
    int xroot = find(subsets, x);  
    int yroot = find(subsets, y);  
  
    if (subsets[xroot].rank < subsets[yroot].rank)  
        subsets[xroot].parent = yroot;  
    else if (subsets[xroot].rank > subsets[yroot].rank)  
        subsets[yroot].parent = xroot;  
    else {  
        subsets[yroot].parent = xroot;  
        subsets[xroot].rank++;  
    }  
}  
  
int count_edges = 0;  
  
void Kruskal() {  
    // allocate the necessary memory for the sets  
    subsets = (struct subset*)malloc(N * sizeof(subset));  
  
    // initiliaze index of roads  
    // count connected edges for mst  
    idx = 0;  
  
    // initialize subsets  
    for (int i = 0; i < N; i++) {  
        subsets[i].parent = i;  
        subsets[i].rank = 0;  
    }  
  
    // Kruskal's algorithm  
    while (count_edges < N-1 && idx < M) {  
        int xroot = find(subsets, roads[idx].src-1);  
        int yroot = find(subsets, roads[idx].dst-1);  
  
        if (xroot != yroot) {  
            edge_check[idx] = true;  
            count_edges++;  
            Union(subsets, xroot, yroot);  
        }  
        idx = idx + 1;  
    }  
  
    free(subsets);  
}  
  
void addEdge(vector <pair<int, int> > adj[], int u, int v, int wt) {  
    adj[u].push_back(make_pair(v, wt));  
    adj[v].push_back(make_pair(u, wt));  
}  
  
void DFSUtil(int u, vector<pair<int, int> > adj[], vector<bool> &visited, int x) {  
    visited[u] = true;  
    distance_arr[u][u] = 0;  
    for (int i = 0; i < adj[u].size(); i++) {  
        if (visited[adj[u][i].first] == false) {  
            if (adj[u][i].second > min_max)  
                min_max = adj[u][i].second;  
            distance_arr[x][adj[u][i].first] = min_max;  
            distance_arr[adj[u][i].first][x] = min_max;  
            DFSUtil(adj[u][i].first, adj, visited, x);  
            min_max = distance_arr[x][adj[u][i].first];  
        }  
    }  
}  
  
void DFS(vector<pair<int, int> > adj[]) {  
    for (int x = 0; x < N; x++) {  
        vector<bool> visited(N, false);  
        for (int u = x; u < N; u++) {  
            min_max = 0;  
            if (visited[u] == false) {  
                DFSUtil(u, adj, visited, x);  
            }  
        }  
    }  
}  
  
void print_output() {  
    for (int i = 0; i < Q; i++) {  
        cout << distance_arr[pairs[i].src-1][pairs[i].dst-1] << endl;  
    }  
}  
  
int main(int argc, char** argv) {  
    read_input();  
    sort(roads, roads+M, mycmp);      
  
    edge_check = (bool*)malloc(M * sizeof(bool));  
  
    for (int i = 0; i < M; i++)  
        edge_check[i] = false;  
  
    distance_arr = (int**)malloc(N * sizeof(int*));  
  
    for (int i = 0; i < N; i++)  
        distance_arr[i] = (int*)malloc(N * sizeof(int));  
  
    for (int i = 0; i < N; i++) {  
        for (int j = 0; j < N; j++)  
            distance_arr[i][j] = 0;  
    }  
  
    Kruskal();  
  
    vector<pair<int, int> > adj[N];  
  
    int count = 0;  
    for (int i = 0; i < M; i++) {  
        if (edge_check[i] == true) {  
            addEdge(adj, roads[i].src-1, roads[i].dst-1, roads[i].wt);  
            count = count + 1;  
            if (count == count_edges)  
                break;  
        }  
    }  
  
    DFS(adj);  
    print_output();  
  
    return 0;  
}  
