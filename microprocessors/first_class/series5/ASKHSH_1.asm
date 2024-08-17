org 100h

jmp start
.data
msg db 0Dh,0Ah, "RESULT:$"
enter db ?
first db ?
var dw ? 
temp dw ? 
sum2 dw ?
quot dw ?

.code
start:
mov enter,0
mov first,0
mov temp,0
mov sum2,0
mov quot,0
mov cx,0
mov bx,0
mov var,0800h  

mainloop:
mov first,1
call valid_HEX_digit
cmp enter,1
jz continue
mov bh,dl
rol bh,4 
mov first,0
call valid_HEX_digit
mov bh,dl
call valid_HEX_digit
mov bl,dl
rol bl,4
call valid_HEX_digit
mov bl,dl
;mov DI,bx
;inc DI
;inc DI 
inc cl
mov ah,2
mov dl,0Dh
int 21h
mov dl,0Ah
int 21h
jmp mainloop

continue:
mov dx, offset msg
mov ah,9
int 21h

mov temp,0
mov bx,0
mov var,0800h
sum_loop:
ror [var],1
jc skip1
rol [var],1
add bx,[var]
jnc skip2
inc sum2 
skip2:
inc temp
skip1:
inc var
inc var
dec cl
jnz sum_loop  

mov dx,sum2
mov ax,bx
div temp        ; AX: QUOTIENT, DX: REMAINDER 
mov quot,dx
and dh,0f0h
rol dh,4
mov dl,dh
call fix_HEX
mov ah,2
int 21h
mov dx,quot
and dh,0fh
mov dl,dh
call fix_HEX
int 21h
mov dx,quot
and dl,0f0h
rol dl,4
int 21h
call fix_HEX
mov dx,quot
and dl,0fh
call fix_HEX  
int 21h

mov dl,0Dh
int 21h
mov dl,0Ah
int 21h
jmp start


valid_HEX_digit:   ;READS A CHARACTER FROM KEYPAD.
go:                ;CHECKS IF THE CHARACTER IS A VALID 
mov ah,08h         ;HEX DIGIT OR "ENTER". 
int 21h            ;CONVERTS THE ASCII CODE OF THE DIGIT
cmp first,1        ;TO THE PROPER FORM.
jnz alles_gut      ;HEX DIGIT--->DL
cmp al,0Dh
jnz alles_gut
mov enter,1
jmp finish
alles_gut:
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
finish:
ret 


fix_HEX:
cmp dl,9
jle 0to9
add dl,37h
jmp fin
0to9:
add dl,30h
fin:
ret