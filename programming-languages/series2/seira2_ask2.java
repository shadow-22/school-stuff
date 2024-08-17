import java.io.*;
import java.util.*;

class Node implements Comparable<Node> {
    public int value;
    public int distance;

    public Node(int value, int distance) {
        this.value = value;
        this.distance = distance;
    }
    public int getValue() {
        return this.value;
    }
    public int getDistance() {
        return this.distance;
    }
    public boolean equals(Node other) {
        return (this.getDistance() == other.getDistance());
    }
    public int compareTo(Node other) {
        if (this.equals(other))
            return 0;
        else if (this.distance > other.distance)
            return 1;
        else
            return -1;
    }
    public String toString() {
    	return "{Value: " + this.value + " Distance: " + this.distance + " }";
    }
}

public class Moredeli {
    public static int N, M;
    public static char[][] grid = new char[1000][1000];
    public static Node[] node;
    public static char[] prev;
    public static boolean[] removed;
    public static PriorityQueue<Node> pQueue = new PriorityQueue<Node>();
    public static int src_x, src_y, end_x, end_y;

    public static void print_grid() {
    	for (int i = 0; i < N; i++) {
    		for (int j = 0; j < M; j++) {
    			System.out.print(grid[i][j]);
    		}
    		System.out.println();
    	}
    }

    public static void parse_grid(String filename) throws IOException {
    	int inByte, i, j;
    	i = j = 0;
    	char temp;

    	try {
    		FileReader text = new FileReader(filename);
    		do {
    			inByte = text.read();
    			if (inByte != -1) {
    				temp = (char)inByte;
    				if (temp == 'S') {
    					src_x = i;
    					src_y = j;
    				}
    				if (temp == 'E') {
    					end_x = i;
    					end_y = j;
    				}
    				if (temp != '\n') {
    					grid[i][j] = temp;
    					j = j + 1;
    				}
    				else {
    					if (i == 0) M = j; // if (i == 0) M = j - 1;
    					j = 0;
    					i = i + 1;
    				}
    			}
    		} while (inByte != -1);
    		N = i;
    		text.close();
    		} catch (FileNotFoundException ex) {
    			System.out.println("File not found.");
    		}
    	}


    	public static void print_path(int i) {
    		if (i == src_x * M + src_y) return;
    		else if (prev[i] == 'U') print_path(i + M);
    		else if (prev[i] == 'D') print_path(i - M);
    		else if (prev[i] == 'L') print_path(i + 1);
    		else if (prev[i] == 'R') print_path(i - 1);
    		System.out.print(prev[i]);
    	}

    	public static void print_add(Node temp, int count) {
    		System.out.println("Enqueued " + String.valueOf(count) + " --> " + temp.toString());
    	}

    	public static void dijkstra() {

    		while (!pQueue.isEmpty()) {
    			Node min_node = pQueue.remove();

    			if (removed[min_node.value] == true) {
    				continue;
    			}

    			removed[min_node.value] = true;

    			int x = min_node.value / M;
    			int y = min_node.value % M;

    			if (y <= M-2 && removed[min_node.value+1] != true && grid[x][y] != 'X' && grid[x][y+1] != 'X' && min_node.distance + 1 < node[min_node.value+1].distance) {
    				node[min_node.value+1].distance = min_node.distance + 1;
    				prev[min_node.value+1] = 'R';
    				pQueue.add(node[min_node.value+1]);
    			}
    			if (y != 0 && removed[min_node.value-1] != true && grid[x][y] != 'X' && grid[x][y-1] != 'X' && min_node.distance + 2 < node[min_node.value-1].distance) {
    				node[min_node.value-1].distance = min_node.distance + 2;
    				prev[min_node.value-1] = 'L';
    				pQueue.add(node[min_node.value-1]);
    			}
    			if (x <= N-2 && removed[min_node.value+M] != true && grid[x][y] != 'X' && grid[x+1][y] != 'X' && min_node.distance + 1 < node[min_node.value+M].distance) {
    				node[min_node.value+M].distance = min_node.distance + 1;
    				prev[min_node.value+M] = 'D';
    				pQueue.add(node[min_node.value+M]);
    			}
    			if (x != 0 && removed[min_node.value-M] != true && grid[x][y] != 'X' && grid[x-1][y] != 'X' && min_node.distance + 3 < node[min_node.value-M].distance) {
    				node[min_node.value-M].distance = min_node.distance + 3;
    				prev[min_node.value-M] = 'U';
    				pQueue.add(node[min_node.value-M]);
    			}
    		}

    	}

    	public static void main(String[] args) throws IOException {
    		try {
    			parse_grid(args[0]);
    		} catch (FileNotFoundException ex) {
    			System.out.println("File not found.");
    		}
            
//            System.out.println("N: " + N + " --- M: " + M);
//            print_grid();


    		node = new Node[N*M];
    		prev = new char[N*M];
    		removed = new boolean[N*M];            

    		for (int i = 0; i < N*M; i++) {
                removed[i] = false;
    			if (i == src_x * M + src_y) {
                    node[i] = new Node(i, 0);
                    pQueue.add(node[i]);
                }
    			else
    				node[i] = new Node(i, Integer.MAX_VALUE);
    		}
            
    		dijkstra();
    		System.out.print(node[(end_x * M + end_y)].distance + " ");
    		print_path(end_x * M + end_y);
            
    	}

} 