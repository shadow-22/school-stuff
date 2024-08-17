package hotel.views;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JLabel;
import javax.swing.Timer;

@SuppressWarnings("serial")
/* My simple clock */
public class DigitalClock extends JLabel implements ActionListener {
	
	private Timer t;
	private Integer first_digit_hour = 0;
	private Integer second_digit_hour = 0;
	private Integer first_digit_min = 0;
	private Integer second_digit_min = 0;
	private Integer first_digit_sec = 0;
	private Integer second_digit_sec = 0;
	private Boolean isGameOn = false;
	
	public DigitalClock(Boolean gameIsOn) {
		isGameOn = gameIsOn;
		t = new Timer(1000, this);
		t.start();
		System.out.println("Timer started.");
	}
	
	public Timer getTimer() {
		return this.t;
	}
	
	public void start() {
		isGameOn = true;
	}
	
	public void actionPerformed(ActionEvent ae) {
		
		if (isGameOn.equals(false)) {
			String time = first_digit_hour.toString() + second_digit_hour.toString() + ":" +
					  first_digit_min.toString() + second_digit_min.toString() + ":" + 
					  first_digit_sec.toString() + second_digit_sec.toString();
			setText(time);
			return;
		}
		
		second_digit_sec++;
		if (second_digit_sec > 9) {
			second_digit_sec = 0;
			first_digit_sec++;
		}
		if (first_digit_sec > 5) {
			first_digit_sec = 0;
			second_digit_min++;
		}
		if (second_digit_min > 9) {
			second_digit_min = 0;
			first_digit_min++;
		}
		if (first_digit_min > 5) {
			first_digit_min = 0;
			second_digit_hour++;
		}
		if (second_digit_hour > 9) {
			second_digit_hour = 0;
			first_digit_hour++;
		}
		
		String time = first_digit_hour.toString() + second_digit_hour.toString() + ":" +
					  first_digit_min.toString() + second_digit_min.toString() + ":" + 
					  first_digit_sec.toString() + second_digit_sec.toString();
		setText(time);
	}
	
}
