#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <stdlib.h>
#include <time.h>
using namespace std;

int main()
{
	vector<float> v;
	float temp;
	ifstream myfile;
	myfile.open("TCS.txt");

	if (myfile.is_open())
	{
		while (!myfile.eof())
		{
			myfile >> temp;
			v.push_back(temp);

		}
	myfile.close();
	}

	ofstream yfile;
	yfile.open("TCS.txt");
	srand (time(NULL));
	cout << rand()/RAND_MAX;
	for(int i = 0;i < v.size()-1;i++){
		yfile << v[i] << " " << v[i] + (v[i+1]-v[i])*rand()/RAND_MAX << " " << v[i] + (v[i+1]-v[i])*rand()/RAND_MAX << " ";
	}
	for(int i = v.size()-2;i >= 0;i--){
		yfile << v[i] << " " << v[i] + (v[i+1]-v[i])*rand()/RAND_MAX << " " << v[i] + (v[i+1]-v[i])*rand()/RAND_MAX << " ";
	}
}
