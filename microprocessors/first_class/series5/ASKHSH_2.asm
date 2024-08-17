org 100h

jmp start

.data
msg1 db 0Dh,0Ah, "Z=$"  
msg2 db " W=$" 
msg3 db 0Dh,0Ah, "Z+W=$"  
msg4 db " Z-W=$"  
msg5 db 0Dh,0Ah, "ERROR$"
varZ dw ?      
varW dw ?
varADD dw ?
varSUB dw ?
error db ?
flag1 db ?
flag2 db ?

.code
start:
mov varZ,0            ; INITIALIZE VARIABLES.
mov varW,0
mov varADD,0
mov varSUB,0
mov error,0
mov flag1,0 
mov flag2,0

mov dx, offset msg1   ;PRINT MESSAGE 1.
mov ah,09h
int 21h

;=================================
;Z 1st HEX DIGIT  
call valid_HEX_digit
cmp error,1            ;IF VARIABLE ERROR IS 1 PRINT ERROR.
jz print_ERROR         ;(ERROR=1: 'ENTER' IS PRESSED ---> NO 2 VALID HEX DIGITS).
rol dl,4               ;PUT THE 1ST FEX DIGIT (4BITS) IN THE 2ND LESS SIGNIFICANT POSITION OF THE WORD varZ.
mov dh,0
mov varZ,dx  
;=================================

;=================================
;Z 2nd HEX DIGIT
call valid_HEX_digit
cmp error,1
jz print_ERROR
mov dh,0
add varZ,dx            ;PUT THE 2ND HEX DIGIT (4BITS) INT THE LESS SIGNIFICANT POSITION OF THE WORD varZ.
;=================================

mov dx, offset msg2    ;PRINT MESSAGE 2.
mov ah,09h
int 21h

;=================================
;W 1st HEX DIGIT        ;SIMILAR OPORATION FOR varW AS varZ.
call valid_HEX_digit
cmp error,1
jz print_ERROR
rol dl,4
mov dh,0
mov varW,dx  
;=================================

;=================================
;W 2nd HEX DIGIT
call valid_HEX_digit
cmp error,1
jz print_ERROR
mov dh,0
add varW,dx  
;=================================

mov ah,08h       ;WAIT FOR 'ENTER'.
int 21h          ;IF ITS NOT ENTER PRINT ERROR.
cmp al,0dh
jnz print_ERROR

;=================================
;ADD
mov ax,varZ        ;varADD IS A WORD BECAUSE IN SOME CASES IT IS A 3 DIGIT HEX NUMBER.
mov bx,varW        ;(E.G. : FF+01=100, FF+FF=1FE )
add ax,bx
mov varADD,ax
;=================================

;=================================
;SUB
mov ax,varZ
mov bx,varW
cmp ax,bx          ;COMPARE varZ-varW
jl minus           ; IF varZ>varW --> Z-W
sub ax,bx          ; IF varZ<varW --> -(W-Z)
mov varSUB,ax
jmp print_ADD_result
minus:
sub bx,ax
mov varSUB,bx
mov flag1,1        ; IF varZ<varW, FLAG1=1

;=================================
print_ADD_result:
mov dx, offset msg3    ;PRINT MESSAGE 3.
mov ah,09h
int 21h

mov ax,varADD  ;3rd DIGIT (MOST SIGNIFICANT).
and ax,0f00h   
ror ax,8
cmp al,0       
jz skip1       ;DONT PRINT 3rd DIGIT IF IT IS 0.
call fix_ASCII
mov ah,2
int 21h  
jmp ok3

skip1:
mov flag2,1    ;FLAG2=1 IF 3rd DIGIT IS 0.

ok3:
mov ax,varADD  ;2nd DIGIT.
and ax,00f0h
ror ax,4
cmp flag2,0    ;IF 3rd DIGIT IS 0 AND 2nd DIGIT IS 0, DONT PRINT 2nd DIGIT.
jz ok2
cmp al,0
jz skip2  
ok2:
call fix_ASCII
mov ah,2
int 21h

skip2:
mov ax,varADD   ;3rd DIGIT (LESS SIGNIFICANT).
and ax,000fh
call fix_ASCII
mov ah,2
int 21h

;==================================
;print SUB result
mov dx, offset msg4    ;PRINT MESSAGE 4.
mov ah,09h
int 21h

cmp flag1,1          ;IF FLAG1=1, PRINT '-' BEFORE THE SUB RESULT.
jnz skip3
mov dl,'-'
mov ah,2
int 21h

skip3:
mov ax,varSUB     ;2nd DIGIT (MOST SIGNIFICANT).
and ax,00f0h
ror al,4
cmp al,0
jz skip4
call fix_ASCII
mov ah,2
int 21h

skip4:
mov ax,varSUB      ;1st DIGIT (LESS SIGNIFICANT).
and ax,000fh
call fix_ASCII
mov ah,2
int 21h
jmp start

;===================================
print_ERROR:
mov dx, offset msg5     ;PRINT ERROR MESSAGE.
mov ah,9
int 21h
jmp start




valid_HEX_digit:   ;READS A CHARACTER FROM KEYPAD.
go:                ;CHECKS IF THE CHARACTER IS A VALID 
mov ah,08h         ;HEX DIGIT OR "ENTER". 
int 21h            ;CONVERTS THE ASCII CODE OF THE DIGIT
cmp al,0dh         ;TO THE PROPER FORM.
jz terminate1      ;HEX DIGIT--->DL
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
mov error,1
finish:
ret

fix_ASCII:      ;CONVERTS A HEX DIGIT TO THE PROPER ASCII CODE.
cmp al,9        
ja A_to_F
add al,30h
jmp ok
A_to_F:
add al,37h
ok:
mov dl,al
ret


RET