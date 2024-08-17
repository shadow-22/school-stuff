.include "m16def.inc"

.def eisodos=r16
.def flag=r17
.def ekat=r18
.def dek=r19
.def mon=r20
.def count=r21
.def temp=r22
.def temp2=r23

.org 0x0
rjmp reset

reset:
ldi r24 , low(RAMEND) ; initialize stack pointer
out SPL , r24
ldi r24 , high(RAMEND)
out SPH , r24

ser temp
out ddra,temp
out ddrc,temp
out ddrd,temp
clr temp

.org 0x100
main:

ldi ekat,0
ldi dek,0
ldi mon,0

rcall lcd_init

in eisodos,pinb

check_sign:
rol eisodos
brcc positive
negative:
ldi flag,1
jmp check_end
positive:
ldi flag,0
check_end:
ror eisodos
clc

mov temp,eisodos

cpi flag,1
brne end_complement
complement:
mov temp,eisodos
neg temp
end_complement:

find_ekat:
subi temp,100
inc count
cpi temp,0
brpl find_ekat
dec count
mov ekat,count
clr count
ldi temp2,100
add temp,temp2

find_dek:
subi temp,10
inc count
cpi temp,0
brpl find_dek
dec count
mov dek,count
clr count
ldi temp2,10
add temp,temp2

find_mon:
subi temp,1
inc count
cpi temp,0
brpl find_mon
dec count
mov mon,count
clr count
ldi temp2,1
add temp,temp2
clr temp


ldi r24,0b00001100 ; display without cursor
rcall lcd_command
ldi r24,3
clr r25
rcall wait_msec
;-------------------------
; DISPLAY THE BINARY FORM

;mov temp,eisodos
;mov r24,temp
;rcall lcd_data
;ldi r24,5
;rcall wait_msec
;clr temp

mov temp,eisodos
loop:
rol temp
inc count
brcs one
zero:
ldi r24,'0'
rcall lcd_data
ldi r24,5
;rcall wait_msec
cpi count,8
brne loop
jmp end_binary
one:
ldi r24,'1'
rcall lcd_data
ldi r24,5
;rcall wait_msec
cpi count,8
brne loop
end_binary:
clr count
clr temp
;-------------------------
; DISPLAY "="
ldi r24,'='
rcall lcd_data
ldi r24,5
;rcall wait_msec
;-------------------------
; DISPLAY "+" OR "-"
cpi flag,0
brne skip

ldi r24,'+'
rcall lcd_data
ldi r24,5
;rcall wait_msec
jmp end_sign

skip:
ldi r24,'-'
rcall lcd_data
ldi r24,5
;rcall wait_msec
end_sign:
;-------------------------
; DISPLAY THE DECIMAL FORM
display_decimal:

ldi temp,0x30
add temp,ekat

mov r24,temp
rcall lcd_data
ldi r24,5
;rcall wait_msec

ldi temp,0x30
add temp,dek

mov r24,temp
rcall lcd_data
ldi r24,5
;rcall wait_msec

ldi temp,0x30
add temp,mon

mov r24,temp
rcall lcd_data
ldi r24,5
;rcall wait_msec
;-------------------------

ldi r24,0b00001100 ; display without cursor
rcall lcd_command

end:
clr temp
clr count
jmp main

;****************
; LCD-ROUTINES
write_2_nibbles: 
push r24         
in r25 ,PIND       
andi r25 ,0x0f  
andi r24 ,0xf0        
add r24 ,r25     
out PORTD ,r24            
sbi PORTD ,PD3   
cbi PORTD ,PD3  
pop r24                  
swap r24  
andi r24 ,0xf0   
add r24 ,r25 
out PORTD ,r24              
sbi PORTD ,PD3  
cbi PORTD ,PD3 
ret
;-------------
lcd_data:                
sbi PORTD ,PD2       
rcall write_2_nibbles     
ldi r24 ,43                
ldi r25 ,0                   
rcall wait_usec  
ret
;-------------
lcd_command: 
cbi PORTD ,PD2        
rcall write_2_nibbles    
ldi r24 ,39                   
ldi r25 ,0                    
rcall wait_usec          
ret   
;------------
lcd_init:      
ldi r24 ,40            
ldi r25 ,0           
rcall wait_msec      
ldi r24 ,0x30          
out PORTD ,r24                  
sbi PORTD ,PD3        
cbi PORTD ,PD3         
ldi r24 ,39  
ldi r25 ,0                      
rcall wait_usec                                                  
                         
ldi r24 ,0x30         
out PORTD ,r24       
sbi PORTD ,PD3  
cbi PORTD ,PD3  
ldi r24 ,39  
ldi r25 ,0  
rcall wait_usec   
ldi r24 ,0x20                   
out PORTD ,r24          
sbi PORTD ,PD3  
cbi PORTD ,PD3  
ldi r24 ,39  
ldi r25 ,0  
rcall wait_usec       
ldi r24 ,0x28         
rcall lcd_command      
ldi r24 ,0x0c             
rcall lcd_command       
ldi r24 ,0x01              
rcall lcd_command  
ldi r24 ,low(1530)  
ldi r25 ,high(1530)  
rcall wait_usec      
ldi r24 ,0x06             
rcall lcd_command                                                                                       
ret  

wait_msec:
push r24
push r25
ldi r24,low(998)
ldi r25,high(998)
rcall wait_usec
pop r25
pop r24
sbiw r24,1
brne wait_msec
ret

wait_usec:
sbiw r24,1
nop
nop
nop
nop
brne wait_usec
ret
