.text
.align 4
.global strcmp
.type strcmp,%function


strcmp:
    push {ip, lr}
    push {r4, r5, r6, r7, r8, r9, r10, r11}

        mov r4, r0 /* pointer1 */
        mov r5, r1 /* pointer2 */
        
        mov r0, #0 /* default value */
        mov r6, #0 /* counter */
        mov r7, #1 /* sign */
        myLoop:
            ldrb r2, [r4, r6]
            ldrb r3, [r5, r6]

            cmp r2, r3
            addeq r6, r6, #1
            movlt r7, #-1
            movgt r7, #1
            movne r0, r7
            bne return_value
            
            cmp r2, #0
            beq return_value
            cmp r3, #0
            beq return_value
            
            cmp r2, r3
        beq myLoop
        
        return_value:
    pop {r4, r5, r6, r7, r8, r9, r10, r11}
    pop {ip, pc}
.data
