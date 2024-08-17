.text
.align 4
.global strlen
.type strlen,%function

strlen:
    push {ip, lr}
    push {r4, r5, r6, r7, r8, r9, r10, r11}
        mov r4, #0  
        mov r6, r0
        myLoop:
            ldrb r0, [r6, r4]
            cmp r0, #0
            addne r4, r4, #1
        bne myLoop
        mov r0, r4
    pop {r4, r5, r6, r7, r8, r9, r10, r11}
    pop {ip, pc}


.data
