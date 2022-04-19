#include <iostream>
#include <fstream>
#include <iomanip>
#include <string>
#include <string.h>
#include <cstdlib>
#ifdef _WIN32
#include <Windows.h>
#else
#include <unistd.h>
#endif

using namespace std;

#include "_SUPER_STORE_CLASSES.cpp"

void MainMenu(Store &s);
void encrypt(char* password,char* encrypted){
	for(int i=0;i<20;i++)	encrypted[i]=password[i]-10;
}
void decrypt(char* password,char* decrypted){
	for(int i=0;i<20;i++)	decrypted[i]=password[i]+10;
}
void updateDP(){
	char old[40];
	char newDP[20],enewDP[20];
	cout<<"Enter new password (max 20 characters): ";
	cin.sync();
	cin.getline(newDP,20);
	encrypt(newDP,enewDP);
	ifstream ifile("_SUPER_STORE_PASSWORDS.bin",ios::binary);
	ifile.read((char*)old,40);
	ifile.close();
	for(int i=0;i<20;i++) old[i]=enewDP[i];
	ofstream ofile("_SUPER_STORE_PASSWORDS.bin",ios::binary);
	ofile.write((char*) old,40);
	ofile.close();
	cout<<"Password Updated."<<endl;	
}
void updateEP(){
	char old[40];
	char newEP[20],enewEP[20];
	cout<<"Enter new password (max 20 characters): ";
	cin.sync();
	cin.getline(newEP,20);
	encrypt(newEP,enewEP);
	ifstream ifile("_SUPER_STORE_PASSWORDS.bin",ios::binary);
	ifile.read((char*)old,40);
	ifile.close();
	for(int i=0;i<20;i++) old[i+20]=enewEP[i];
	ofstream ofile("_SUPER_STORE_PASSWORDS.bin",ios::binary);
	ofile.write((char*) old,40);
	ofile.close();
	cout<<"Password Updated."<<endl;	
}
void readDP(char* dDP){
	char DP[20];
	ifstream file("_SUPER_STORE_PASSWORDS.bin",ios::binary);
	file.seekg(0);
	file.read((char*)DP,20);
	file.close();
	decrypt(DP,dDP);
}
void readEP(char* dEP){
	char EP[20];
	ifstream file("_SUPER_STORE_PASSWORDS.bin",ios::binary);
	file.seekg(20);
	file.read((char*)EP,20);
	file.close();
	decrypt(EP,dEP);
}
bool login(int c){
	char givenPassword[20],realPassword[20];
	cout<<"Enter your password: ";
	cin.sync();
	cin.getline(givenPassword,20);
	if(c==1) readDP(realPassword);
	else if(c==2) 	readEP(realPassword);
	else return false;
	if(strcmp(givenPassword,realPassword)==0) return true;
	else return false;
}
bool purchase(Store &s,int index=-2){
	int i,cIndex,iIndex,count,qnty;
	char un,name[30]={0},categoryName[20]={0};
	cout<<endl<<"Would you like to buy something? (Enter 'y' if yes): ";
	cin>>un;
	if(!(un=='Y' || un=='y')) return false;
	int bill=0;
	do{
		cout<<"How many Items you want to purchase (maximum 10 at a time): ";
		while(!(cin>>count)){
			cin.clear();
			cin.ignore(1000,'\n');
			cout<<"Please re-enter (numbers only): ";
		}
	}while(count<1 || count>10);
	Item *items[count];
	for(i=0;i<count;i++) items[i]=NULL;
	int quantity[count];
	int bills[count]={0};
	for(i=0;i<count;i++){
		if(index==-2){
			do{
				cout<<"Enter Category Name: ";
				cin.sync();
				cin.getline(categoryName,20);
				cIndex=s.indexOfCategory(categoryName);
				if(cIndex<0) cout<<"Could not find this category, Please Re-enter!"<<endl;
			}while(cIndex<0);
		}
		else	cIndex=index;	
		do{
			cout<<"Enter Item Name: ";
			cin.sync();
			cin.getline(name,30);
			iIndex=s.list[cIndex]->indexOfItem(name);
			if(cIndex<0) cout<<"Could not find this item, Please Re-enter!"<<endl;
		}while(iIndex<0);
		do{
			cout<<"Enter quantity: ";
			while(!(cin>>qnty)){
				cin.clear();
				cin.ignore(1000,'\n');
				cout<<"Please re-enter (numbers only): ";
			}
			if(qnty<=0) cout<<"Invalid Entry, Please Re-enter!"<<endl;
		}while(!(qnty>0));
		if(qnty>s.list[cIndex]->listC[iIndex]->stock){
			cout<<"Sorry but this item is out of stock."<<endl;
			cout<<"Please continue to next item you want to purchase."<<endl;
			continue;
		}
		else{
			items[i]=s.list[cIndex]->listC[iIndex];
			quantity[i]=qnty;
			bills[i]=items[i]->price*quantity[i];
			cout<<"Added to list, Please proceed to next item."<<endl;
		}
	}
	cout<<endl<<endl;
	cout<<"\t"<<setw(32)<<left<<"Name"<<setw(10)<<right<<"Unit-Price"
		<<setw(10)<<right<<"Quantity"<<setw(20)<<right<<"\tBill"<<endl;
	cout<<"\t======================================================================================"<<endl;
	for(i=0;i<count;i++){
		if(items[i]!=NULL){
			items[i]->showToCustomer();
			cout<<setw(10)<<right<<quantity[i]<<setw(20)<<right
			<<quantity[i]<<" x "<<items[i]->price<<" = "<<bills[i]<<endl;
			bill+=bills[i];	
		}	
	}
	cout<<endl<<"Total Bill: "<<bill<<endl;
	cout<<endl<<"Confirm the purchase (Enter 'y' if yes): ";
	cin>>un;
	if(un=='y' || un=='Y'){
		for(i=0;i<count;i++){
			if(items[i]!=NULL){
				items[i]->stock -= quantity[i];
			}
		}
		cout<<"Purchase Completed"<<endl;
		s.save();
	}
	else	cout<<"Selected Items Discarded"<<endl;
}

void DealerMenu(Store &s){
	cout<<endl<<"Loading Dealer Menu........."<<endl;
	Sleep(500);
	system("CLS");
	cout<<"What do you intend:"<<endl;
	cout<<"\t1.\tView Everything"<<endl;
	cout<<"\t2.\tView a Category"<<endl;
	cout<<"\t3.\tAdd Items"<<endl;
	cout<<"\t4.\tRemove Items"<<endl;
	cout<<"\t5.\tAdd Categories"<<endl;
	cout<<"\t6.\tRemove Categories"<<endl;
	cout<<"\t7.\tUpdate Stock"<<endl;
	cout<<"\t8.\tUpdate Price"<<endl;
	cout<<"\t9.\tChange your Password"<<endl;
	cout<<"\t10.\tBack to Main Menu"<<endl;
	cout<<"\t11.\tExit"<<endl<<endl;
	int x,i,count,price,stock,mS;
	char categoryName[20]={0},name[30]={0};
	char un;
	do{
		cout<<"Enter Selected Number:";
		while(!(cin>>x)){
			cin.clear();
			cin.ignore(1000,'\n');
			cout<<"Please re-enter (numbers only): ";
		}
		switch(x){
			case 1:
				cout<<s;
				cout<<"Press any key to go back to Dealer Menu: ";
				cin>>un;	DealerMenu(s);
				break;
			case 2:
				s.showCategories();
				cout<<"Enter Name of the Category you want to view contents of: ";
				cin.sync();
				cin.getline(categoryName,20);
				s.showCategory(categoryName);
				cout<<"Press any key to go back to Dealer Menu: ";
				cin>>un;	DealerMenu(s);
				break;
			case 3:
				do{
					cout<<"How many Items you want to add (0-12): ";
					while(!(cin>>count)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					if(count<0 || count>12) cout<<"Invalid Input! Please Re-enter"<<endl;
				}while(count<0 || count>12);
				for(i=1;i<=count;i++){
					cout<<"Enter Category Name: ";	cin.sync();cin.getline(categoryName,20);
					cout<<"Enter Item Name: ";	cin.sync();cin.getline(name,30);
					cout<<"Enter Item Price: ";	
					while(!(cin>>price)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					cout<<"Enter Item Stock: ";	
					while(!(cin>>stock)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					if(s.addItem(categoryName,name,price,stock)) cout<<"Item has been added Successfully."<<endl;
					else cout<<"Could not add Item."<<endl;
				}
				s.save();
				DealerMenu(s);
				break;
			case 4:
				do{
					cout<<"How many Items you want to remove (0-12): ";
					while(!(cin>>count)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					if(count<0 || count>12) cout<<"Invalid Input! Please Re-enter"<<endl;
				}while(count<0 || count>12);
				for(i=1;i<=count;i++){
					cout<<"Enter Category Name: ";	cin.sync();cin.getline(categoryName,20);
					cout<<"Enter Item Name: ";	cin.sync();cin.getline(name,30);
					if(s.removeItem(categoryName,name)) cout<<"Item removed"<<endl;
					else cout<<"Could not remove Item"<<endl;
				}
				s.save();
				DealerMenu(s);
				break;
			case 5:
				do{
					cout<<"How many Categories you want to add (0-12): ";
					while(!(cin>>count)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					if(count<0 || count>12) cout<<"Invalid Input! Please Re-enter"<<endl;
				}while(count<0 || count>12);
				for(i=1;i<=count;i++){
					cout<<"Enter Category Name: ";	cin.sync();cin.getline(categoryName,20);
					do{
						cout<<"Enter Maximum Size: ";
						while(!(cin>>mS)){
							cin.clear();
							cin.ignore(1000,'\n');
							cout<<"Please re-enter (numbers only): ";
						}
						if(mS<=0) cout<<"Please Re-enter!"<<endl;
					}while(mS<=0);
					if(s.addCategory(categoryName,mS)) cout<<"Category Added"<<endl;
					else cout<<"Could not add Category"<<endl;
				}
				s.save();
				DealerMenu(s);
				break;
			case 6:
				do{
					cout<<"How many Categories you want to remove (0-12): ";
					while(!(cin>>count)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					if(count<0 || count>12) cout<<"Invalid Input! Please Re-enter"<<endl;
				}while(count<0 || count>12);
				for(i=1;i<=count;i++){
					cout<<"Enter Category Name: ";	cin.sync();cin.getline(categoryName,20);
					if(s.removeCategory(categoryName)) cout<<"Category Removed"<<endl;
					else cout<<"Could not Remove Category"<<endl;
				}
				s.save();
				DealerMenu(s);
				break;
			case 7:
				cout<<"Enter Category Name: ";cin.sync();cin.getline(categoryName,20);
				cout<<"Enter Item Name: ";cin.sync();cin.getline(name,30);
				cout<<"Enter how much do you want to add to stock: ";
				while(!(cin>>stock)){
					cin.clear();
					cin.ignore(1000,'\n');
					cout<<"Please re-enter (numbers only): ";
				}
				if(s.addToStock(categoryName,name,stock)) cout<<"Stock Updated"<<endl;
				else cout<<"Could not update stock"<<endl;
				s.save();
				DealerMenu(s);
				break;
			case 8:
				cout<<"Enter Category Name: ";cin.sync();cin.getline(categoryName,20);
				cout<<"Enter Item Name: ";cin.sync();cin.getline(name,30);
				cout<<"Enter new Price: ";
				while(!(cin>>price)){
					cin.clear();
					cin.ignore(1000,'\n');
					cout<<"Please re-enter (numbers only): ";
				}
				if(s.updatePrice(categoryName,name,price)) cout<<"Price Updated"<<endl;
				else cout<<"Could not update price"<<endl;
				s.save();
				DealerMenu(s);
				break;
			case 9:
				updateDP();
				DealerMenu(s);
				break;
			case 10:
				MainMenu(s);
				break;
			case 11:
				s.save();
				cout<<endl<<endl<<"Thanks for visiting.   :)"<<endl;
				exit(0);
				break;
			default:
				cout<<"Invalid Selection!"<<endl;
				break;
		}
		
	}while(!(x>=1 && x<=11));
}
void EmployeeMenu(Store &s){
	cout<<endl<<"Loading Employee Menu........."<<endl;
	Sleep(500);
	system("CLS");
	cout<<"What do you intend:"<<endl;
	cout<<"\t1.\tView Everything"<<endl;
	cout<<"\t2.\tView a Category"<<endl;
	cout<<"\t3.\tUpdate Stock"<<endl;
	cout<<"\t4.\tChange your Password"<<endl;
	cout<<"\t5.\tBack to Main Menu"<<endl;
	cout<<"\t6.\tExit"<<endl<<endl;
	int x,stock,unint;
	char categoryName[20]={0},name[30]={0};
	char un;
	do{
		cout<<"Enter Selected Number:";
		while(!(cin>>x)){
			cin.clear();
			cin.ignore(1000,'\n');
			cout<<"Please re-enter (numbers only): ";
		}
		switch(x){
			case 1:
				cout<<s;
				cout<<"Press any key to go back to Employee Menu: ";
				cin>>un;	EmployeeMenu(s);
				break;
			case 2:
				s.showCategories();
				do{
					cout<<"Enter Name of the Category you want to view contents of: ";
					cin.sync();
					cin.getline(categoryName,20);
					unint=s.showCategory(categoryName);
					if(unint==-1){
						cout<<"Do you want to Re-enter ('y' if yes): ";
						cin>>un;
					}
					else	un='n';
				}while(un=='y' || un=='Y');
				cout<<"Press any key to go back to Employee Menu: ";
				cin>>un;	EmployeeMenu(s);
				break;
			case 3:
				cout<<"Enter Category Name: ";cin.sync();cin.getline(categoryName,20);
				cout<<"Enter Item Name: ";cin.sync();cin.getline(name,30);
				cout<<"Enter how much do you want to add to stock: ";
				while(!(cin>>stock)){
					cin.clear();
					cin.ignore(1000,'\n');
					cout<<"Please re-enter (numbers only): ";
				}
				if(s.addToStock(categoryName,name,stock)) cout<<"Stock Updated"<<endl;
				else cout<<"Could not update stock"<<endl;
				cout<<"Press any key to go back to Employee Menu: ";
				cin>>un;	
				s.save();
				EmployeeMenu(s);
				break;
			case 4:
				updateEP();
				EmployeeMenu(s);
				break;
			case 5:
				MainMenu(s);
				break;
			case 6:
				s.save();
				cout<<endl<<endl<<"Thanks for visiting.   :)"<<endl;
				exit(0);
				break;
			default:
				cout<<"Invalid Selection!"<<endl;
				break;
		}
		
	}while(!(x>=1 && x<=6));
}
void CustomerMenu(Store &s){
	cout<<endl<<"Loading Customer Menu........."<<endl;
	Sleep(500);
	system("CLS");
	cout<<"What do you intend:"<<endl;
	cout<<"\t1.\tView Everything"<<endl;
	cout<<"\t2.\tView a Category"<<endl;
	cout<<"\t3.\tBack to Main Menu"<<endl;
	cout<<"\t4.\tExit"<<endl<<endl;
	int x,index;
	char categoryName[20]={0},name[30]={0};
	char un;
	do{
		cout<<"Enter Selected Number:";
		while(!(cin>>x)){
			cin.clear();
			cin.ignore(1000,'\n');
			cout<<"Please re-enter (numbers only): ";
		}
		switch(x){
			case 1:
				cout<<s;
				purchase(s,-2);
				cout<<"Press any key to go back to Customer Menu: ";
				cin>>un;	CustomerMenu(s);
				break;
			case 2:
				s.showCategories();
				do{
					cout<<"Enter Name of the Category you want to view contents of: ";
					cin.sync();
					cin.getline(categoryName,20);
					index=s.showCategory(categoryName);
					if(index==-1){
						cout<<"Do you want to Re-enter ('y' if yes): ";
						cin>>un;
					}
					else un=='n';
				}while(un=='y');
				if(index!=-1)	purchase(s,index);
				cout<<"Press any key to go back to Customer Menu: ";
				cin>>un;	CustomerMenu(s);
				break;
			case 3:
				MainMenu(s);
				break;
			case 4:
				s.save();
				cout<<endl<<endl<<"Thanks for visiting.   :)"<<endl;
				exit(0);
				break;
			default:
				break;
		}
	}while(!(x>=1 && x<=4));

}


void MainMenu(Store &s){
	cout<<endl<<"Loading Main Menu.........."<<endl;
	Sleep(500);
	system("CLS");
	cout<<"Select User:"<<endl;
	cout<<"\t1.\tDealer/Owner"<<endl;
	cout<<"\t2.\tEmployee"<<endl;
	cout<<"\t3.\tCustomer"<<endl;
	cout<<"\t4.\tExit"<<endl;
	int x; char un;
	do{
		cout<<"Enter Selected Number:";
		while(!(cin>>x)){
			cin.clear();
			cin.ignore(1000,'\n');
			cout<<"Please re-enter (numbers only): ";
		}
		switch (x){
			case 1:
				
				if(!login(1)){
					cout<<"Password Incorrect!"<<endl<<"Default Password is 'DealWithMe'"<<endl;
					cout<<"Press any key to go back: ";
					while(!(cin>>un)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (characters only): ";
					}
					MainMenu(s);
				}
				else	DealerMenu(s);
				break;
				
			case 2:
				
				if(!login(2)){
					cout<<"Password Incorrect!"<<endl<<"Default Password is 'IAmAnEmployee'"<<endl;
					cout<<"Press any key to go back: "; 
					while(!(cin>>un)){
						cin.clear();
						cin.ignore(1000,'\n');
						cout<<"Please re-enter (numbers only): ";
					}
					MainMenu(s);
				}
				else	EmployeeMenu(s);
				break;
				
			case 3:
				
				CustomerMenu(s);
				break;
				
			case 4:
				s.save();
				cout<<endl<<endl<<"Thanks for visiting.   :)"<<endl;
				exit(0);
				break;
				
			default:
				cout<<"Invalid Selection!"<<endl;
				break;
		}
	}while(!(x>=1 && x<=4));
	
}










