package hotel.views;

import java.awt.Color;
import java.awt.Component;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;
import java.util.Scanner;

import javax.swing.JComboBox;
import javax.swing.JOptionPane;

public class GameLogic {
	/* self explanatory */
	private FirstHotelGui hotelPointer;
	/* Starting Position of the Players */
	private MyTuple S;
	private List<Player> Players = new ArrayList<Player>();
	private List<Color> Colors = new ArrayList<Color>();
	private static final Integer NUMBER_OF_PLAYERS = 3;
	/* Kind of redundant but it improves readability */
	private static final List<String> ALPHABET = Arrays.asList("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "p");
	/* Player1 -> 0, Player2 -> 1, Player3 -> 2 */
	private Integer currPlayer;
	/* Self explanatory - ranges from 1 to  6 */
	private Integer currDiceResult;
	/* Each cell on the 2d array corresponds to a tile on the board */
	private Tile[][] TileBoard = new Tile[12][15];
	/* The circular sequence of tiles players step on over the course of the game */
	private List<Tile> Path = new ArrayList<Tile>();
	/* A single combo-box is used to display the options for both hotels/upgrades and entrances */
	private Boolean buyHotelOrEntranceFlag = false;
	/* probably of no use */
	private Boolean RealEstateOrBuy = false;
	/* if 2 then game is over */
	private Integer numberOfPlayersBankrupt = 0;
	/* Given  an integer that corresponds to the index of a tile if the TileBoard was a vector, 
	 * give me a yes or no to the question: Is the tile part of the Path? */
	private Map<Integer,Boolean> PositionIsInPath = new HashMap<Integer,Boolean>();
	/* Boolean flag in case current player has passed through the city hall */
	private Boolean hasPassedThroughC = false;
	
	/* The constructor - creates the Board, Path and initializes JLabels */
	public GameLogic(FirstHotelGui hotelPointer) {
		this.hotelPointer = hotelPointer;
		
		for (int i = 0; i < hotelPointer.theBoard.size(); i++) {
			Integer row = i / 15;
			Integer col = i - row * 15;
			MyTuple Position = new MyTuple(row, col);
			TileBoard[row][col] = new Tile(hotelPointer.theBoard.get(i), Position);
			PositionIsInPath.put(i, false);
			//System.out.println("PositionIsInPath(" + row + ", " + col + "): " + PositionIsInPath.get(i));
			
			/* read max level of construction */
			/* and name of hotel */
			String symbol = hotelPointer.theBoard.get(i);
			if (symbol.chars().allMatch(Character :: isDigit)) {
				try {
					Scanner myScanner = new Scanner(new File(hotelPointer.gameFolder + File.separator + symbol + ".txt"));
					Integer lineCounter = 0;
					String name = "";
					while (myScanner.hasNextLine()) {
						if (lineCounter.equals(0))
							name = myScanner.nextLine();
						else
							myScanner.nextLine();
						lineCounter++;
					}
					Integer maxLevelOfExpansion = lineCounter - 5;
					TileBoard[row][col].setMaxLevelOfExpansion(maxLevelOfExpansion);
					TileBoard[row][col].setNameHotel(name);
					myScanner.close();
				} catch (FileNotFoundException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
			
		}
		
		//printTileBoardTest();
		
		/* find playing Path in Board */
		Integer indexS = hotelPointer.theBoard.indexOf("S".toString());
		Integer sRow = indexS / 15;
		Integer sCol = indexS - sRow * 15;
		S = new MyTuple(sRow, sCol);
		findPath(S);
		//printPath();
		
		Colors.add(Color.blue);
		Colors.add(Color.red);
		Colors.add(Color.green);
		
		for (int i = 0; i < NUMBER_OF_PLAYERS; i++) {
			Players.add(new Player(S, Colors.get(i)));
		}
		
		hotelPointer.getMoneyPlayer1Label().setText(Players.get(0).getMoney().toString());
		hotelPointer.getMoneyPlayer2Label().setText(Players.get(1).getMoney().toString());
		hotelPointer.getMoneyPlayer3Label().setText(Players.get(2).getMoney().toString());
		
		hotelPointer.getcurrPos().setText(ALPHABET.get(Players.get(0).getPosition().getY()) + 
							new Integer(Players.get(0).getPosition().getX() + 1).toString());
		hotelPointer.getColorLed().setForeground(Players.get(0).getColor());
		
		currPlayer = 0;
	}
	
	/* Calculate next player - useful in case a player goes bankrupt and order changes */
	public void getNextPlayer() {
		Integer tmpCurrPlayer = currPlayer;
		if (tmpCurrPlayer == 2) {
			tmpCurrPlayer = 0;
		} else {
			tmpCurrPlayer = tmpCurrPlayer + 1;
		}
		if (Players.get(tmpCurrPlayer).isBankrupt()) {
			currPlayer = tmpCurrPlayer;
			getNextPlayer();
		}
		else
			this.currPlayer = tmpCurrPlayer;
		
		System.out.println("tmpCurrPlayer: " + tmpCurrPlayer);
	}
	
	/* Game has ended */
	public void gameOver() {
		
		if (!Players.get(0).isBankrupt()) {
			hotelPointer.getTextArea().append("\nPlayer 1 won the game!\n\n");
		}
		else if (!Players.get(1).isBankrupt()) {
			hotelPointer.getTextArea().append("\nPlayer 2 won the game!\n\n");
		} else if (!Players.get(2).isBankrupt()) {
			hotelPointer.getTextArea().append("\nPlayer 3 won the game!\n\n");
		}
		
		hotelPointer.getComboBox_Game().setSelectedIndex(1);
	}
	
	/* Makes the necessary changes in case a player goes bankrupt */
	public void playerIsBankrupt(Player p) {
		p.setIsBankrupt(true);
		
		for (Tile currTile : p.getTilesOwned()) {
			if (currTile.getCurrentLevelOfExpansion() >= 1) {
				currTile.isConfiscated(true);
				currTile.setCurrentLevelOfExpansion(-1);
			}
			if (currTile.hasEntrance()) {
				currTile.setHasEntrance(false);
			}
		}
		
		numberOfPlayersBankrupt++;
		
	}
	
	/* self explanatory */
	public void completeEntrancePurchase(String s) {
		String tmpS = s;
		char[] parts = tmpS.toCharArray();
		Integer y = parts[0] - 'a';
		Integer x = Integer.parseInt(tmpS.substring(1)) - 1;
		
		Tile hotelToAddEntranceTo = TileBoard[x][y];
		
		Tile leftTile = TileBoard[x][y-1];
		Tile rightTile = TileBoard[x][y+1];
		Tile upTile = TileBoard[x-1][y];
		Tile downTile = TileBoard[x+1][y];
		List<Tile> tmpNeighbours = new ArrayList<Tile>();
		tmpNeighbours.add(leftTile);
		tmpNeighbours.add(rightTile);
		tmpNeighbours.add(upTile);
		tmpNeighbours.add(downTile);
		
		Tile entranceTile = null;
		System.out.println("Test: Hotel Position To Add Entrance To: " + x + " " + y);
		System.out.println("!leftTile.hasEntrance(): " + !leftTile.hasEntrance());
		System.out.println("PositionIsInPath.get(" + x + ", " + y + "): " + PositionIsInPath.get( x * 15 + y));
		System.out.println("*****");
		for (int i = 0; i < 12; i++) {
			for (int j = 0; j < 15; j++) {
				System.out.println("PositionIsInPath.get(" + i + ", " + j + "): " + PositionIsInPath.get(i * 15 + j));
			}
		}
		if (PositionIsInPath.get(x*15 + y -1) && !leftTile.hasEntrance() && 
				!leftTile.getName().equals("C") && !leftTile.getName().equals("B") && !leftTile.getName().equals("S") ) {
			entranceTile = leftTile;
		}
		if (PositionIsInPath.get(x*15 + y + 1) && !rightTile.hasEntrance() &&
				!rightTile.getName().equals("C") && !rightTile.getName().equals("B") && !rightTile.getName().equals("S")) {
			entranceTile = rightTile;
		}
		if (PositionIsInPath.get((x-1)*15 + y) && !upTile.hasEntrance() &&
				!upTile.getName().equals("C") && !upTile.getName().equals("B") && !upTile.getName().equals("S")) {
			entranceTile = upTile;
		}
		if (PositionIsInPath.get((x+1) * 15 + y) && !downTile.hasEntrance() &&
				!downTile.getName().equals("C") && !downTile.getName().equals("B") && !downTile.getName().equals("S")) {
			entranceTile = downTile;
		}
		
		if (entranceTile == null) {
			hotelPointer.getTextArea().append("\nThere's no available slot for an entrance to that hotel!\n");
			return;
		}
		
		entranceTile.setHasEntrance(true);
		entranceTile.setDailyCost(hotelToAddEntranceTo.getDailyCost());
		entranceTile.setEntranceOf(hotelToAddEntranceTo);
		//entranceTile.setOwner(hotelToAddEntranceTo.getOwner());
		
		String yEnt = ALPHABET.get(entranceTile.getPosition().getY());
		String xEnt = new Integer(entranceTile.getPosition().getX() + 1).toString();
		hotelPointer.getTextArea().append("\nEntranced added to " + hotelToAddEntranceTo.getName() + " at " + yEnt + xEnt + "!\n\n");
		
		Integer moneyToPayForEntrance = 0;
		try {
			Scanner myScanner = new Scanner(new File(hotelPointer.gameFolder + File.separator + TileBoard[x][y].getName() + ".txt"));
			myScanner.nextLine();
			myScanner.nextLine();
			moneyToPayForEntrance = Integer.parseInt(myScanner.nextLine());
			myScanner.close();
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		if (moneyToPayForEntrance.equals(0)) {
			System.out.println("problem pay entrance");
		}
		
		if (hasPassedThroughC.equals(false))
			Players.get(currPlayer).setMoney(Players.get(currPlayer).getMoney() - moneyToPayForEntrance);
		else
			hotelPointer.getTextArea().append("\nYou bought an entrance for free thanks to the Mayor!\n\n");
		
		switch (currPlayer) {
			case 0:
				hotelPointer.getMoneyPlayer1Label().setText(Players.get(0).getMoney().toString());
				break;
			case 1:
				hotelPointer.getMoneyPlayer2Label().setText(Players.get(1).getMoney().toString());
				break;
			case 2:
				hotelPointer.getMoneyPlayer3Label().setText(Players.get(2).getMoney().toString());
				break;
		}
		
		Players.get(currPlayer).setNumberOfEntrances(Players.get(currPlayer).getNumberOfEntrances() + 1);
		getNextPlayer();
		
		hotelPointer.getColorLed().setForeground(Players.get(currPlayer).getColor());
		String nextPlayerPos = ALPHABET.get(Players.get(currPlayer).getPosition().getY()) + new Integer(Players.get(currPlayer).getPosition().getX()+1).toString();
		hotelPointer.getcurrPos().setText(nextPlayerPos);
		hotelPointer.getRollDiceButton().setEnabled(true);
	}
	
	/* self explanatory */
	public void completeHotelPurchase(String s) {
		String tmpS = s;
		char[] parts = tmpS.toCharArray();
		Integer y = parts[0] - 'a';
		Integer x = Integer.parseInt(tmpS.substring(1)) - 1;
		
		Integer currentLevelOfExpansion = TileBoard[x][y].getCurrentLevelOfExpansion();
		Integer maxLevelOfExpansion = TileBoard[x][y].getMaxLevelOfExpansion();
		
		if (currentLevelOfExpansion.equals(maxLevelOfExpansion)) {
			hotelPointer.getTextArea().append("\nYou can't build any more hotels in this tile!\n\n");
			return;
		}
		
		Integer lineToRead = currentLevelOfExpansion + 4; //(zero-based aka 4 is fifth line)
		Integer defaultCost = -1;
		Integer defaultDailyCost = -1;
		try {
			Scanner myScanner = new Scanner(new File(hotelPointer.gameFolder + File.separator + TileBoard[x][y].getName() + ".txt"));
			Integer counterLine = 0;
			while (myScanner.hasNextLine() && !counterLine.equals(lineToRead)) {
				myScanner.nextLine();
				counterLine++;
			}
			String[] readLine = myScanner.nextLine().split(",");
			defaultCost = Integer.parseInt(readLine[0]);
			defaultDailyCost = Integer.parseInt(readLine[1]);
			myScanner.close();
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		/* there's room for improvement over the percentages... perhaps even a Double */
		Integer probabilityNum = new Random().nextInt(100) + 1;
		
		if (probabilityNum >= 1 && probabilityNum <= 49) {
			if (defaultCost.equals(-1)) {
				System.out.println("\nsomething's wrong beep beep");
				return;
			}
			if (defaultCost >= Players.get(currPlayer).getMoney()) {
				hotelPointer.getTextArea().append("\nYou don't have enough money to buy this!\n\n");
				hotelPointer.getTextArea().append("\nPurchase aborted!\n\n");
			} else {
				Players.get(currPlayer).setMoney(Players.get(currPlayer).getMoney() - defaultCost);
				TileBoard[x][y].setCurrentLevelOfExpansion(currentLevelOfExpansion + 1);
				TileBoard[x][y].setDailyCost(TileBoard[x][y].getDailyCost() + defaultDailyCost);
				hotelPointer.getTextArea().append("\nPurchase was granted and completed :) \n\n");
			}
		} else if (probabilityNum >= 50 && probabilityNum <= 70) {
			hotelPointer.getTextArea().append("\nPurchase was rejected :(\n\n");
		} else if (probabilityNum >= 71 && probabilityNum <= 85) {
			TileBoard[x][y].setCurrentLevelOfExpansion(currentLevelOfExpansion + 1);
			TileBoard[x][y].setDailyCost(TileBoard[x][y].getDailyCost() + defaultDailyCost);
			hotelPointer.getTextArea().append("\nPurchase was granted and completed for free!\n\n");
		} else if (probabilityNum >= 86 && probabilityNum <= 100) {
			hotelPointer.getTextArea().append("\nPurchase was granted for double the cost!\n\n");
			if (defaultCost >= Players.get(currPlayer).getMoney()) {
				hotelPointer.getTextArea().append("\nYou don't have enough money to buy this!\n\n");
				hotelPointer.getTextArea().append("\nPurchase aborted!\n\n");
			} else {
				Players.get(currPlayer).setMoney(Players.get(currPlayer).getMoney() - 2 * defaultCost);
				TileBoard[x][y].setCurrentLevelOfExpansion(currentLevelOfExpansion + 1);
				TileBoard[x][y].setDailyCost(TileBoard[x][y].getDailyCost() + defaultDailyCost);
				hotelPointer.getTextArea().append("\nPurchase was granted and completed :) \n\n ");
			}
		}
		
		switch (currPlayer) {
			case 0:
				hotelPointer.getMoneyPlayer1Label().setText(Players.get(currPlayer).getMoney().toString());
				break;
			case 1:
				hotelPointer.getMoneyPlayer2Label().setText(Players.get(currPlayer).getMoney().toString());
				break;
			case 2:
				hotelPointer.getMoneyPlayer3Label().setText(Players.get(currPlayer).getMoney().toString());
				break;
		}

		getNextPlayer();
		
		hotelPointer.getColorLed().setForeground(Players.get(currPlayer).getColor());
		String nextPlayerPos = ALPHABET.get(Players.get(currPlayer).getPosition().getY()) + new Integer(Players.get(currPlayer).getPosition().getX()+1).toString();
		hotelPointer.getcurrPos().setText(nextPlayerPos);
		hotelPointer.getRollDiceButton().setEnabled(true);
	}
	
	/* handler for the Buy Hotel or Entrance buttons 
	 * calls either completeHotelPurchase or completeEntrancePurchase */
	public void reqNewHotelOrNewEntrance(String choice) {
		if (choice.equals("e")) {
			hotelPointer.getTextArea().append("\nHehe you chose an entrance :)");
			buyHotelOrEntranceFlag = false;
			
			if (Players.get(currPlayer).getTilesOwned().size() == 0) {
				hotelPointer.getTextArea().append("\nYou don't own any real estates at the moment :( \n\n");
				return;
			}
			
			List<Tile> tilesOwned = Players.get(currPlayer).getTilesOwned();
			List<Tile> hotelsOwned = new ArrayList<Tile>();
			for (Tile currTile : tilesOwned) {
				if (currTile.getCurrentLevelOfExpansion() >= 1) {
					hotelsOwned.add(currTile);
				}
			}
			
			if (hotelsOwned.size() == 0) {
				hotelPointer.getTextArea().append("\nYou don't own any hotels at the moment :( \n\n");
				return;
			}
			
			/* i'll use the same combo-box to capture the player's choice both for hotels and entrances 
			 * don't mind the unfortunate naming assignment "ChooseHotelToBuild" */
			hotelPointer.getComboBoxChooseHotelToBuild().removeAllItems();
			for (Tile currTile : hotelsOwned) {
				MyTuple pos = currTile.getPosition();
				String out = "";
				String y = ALPHABET.get(pos.getY());
				String x = new Integer(pos.getX()+1).toString();
				out = y + x;
				hotelPointer.getComboBoxChooseHotelToBuild().addItem(out);
			}
			
			hotelPointer.getWhichOne().setVisible(true);
			hotelPointer.getSideLayer().add(hotelPointer.getComboBoxChooseHotelToBuild());
			hotelPointer.revalidate();
			hotelPointer.repaint();
			
		} else if (choice.equals("h")) { 
			hotelPointer.getTextArea().append("\nHehe you chose a hotel :(");
			buyHotelOrEntranceFlag = true;
			
			if (Players.get(currPlayer).getTilesOwned().size() == 0) {
				hotelPointer.getTextArea().append("\nYou don't own any real estates at the moment :( \n\n");
				return;
			}
			
			hotelPointer.getComboBoxChooseHotelToBuild().removeAllItems();
			for (Tile currTile : Players.get(currPlayer).getTilesOwned()) {
				MyTuple pos = currTile.getPosition();
				String out = "";
				String y = ALPHABET.get(pos.getY());
				String x = new Integer(pos.getX()+1).toString();
				out = y + x;
				hotelPointer.getComboBoxChooseHotelToBuild().addItem(out);
			}
			
			hotelPointer.getWhichOne().setVisible(true);
			hotelPointer.getSideLayer().add(hotelPointer.getComboBoxChooseHotelToBuild());
			hotelPointer.revalidate();
			hotelPointer.repaint();
			
		} else {
			System.out.println("Something is wrong! no player choice\n\n");
		}
	}
	
	/* handler for the money request from the bank button */
	public void reqMoneyFromBank() {
		Players.get(currPlayer).setMoney(Players.get(currPlayer).getMoney() + 1000);
		
		switch (currPlayer) {
			case 0:
				hotelPointer.getMoneyPlayer1Label().setText(Players.get(currPlayer).getMoney().toString());
				break;
			case 1:
				hotelPointer.getMoneyPlayer2Label().setText(Players.get(currPlayer).getMoney().toString());
				break;
			case 2:
				hotelPointer.getMoneyPlayer3Label().setText(Players.get(currPlayer).getMoney().toString());
				break;
		}
		
		hotelPointer.getTextArea().append("\nPlayer" + new Integer(currPlayer + 1).toString() + " got 1000MS from the bank!\n\n");
		
		getNextPlayer();
		
		hotelPointer.getColorLed().setForeground(Players.get(currPlayer).getColor());
		String x = ALPHABET.get(Players.get(currPlayer).getPosition().getY()) + new Integer(Players.get(currPlayer).getPosition().getX()+1).toString();
		hotelPointer.getcurrPos().setText(x);
		hotelPointer.getRollDiceButton().setEnabled(true);
	}
	
	/* self explanatory */
	public void completeRealEstatePurchase(String playerChoice) {
		String[] parts = playerChoice.split(",");
		String whichTile = parts[1];
		Tile realEstateTile = null;
		
		switch (whichTile) {
			case "left":
				realEstateTile = TileBoard[Players.get(currPlayer).getPosition().getX()][Players.get(currPlayer).getPosition().getY()-1];
				break;
			case "right":
				realEstateTile = TileBoard[Players.get(currPlayer).getPosition().getX()][Players.get(currPlayer).getPosition().getY()+1];
				break;
			case "up":
				realEstateTile = TileBoard[Players.get(currPlayer).getPosition().getX()-1][Players.get(currPlayer).getPosition().getY()];
				break;
			case "down":
				realEstateTile = TileBoard[Players.get(currPlayer).getPosition().getX()+1][Players.get(currPlayer).getPosition().getY()];
				break;
		}
		
		Integer moneyToPay;
		try {
			Scanner myScanner = new Scanner(new File(hotelPointer.gameFolder + File.separator + parts[0] + ".txt"));
			myScanner.nextLine();
			String[] secondLine = myScanner.nextLine().split(",");
			
			if (!realEstateTile.isOwned()) {
				moneyToPay = Integer.parseInt(secondLine[0]);
				if (Players.get(currPlayer).getMoney() - moneyToPay >= 0) {
					Players.get(currPlayer).setMoney(Players.get(currPlayer).getMoney() - moneyToPay);
					realEstateTile.setIsOwned(true);
					realEstateTile.setOwner(currPlayer);
					realEstateTile.setCurrentLevelOfExpansion(0);
					System.out.println("New owner of tile " + ALPHABET.get(realEstateTile.getPosition().getY()) + new Integer(realEstateTile.getPosition().getX()+1) + " is Player" + TileBoard[realEstateTile.getPosition().getX()][realEstateTile.getPosition().getY()].getOwner());
					Players.get(currPlayer).getTilesOwned().add(realEstateTile);
				
					switch (currPlayer) {
						case 0:
							hotelPointer.getMoneyPlayer1Label().setText(Players.get(currPlayer).getMoney().toString());
							break;
						case 1:
							hotelPointer.getMoneyPlayer2Label().setText(Players.get(currPlayer).getMoney().toString());
							break;
						case 2:
							hotelPointer.getMoneyPlayer3Label().setText(Players.get(currPlayer).getMoney().toString());
							break;
					}
				
					hotelPointer.getTextArea().append("Congrats, you just bought this real estate!");
					System.out.println("******************************************");
					System.out.println("Real Estate was not owned by anybody.");
					System.out.println("CurrPlayer: " + new Integer(currPlayer+1));
					System.out.println("Money1: " + Players.get(0).getMoney());
					System.out.println("Money2: " + Players.get(1).getMoney());
					System.out.println("Money3: " + Players.get(2).getMoney());
					System.out.println("********************************************");
					
					getNextPlayer();
					
					hotelPointer.getColorLed().setForeground(Players.get(currPlayer).getColor());
					String x = ALPHABET.get(Players.get(currPlayer).getPosition().getY()) + new Integer(Players.get(currPlayer).getPosition().getX()+1).toString();
					hotelPointer.getcurrPos().setText(x);
					hotelPointer.getRollDiceButton().setEnabled(true);
				} else {
					hotelPointer.getTextArea().append("\nYou don't have enough money to buy this real estate!\n");
				}
			}
			else {
				moneyToPay = Integer.parseInt(secondLine[1]);
				if (Players.get(currPlayer).getMoney() - moneyToPay >= 0) {
					Integer currOwner = realEstateTile.getOwner();
					Players.get(currPlayer).setMoney(Players.get(currPlayer).getMoney() - moneyToPay);
					Players.get(currOwner).setMoney(Players.get(currOwner).getMoney() + moneyToPay);
					realEstateTile.setIsOwned(true);
					realEstateTile.setOwner(currPlayer);
					realEstateTile.setCurrentLevelOfExpansion(0);
					Players.get(currPlayer).getTilesOwned().add(realEstateTile);
					Players.get(currOwner).getTilesOwned().remove(realEstateTile);
					
					switch (currPlayer) {
						case 0:
							hotelPointer.getMoneyPlayer1Label().setText(Players.get(currPlayer).getMoney().toString());
							break;
						case 1:
							hotelPointer.getMoneyPlayer2Label().setText(Players.get(currPlayer).getMoney().toString());
							break;
						case 2:
							hotelPointer.getMoneyPlayer3Label().setText(Players.get(currPlayer).getMoney().toString());
							break;
					}
				
					switch (currOwner) {
						case 0:
							hotelPointer.getMoneyPlayer1Label().setText(Players.get(currOwner).getMoney().toString());
							break;
						case 1:
							hotelPointer.getMoneyPlayer2Label().setText(Players.get(currOwner).getMoney().toString());
							break;
						case 2:
							hotelPointer.getMoneyPlayer3Label().setText(Players.get(currOwner).getMoney().toString());
							break;
					}
				
					hotelPointer.getTextArea().append("Congrats, you just bought this real estate!");
				
					System.out.println("******************************************");
					System.out.println("Real Estate was owned by " + new Integer(currOwner+1) + ".");
					System.out.println("CurrPlayer: " + new Integer(currPlayer+1));
					System.out.println("Money1: " + Players.get(0).getMoney());
					System.out.println("Money2: " + Players.get(1).getMoney());
					System.out.println("Money3: " + Players.get(1).getMoney());
					System.out.println("********************************************");
					
					getNextPlayer();
					
					hotelPointer.getColorLed().setForeground(Players.get(currPlayer).getColor());
					String x = ALPHABET.get(Players.get(currPlayer).getPosition().getY()) + new Integer(Players.get(currPlayer).getPosition().getX()+1).toString();
					hotelPointer.getcurrPos().setText(x);
					hotelPointer.getRollDiceButton().setEnabled(true);
				} else {
					hotelPointer.getTextArea().append("\nYou can't buy this real estate! You don't have enough money!\n");
				}
			}
			
			/* test */
			
			myScanner.close();
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	
	/* Handler for the Request Building & Result 
	 * Checks if the neightbouring tiles are legal moves
	 * is there any real estate tile
	 * are they owned by an opponent or the bank? */
	public void requestRealEstatePurchase() {
		hotelPointer.getReqRealEstateBox().removeAllItems();
		
		List<String> listOfOptions = new ArrayList<String>();
		Tile tmpCurrTile = Path.get(Players.get(currPlayer).getIndex());
		Tile left, right, up, down;
		
		if (tmpCurrTile.getPosition().getY() != 0)
			left = TileBoard[tmpCurrTile.getPosition().getX()][tmpCurrTile.getPosition().getY()-1];
		else
			left = null;
		
		if (tmpCurrTile.getPosition().getY() != 14)
			right = TileBoard[tmpCurrTile.getPosition().getX()][tmpCurrTile.getPosition().getY()+1];
		else
			right = null;
		
		if (tmpCurrTile.getPosition().getX() != 0) 
			up = TileBoard[tmpCurrTile.getPosition().getX()-1][tmpCurrTile.getPosition().getY()];
		else
			up = null;
		
		if (tmpCurrTile.getPosition().getX() != 11)
			down = TileBoard[tmpCurrTile.getPosition().getX()+1][tmpCurrTile.getPosition().getY()];
		else
			down = null;
		
		
		if (left != null && !left.isConfiscated()) {
			if (left.getName().chars().allMatch(Character :: isDigit)) {
				if (!left.isOwned())
					listOfOptions.add(left.getName() + ",left");
				else {
					if (left.getCurrentLevelOfExpansion().equals(0))
						listOfOptions.add(left.getName() + ",left");
				}
			}
		}
		
		if (right != null && !right.isConfiscated()) {
			if (right.getName().chars().allMatch(Character :: isDigit)) {
				if (!right.isOwned())
					listOfOptions.add(right.getName() + ",right");
				else {
					if (right.getCurrentLevelOfExpansion().equals(0))
						listOfOptions.add(right.getName() + ",right");
				}
			}
		}
		
		if (up != null && !up.isConfiscated()) {
			if (up.getName().chars().allMatch(Character :: isDigit)) {
				if (!up.isOwned())
					listOfOptions.add(up.getName() + ",up");
				else {
					if (up.getCurrentLevelOfExpansion().equals(0))
						listOfOptions.add(up.getName() + ",up");
				}
			}
		}
		
		if (down != null && !down.isConfiscated()) {
			if (down.getName().chars().allMatch(Character :: isDigit)) {
				if (!down.isOwned())
					listOfOptions.add(down.getName() + ",down");
				else {
					if (down.getCurrentLevelOfExpansion().equals(0))
						listOfOptions.add(down.getName() + ",down");
				}
			}
		}
		
		for (String currString : listOfOptions) {
			hotelPointer.getReqRealEstateBox().addItem(currString);
		}

	}
	
	/* Debugging */
	public void printTileBoardTest() {
		for (int i = 0; i < 12; i++) {
			for (int j = 0; j < 15; j++) {
				hotelPointer.getTextArea().append(TileBoard[i][j].getName() + ": " + 
												TileBoard[i][j].getPosition().getX() + " " +
												TileBoard[i][j].getPosition().getY() + "\n");
			}
		}
	}
	
	/* Debugging */
	public void printPath() {
		System.out.println("*******************************");
		for (Tile currTile : Path) {
			System.out.print(currTile.getName());
		}
		System.out.println("\n*****************************");
	}
	
	/* calculate the sequence of tiles players step on over the course of the game */
	public void findPath(MyTuple S) {
		MyTuple tmp = null;		
		/* getX returns row(0-based) 
		 * getY returns column(0-based) 
		 * upper left Tile is (0,0) */
		String left, right, down, up;
		tmp = S;
		Map<MyTuple, Boolean> havePassedThrough = new HashMap<MyTuple, Boolean>();
		
		/* initialize hash-map 
		 * havePassedThrough includes only the tiles current player has passed through due to the dice roll */
		for (int i = 0; i < 12; i++) {
			for (int j = 0; j < 15; j++) {
				havePassedThrough.put(TileBoard[i][j].getPosition(), false);
			}
		}
		
		/* main loop */
		Tile nextTile = null;
		while (havePassedThrough.get(TileBoard[tmp.getX()][tmp.getY()].getPosition()).equals(false)) {
			Integer x = tmp.getX();
			Integer y = tmp.getY();
		
			if (y.equals(14))
				right = null;
			else
				right = TileBoard[x][y+1].getName();
		
			if (y.equals(0))
				left = null;
			else
				left = TileBoard[x][y-1].getName();
		
			if (x.equals(0))
				up = null;
			else
				up = TileBoard[x-1][y].getName();
		
			if (x.equals(11))
				down = null;
			else
				down = TileBoard[x+1][y].getName();
					
			if (up.equals("B") || up.equals("C") || up.equals("E") || up.equals("H")) {
				if (havePassedThrough.get(TileBoard[x-1][y].getPosition()).equals(false))
					nextTile = TileBoard[x-1][y];
			}
			
			if (left.equals("B") || left.equals("C") || left.equals("E") || left.equals("H")) {
				if (havePassedThrough.get(TileBoard[x][y-1].getPosition()).equals(false))
					nextTile = TileBoard[x][y-1];
			}
			
			if (down.equals("B") || down.equals("C") || down.equals("E") || down.equals("H")) {
				if (havePassedThrough.get(TileBoard[x+1][y].getPosition()).equals(false))
					nextTile = TileBoard[x+1][y];
			}
			
			if (right.equals("B") || right.equals("C") || right.equals("E") || right.equals("H")) {
				if (havePassedThrough.get(TileBoard[x][y+1].getPosition()).equals(false))
					nextTile = TileBoard[x][y+1];
			}
			
			havePassedThrough.put(TileBoard[tmp.getX()][tmp.getY()].getPosition(), true);
			Path.add(TileBoard[tmp.getX()][tmp.getY()]);
			PositionIsInPath.put(x*15 + y, true);
			//System.out.println("nextTile = " + ALPHABET.get(nextTile.getPosition().getY()) + " " + new Integer(nextTile.getPosition().getX()+1));
			tmp = new MyTuple(nextTile.getPosition().getX(), nextTile.getPosition().getY());
		}
		
	}
	
	/* Self-explanatory
	 * Handler for the dice roll button
	 * Forwards the player by the appropriate amount of steps as given by FirstHotelGui
	 * Checks if the new position is a legal move(aka is there any other player already there?)
	 * Also checks if the new position includes an entrance
	 * If so it updates the money variables and JLabels */
	public void executeNewDiceRoll() {
		
		if (currDiceResult.equals(null)) {
			System.out.println("something's wrong with the dice :(");
			return;
		}
				
		Integer currIndex = Players.get(currPlayer).getIndex();
		Players.get(currPlayer).setIndex(checkTileAvailability(currIndex));
		System.out.println("Current Index: " + Players.get(currPlayer).getIndex());
		Players.get(currPlayer).setPosition(Path.get(Players.get(currPlayer).getIndex()).getPosition());
		
		hotelPointer.getcurrPos().setText(ALPHABET.get(Players.get(currPlayer).getPosition().getY()) + 
				new Integer(Players.get(currPlayer).getPosition().getX() + 1));
		
		/* boolean flag in case current player has passed through the city hall */
		hasPassedThroughC = false;
		/* calculate what tiles has current player passed through */
		Players.get(currPlayer).getHasPassedThrough().clear();;
		
		if (Players.get(currPlayer).getIndex() < currIndex) {
			Integer t1 = Path.size() - Players.get(currPlayer).getIndex();
			Integer t2 = Players.get(currPlayer).getIndex();
			
			for (int i = currIndex+1; i < Path.size(); i++) {
				Players.get(currPlayer).getHasPassedThrough().add(Path.get(i));
			}
			
			for (int i = 0; i <= Players.get(currPlayer).getIndex(); i++) {
				Players.get(currPlayer).getHasPassedThrough().add(Path.get(i));
			}
			
		} else {
			for (int i = currIndex+1; i <= Players.get(currPlayer).getIndex(); i++) {
				Players.get(currPlayer).getHasPassedThrough().add(Path.get(i));
			}
		}
		
		for (Tile currTile : Players.get(currPlayer).getHasPassedThrough()) {
			System.out.print(currTile.getName());
			if (currTile.getName().equals("C")) {
				hasPassedThroughC = true;
			}
		}
		System.out.println();
		
		if (Path.get(Players.get(currPlayer).getIndex()).hasEntrance()) {
			Integer currPlayerMoney = Players.get(currPlayer).getMoney();
			Integer newCurrPlayerMoney = currPlayerMoney - Path.get(Players.get(currPlayer).getIndex()).getDailyCost() * currDiceResult;
			if (newCurrPlayerMoney <= 0) {
				System.out.println("Player has zero or negative money");
				switch (currPlayer) {
					case 0:
						playerIsBankrupt(Players.get(0));
						hotelPointer.getMoneyPlayer1Label().setText("0");
						hotelPointer.getTextArea().append("\nPlayer 1 is bankrupt!\n");
						break;
					case 1:
						playerIsBankrupt(Players.get(1));
						hotelPointer.getMoneyPlayer2Label().setText("0");
						hotelPointer.getTextArea().append("\nPlayer 2 is bankrupt!\n");
						break;
					case 2:
						playerIsBankrupt(Players.get(2));
						hotelPointer.getMoneyPlayer3Label().setText("0");
						hotelPointer.getTextArea().append("\nPlayer 3 is bankrupt!\n");
						break;
				}
				
				if (numberOfPlayersBankrupt == 2) {
					gameOver();
				}
				
			} else {
				Players.get(currPlayer).setMoney(newCurrPlayerMoney);
				
				switch (currPlayer) {
					case 0:
						hotelPointer.getMoneyPlayer1Label().setText(Players.get(0).getMoney().toString());
						break;
					case 1:
						hotelPointer.getMoneyPlayer2Label().setText(Players.get(1).getMoney().toString());
						break;
					case 2:
						hotelPointer.getMoneyPlayer3Label().setText(Players.get(2).getMoney().toString());
						break;
				}
				
				Integer OwnerToPay = Path.get(Players.get(currPlayer).getIndex()).getEntranceOf().getOwner();
				Integer OwnerUsedToHad = Players.get(OwnerToPay).getMoney();
				Players.get(OwnerToPay).setMoney(Players.get(OwnerToPay).getMoney() + Path.get(Players.get(currPlayer).getIndex()).getDailyCost() * currDiceResult);
				
				hotelPointer.getTextArea().append("\nPlayer " + new Integer(currPlayer+1).toString() + " has to pay Player " + new Integer(OwnerToPay+1).toString() + " " + 
												Path.get(Players.get(currPlayer).getIndex()).getDailyCost() * currDiceResult + " MS\n\n");
				hotelPointer.getTextArea().append("\ncurrDiceResult was " + currDiceResult + " and dailyCost was " + Path.get(Players.get(currPlayer).getIndex()).getDailyCost() + "\n\n");
				
				System.out.println("Player " + new Integer(currPlayer+1) + " used to had " + currPlayerMoney + " MS");
				System.out.println("Player " + new Integer(currPlayer+1) + " has to pay Player" + new Integer(OwnerToPay+1) + " " + new Integer(currPlayerMoney - newCurrPlayerMoney) + " MS" );
				System.out.println("Player " + new Integer(OwnerToPay+1) + "(Owner) used to had " + OwnerUsedToHad + " MS");
				System.out.println("Player " + new Integer(OwnerToPay+1) + "(Owner) now has " + Players.get(OwnerToPay).getMoney() + " MS");
				
				switch (OwnerToPay) {
					case 0:
						hotelPointer.getMoneyPlayer1Label().setText(Players.get(0).getMoney().toString());
						break;
					case 1:
						hotelPointer.getMoneyPlayer2Label().setText(Players.get(1).getMoney().toString());
						break;
					case 2:
						hotelPointer.getMoneyPlayer3Label().setText(Players.get(2).getMoney().toString());
						break;
				}
				
			}
		}
		
		hotelPointer.getRollDiceButton().setEnabled(false);
		
	}
	
	/* is the tile already occupied by an opponent player? 
	 * that is the question */
	public Integer checkTileAvailability(Integer currIndex) {
		Integer tmpCurrIndex = currIndex;
		switch (currPlayer) {
			case 0:
				if (Players.get(1).getIndex().equals(currIndex+currDiceResult) || Players.get(2).getIndex().equals(currIndex+currDiceResult)) {
					if (Players.get(1).getIndex().equals(currIndex+currDiceResult+1) || Players.get(2).getIndex().equals(currIndex+currDiceResult+1))
						tmpCurrIndex += 2;
					else
						tmpCurrIndex += 1;
				}
				break;
			case 1:
				if (Players.get(0).getIndex().equals(currIndex+currDiceResult) || Players.get(2).getIndex().equals(currIndex+currDiceResult)) {
					if (Players.get(0).getIndex().equals(currIndex+1+currDiceResult) || Players.get(2).getIndex().equals(currIndex+1+currDiceResult)) 
						tmpCurrIndex += 2;
					else
						tmpCurrIndex += 1;
				}
				break;
			case 2:
				if (Players.get(0).getIndex().equals(currIndex+currDiceResult) || Players.get(1).getIndex().equals(currIndex+currDiceResult)) {
					if (Players.get(0).getIndex().equals(currIndex+1+currDiceResult) || Players.get(1).getIndex().equals(currIndex+1+currDiceResult))
						tmpCurrIndex += 2;
					else
						tmpCurrIndex += 1;
				}
				break;
		}
		if (tmpCurrIndex+currDiceResult >= Path.size()) {
			return tmpCurrIndex+currDiceResult - Path.size();
		}
		else
			return tmpCurrIndex+currDiceResult;
	}
	
	/* setters - getters */
	public void setCurrDiceResult(Integer currDiceResult) {
		this.currDiceResult = currDiceResult;
	}
	
	public void setCurrentPlayer(Integer nextPlayer) {
		currPlayer = nextPlayer;
	}
	
	public Integer getCurrentPlayer() {
		return this.currPlayer;
	}
	
	public List<Player> getPlayers() {
		return Players;
	}
	
	public Tile[][] getTileBoard() {
		return TileBoard;
	}
	
	public List<String> getAlphabet() {
		return ALPHABET;
	}
	
	public Boolean getBuyHotelOrEntranceFlag() {
		return buyHotelOrEntranceFlag;
	}
	
	public void setRealEstateOrBuy(Boolean a) {
		RealEstateOrBuy = a;
	}
	
	public Boolean getRealEstateOrBuy() {
		return RealEstateOrBuy;
	}
	
}
