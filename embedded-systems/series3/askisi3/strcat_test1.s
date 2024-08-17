.text
.align 4
.global strcat
.type strcat,%function 
.extern printf 
.extern strlen

strcat:
    push {ip, lr}
    push {r4, r5, r6, r7, r8, r9, r10, r11}
    /*  ldr r0, =string2  test string */
    /*  ldr r1, =string1  test string */

        mov r4, r0  /* r4 is the pointer to the destination string */
        mov r5, r1  /* r5 is the pointer to the source string */
        
        /* print first argument */
/*        ldr r0, =first_arg
        mov r1, r4
        bl printf
*/        
        /* print second argument */
/*        ldr r0, =second_arg
        mov r1, r5
        bl printf
*/        

        mov r0, r4
        bl stlen
        mov r6, r0 /* r6 has now the size of destination string */
        
        mov r7, #0
        add r6, r6, #1
        loop1:
            ldrb r0, [r5, r7]
            strb r0, [r4, r6]
            mov r0, #0
            strb r0, [r4, r6]
            add r6, r6, #1
            add r7, r7, #1
            cmp r0, #0
        bne loop1

/* ----------------------------------------------------------- */
        mov r6, #0 /* counter first string */
        mov r0, r4
        bl strlen
        mov r6, r0
        mov r7, r6 /* r7 now has the size of destination string */

        mov r0, r5
        bl strlen
        mov r9, r0
        add r6, r7, r9
        add r6, r6, #3

        mov r0, r6
        bl malloc
        mov r8, r0    /* r8 now has address that has the number of bytes 
                         that we need to concatinate the two strings    */

        /* copy destination string */
        mov r6, #0
        loop1:
            ldrb r0, [r4, r6]
            cmp r0, #0
            strneb r0, [r8, r6]
            addne r6, r6, #1
        bne loop1
        
        mov r7, r6
        mov r6, #0
        loop2:
            ldrb r0, [r5, r6]
            strb r0, [r8, r7]
            add r6, r6, #1
            add r7, r7, #1
            cmp r0, #0
        bne loop2
        
        mov r0, #0
        strb r0, [r8, r7]
/*
        ldr r0, =exit
        mov r1, r8
        bl printf */
        mov r0, r8

    pop {r4, r5, r6, r7, r8, r9, r10, r11}
    pop {ip, pc}


.data
    string2: .asciz "ABCDEFGHIGKLMNOPQRST"
    string1: .asciz " and i'm an Electrical and Computer Engineer."
    exit: .asciz "Exit: %s\n"
    first_arg: .asciz "First argument: %s\n"
    second_arg: .asciz "Second argument: %s\n"
    testing: .asciz "Test%d\n"
