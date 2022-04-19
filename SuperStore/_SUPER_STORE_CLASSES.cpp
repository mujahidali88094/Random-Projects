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

class Item{
	public:
	char name[30];
	int price;
	int stock;
	Item(const char* name="Unnamed",int price=10,int stock=10){
		set(name,price,stock);
	}
	void set(const char* name,int price,int stock){
		strcpy(this->name,name);
		if(price>0) this->price=price;
		else this->price=10;
		if(stock>0) this->stock=stock;
		else this->stock=10;
	}
	void updateName(const char* n){
		strcpy(this->name,n);
	}
	bool addStock(int s){
		if(s>0){
			this->stock+=s;
			return true;
		}
		return false;
	}
	bool updatePrice(int p){
		if(p>0){
			this->price=p;
			return true;
		}
		return false;
	}
	void showToCustomer(){
		cout<<"\t"<<setw(32)<<left<<name<<setw(10)<<right<<price;
	}
	friend ostream& operator <<(ostream&,Item&);
};
ostream& operator <<(ostream& out,Item& item){
	out<<"\t"<<setw(32)<<left<<item.name<<setw(10)<<right<<item.price<<setw(10)
	   <<right<<item.stock<<endl;
	return out;
}



class Category{
	public:
	char name[20];
	int maxSize;
	int currSize;
	Item **listC;
	Category(const char* name="Unnamed",int maxSize=1){
		currSize=0;
		set(name,maxSize);
	}
	void set(const char* name,int mS){
		if(mS>=1){
			strcpy(this->name,name);
			this->maxSize=mS;
			listC=new Item*[maxSize];
			for(int i=0;i<maxSize;i++){
				listC[i]=NULL;
			}
		}
	}
	void initializePointers(int mS){
		this->maxSize=mS;
		listC=new Item*[maxSize];
		for(int i=0;i<maxSize;i++){
			listC[i]=NULL;
		}
	}
	void initializeDefaultObjects(int cS){
		this->currSize=cS;
		for(int i=0;i<currSize;i++){
			listC[i]=new Item;
		}
	}
	void freeListC(){
		currSize=0;
		for(int i=0;i<maxSize;i++){
			if(listC[i]!=NULL){
				delete listC[i];
				listC[i]=NULL;
			}	
		}
		delete []listC;
	}
	int getMaxSize()const{ return maxSize; }
	int getCurrSize()const{ return currSize; }
	int indexOfItem(const char* name){
		for(int i=0;i<maxSize;i++)
			if(listC[i]!=NULL){
				if(strcmp(listC[i]->name,name)==0)
					return i;
			}
		return -1;
	}
	bool addItem(const char* name,int price,int stock){
		if(currSize==maxSize) return false;
		if((indexOfItem(name))!=-1) return false;
		for(int i=0;i<maxSize;i++){
			if(listC[i]==NULL){
				listC[i]=new Item(name,price,stock);
				++currSize;
				return true;
			}
		}
		return false;
	}
	bool removeItem(const char* name){
		for(int i=0;i<maxSize;i++){
			if(listC[i]!=NULL){
				if(strcmp(listC[i]->name,name)==0){
					delete listC[i];
					listC[i]=NULL;
					--currSize;
					return true;
				}
			}
		}
		return false;
	}
	~Category(){ this->freeListC();	}
	friend ostream& operator <<(ostream&,Category&);	
};
ostream& operator <<(ostream& out,Category& c){
	out<<endl<<"  Category: "<<c.name<<endl<<endl;
	out<<"\t"<<setw(32)<<left<<"Name"<<setw(10)<<right<<"Price"<<setw(10)
	   <<right<<"Stock"<<endl;
	out<<"\t===================================================="<<endl;
	for(int i=0;i<c.maxSize;i++)
		if(c.listC[i]!=NULL)
			out<<*c.listC[i];
	out<<endl;
	return out;
}


class Store{
	public:
	char name[50];
	int maxSize;
	int currSize;
	Category **list;
	Store(const char* name="Unnamed",int maxSize=1){
		set(name,maxSize);
		currSize=0;
	}
	void set(const char* name,int mS){
		if(mS>=1){
			strcpy(this->name,name);
			this->maxSize=mS;
			list=new Category*[maxSize];
			for(int i=0;i<maxSize;i++){
				list[i]=NULL;
			}
		}
	}
	void initializePointers(int mS){
		this->maxSize=mS;
		list=new Category*[maxSize];
		for(int i=0;i<maxSize;i++){
			list[i]=NULL;
		}
	}
	void initializeDefaultObjects(int cS){
		this->currSize=cS;
		for(int i=0;i<currSize;i++){
			list[i]=new Category;
		}
	}
	void freeList(){
		currSize=0;
		for(int i=0;i<maxSize;i++){
			if(list[i]!=NULL){
				delete list[i];
				list[i]=NULL;
			}
		}	
		delete []list;
	}
	void updateName(const char* n){
		strcpy(this->name,n);
	}
	int getMaxSize()const{ return maxSize; }
	int getCurrSize()const{ return currSize; }
	int indexOfCategory(const char* name){
		for(int i=0;i<maxSize;i++)
			if(list[i]!=NULL)
				if(strcmp(list[i]->name,name)==0)
					return i;
		return -1;
	}
	bool findCandX(int &c,int &x,const char* categoryName,const char* name){
		c=indexOfCategory(categoryName);
		if(c==-1) return false;
		else{
			x=list[c]->indexOfItem(name);
			if(x==-1) return false;
		}
		return true;
	}
	bool addCategory(const char* name,int mS){
		if(currSize==maxSize) return false;
		if(indexOfCategory(name)!=-1) return false;
		for(int i=0;i<maxSize;i++){
			if(list[i]==NULL){
				list[i]=new Category(name,mS);
				++currSize;
				return true;
			}
		}
		return false;
	}
	bool removeCategory(const char* name){
		int x=indexOfCategory(name);
		if(x==-1) return false;
		else{
			delete list[x];
			list[x]=NULL;
			--currSize;
			return true;
		}
	}
	bool addItem(const char* categoryName,const char* name,int price,int stock){
		int x=indexOfCategory(categoryName);
		if(x==-1) return false;
		else{
			if(list[x]->addItem(name,price,stock)) return true;
			else return false;
		}
	}
	bool removeItem(const char* categoryName,const char* name){
		int x=indexOfCategory(categoryName);
		if(x==-1) return false;
		else{
			if(list[x]->removeItem(name)) return true;
			else return false;
		}
	}
	bool addToStock(const char* categoryName,const char* name,int stock){
		int c,x;
		findCandX(c,x,categoryName,name);
		if(c==-1 || x==-1){
			return false;
		}
		else{
			if(list[c]->listC[x]->addStock(stock)) return true;
			else return false;	
		}
	}
	bool updatePrice(const char* categoryName,const char* name,int price){
		int c,x;
		findCandX(c,x,categoryName,name);
		if(c==-1 || x==-1) return false;
		else{
			if(list[c]->listC[x]->updatePrice(price)) return true;
			else return false;
		}
	}
	
	void save(){
		ofstream file("_SUPER_STORE_DATA.bin",ios::binary);
		int i,j;
		file.write((char*)&name,50);
		file.write((char*)&maxSize,sizeof(int));
		file.write((char*)&currSize,sizeof(int));
		for(i=0;i<maxSize;i++){
			if(list[i]!=NULL){
				file.write((char*)&list[i]->name,20);
				file.write((char*)&list[i]->maxSize,sizeof(int));
				file.write((char*)&list[i]->currSize,sizeof(int));
				for(j=0;j<list[i]->maxSize;j++){
					if(list[i]->listC[j]!=NULL){
						file.write((char*)list[i]->listC[j],sizeof(Item));
					}
				}
			}
		}
		file.close();
	}
	void read(){
		ifstream file("_SUPER_STORE_DATA.bin",ios::binary);
		int test;
		file.read((char*)&test,sizeof(int));
		if(!file.eof()){
			freeList();
			int i,j,fileEndStatus=0;
			file.seekg(0);
			file.read((char*)&name,50);
			file.read((char*)&maxSize,sizeof(int));
			file.read((char*)&currSize,sizeof(int));
			initializePointers(maxSize);
			initializeDefaultObjects(currSize);
			for(i=0;i<currSize;i++){
				list[i]->freeListC();
				file.read((char*)&list[i]->name,20);
				if(file.eof()){ fileEndStatus=1; break;}
				file.read((char*)&list[i]->maxSize,sizeof(int));
				file.read((char*)&list[i]->currSize,sizeof(int));
				list[i]->initializePointers(list[i]->maxSize);
				list[i]->initializeDefaultObjects(list[i]->currSize);
				for(j=0;j<list[i]->currSize;j++){
					file.read((char*) list[i]->listC[j],sizeof(Item));
					if(file.eof()){	fileEndStatus=2; break;}
				}
			}
		}
		file.close();
	}
	~Store(){ freeList();	}
	void showCategories(){
		for(int i=0;i<maxSize;i++){
			if(list[i]!=NULL){
				cout<<"\t"<<i<<".\t"<<list[i]->name<<endl;
			}
		} 
	}
	int showCategory(const char* categoryName){
		int x=indexOfCategory(categoryName);
		if(x==-1){
			cout<<"Sorry for inconvenience but '"<<categoryName<<"' Category does not exist!"<<endl;
			return x;
		}
		else{
			cout<<*list[x];
			return x;
		}
	}
	friend ostream& operator <<(ostream&,Store&);	
};
ostream& operator <<(ostream& out,Store& s){
	cout<<endl<<"Loading Store............"<<endl;
	Sleep(500);
	system("CLS");
	out<<endl<<endl;
	out<<"\t\t  "<<s.name<<endl<<"  ================================================================"<<endl<<endl;
	for(int i=0;i<s.maxSize;i++)
		if(s.list[i]!=NULL)
			out<<*s.list[i];
	out<<endl;
	out<<"  ================================================================"<<endl;
	return out;
}

