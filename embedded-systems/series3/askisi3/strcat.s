.text
.align 4
.global strcat
.type strcat,%function 
.extern strlen

strcat:
    push {ip, lr}
    push {r4, r5, r6, r7, r8, r9, r10, r11}

        mov r4, r0  /* r4 is the pointer to the destination string */
        mov r5, r1  /* r5 is the pointer to the source string */
        
        mov r0, r4
        bl strlen
        mov r6, r0 /* r6 has now the size of destination string */
        
        mov r7, #0
        loop1:
            ldrb r0, [r5, r7]
            strb r0, [r4, r6]
            add r6, r6, #1
            add r7, r7, #1
            cmp r0, #0
        bne loop1


    pop {r4, r5, r6, r7, r8, r9, r10, r11}
    pop {ip, pc}


.data
