name "5h_seira_ask1"    

org 100h

.data
msg1 db 0Dh,0Ah, " Enter a string of at most 5 decimal numbers: $" 
msg2 db 0Dh,0Ah, " Enter addition (+) or Subtraction (-) symbol: $"
msg3 db 0dh,0Ah, " Enter a string of at most 5 decimal numbers: $"
msg4 db 0dh,0Ah, " The result is: $"
array1 db 6h dup (0)          ; first number
array2 db 6h dup (0)          ; second number 
array3 db 8h dup (0)   ; united + or -
do db ?                ; operation (add/+) or (sub/-)  
temp1 db ?
temp2 db ?
big db ?

.code 

start:

;**************************************
; WRITE FIRST NUMBER

mov dx, offset msg1
mov ah,09h
int 21h

mov bx,01h

read1:
mov ah,08h
int 21h 
cmp al,0dh
jz operation
cmp al,30h
jb read1
cmp al,3Ah
jae read1
mov dl,al
mov ah,02h
int 21h
sub al,30h
mov array1[bx],al
inc bx
cmp bx,6h 
jz operation
jmp read1

operation:

mov temp1,bl   ; save number of string1
mov bx,1h

;***************************************
; CHOOSE OPERATION

mov dx, offset msg2
mov ah,09h
int 21h

loop:
mov ah,08h
int 21h
cmp al,'+'
jz save1
cmp al,'-'
jnz loop

save1:
mov do,al
mov ah,02h
mov dl,al
int 21h

;**************************************
; WRITE SECOND NUMBER

mov dx, offset msg3
mov ah,09h
int 21h

read2:
mov ah,08h
int 21h  
cmp al,0dh
jz output
cmp al,30h
jb read2
cmp al,3Ah
jae read2
mov dl,al
mov ah,02h
int 21h
sub al,30h
mov array2[bx],al
inc bx
cmp bx,6h
jz output
jmp read2

output:

mov temp2,bl  ; save number of string2
mov bx,1

;**************************************

mov al, temp1
cmp al, temp2
jb biggest
biggest: 
mov al,temp2 
mov big,al ; biggest of the two in big 


;***********************************





;**********************************

continue:

mov al,do
cmp al,'+'
jz addition  

;**************************************
; SUBTRACTION

subtraction:
lea si, array1
lea bx, array2
lea di, array3
mov cl, big
mov ch, 0

minus:
mov al, [si]
sub al, [bx]
mov [di], al
inc si
inc bx
inc di
loop minus
jmp ok1

;**************************************
;  ADDITION

addition:
lea si, array1
lea bx, array2
lea di, array3
;mov al,temp1
mov cl, big
mov ch, 0

sum:
mov al, [si]
add al, [bx]

;////
; what if [si]+[bx]>=Ah=10?  
cmp al, 10
jae fix
jmp continue1
fix: sub al, 10
mov [di], al
mov al, [di-1]
inc al
mov [di-1], al
jmp continue2
continue1:
mov [di], al
continue2:
inc si
inc bx
inc di
loop sum

;*************************************
; DISPLAY

ok1:
mov dx, offset msg4
mov ah,09h
int 21h  
mov cx,0
lea bx, array3

ok:
mov ah,02
mov dl, [bx]   
add dl,30h
int 21h
inc bx
inc cx
cmp cl,big
jz outof
jmp ok

outof:
jmp start

ret