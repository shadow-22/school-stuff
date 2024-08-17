org 100h

jmp start

.data
byte db ?
terminate db ?       

.code
start:
mov byte,0
mov terminate,0
call hex_keyb     ;1st VALID HEX DIGIT.
cmp terminate,1   ;TERMINATE CONDITION.
jz finito 
rol dl,4          ;4 TIMES LEFT SHIFT FOR THE 1ST DIGIT.
mov byte,dl       ;TAKES THE MOST SIGNIFICANT POSITION IN BYTE.
call hex_keyb     ;2nd VALID HEX DIGIT.
cmp terminate,1
jz finito
add byte,dl       ;TAKES THE LESS SIGNIFICANT POSITION IN BYTE.
mov ah,2
mov dl,' '
int 21h 

mov bl,byte
call print_dec   ;PRINT DEC.
mov dl,'='       ;PRINT '='.
mov ah,2
int 21h 

mov bl,byte
call print_oct   ;PRINT OCT.
mov dl,'='       ;PRINT '='.
mov ah,2
int 21h  

mov bl,byte 
call print_bin   ;PRINT BIN.
mov ah,2
mov dl,0Ah       ;NEW LINE.
int 21h
mov dl,0Dh
int 21h
jmp start
          
          
          
print_dec: 
mov cx,0
mov al,bl        ;AL <-- HEX NUMBER
mov ah,0
mov bl,100       ;AL/100. MAX HEX NUMB IS FFH -> 255 (DEC)
div bl
mov ch,ah        ;SAVE THE REMAINDER.
cmp al,0         ;CHECK IF QUOTIENT IS 0.
jz check_decade  ;IF YES DONT PRINT HUNDREND.
mov cl,1
mov ah,2
mov dl,al        ;PRINT HUNDERED.
add dl,30h
int 21h
check_decade:
mov al,ch        ;THE REMAINDER FROM THE PREVIOUS DIVISION IS NOW THE DIVIDEND.
mov ah,0         ;THE PREVIOUS REMAINDER DIVIDED BY 10.
mov bl,10
div bl 
mov ch,ah        ;SAVE THE NEW REMAINDER.
cmp cl,1
jz print_decade  ;IF HUNDRED IS 0 AND DECADE IS 0 DONT PRINT DECADE.
cmp al,0
jz print_monad
print_decade:    ;PRINT DECADE.
mov ah,2
mov dl,al 
add dl,30h
int 21h
print_monad:     ;PRINT MONAD.
mov dl,ch
add dl,30h
mov ah,2
int 21h  
ret 


print_oct:        ;SIMILAR AS THE DECIMAL CONVERTION. THE DIVISORS HERE ARE 64 AND 8.
mov cx,0          ;MAX HEX NUMB FFH -> 377 (OCT). SO 3 DIGITS MAX REQUIRED.
mov al,bl
mov ah,0
mov bl,64
div bl 
mov ch,ah
cmp al,0
jz check_2nd_digit
mov cl,1
mov ah,2
mov dl,al
add dl,30h
int 21h
check_2nd_digit:
mov al,ch
mov ah,0
mov bl,8
div bl 
mov ch,ah
cmp cl,1
jz print_2nd_digit
cmp al,0
jz print_3rd_digit
print_2nd_digit:
mov ah,2
mov dl,al 
add dl,30h
int 21h
print_3rd_digit: 
mov dl,ch
add dl,30h
mov ah,2
int 21h  
ret 


print_bin:              ;PRINT BINARY. MOST SIGNIFICANT 0 IS IGNORED.
mov cl,0                ;THIS LOOP SHIFTS LEFT THE BYTE UNTIL THE 1st ACE APPEARS. 
ignore_msb_0: 
inc cl
cmp cl,9                ;IF THERE IS NO ACE PRINT A SINGLE ZERO ( "0" ).
jz print_0
rol bl,1
jnc ignore_msb_0  

dec cl 
ror bl,1                
print_loop:             ;THIS LOOP BEGINS WHERE THE PREVIOUS ENDS.
inc cl                  ;SHIFTS LEFT THE BYTE AND PRINTS 0 OR 1 DEPENDING ON THE VALUE OF THE CARRY BIT.
cmp cl,9
jz stop
rol bl,1
jc print_1
mov ah,2
mov dl,30h
int 21h
jmp skip 
print_1:
mov ah,2
mov dl,31h
int 21h 
skip:
jmp print_loop


print_0:
mov ah,2
mov dl,30h
int 21h

stop:
ret


hex_keyb:          ;READS A CHARACTER FROM KEYPAD
go:                ;CHECKS IF THE CHARACTER IS A VALID 
mov ah,08h         ;HEX DIGIT OR THE TERMINATE SIGNAL "T"
int 21h            ;CONVERTS THE ASCII CODE OF THE DIGIT 
cmp al,"T"         ;TO THE PROPER FORM
jz terminate1      ;HEX DIGIT--->DL
cmp al,"0"
jb go
cmp al,"F"         ;READS AND PRINTS THE VALID HEX DIGIT.
ja go              ;I WAS NOT SURE IF THE PROGRAMM SHOULD ALSO PRINT THE HEX NUMBER.
cmp al,"9"         ;I DID IT TO BE ABLE TO SEE THE HEX NUMBER.
jle print1         ;IF THE PROGRAMM MUST ONLY READ, THE PRINT INSTRUCTIONS SHOULD BE IGNORED.
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
mov terminate,1
finish:
ret


finito:
RET
