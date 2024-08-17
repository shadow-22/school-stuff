.include "m16def.inc"
.def temp=r16
.def store1=r17
.def store2=r18
.def led=r19
.def flag=r20
.def constant=r21
;--------------------
; OUTPUT IS PORTC
ldi temp,0xff 
out ddrc,temp
;--------------------
; INPUT IS PORTB
ldi temp,0x00
out ddrb,temp
clr temp
;--------------------
; MAIN PROGRAM

main:
clr flag
clr temp
clr led
clr store1
clr store2
;--------------------
; FIRST GATE
in store1,pinb
andi store1,0x01
in store2,pinb    ; second bit
andi store2,0x02
clc
ror store2
or store1,store2
mov temp,store1
cpi temp,0x01
brne skip
ldi led,0x01
out portc,led
inc flag

skip:
;-------------------
; SECOND GATE
in store1,pinb    ; third bit
andi store1,0x04  
in store2,pinb    ; fourth bit
andi store2,0x08
clc
ror store2
and store1,store2
mov temp,store1
cpi temp,0x04
brne skip2
ldi led,0x02
out portc,led
inc flag
inc flag
out portc,flag

skip2:
;-------------------
; THIRD GATE
in store1,pinb
andi store1,0x10 ; fifth bit
in store2,pinb
andi store2,0x20 ; sixth bit
clc
ror store2
eor store1,store2
mov temp,store1
cpi temp,0x10
brne skip3
ldi led,0x04
out portc,led
ldi constant,0x04
add flag,constant
out portc,flag

skip3:
;-------------------
; FOURTH GATE
in store1,pinb  ; seventh bit
andi store1,0x40
in store2,pinb  ; eighth bit
andi store2,0x80
clc 
ror store2
eor store1,store2
clc
rol temp
clc 
rol temp
eor temp,store1
cpi temp,0x40
brne skip4
ldi led,0x08
out portc,led
ldi constant,0x08
add flag,constant
out portc,flag

skip4:
in temp,pina
ldi constant,0x09
again:
dec constant
cpi constant,0x00
breq end
ror temp
brcc again
com flag
out portc,flag

;-------------------
; END OF LOOP
end:
jmp main


