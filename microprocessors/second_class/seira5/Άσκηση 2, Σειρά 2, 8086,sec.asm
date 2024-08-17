; emu8086 version 4.00-Beta-12 or better is required! 
; put file named "input.txt" to c:\emu8086\vdrive\c\ 
; (it's possible to copy "ReadMe.txt" and rename it or use any other 
; file that contains ASCII chars). 



org 100h            ; .com memory layout 

.data
;array db ?
i db ?
;si db 0h
;temp db ?
;length db ?
file db "c:\input.txt", 0
filename db "output.txt", 0 
handle dw ?
store dw ? 
BUF db ? 
ending db 00h
counter db ?
counter2 db 0 
temp db ?
length db ?
array1 db 200 dup (0)
array db ?           
;array2 db 100 (0)                     
                     ; allagh grammhs
;msg1 db 0Dh,0Ah, "$" ; allazei me to pou to valw se diaforetikh thesi sto .data
                     ; kalytera na to estelna se mia diaforetikh akyrh makrinh thesh mnhmhs

                     
;array2 db ?

   
.code 

;******************
mov ah,01h          ; READ THE INTEGER
int 21h

sub al,30h          ; MAKE IT A NUMBER
mov counter,al      ; SAVE IT INTO VARIABLE COUNTER

;****************** 


;*********************
; NEW LINE
mov ah, 0Eh          ; PRINT NEW LINE SEQUENCE
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;*********************

mov dx, offset file ; address of file to dx 
mov al,0            ; open file (read-only) 
mov ah,3dh 
int 21h             ; call the interupt 
jc terminate        ; if error occurs, terminate program 
mov store,ax
mov bx,ax           ; put handler to file in bx 

mov cx,1            ; read one character at a time 
start:
mov cx,1 
mov bh,00h
mov bl,00h
mov bx,store
mov length,00h
mov si,00h 
mov counter2,00h
print: 
lea dx, BUF 
mov ah,3fh          ; read from the opened file (its handler in bx) 
int 21h 
CMP AX, 0           ; how many bytes transfered? 
JZ terminate        ; end program if end of file is reached (no bytes left). 
mov al, BUF         ; char is in BUF, send to ax for printing (char is in al)
mov ah,0eh          ; print character (teletype). 
int 10h      
mov array[si],al    ; KANEI TO TEMP 69H?????
inc si              ; otan diavazei to 'i' to vazei kai sto length??
cmp al,0Ah
jz  reverse             
jmp print           ; repeat if not end of file. 

terminate:
;************** 
mov ending,01h 
inc si
inc si
jmp reverse


;**************
end: 
mov ah, 0           ; wait for any key... 
int 16h 
ret 


;*******************
; SHIFT ARRAY
reverse:
;mov si,0h
;*********************
; NEW LINE
mov ah, 0Eh          ; PRINT NEW LINE SEQUENCE
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;*********************
mov ah,0h
mov al,0h 
mov ax,si
dec ax 
dec ax
mov length,al      ; to length pairnei to 7 pou einai to ascii tou bell(xontrh boula) kai to vazei kai ston array sthn thesi 4,array[3] pou kanonika einai to 'i'???
cmp al,counter
jae SHIFT2
mov al,counter
sub al,length
mov counter,al
;**********************
;mov si,00h
;loop1:
;mov al,array[si]
;mov array2[si],al
;mov ah,0h
;inc si
;mov ax,si
;cmp al,length
;jnz loop1
;************************ 
SHIFT2:
mov ah,0h
mov al,length
mov si,ax
dec si
SHIFT:
mov al,array[0]
mov temp,al 

mov al,array[si]
mov array[0],al
;*******
mov ah,0h
mov al,length
mov si,ax
dec si
dec si
;mov si,6h
;*******              
again:        
mov al,array[si]
mov array[si+1],al
dec si
cmp si,0
jnz again
mov al,temp
mov array[1],al    ; BAZEI TO 'P'(ARRAY[0]) STO ARRAY[4]????

;********************* 
; SHIFT COUNTER TIMES
inc counter2        ; HOW MANY TIMES TO REPEAT THE SHIFT?
mov al,counter2
cmp al,counter
jnz SHIFT2
;*********************  

mov si,0h
print2:
mov dl,array[si]
mov ah,02h
int 21h
inc si   
mov ah,0h
mov al,0h
mov ax,si
cmp al,length
jb print2

mov ah,0h
mov al,0h
mov ax,si
add al,01h
mov si,ax
;jmp print

;*********************
; NEW LINE
mov ah, 0Eh          ; PRINT NEW LINE SEQUENCE
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;*********************

;*********************
; NEW LINE
mov ah, 0Eh          ; PRINT NEW LINE SEQUENCE
mov al, 0Dh
int 10h
mov al, 0Ah
int 10h 
;*********************


;********************
; WRITE TO FILE
	mov al, 2
	mov dx, offset filename
	mov ah, 3dh
	int 21h
	jc err
	mov handle, ax
	jmp k
;mess1 db ' I WIN! $'
;	handle dw ?
	err:
	; ....
;////	loop
k: 
mov cx,00h
mov si,00h
;k: ;WRITE STRING ON FILE.
mov ah, 40h                         ; write to 
mov bx, handle                      ; file
mov dx, offset array[si]                ; where to find data to write
mov cl, length ;LENGTH OF STRING IN CX.
int 21h 
inc si  

;mov dx, offset msg1
;int 21h
;////
;********************
;*****************
; WRITE ENTER



;*************

;   mov dx,00h
;   lea dx, msg1        ; ds:dx -> data to write
;    mov bx, handle      ; file handle
;   mov cx, 2           ; number of bytes to write
 ;   mov ah, 40h         ; WRITE TO FILE OR DEVICE
;    int 21h 


;*************







;mov al,2  
;mov dx,offset filename
;mov ah,3dh            
;int 21h
;mov handle,ax


;mov ah,40h 
;mov dx, offset msg1
;mov bx, handle
;mov dx, offset msg1 
;int 21h

;*****************
cmp ending,01H
JZ  end
jmp start
END