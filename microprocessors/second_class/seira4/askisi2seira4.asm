

org 100h

jmp start

.data
array1 db 9h dup (0)
msg1 db 0Dh,0Ah, " GIVE 3 HEX DIGITS: $" 
msg2 db 0Dh,0Ah, " DECIMAL= $"
var1 dw ?
thousand db ?
hundred db ?
decade db ?
monad db ?
flag db ? 
stop db ?

.code
start:
mov var1,0
mov thousand,0
mov hundred,0
mov decade,0
mov monad,0 
mov flag,0
mov stop,0

mov dx, offset msg1
mov ah,09h
int 21h

;======================
;1ST HEX DIGIT
call valid_HEX_digit
cmp stop,1
jz terminate
mov dh,0        ;PUT 1ST MSB IN THE CORRECT POSITION
rol dx,8        ;IN THE WORD VAR1
mov var1,dx
;=======================

;======================= 
;2ND HEX DIGIT
call valid_HEX_digit
cmp stop,1
jz terminate
mov dh,0        ;PUT 2ND MSB IN THE CORRECT POSITION
rol dx,4        ;IN THE WORD VAR1
add var1,dx 
;======================= 
 
;======================= 
;3RD HEX DIGIT
call valid_HEX_digit
cmp stop,1
jz terminate
mov dh,0       ;PUT LSB IN THE CORRECT POSITION
add var1,dx    ;IN THE WORD VAR1
;======================= 

get_char:                                 
mov ah,08h       ;WAIT FOR STOP OR 'ENTER'
int 21h
cmp al,"U"
jz terminate
cmp al,0dh
jz result
jmp get_char


result:
mov dx, offset msg2
mov ah,09h
int 21h   

;========================
;DECIMAL CONVERTION
mov ax,var1
mov dx,0
mov bx,1000
div bx
mov thousand,al
mov ax,dx
mov bl,100
div bl
mov hundred,al
mov al,ah
mov ah,0
mov bl,10
div bl
mov decade,al
mov monad,ah
;========================      
       
cmp thousand,0     ;IF THOUSAND=0 DONT PRINT THOUSAND
jz check_h
mov flag,1
mov dl,thousand    ;ELSE PRINT THOUSAND AND ","
add dl,30h
mov ah,2
int 21h
mov dl,","
int 21h

check_h:
cmp flag,0        ;IF HUNDRED=0 AND THOUSAND=0
jnz skip1         ;DONT PRINT HUNDRED
cmp hundred,0
jz check_the_d
skip1: 
mov flag,1
mov dl,hundred    ;ELSE PRINT HUNDRED
add dl,30h
mov ah,2
int 21h

check_the_d:
cmp flag,0       ;IF DECADE,HUNDRED,THOUSAND=0
jnz skip2        ;DONT PRINT DECADE
cmp decade,0
jz print_m
skip2:
mov dl,decade    ;ELSE PRINT DECADE
add dl,30h
mov ah,2
int 21h

print_m:
mov dl,monad     ;PRINT MONAD
add dl,30h
mov ah,2
int 21h 

jmp start
 



  
valid_HEX_digit:   ;READS A CHARACTER FROM KEYPAD
go:                ;CHECKS IF THE CHARACTER IS A VALID 
mov ah,08h         ;HEX DIGIT OR THE TERMINATE SIGNAL "U"
int 21h            ;CONVERTS THE ASCII CODE OF THE DIGIT 
cmp al,"U"         ;TO THE PROPER FORM
jz terminate1      ;HEX DIGIT--->BL
cmp al,"0"
jb go
cmp al,"F"
ja go
cmp al,"9"
jle print1
cmp al,"A"
jb go
print1:
mov ah,02h
mov dl,al
int 21h 
cmp dl,"9"
ja AtoF
sub dl,30h
jmp finish
AtoF:
sub dl,37h
jmp finish
terminate1:
mov stop,1
finish:
ret

terminate:

RET