
org 100h

jmp start

.data
array1 db 9h dup (0)
msg1 db 0Dh,0Ah, " Give a 9-bit 2's complement number: $" 
msg2 db 0Dh,0Ah, " Decimal: $"
var1 db ?
var2 db ?
flag db ?

.code
start:
mov dx, offset msg1
mov ah,09h
int 21h

mov var1,0
mov var2,0
mov bx,0ffffh 

enter:
mov flag,0 
inc bx
cmp bx,07h
jz put_dot
;============================================ 
get_char1:
mov ah,08h
int 21h
cmp al,"B"             ; check if "B" has entered
jnz cmp_0a
mov flag,1             ;if yes flag=1
jmp get_char1

cmp_0a:                ; print "0"     
cmp al,"0"
jz print_binary1

cmp_1a:            
cmp al,"1"             ; if "1" has entered after "B"    
jnz cmp_3a             ; then flag=2 and don't print "1"
cmp flag,1             ; else print "1"
jnz print_binary1
mov flag,2
jmp get_char1
                         
cmp_3a:                ; if "3" has entered after "B1" string
cmp al,"3"             ; then end programm
jnz get_char1
cmp flag,2
jz end_prog
jmp get_char1  



;============================================             
print_binary1:
mov ah,02h
mov dl,al
int 21h            ; print binary (integer part)  
sub al,30h
add var1,al        ; save integer in var1
rol var1,1
jmp enter
;=============================================
put_dot:
mov cl,al
mov ah,02h
mov dl,2Eh         ; print dot
int 21h
mov al,cl 
mov bx,0ffffh 
jmp continue 
;=============================================



continue:
mov flag,0
inc bx
cmp bx,2
jz print_message2
;=============================================== 
get_char2:
mov ah,08h
int 21h
cmp al,"B"            ; check if "B" has entered
jnz cmp_0b
mov flag,1            ;if yes flag=1
jmp get_char2

cmp_0b:               ; print "0"      
cmp al,"0"
jz print_binary2

cmp_1b:            
cmp al,"1"            ; if "1" has entered after "B"     
jnz cmp_3b            ; then flag=2 and don't print "1"
cmp flag,1            ; else print "1"
jnz print_binary2
mov flag,2
jmp get_char2
 
cmp_3b:              ; if "3" has entered after "B1" string
cmp al,"3"           ; then end programm
jnz get_char2
cmp flag,2
jz end_prog
jmp get_char2 


;=============================================
print_binary2:
mov ah,02h
mov dl,al
int 21h              ; print binary (fraction part)
sub al,30h
add var2,al
rol var2,1
jmp continue
;=============================================  
 
 
;=============================================
print_message2:
mov dx, offset msg2
mov ah,09h     
int 21h

rol var1,1
jnc positive
ror var1,2
ror var2,1  
;================================================           
negative:
mov ah,02h        ; print "-"
mov dl,"-"  
int 21h

not var1          ;/ 1's complement
and var1,7fh
not var2
and var2,03h      ;/

add var2,1        ;/ 2's complement
and var2,3
cmp var2,0
jnz decimal_con
add var1,1        ;/
jmp decimal_con
;================================================

positive:
ror var1,2
ror var2,1 
cmp var1,0
jnz skip
cmp var2,0
jnz skip
mov ah,02h      ; print "0"
mov dl,"0"  
int 21h
jmp start
skip:
mov ah,02h      ; print "+"
mov dl,"+"  
int 21h

;================================================
decimal_con:
mov ah,0
mov al,var1
mov bl,10      ; var1/10
div bl 
mov ch,ah      ;al<--piliko, ah<--ipoloipo
mov dl,al
cmp dl,0
jz print_monad
add dl,30h     ;print decade if not 0
mov ah,2
int 21h
print_monad:
mov ah,2       ;print monad
mov dl,ch
add dl,30h
int 21h

mov ah,02h         ;/ print dot
mov dl,2Eh          
int 21h            ;/

cmp var2,0
jz print_00
cmp var2,1
jz print_25
cmp var2,2
jz print_50
cmp var2,3
jz print_75

print_00:
mov ah,02h         
mov dl,"0"          
int 21h
mov ah,02h         
mov dl,"0"          
int 21h
jmp finish


print_25:
mov ah,02h         
mov dl,"2"          
int 21h
mov ah,02h         
mov dl,"5"          
int 21h
jmp finish

print_50: 
mov ah,02h         
mov dl,"5"          
int 21h
mov ah,02h         
mov dl,"0"          
int 21h 
jmp finish

print_75:
mov ah,02h         
mov dl,"7"          
int 21h
mov ah,02h         
mov dl,"5"          
int 21h

finish:
jmp start  
end_prog:
ret


;FOR MORE COMMENTS ABOUT THE PROGRAMM SEE THE PDF DOCUMENT

