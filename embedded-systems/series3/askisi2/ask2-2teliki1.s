.text
.global main
.extern scanf
.extern printf
.extern strlen
.extern malloc
.extern free

print_conversion:
    push {r7, ip, lr}
        ldr r0, =currChar
        mov r1, r11
        ldrb r1, [r1, r5]
        bl printf

        /* write that to the file */
        ldr r0, =fd
        ldr r0, [r0]
        mov r1, r11
        ldrb r1, [r1, r5]
        mov r2, #1
        mov r7, #4
        swi 0
        
        ldr r0, =tempChar
        mov r1, r11
        ldr r1, [r1, r5]
        str r1, [r0]
        ldr r1, =tempChar
        ldr r0, =fd
        ldr r0, [r0]
        mov r2, #1
        mov r7, #4
        swi 0
        
        ldr r0, =helper1
        bl printf
        
        ldr r0, =helper1
        bl strlen
        mov r2, r0
        ldr r0, =fd
        ldr r0, [r0]
        ldr r1, =helper1
        mov r7, #4
        swi 0
        
        ldr r0, =helper2
        mov r1, r6
        bl printf
        
        ldr r0, =tempChar
        mov r1, r6
        
        /* problem if it appears more than 9 times */
        cmp r1, #9
        ble skip_fix
        push {r3, r4}
        mov r3, #0
        mov r4, #0
        fix_loop:
        cmp r1, #9
        ble skip_loop
        subgt r1, r1, #10
        add r3, r3, #1
        b fix_loop
        skip_loop:
        mov r4, r1
        /* r3 has first digit, r4 has second one */
        /* print r3 */
        ldr r0, =tempChar
        mov r1, r3
        add r1, r1, #48
        str r1, [r0]
        ldr r1, =tempChar
        ldr r0, =fd
        ldr r0, [r0]
        mov r2, #1
        mov r7, #4
        swi 0
        /* print second digit */
        ldr r0, =tempChar
        mov r1, r4
        add r1, r1, #48
        str r1, [r0]
        ldr r1, =tempChar
        ldr r0, =fd
        ldr r0, [r0]
        mov r2, #1
        mov r7, #4
        swi 0
        pop {r3, r4}
        b print_new_line

        skip_fix:
        /* this is the end of fix*/
        add r1, r1, #48
        str r1, [r0]
        ldr r1, =tempChar
        ldr r0, =fd
        ldr r0, [r0]
        mov r2, #1
        mov r7, #4
        swi 0
        
        print_new_line:
        ldr r0, =tempChar
        mov r1, #'\n'
        str r1, [r0]
        ldr r1, =tempChar
        ldr r0, =fd
        ldr r0, [r0]
        mov r2, #1
        mov r7, #4
        swi 0

    pop {r7, ip, pc}


do_things:
    push {ip, lr}

        mov r0, r11
        bl strlen
        mov r4, r0
        cmp r4, #32
        movgt r4, #32
        mov r5, #0 /* index */
        mov r9, r11

        loop_exterior:
            ldrb r8, [r9, r5]
            cmp r8, #33
            blt skip_curr_char
           
            cmp r5, #0
            ble skip_checking
            /* check if it has already been processed */
                mov r1, r5
                checking:
                sub r1, r1, #1
                ldrb r0, [r9, r1]
                cmp r0, r8
                beq skip_curr_char
                cmp r1, #0
                bne checking
            skip_checking:

            mov r6, #0 /* counter */
            mov r7, #0 /* inside index */
            
            loop_interior:
                ldrb r2, [r9, r7]
                cmp r2, r8
                addeq r6, r6, #1
                add r7, r7, #1
                cmp r7, r4
            bne loop_interior

            bl print_conversion

            skip_curr_char:
            add r5, r5, #1
            cmp r5, r4
        bne loop_exterior

    pop {ip, pc}

main:
    push {ip, lr}    
        forever_and_ever:
            ldr r0, =enter
            bl printf
            
            ldr r0, =nameOutput

         /*   mov r1, #1089 */ /* this will fail, 1089 is too large for mov instruction */
            ldr r1, =1089
            mov r7, #5
            swi 0
             
            ldr r1, =fd
            str r0, [r1]

            mov r0, #200
            bl malloc
            mov r11, r0

            ldr r0, =input
            mov r1, r11
            bl scanf 
            
            /* check if scanf failed */
            cmp r0, #0
            ldreq r0, =scanFail
            bleq printf
            beq demis_no_more

            mov r0, r11
            bl strlen
            mov r10, r0
            
            /* check for size */
            /*
            ldr r0, =length
            mov r1, r10
            bl printf
            */

            mov r0, r10
            cmp r0, #1
            bgt go_on
                mov r0, r11
                ldrb r0, [r0, #0]
                cmp r0, #113
                beq demis_no_more
                cmp r0, #'Q'
                beq demis_no_more
            go_on:
            
            bl do_things      
            ldr r0, =newLine
            bl printf
            
            /* doesn't seem to work :( */
            /*
            ldr r0, =fd
            ldr r0, [r0]
            ldr r1, =anotherInput
            mov r7, #4
            swi 0
            */

           
            mov r0, r11
            bl free
/*            
            mov r0, #1
            bl fflush
*/            
      /*      b demis_no_more  */

            /*
            sub r10, r10, #1
            cmp r10, #0
            bne forever_and_ever
            */
            do_it_again:
            ldr r0, =tempChar
            bl getchar
            b forever_and_ever
        demis_no_more:
    pop {ip, pc}

.data
    enter: .asciz "Enter: "
    exit: .asciz "You typed: %s\n"
    length: .asciz "Length: %d\n"
    input: .asciz "%[^\n]s"
    output: .asciz "%s"
    currChar: .asciz "%c"
    newLine: .asciz "\n\n"
    conv: .asciz "%c -> %d\n"
    helper1: .asciz " -> "
    helper2: .asciz "%d\n"
    fd: .word 1 
    nameOutput: .asciz "out"
    tempChar: .byte 's'
    anotherInput: .asciz "Another input\n"
    scanFail: .asciz "Scanf Failed!\n"
