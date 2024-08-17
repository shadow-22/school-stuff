package hotel.views;

import java.awt.Color;
import java.awt.Font;
import java.awt.Graphics;
import java.util.ArrayList;
import java.util.List;

import javax.swing.JPanel;

@SuppressWarnings("serial")
/* Yes, it's ugly */
public class MainGrid extends JPanel {

	public static Integer spacing = 9;
	FirstHotelGui pointer = null;
	GameLogic gamePtr = null;
	
	public MainGrid() {
		
	}
	
	public MainGrid(FirstHotelGui ptr) {
		pointer = ptr;
	}
	
	public void setGamePtr(GameLogic gamePtr) {
		this.gamePtr = gamePtr;
	}
	
	public void paintComponent(Graphics g) {
		
		System.out.println("\npaintComponent was called.");
		
		g.setColor(Color.DARK_GRAY);
		g.fillRect(0, 0, 764, 585);
		g.setColor(Color.gray);
		
		for (int i = 0; i < 15; i++) {
			for (int j = 0; j < 12; j++) {
				g.fillRect(spacing + i * 47 + 21, spacing + j * 47 + 8, 47-spacing, 47-spacing);
			}
		}
		
		try {
			if (pointer != null & !pointer.theBoard.isEmpty()) {
				g.setFont(new Font("TimesRoman", Font.PLAIN, 21));
				g.setColor(Color.white);
				for (int i = 0; i < 12; i++) {
					for (int j = 0; j < 15; j++) {
						g.drawString(pointer.theBoard.get(i*15 + j), spacing + j * 47 + 8 + 24, spacing + i * 47 + 21 + 14);
					}
				}
			}
		} catch (Exception ex) {
			System.out.println("something's wrong");
		}

		
	}
	
}
