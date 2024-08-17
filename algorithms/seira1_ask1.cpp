#include <iostream>  
#include <algorithm>  
#include <vector>  
#include <cmath>  
#include <climits>  
#include <cfloat>  
  
using namespace std;  
   
long long int min_distance(pair<long long int, long long int> points[], long int size, long long int median) {  
    long long int medianX = get<0>(points[median]);  
    long long int medianY = get<1>(points[median]);  
    long long int sum = 0;  
    for (long long int i = 0; i < size; i++) {  
        long long int xpr = abs(medianX - get<0>(points[i])) + abs(medianY - get<1>(points[i]));  
        sum = sum + xpr;  
    }  
    return sum;  
}  
  
int main(int argc, char* argv[]) {  
   
    long int N;   
    cin >> N;  
    bool even;  
    pair<long long int, long long int> points[N];  
    vector<long long int> x_cord(N);  
    vector<long long int> y_cord(N);  
       
    if (N % 2 == 0)   
        even = true;  
    else   
        even = false;  
   
    pair<long long int, long long int> temp;  
    long long int a, b;  
    for (long int i = 0; i < N; i++) {  
        cin >> a;  
        cin >> b;  
        points[i] = make_pair(a, b);  
        x_cord[i] = a;  
        y_cord[i] = b;  
    }  
   
    long long int x_median, y_median;  
    pair<long long int, long long int> median[4];  
    nth_element(x_cord.begin(), x_cord.begin() + (N-1)/2, x_cord.end());  
    nth_element(y_cord.begin(), y_cord.begin() + (N-1)/2, y_cord.end());  
    long long int x_m_f = x_cord[(N-1)/2];  
    long long int y_m_f = y_cord[(N-1)/2];  
  
    if (even == false) {  
    pair<long long int, long long int> median = make_pair(x_cord[(N-1)/2], y_cord[(N-1)/2]);  
    }  
    else {  
        long long int x_median_first = x_m_f;   
        long long int y_median_first = y_m_f;  
        nth_element(x_cord.begin(), x_cord.begin() + N/2, x_cord.end());  
        long long int x_median_second = x_cord[N/2];  
        nth_element(y_cord.begin(), y_cord.begin() + N/2, y_cord.end());  
        long long int y_median_second = y_cord[N/2];  
  
        median[0] = make_pair(x_median_first, y_median_first);  
        median[1] = make_pair(x_median_second, y_median_first);  
        median[2] = make_pair(x_median_first, y_median_second);  
        median[3] = make_pair(x_median_second, y_median_second);  
    }  
  
    long long int geomedian;  
  
    if (even == false) {  
        long long int min = LLONG_MAX;   
        for (long int i = 0; i < N; i++) {  
            long long int x_temp = get<0>(points[i]);  
            long long int y_temp = get<1>(points[i]);  
            long long int diff_x = abs(x_median - x_temp);  
            long long int diff_y = abs(y_median - y_temp);  
            long long int temp_xpr = pow(diff_x, 2) + pow(diff_y, 2);  
            long long diff_temp = sqrt(temp_xpr);  
            if (diff_temp < min) {  
                min = diff_temp;  
                geomedian = i;  
            }  
        }  
    }  
      
    if (even == true) {  
        long long int min = LLONG_MAX;   
        for (long int i = 0; i < N; i++) {  
            long long int x_temp = get<0>(points[i]);  
            long long int y_temp = get<1>(points[i]);  
            for (int j = 0; j < 4; j++) {  
                long long int diff_x = abs(get<0>(median[j]) - x_temp);  
                long long int diff_y = abs(get<1>(median[j]) - y_temp);  
                long long int temp_xpr = pow(diff_x, 2) + pow(diff_y, 2);  
                long long int diff_temp = sqrt(temp_xpr);  
                if (diff_temp < min) {  
                    min = diff_temp;  
                    geomedian = i;  
                }  
            }  
        }                         
    }  
  
    cout << min_distance(points, N, geomedian) << endl;  
    return 0;  
}  