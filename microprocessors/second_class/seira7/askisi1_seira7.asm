.include "m16def.inc"
.def reg=r19      ;metrhths interrupts
.def c1=r20       ;isws den xreiazetai,ypoleimmata
.def counter=r18  ;apo palioteres prospatheies
.def ncounter=r21 ;NORMAL COUNTER LED-->PORTA
;----------------------------
; interrupt int0(mask all the others)
.org 0x0
rjmp reset
.org 0x2
rjmp isr0

reset:
ldi r24,( 1<<isc01) |( 1<<isc00)   ;shma 
;ldi reg1,0x00                     ;thetikhs
out mcucr, r24                     ;akmhs
ldi r24, (1<<int0)                 ;energopoihsh 
out gicr, r24                      ;diakophs
sei                                ;int0
;----------------------------
; fix ret for subroutines
reset1: 
ldi r24 , low(RAMEND) ; initialize stack pointer
out SPL , r24
ldi r24 , high(RAMEND)
out SPH , r24
;----------------------------
; INITIALIZE PORTS
ser r24              ; initialize PORTA for output
out DDRA , r24
ser r24              ; initialize PORTB for output
out DDRB , r24
clr r24 
;----------------------------
; kyriws programma-metrhths
main:
clr ncounter         ;arxikopoihsh
clr reg              ;se kathe epanalhpsh
loop:                ;apeiros broxos
out porta,ncounter
ldi r24 , low(100)   ;load r25:r24 with 100
ldi r25 , high(100)  ;delay 1/10 second
rcall wait_msec
inc ncounter         ; metrhths led porta
rjmp loop
;---------------------------
; kathisterisi 1/10 sec
wait_usec:
sbiw r24 ,1 
nop 
nop 
nop 
nop 
brne wait_usec
ret 

wait_msec:
push r24 
push r25 
ldi r24 , low(998)  ;load r25:r24 with 98
ldi r25 , high(998) ; delay 1/10 second
rcall wait_usec 
pop r25 
pop r24 
sbiw r24 , 1 
brne wait_msec
ret
;---------------------------
; interrupt subroutine
isr0:
push r24
push r25

ldi r22,0x00      ;mhdenismos se periptwsh poy 
out portb,r22     ;paramenei h prohgoumenh timh

ldi r24,(1<<intf0)
out gifr,r24

ldi r24, low(5)
ldi r25, high(5)
rcall wait_msec

in r18,gifr     ;elegxos gia spinthirismo
andi r18,0b01000000
cpi r18,0b01000000
breq isr0
;-------------------
; elegxos gia to pd0
in r23,pind
andi r23,0x01
cpi r23,0x01
breq skip      ;an 1,mhn ton aukshseis
inc reg        ;aukshsh metrhth interrupt
skip:
out portb, reg
;-----------------
pop r25
pop r24
reti
