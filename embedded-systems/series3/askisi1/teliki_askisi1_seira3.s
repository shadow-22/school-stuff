.text
.global main
.extern scanf
.extern printf

check_char:
    push {ip, lr}

    /* ascii table checkup */

    check_small:
        cmp r1, #97
        blt check_capital
        cmpge r1, #122
        suble r1, r1, #32
        b print_and_return
    
    check_capital:
        cmp r1, #65
        blt check_number
        cmpge r1, #90
        addle r1, #32
        b print_and_return

    check_number:
        cmp r1, #48
        blt print_and_return
        cmpge r1, #57
        bgt print_and_return
        /* it's a number */
        cmp r1, #53
        addlt r1, r1, #5
        subgt r1, r1, #5
        b print_and_return
    
    print_and_return:
    bl printf
    pop {ip, pc}


/* printCharacter: Given every character that was typed it
                   makes the necessary adjustments and 
                   prints it back on the screen */
printCharacter:
    push {ip, lr}
    ldr r0, =currChar
    mov r1, r6
    bl check_char 
    pop {ip, pc}

main:
    push {ip, lr}
    
    forever_and_ever:
        ldr r0, =enter
        bl printf

        ldr r0, =input
        ldr r1, =inputString
        bl scanf /* space breaks scanf */
                
        ldr r0, =inputString
        bl strlen

        mov r5, r0 /* r5 now has the length of the string read */
        
        cmp r5, #32
        movge r5, #32 /* if input is longer than 32 characters then ignore the extra characters */ 
        
        cmp r0, #1 /* if string's length isn't 1 there's no need to check for Q or q */
        bgt dont_stop_yet
        ldr r0, =inputString
        ldrb r1, [r0, #0]
        cmp r1, #113
        beq demis_no_more
        cmp r1, #81
        beq demis_no_more
        dont_stop_yet:

        ldr r0, =exit
        bl printf

        ldr r0, =inputString

        ldr r2, =inputString /* pointer */
        mov r4, #0 /* index */
        
        myLoop:
            ldr r2, =inputString
            ldrb r6, [r2, r4]
            bl printCharacter
            add r4, r4, #1
            cmp r4, r5
        ble myLoop

        ldr r0, =newLine
        bl printf
    
        b forever_and_ever
    demis_no_more:

    mov r0, #0
    pop {ip, pc}

.data
    enter: .asciz "Enter: "
    exit: .asciz "Exit:  "
    length: .asciz "Length: %d\n"
    input: .asciz "%s"
    output: .asciz "%s"
    currChar: .asciz "%c"
    newLine: .asciz "\n\n"
    inputString: .asciz "%s" 
