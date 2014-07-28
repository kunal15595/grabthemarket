#include <iostream>
#include <fstream>
#include <vector>
#include <sstream>
#include <string>
#include <stdlib.h>     /* atoi */
using namespace std;

int main(int argc, char const *argv[])
{
	vector<float> v;
	vector<float> p;
	int max, count, sum_max, count_max, index, loss_max=0, loss=0, loss_index = 0, loss_diff_1, loss_diff_2;
	ifstream myReadFile;
	 myReadFile.open("mama.txt");
	 char output[100];
	 if (myReadFile.is_open()) {
	 	while (!myReadFile.eof()) {


	    myReadFile >> output;
		v.push_back(atof(output));
		// p.push_back(p[p.size()-1] + atoi(output));
		// cout << v.size();
		
	 	}
	}
	cout << v.size() << endl;

	for (int i = 0; i < v.size()-1; ++i)
	{
		for (int j = i+1; j < v.size(); ++j)
		{
			for (int k = i; k <= j; ++k)
			{
				loss+=v[k];
				loss_index++;
			}
			if(loss_max > loss ){
				loss_max=loss;
				loss_diff_1 = i;
				loss_diff_2 = j;
				
			}
				loss = 0;
				loss_index = 0;
		}

	}
	cout << "loss-max : " << loss_max << "loss_index : " << loss_index << "loss_diff_1 : " << loss_diff_1 << "loss_diff_2 : " << loss_diff_2 <<"\n";

	for (int i = 0; i < v.size(); ++i)
	{

		// cout << v[i] << endl;
		if(v[i] < 0){
			max += v[i];
			
			count++;
		}else{
			if(sum_max > max){
				sum_max = max;
				count_max = count;
				index = i;
			}
			
			max = 0;
			count = 0;
		}
	}
	cout << "total : " << sum_max << "\ncount : " << count_max << "\nindex : " << index << endl;
	myReadFile.close();
	return 0;
}