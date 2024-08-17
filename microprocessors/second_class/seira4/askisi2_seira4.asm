name "hex"

org 100h
jmp  code 
 
;result db '000', 0
temp   dw ?
source db 4 dup (0)
msg1 db 0Dh,0Ah, " enter three digit hex number: $"
msg2 db 0Dh,0Ah, " decimal form: $"

; source hex value is 3 char string.
; numeric value is stored into temp,
; and string decimal value is stored into result.
;///





code:
    
mov dx, offset msg1
mov ah, 9
int 21h

mov bx,0               
start5: 

mov ah,8h ; keyboard input subprogram  
int 21h ; read character into al
cmp al,30h 
jb start5 
cmp al,39h 
jz start3
jb start3
ja start2 

start2:
cmp al,41h
jb start5
cmp al,46h
ja start5 
start3:
inc bx  
mov dl,al
mov ah,2h 
int 21h  

mov source[bx],al 
cmp bx,3
jnz start5
 
enter:
mov ah,8h ; keyboard input subprogram  
int 21h ; read character into al
cmp al,0dh 
jnz enter  






;///    

start:  

; convert first digit to value 0..15 from ascii:
mov al, source[1]
cmp al, '0'
jae  c1

c1:
cmp al, '9'
ja c2     ; jumps only if not '0' to '9'.

sub al, 30h  ; convert char '0' to '9' to numeric value.
jmp num3_ready

c2:
; gets here if it's 'a' to 'f' case:
or al, 00100000b   ; remove upper case (if any).
sub al, 57h  ;  convert char 'a' to 'f' to numeric value.

num3_ready:
mov bl,16 
mul bl      ; ax = al * bl

mov bl,16 
mul bl      ; ax = al * bl
mov temp, ax

; convert second digit to value 0..15 from ascii:
mov al, b.source[2]
cmp al, '0'
jae  f1

f1:
cmp al, '9'
ja f2     ; jumps only if not '0' to '9'.

sub al, 30h  ; convert char '0' to '9' to numeric value.
jmp num1_ready

f2:
; gets here if it's 'a' to 'f' case:
or al, 00100000b   ; remove upper case (if any).
sub al, 57h  ;  convert char 'a' to 'f' to numeric value.

num1_ready:
mov bl, 16
mul bl      ; ax = al * bl

add temp, ax


; convert third digit to value 0..15 from ascii:
mov al, source[3]
cmp al, '0'
jae  g1

g1:
cmp al, '9'
ja g2     ; jumps only if not '0' to '9'.

sub al, 30h  ; convert char '0' to '9' to numeric value.
jmp num2_ready

g2:
; gets here if it's 'a' to 'f' case:
or al, 00100000b   ; remove upper case (if any).
sub al, 57h  ;  convert char 'a' to 'f' to numeric value.

num2_ready:
xor ah, ah 
add temp, ax  
; convertion from hex string complete!

; convert to decimal string,
; it has to be 4 decimal digits or less:
 
; print pre-result message:
mov dx, offset msg2
mov ah, 9
int 21h 
 
mov dx,0
mov ax,temp
mov bx,1000
div bx  
;xor ah,ah
;mov al, dl
mov temp,dx
add al,30h 
mov dl, al
mov ah,2
int 21h

mov dx,0
mov ax,temp
mov bx,100
div bx   
mov temp,dx
add al,30h
mov dl,al
mov ah,2
int 21h  

mov dx,0
mov ax,temp
mov bx,10
div bx   
mov temp,dx
add al,30h
mov dl,al
mov ah,2
int 21h 

xor dh,dh 
mov dx,temp
mov ax,dx
add ax,30h
mov dx,ax 
mov ah,2
int 21h 

jmp code
ret