#include <iostream>
#include <fstream>
#include <iomanip>
#include <string>
#include <string.h>

#include "_SUPER_STORE_FUNCTIONS.cpp"

using namespace std;

int main(){
	
//	char p1[20],p2[20];
//	readDP(p1);readEP(p2);
//	cout<<p1<<" "<<p2<<endl;
	
//	updateDP();
//	updateEP();
	
	Store s;
	s.read();
	MainMenu(s);
	s.save();

	
	
	
	
	return 0;
}
