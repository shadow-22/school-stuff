name "trith askhsh"

org 100h

.data
array0 db 16h DUP (0)   ; STORING OF INPUT
space db 150h dup(0)    ; ITS ABSENCE FUCKS UP THE VARIABLES
msg1 db 0Dh,0Ah, "Enter a string of characters,numbers and spaces: $"
msg2 db 0Dh,0Ah, "Result is: $" 
msg3 db 0Dh,0Ah, "*************************************************$"
notifier db 0
notifier2 db 0
minimum db 0
thesimin db 0
minimum2 db 0
thesimin2 db 0
counter1 db 0
counter2 db 0 

.code
start:
;----------------------------
; INITIALIZE ALL VARIABLES AND REGISTERS
mov dx,0h
mov bx,0h         ; ARRAY INDEX
mov cx,0h         ; LENGTH OF STRING 
mov notifier,0    ; NUMBER COUNTER
mov notifier2,0   ; LOOP COUNTER
mov minimum,0     ; SMALLEST NUMBER
mov minimum2,0    ; SECOND SMALLEST
mov thesimin,0    ; INDEX OF SMALLEST
mov thesimin2,0   ; >>    >> SECOND >>
mov counter1,0    ; MIN COUNTER
mov counter2,0    ; LOOP COUNTER, COULD BE REPLACED WITH NOTIFIER2 PROBABLY
;----------------------------
; NEW LINE
mov ah, 0Eh       ; PRINT NEW LINE SEQUENCE
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;----------------------------
; PRING MSG1
mov dx, offset msg1
mov ah, 09h
int 21h
;----------------------------
; READ INPUT
read:             
mov ah,08h
int 21h 
cmp al,'*'        ; IF '*'
jz end            ; END PROGRAM
cmp al,0dh        ; IF 'ENTER'
jz moveon         ; END STRING
cmp al,20h        ; IF 'SPACE'
jz store          ; STORE IT
cmp al,30h        ; IF <'0'
jb read           ; NEXT ONE
cmp al,7Bh        ; IF >'z'
jae read          ; NEXT ONE
cmp al,5Bh        ; IF >'Z'
jae examine1      ; EXAMINE
cmp al,3Ah        ; IF >'9'
jae examine2      ; EXAMINE
;----------------------------
; INPUT IS CORRECT
store:
mov array0[bx],al ; STORE INPUT 
inc bx 
mov dl,al
mov ah,02h
int 21h
cmp bx,16         ; IF INPUT=16
jz  moveon        ; END STRING
jae moveon        
jmp read          ; NEXT INPUT
;----------------------------
; EXAMINE INPUT
examine1:
cmp al,7Bh
jae read
cmp al,60h
jz read
jb read
jmp store
examine2:
cmp al,40h
jz read
jb read
jmp store 
;----------------------------
; THE STRING HAS BEEN STORED
moveon:
mov cx,bx            ; LENGTH OF STRING
mov bx,0             ; INITIALIZE ARRAY INDEX
;----------------------------
; PRINT NEW LINE
mov ah, 0Eh          
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;----------------------------
; PRINT MSG2:  
mov dx, offset msg2
mov ah,09h
int 21h
;----------------------------
; PRINT UPPER CASE
loop1:
mov al,array0[bx] 
cmp al, 'A'
jae check1
inc bx
cmp bx,cx
jnz loop1
jmp next1

check1:
cmp al,'Z'
jz print1
jb print1
inc bx 
cmp bx,cx
jz next1
jmp loop1

print1:
mov dl,al
mov ah,02h
int 21h
inc bx
cmp bx,cx
jae next1
jmp loop1
;---------------------------- 
; PRINT '-'
next1:
mov al,'-'
mov dl,al
mov ah,02h
int 21h
mov bx,0          ; INITIALIZE ARRAY INDEX
;----------------------------
; PRINT LOWER CASE
loop2:
mov al,array0[bx]
cmp al,'a'
jz print2
jae print2
inc bx
cmp bx,cx
jnz loop2
jmp next2

print2: 
mov dl,al
mov ah,02h
int 21h
inc bx
cmp bx,cx
jae next2
jmp loop2
;----------------------------  
; PRINT '-'
next2:
mov al,'-'
mov dl,al
mov ah,02h
int 21h
mov bx,0           ; INITIALIZE ARRAY INDEX
mov ah,0h
;----------------------------
; PRINT NUMBERS
loop3:
mov al,array0[bx]
cmp al,'9'
jz print3
jb print3
skipspace:         
inc bx
cmp bx,cx
jnz loop3
jmp pass
print3:
cmp al,20h         ; IGNORE SPACE
jz skipspace
;----------------------------
; MIN
inc notifier
cmp notifier,1h
jz  min
;----------------------------
continue:      
cmp al,minimum
jl min2 
continue2:    
mov dl,al
mov ah,02h
int 21h
inc bx
cmp bx,cx
jae pass
jmp loop3
jmp pass      
;----------------------------
min:
mov minimum,al
mov thesimin,bl
jmp continue
min2:
mov minimum,al 
mov thesimin,bl
jmp continue2
;----------------------------
pass: 
;----------------------------
; PRINT NEW LINE
mov ah, 0Eh        
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;----------------------------
; WHAT IF NO NUMBER?
mov al,notifier,
cmp al,0h
jz start
;---------------------------- 
; WHAT IF ONLY 1 NUMBER?
mov al,notifier
cmp al,1h
jnz goon
mov bl,thesimin
mov bh,00h
mov al,array0[bx]
mov dl,al
mov ah,2
int 21h
jmp over
goon: 
;----------------------------
; WHAT IF MIN 2 TIMES? 
mov ax,0h
mov bx,0h
loop4:
mov al,array0[bx]
cmp al,minimum
jz counter
inc bx
cmp bx,cx
jnz loop4
jmp stop
counter:
inc counter1
cmp counter1,2h
jz stoploop
inc bx 
cmp bx,cx
jnz loop4 
jmp stop
stoploop:
mov bh,0
mov bl,thesimin
mov al,array0[bx]
mov dl,al
mov ah,2h
int 21h
inc counter2
cmp counter2,2h
jz start
jmp stoploop
stop: 
mov ax,0h
;----------------------------
; FIND SECOND MIN
mov bx,0h   
whatever1:            
mov al,array0[bx]
cmp al,':'
jb  exspace
jz back    
jmp forward 
back: 
inc notifier2
mov ah,notifier2
cmp ah,1h
jz whatever2
jmp whatever3
whatever2: 
mov al,minimum
mov minimum2,al
mov al,array0[bx] 
whatever3:
sub al,minimum
cmp al,minimum2
jl continue3
jmp forward
continue3:
mov minimum2,al
mov thesimin2,bl
forward:
inc bx
cmp bx,cx
jnz whatever1
jmp jumpover

exspace:
cmp al,minimum
jz forward
cmp al,20h
jnz back
jmp forward        ; for '9' case,i think...
;----------------------------
; WHICH CAME FIRST?
jumpover:
mov al,thesimin
sub al,thesimin2
jb display1
jmp display2
;----------------------------
; DISPLAY TWO SMALLEST
display1:
mov bh,0h
mov bl,thesimin
mov al,array0[bx]
mov dl,al
mov ah,02h
int 21h
mov bl,thesimin2
mov al,array0[bx]
mov dl,al
mov ah,02h
int 21h         
jmp over         
display2:
mov bh,0h
mov bl,thesimin2
mov al,array0[bx]
mov dl,al
mov ah,02h
int 21h
mov bl,thesimin
mov al,array0[bx]
mov dl,al
mov ah,02h
int 21h
;----------------------------
over: 
;----------------------------
; PRINT NEW LINE
mov ah, 0Eh        
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;----------------------------
; PRINT NEW LINE
mov ah, 0Eh        
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;----------------------------
; PRINT MSG3
mov dx,offset msg3
mov ah,09h
int 21h
;----------------------------

jmp start ; NEXT STRING

end:

ret ; END THE PROGRAM