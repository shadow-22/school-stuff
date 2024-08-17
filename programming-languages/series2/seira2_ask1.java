// http://www.geeksforgeeks.org/disjoint-set-data-structures-java-implementation/

import java.io.*;
import java.util.*;

class DisjointUnionSets {
    int [] rank, parent;
    int n;

    public DisjointUnionSets(int n) {
        rank = new int[n];
        parent = new int[n];
        this.n = n;
        makeSet();
    }

    void makeSet() {
        for (int i = 0; i < n; i++)
            parent[i] = i;
    }

    int find(int x) {
        if (parent[x] != x)
            parent[x] = find(parent[x]);
        return parent[x];
    }

    void union(int x, int y) {
        int xRoot = find(x), yRoot = find(y);
        if (xRoot == yRoot)
            return;
        Villages.counter = Villages.counter-1;
        if (rank[xRoot] < rank[yRoot])
            parent[xRoot] = yRoot;
        else if (rank[yRoot] < rank[xRoot])
            parent[yRoot] = xRoot;
        else {
            parent[yRoot] = xRoot;
            rank[xRoot] = rank[xRoot] + 1;
        }
    }
}

public class Villages {
    static int N, M, K, src, dest;
    public static int counter;

    public static void main(String[] args) throws IOException {
    	try {
    		Scanner sc = new Scanner(new File(args[0]));
    		N = sc.nextInt();
    		M = sc.nextInt();
    		K = sc.nextInt();

    		DisjointUnionSets dus = new DisjointUnionSets(N+1);
    		counter = N;

    		for (int i = 0; i < M; i++) {
    			src = sc.nextInt();
    			dest = sc.nextInt();
    			dus.union(src, dest);
    		}
    		sc.close();

            if (counter == 1)
            	System.out.println("1");
            else if (counter - K <= 1)
            	System.out.println("1");
            else
            	System.out.println(counter - K);

    	} catch (FileNotFoundException ex) {
    		System.out.println("File not found.");
    	}
    }

}