.include "m16def.inc"

.org 0x0
rjmp reset1
.org 0x2
rjmp ISR0
.org 0x10
rjmp ISR_TIMER1_OVF ; ρουτίνα εξυπηρέτησης της διακοπής υπερχείλισης του timer1
;----------
.def on=r21
.def counter=r23
reset1:

ldi r16,high(ramend)
out sph,r16
ldi r16,low(ramend)
out spl,r16

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

;----------
clr r24
clr r21
ldi r16,0x00
out ddrb,r16      ; eisodos/e3odos
ldi r16,0xff
out ddra,r16

;-----------------
check:
push on
push r22
sei            
in r17,pinb      ;elegxos gia pb0
andi r17,0x01
cpi r17,0x01
breq led_on
jmp check
pop r22
pop on


;------------------------


led_on:
cpi on,0x00
breq first_time
ldi r22,0x01
ldi r18,0xff
out porta,r18
ldi on,0x01
ldi r24,0xf0
out TCNT1H,r24
ldi r24,0xbe
out TCNT1L,r24
jmp check



refresh:
ldi r18,0x80
out porta,r18
ldi on,0x01
ldi r24,0xb3
out TCNT1H,r24
ldi r24,0xb5
out TCNT1L,r24
jmp check



first_time:
ldi r18,0x80
out porta,r18
ldi on,0x01
ldi r24,0xA4 ; αρχικοποίηση του TCNT1 to
out TCNT1H ,r24 ; για υπερχείλιση μετά από 3 sec
ldi r24 ,0x73
out TCNT1L ,r24
jmp check
;----------------------------------------
ISR0:
push on
push r22

in r23,sreg
push r23
rcall led_on
pop r23
out sreg,r23
pop r22
pop on
reti

;-----------------------------


ISR_TIMER1_OVF:
ldi r24,0x00
cpi r22,0x01
breq rr
ldi r18,0x00
out porta,r18
ldi on,0x00
jmp check
rr:
ldi r22,0x00
jmp refresh

cpi r22,0x01
brne led_off
rcall refresh
jmp check
led_off:
ldi r18,0x00
out porta,r18
clr r21
jmp check
