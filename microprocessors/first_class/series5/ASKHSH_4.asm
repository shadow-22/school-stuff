org 100h

jmp start
.data
array1 db 20 dup (0)      ; 20 CELL-BYTE ARRAY. 
stop db ?                 ; TERMINATION FLAG.
enter db ?                ; 'ENTER' FLAG.


.code
start:
mov stop,0 
mov enter,0
mov bx,0                  ; BX: CELL INDEX
mov cx,0

mainloop:
call valid_character 
cmp stop,1                ; TERMINATION FLAG VALUE CHECK.
jz sudden_death 
cmp enter,1
jz print                  ; 'ENTER' FLAG VALUE CHECK.
mov array1[bx],dl         ; SAVE VALID CHARACTER IN ARRAY1.
inc bx
cmp bx,20                 ; MAX NUMB OF VALID CHARACTERS.
jnz mainloop

print:
cmp bx,0                  ; IF THERE IS NO VALID CHARACTER AND 'ENTER' IS PRESSED, DONT PRINT ANYTHING.
jz start
mov cx,bx                 ; CX <--- ARRAY1 SIZE (NUMBER OF NON EMPTY CELLS). 
mov bx,0
mov ah,2
mov dl,0Dh
int 21h
mov dl,0Ah                ;NEW LINE TO CHECK THE RESULT EASIER.
int 21h

printloop:
mov dl,array1[bx]         ;PRINT THE CONTENT OF THE CELLS IN ORDER.
int 21h
inc bx
cmp bx,cx
jnz printloop

mov dl,0Dh                ;NEW LINE.
int 21h
mov dl,0Ah
int 21h

jmp start


valid_character:   ;READS A CHARACTER FROM KEYPAD
go:                ;CHECKS IF THE CHARACTER IS VALID (0-9 or a-z)
mov ah,08h         ;OR THE TERMINATE KEY BUTTON '=' IS PUSHED.
int 21h            ;CONVERTS CHARACTERS FROM a-z TO A-Z. 
cmp al,'='         ;CHARACTER-->DL
jz terminate1
cmp al,0Dh
jz ok1      
cmp al,"0"
jb go
cmp al,"z"
ja go
cmp al,"9"
jle print1
cmp al,"a"
jb go
print1:
mov ah,02h
mov dl,al
int 21h
cmp dl,"9"
jle finish
sub dl,20h 
jmp finish
terminate1:
mov stop,1
jmp finish
ok1:
mov enter,1
finish:
ret 
 
 
sudden_death:
RET