#include <iostream>
#include <iomanip>
#ifdef __cplusplus__
	#include <cstdlib>
#else
	#include <stdlib.h>
#endif

using namespace std;

#define P1_TAIN 'X'
#define P2_TAIN 'Y'

void convertNoToIndex(int no,int &i,int &j){
	j=no%3;
	if(j==0) j=3;
	--j;
	i=(no-1)/3;		
}
void convertIndexToNo(int &no,int i,int j){
	++j;
	no=(i*3)+j;
}
bool isInRange(int x){
	if(x>=1 && x<=9) return true;
	else false;	
}
void initialize(char board[3][3]){
	char temp='1'; int i,j;
	for(i=0;i<3;i++)	for(j=0;j<3;j++)	board[i][j]=temp++;
}
void show(char board[3][3]){
	if(system("cls")) system("clear");
	int i,j=0;
	cout<<"-------|-------|-------\n";
	for(i=0;i<3;i++){
		cout<<"   "<<board[i][0]<<"   |"
			<<"   "<<board[i][1]<<"   |"
			<<"   "<<board[i][2]<<"   \n";
		cout<<"-------|-------|-------\n";
	}
}
bool somethingIsPresentOn(int x,char board[3][3]){
	int i,j; convertNoToIndex(x,i,j);
	if(board[i][j]==P1_TAIN || board[i][j]==P2_TAIN) return true;
	else return false;
}
bool isPresentOn(char sel,int x,char board[3][3]){
	int i,j; convertNoToIndex(x,i,j);
	if(sel=='X'){
		if(board[i][j]==P1_TAIN) return true;
		else return false;
	}
	else if(sel=='Y'){
		if(board[i][j]==P2_TAIN) return true;
		else return false;
	}
}
void pasteOn(char sel,int x,char board[3][3]){
	int i,j; convertNoToIndex(x,i,j);
	if(sel=='X')	board[i][j]=P1_TAIN;
	if(sel=='Y')	board[i][j]=P2_TAIN;
}
void deleteFrom(int x,char board[3][3]){
	int i,j; convertNoToIndex(x,i,j);
	board[i][j]=48+x;
}
int findFirstOccurence(char sel,char board[3][3]){
	int i,j;
	for(i=0;i<3;i++){
		for(j=0;j<3;j++){
			if(board[i][j]==sel) goto OUTSIDE;
		}
	}
	return -1;
	OUTSIDE:
	int x;
	convertIndexToNo(x,i,j);
	return x;		
}
bool isANeighbourMove(int from,int to){
	if(from==to) return false;
	if(from==5 || to==5) return true;
	switch(from){
		case 1: if(to==2 || to==4 ) return true; else return false; break;
		case 2: if(to==1 || to==3 ) return true; else return false; break;
		case 3: if(to==2 || to==6 ) return true; else return false; break;
		case 4: if(to==1 || to==7 ) return true; else return false; break;
		case 6: if(to==3 || to==9 ) return true; else return false; break;
		case 7: if(to==4 || to==8 ) return true; else return false; break;
		case 8: if(to==7 || to==9 ) return true; else return false; break;
		case 9: if(to==6 || to==8 ) return true; else return false; break;
		default: return false;
	}
}

class Player{
	public:
	int playerNo;
	int tainCount=0;
	bool turnSt=true;
	bool winSt=false;
	void turn(char board[3][3]){
		if(tainCount==3) move(board);
		else inputNew(board);
		show(board);
		if(hasWon(board)) winSt=true; 
	}
	void inputNew(char board[3][3]){
		int selNo;
		REPEAT:
		cout<<"Choose the number where you want to place a new tain:";
		cin>>selNo;
		if(isInRange(selNo)){
			if(!somethingIsPresentOn(selNo,board)){
				if(playerNo==1) pasteOn('X',selNo,board);
				if(playerNo==2) pasteOn('Y',selNo,board);
			}
			else{
				cout<<"A tain already exists there!Choose another\n";
				goto REPEAT;
			}
		}
		else{
			cout<<"Invalid Number! Please enter appropriate number(0-9)\n";
			goto REPEAT;
		}
		++tainCount;
	}
	void move(char board[3][3]){
		int from,to;
		REPEAT:
		cout<<"Move tain from:";cin>>from;cout<<"to:";cin>>to;
		if(isInRange(from) && isInRange(to) && isANeighbourMove(from,to)){
			if(playerNo==1){
				if(isPresentOn('X',from,board) && !somethingIsPresentOn(to,board)){
					deleteFrom(from,board);
					pasteOn('X',to,board);
				}
				else{
					cout<<"Invalid Selection! Please enter valid entries\n";
					goto REPEAT;
				}
			}
			else if(playerNo==2){
				if(isPresentOn('Y',from,board) && !somethingIsPresentOn(to,board)){
					deleteFrom(from,board);
					pasteOn('Y',to,board);
				}
				else{
					cout<<"Invalid Selection! Please enter valid entries\n";
					goto REPEAT;
				}
			}
		}
		else{
			cout<<"Invalid Move! Please enter valid entries\n";
			goto REPEAT;
		}
	}
	bool hasWon(char board[3][3]){
		char obj; if (playerNo==1) obj='X'; else if(playerNo==2) obj='Y';
		int first=findFirstOccurence(obj,board);
		if((first==1 || first==4 || first==7) && isPresentOn(obj,first+1,board) && isPresentOn(obj,first+2,board)) return true;
		else if((first==1 || first==2 || first==3) && isPresentOn(obj,first+3,board) && isPresentOn(obj,first+6,board)) return true;
		else if(first==1 && isPresentOn(obj,first+4,board) && isPresentOn(obj,first+8,board)) return true;		
		else if(first==3 && isPresentOn(obj,first+2,board) && isPresentOn(obj,first+4,board)) return true;
		else return false;
	}
};

void toggleTurnSt(Player &p1,Player &p2){
	if(p1.turnSt){
		p1.turnSt=false;
		p2.turnSt=true;
	}
	else if(p2.turnSt){
		p2.turnSt=false;
		p1.turnSt=true;
	}
}
int gameIsOn(Player &p1,Player &p2,char board[3][3]){
	while(true){
		if(p1.turnSt){
			cout<<"Player 1's Turn:\n";
			p1.turn(board);
			if(p1.winSt) return 1; 
		}
		else if(p2.turnSt){
			cout<<"Player 2's Turn:\n";
			p2.turn(board);
			if(p2.winSt) return 2;
		}
		toggleTurnSt(p1,p2);
	}
}

int main(){
	char board[3][3]; int i,j;
	Player p1,p2;
	p1.playerNo=1;
	p2.playerNo=2;
	initialize(board);
	show(board);
	int w=gameIsOn(p1,p2,board);
	if(w==1) cout<<"Player 1 has won the game. :)\n";
	else if(w==2) cout<<"Player 2 has won the game. :)\n";
	return 0;
	
}
