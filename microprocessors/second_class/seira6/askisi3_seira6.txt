// first program
// in C-AVR

#define F_CPU 4000000UL
#include <avr/io.h> 
#include <util/delay.h>
#include <stdio.h>
//#include <mega16.h>

//unsigned char x,y,led;
volatile uint8_t x;
volatile uint8_t y;
volatile uint8_t led;
volatile uint8_t flag_right;
volatile uint8_t flag_left;


int main(void)             // main program
{
   DDRB=0xff;              // PortB is for output
   DDRD=0X00;              // PortD is for input
   PORTB=0b00000001;        // led PB0 on
   led=0x01;

while(1){
      x=PIND;

	  y=x&0x1;            // first bit/button 
      if (y==0x1){
	  while (y!=0){
	  x=PIND;
	  y=x&0x1;
	  }
	  led=led<<1;
	  PORTB=led;
	  flag_left=1;
	  flag_right=0;
 //     _delay_ms(1);       // delay 100-milli seconds
	  }

	  y=x&0x2;           // second
	  if (y==0x2){
	  led=led>>1;
	  PORTB=led;
	  flag_right=1;
	  flag_left=0;
//      _delay_ms(1);       // delay 100-milli seconds
	  }

	  y=x&0x4;           // third
	  if (y==0x04){
	  led=led<<2;
	  PORTB=led;
	  flag_left=1;
	  flag_right=0;
//      _delay_ms(1);       // delay 100-milli seconds
	  }

	  y=x&0x8;           // fourth 
	  if (y==0x8){
	  led=led>>2;
	  PORTB=led;
	  flag_right=1;
	  flag_left=0;
//      _delay_ms(1);       // delay 100-milli seconds
	  }

	  y=x&0x10;          // fifth
	  if (y==0xA){
	  led=0x01;
	  PORTB=led;
//      _delay_ms(1);       // delay 100-milli seconds
	  }
      
	  if (led==0x0){

	  if (flag_right==0x1){
	  led=0x80;
	  PORTB=led;
//	  _delay_ms(1);
	  }

	  if (flag_left==0x1){
	  led=0x01;
	  PORTB=led;
//	  _delay_ms(1);
	  }

	  }
}   
   return 0;               // end of main
}



//*********************************
// TRASH
//_delay_ms(100);       // delay 100-milli seconds




