// http://www.geeksforgeeks.org/dials-algorithm-optimized-dijkstra-for-small-range-weights/

#include <iostream>
#include <list>
#include <vector>
#include <stdio.h>
#include <stdlib.h>

using namespace std;
# define INF 0x3f3f3f3f

long previous[2000001];
char symbol[2000001];

class Graph
{
    int V;  
    list< pair<int, int> > *adj;
 
public:
    Graph(int V);  
    void addEdge(int u, int v, int w);
    void shortestPath(int s, int W, int e, int count);
    void print_recursive(long i, int count);
};

void Graph::print_recursive(long i, int count) {
    if (symbol[i]=='L' || symbol[i]=='R' || symbol[i]=='U' || symbol[i]=='D' || symbol[i]=='W') {
        print_recursive(previous[i], count); 
        cout << symbol[i];
    }
} 

Graph::Graph(int V)
{
    this->V = V;
    adj = new list< pair<int, int> >[V];
}
 
void Graph::addEdge(int u, int v, int w)
{
    adj[u].push_back(make_pair(v, w));
    adj[v].push_back(make_pair(u, w));
}
 
void Graph::shortestPath(int src, int W, int end, int count)
{
    vector<pair<int, list<int>::iterator> > dist(V);
 
    for (int i = 0; i < V; i++)
        dist[i].first = INF;
 
    list<int> *B = new list<int>[W * V + 1];
    
    B[0].push_back(src);
    dist[src].first = 0;
 
    int idx = 0;
    while (1)
    {
        while (B[idx].size() == 0 && idx < W*V)
            idx++;
 
        if (idx == W*V) { 
            cout << dist[end].first << " ";  
            print_recursive(end, count);
            break;
        }
        
        int u = B[idx].front();  
        B[idx].pop_front();     

        for (auto i = adj[u].begin(); i != adj[u].end(); ++i)
        {
            int v = (*i).first;
            int weight = (*i).second;
 
            int du = dist[u].first;
            int dv = dist[v].first;
            
            if (dv > du + weight)
            {
                if (dv != INF)
                    B[dv].erase(dist[v].second);
 
                dist[v].first = du + weight;
                dv = dist[v].first;
 
                B[dv].push_front(v);
 
                dist[v].second = B[dv].begin();
                previous[v] = u;

                if (v/(count-1) > u/(count-1)) {
                  symbol[v] = 'D';
                }
                else if (v/(count-1) < u/(count-1)) {
                  symbol[v] = 'U';
                }
                else if (v > u) {
                  symbol[v] = 'R';
                }
                else if (v < u) {
                  symbol[v] = 'L';
                }
                if (v/(count-1) > (u/(count-1)+1)) {
                  symbol[v] = 'W';
                }   
                if (v/(count-1) < (u/(count-1)-1)) {
                  symbol[v] = 'W';
                }             
            }
        }
    }

}   

void print_char_array(char name[1000][1000], int x, int y) {
    for (int i=0; i<x; i++) {
        for (int j=0; j<y; j++)
            printf("myArray[%d][%d]=%c\n", i, j, name[i][j]);
    }
}
 
int main(int argc, char** argv)
{
//START: READING INPUT	
   FILE *fp;
   char tmp;
   int i, j, x, y;
   i = j = x = y = 0;
   bool first_new_line = false;
   char myArray[1002][1002];

   if (argc < 2) {
    printf("No input.\n");
    exit(1);
   }

   fp = fopen(argv[1], "r");
   while (!feof(fp)) {
    fscanf(fp, "%c", &tmp);
    myArray[i][j] = tmp;

    if (tmp == '\n' && first_new_line == false) {
      first_new_line = true;
      y = j+1;
    }

    j = j+1;

    if (tmp == '\n') {
      i = i+1;
      j = 0;
    }    
   }

   x = i+1;
   x = x-1-1;
   int count = y;
   myArray[x-1][y-1] = '\n';
//END: READING INPUT.
//**************************************************************************************************
// START: FIND SOURCE & END INDEX.
   int index = 0;
   int count_nl_source = 0;
   int count_nl_end = 0;
   int source = 0;
   int end = 0;
   bool source_found = false;
   bool end_found = false;
   
   for (int i=0; i<x; i++) {
    for (int j=0; j<count; j++) {

        if (myArray[i][j] == 'S') {
            source = index;
            source_found = true;
        }
        else if (myArray[i][j] == 'E') {
            end = index;
            end_found = true;
        }

        if (source_found == false && myArray[i][j] == '\n')
            count_nl_source = count_nl_source+1;
        
        if (end_found == false && myArray[i][j] == '\n')
            count_nl_end = count_nl_end+1;
        index = index+1; 
    }
   }
   end = end-count_nl_end;
   source = source-count_nl_source;
// END: FIND SOURCE & END INDEX.    
//***************************************************************************************************
// START: CREATE GRAPH
   int V = x*(count-1)*2;
   Graph g(V);
   index = 0;

   for (int i=0; i<x; i++) {
    for (int j=0; j<count-1; j++) {
        if (j <= count-3 && myArray[i][j] != '\n' && myArray[i][j] != 'X' && myArray[i][j+1] != 'X') {
            g.addEdge(index, index+1, 2);
              g.addEdge(index+V/2, index+V/2+1, 1);
            }
        if (myArray[i][j] == 'W') {
            g.addEdge(index, index+V/2, 1);
        }

        index = index+1;
    }
   }

   index = 0;
   for (int i=0; i<x; i++) {
    for (int j=0; j<count-1; j++) {
        if (i<=x-2 && myArray[i][j] != '\n' && myArray[i][j] != 'X' && myArray[i+1][j] != 'X') {
            g.addEdge(index, index+count-1, 2);
               g.addEdge(index+V/2, index+V/2+count-1, 1);
        }
        index = index+1;
    }
   }

   g.shortestPath(source, 2, end, count);
   return 0;   
}