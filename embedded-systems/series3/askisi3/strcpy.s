.text
.align 4
.global strcpy 
.type strcpy,%function

strcpy:
    push {ip, lr}
    push {r4, r5, r6, r7, r8, r9, r10, r11}

    mov r4, r0
    mov r5, r1

    mov r6, #0 
    myLoop:
        ldrb r3, [r5, r6]
        strb r3, [r4, r6]
        add r6, r6, #1
        cmp r3, #0
    bne myLoop
    
    mov r0, r4
    pop {r4, r5, r6, r7, r8, r9, r10, r11}
    pop {ip, pc}

.data
