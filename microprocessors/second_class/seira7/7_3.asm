.include "m16def.inc"

.org 0x0
rjmp reset
.org 0x2
rjmp ISR0
.org 0x10
rjmp ISR_TIMER1_OVF ; ρουτίνα εξυπηρέτησης της διακοπής υπερχείλισης του timer1
;----------
reset:
ldi r24 ,( 1 << ISC01) | ( 1 << ISC00)
out MCUCR , r24
ldi r24 ,( 1 << INT0)
out GICR , r24
sei
;----------
ldi r24 ,(1<<TOIE1) ; ενεργοποίηση διακοπής υπερχείλισης του μετρητή TCNT1
out TIMSK ,r24      ; για τον timer1
;----------
ldi r24 ,(1<<CS12) | (0<<CS11) | (1<<CS10) ; CK/1024
out TCCR1B ,r24
;----------
reset1:

ldi r16,high(ramend)
out sph,r16
ldi r16,low(ramend)
out spl,r16
;----------
clr r21
ldi r16,0x00
out ddrb,r16
ldi r16,0xff
out ddra,r16
check:

in r17,pinb
andi r17,0x01
cpi r17,0x01
breq led_on
in r19,gifr
andi r19,0b01000000
cpi r19,0b01000000
breq led_on

sbis pina,0x07
jmp check
ldi r24,0xA4 ; αρχικοποίηση του TCNT1 to
out TCNT1H ,r24 ; για υπερχείλιση μετά από 5 sec
ldi r24 ,0x73
out TCNT1L ,r24
rcall led_on
jmp check


led_on:
inc r21
ldi r18,0x80
out porta,r18
ret

ISR0:
ldi r24,0xA4 ; αρχικοποίηση του TCNT1 to
out TCNT1H ,r24 ; για υπερχείλιση μετά από 5 sec
ldi r24 ,0x73
out TCNT1L ,r24
rcall led_on
reti

ISR_TIMER1_OVF:
ldi r18,0x00
out porta,r18
reti







