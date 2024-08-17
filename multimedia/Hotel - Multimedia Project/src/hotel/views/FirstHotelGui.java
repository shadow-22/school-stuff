package hotel.views;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;
import java.awt.GridLayout;
import java.awt.Toolkit;

import javax.swing.JComboBox;
import javax.swing.AbstractButton;
import javax.swing.BoxLayout;
import javax.swing.ButtonGroup;
import javax.swing.JRadioButton;
import javax.swing.JScrollBar;
import javax.swing.JScrollPane;

import java.awt.FlowLayout;
import javax.swing.UIManager;
import javax.swing.JLabel;
import javax.swing.JOptionPane;

import java.awt.Font;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Enumeration;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Random;
import java.util.Scanner;
import java.awt.event.ActionEvent;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.ScrollPaneConstants;
import javax.swing.Timer;
import javax.swing.JToggleButton;

//@SuppressWarnings({ "serial", "unused" })
/* All eventListeners are in createEvents() method 
 * and are separated by the JComponents
 * There're also some setters and getters */
public class FirstHotelGui extends JFrame {

	private JPanel contentPane;
	@SuppressWarnings("rawtypes")
	private JComboBox comboBox_game, comboBox_statistics;
	private JLabel lblGame, lblStatistics, lblPlayer1, lblPlayer2, lblPlayer3, lblAvailableHotels, numHotels, lblTotalTime;
	private DigitalClock totalTime;
	private JLabel money1, money2, money3;
	private JPanel upperLayer, sideLayer;
	public MainGrid mainLayer;
	private JTextArea textArea;
	private JRadioButton rollDice_button, reqBuild_button, buyH_button, buyEntr_button, reqMoney_button;
	private JLabel lblWhichOne;
	private ButtonGroup myGroup;
	JRadioButton rdbtnBuyEntrance, rdbtnBuyHotel; // i think it's safe to ignore this line...
	
	private JComboBox ReqRealEstateBox, comboBoxChooseHotelToBuild;
	
	private Integer numberOfAvailableHotels;
	
	public List<String> theBoard = new ArrayList<String>(200);
	public Boolean gameIsOn = false;
	String gameFolder = "";
	public static Integer numOfTiles = 0;
	private String[] allHotels;
	private JLabel ColorLed;
	
	private GameLogic currentGame;
	private FirstHotelGui this_pointer = this;
	private JLabel lblCurrentPosition;
	private JLabel currPos;
	private JLabel lblB;
	private JLabel lblC;
	private JLabel lblD;
	private JScrollPane scrollPane;
	
	/* In many case there's not much a player can do - but the show must go on */
	private JToggleButton tglbtnPassTurn;
	
	/**
	 * Launch the application.
	 */
	public static void main(String[] args) {
		try {
			UIManager.setLookAndFeel("javax.swing.plaf.nimbus.NimbusLookAndFeel");
		} catch (Throwable e) {
			e.printStackTrace();
		}
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				try {
					FirstHotelGui frame = new FirstHotelGui();
					frame.setVisible(true);
					frame.setResizable(false);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}
	
	public JRadioButton getRollDiceButton() {
		return rollDice_button;
	}
	
	public JLabel getWhichOne() {
		return lblWhichOne;
	}
	
	public JPanel getSideLayer() {
		return sideLayer;
	}
	
	public JComboBox getComboBoxChooseHotelToBuild() {
		return comboBoxChooseHotelToBuild;
	}
	
	public JComboBox getReqRealEstateBox() {
		return this.ReqRealEstateBox;
	}
	
	public JTextArea getTextArea() {
		return this.textArea;
	}
	
	public JComboBox getComboBox_Game() {
		return this.comboBox_game;
	}
	
	public JLabel getMoneyPlayer1Label() {
		return this.money1;
	}
	
	public JLabel getMoneyPlayer2Label() {
		return this.money2;
	}
	
	public JLabel getMoneyPlayer3Label() {
		return this.money3;
	}
	
	public JLabel getcurrPos() {
		return this.currPos;
	}
	
	public JLabel getColorLed() {
		return this.ColorLed;
	}
	
	/**
	 * Create the frame.
	 */
	public FirstHotelGui() {
		setTitle("MediaLab Hotel");
		numberOfAvailableHotels = 0;
		//totalTimePassed = 0;
		
		initComponents();
		createEvents();

	}

	private void createEvents() {
		
		/* EventListener for the Game menu */
		comboBox_game.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (comboBox_game.getSelectedItem().toString().equals("Start")) {
				/* if a current game is running, pause it */
				/* remove radio buttons and stop clock */
					if (gameIsOn.equals(true)) {
						gameIsOn = false;
						Enumeration<AbstractButton> enumeration = myGroup.getElements();
						while (enumeration.hasMoreElements()) {
							enumeration.nextElement().setEnabled(false);
						}
						/* stop clock */
						totalTime.getTimer().stop();
						/* and create new instance */
						FirstHotelGui new_JFrame = new FirstHotelGui();
						new_JFrame.setVisible(true);
						new_JFrame.comboBox_game.setSelectedIndex(0);
						return;
					}
					
				/* open folder boards, pick randomly a sub-folder, 
				 * read the board.txt file and save it to theBoard array */
					String defaultOriginFolder = "";
					defaultOriginFolder = System.getProperty("user.dir") + File.separator + "boards";
					File defaultFolder = new File(defaultOriginFolder);
					String[] allContents = defaultFolder.list();
					
					List<String> allSubFolders = new ArrayList<String>();
					for (String curr : allContents) {
						if (new File(defaultOriginFolder + File.separator + curr).isDirectory()) {
							allSubFolders.add(curr);
						}
					}
					
					String pickedGame = allSubFolders.get(new Random().nextInt(allSubFolders.size()));
					pickedGame = defaultOriginFolder + File.separator + pickedGame;
					gameFolder = pickedGame;
					File currGame = new File(pickedGame + File.separator + "board.txt");
					System.out.println("Picked Game folder is: " + pickedGame);
					
					/* initialize the number of available hotels variable and label */
					String[] temp_array = (new File(pickedGame)).list();
					System.out.println("Number of hotels: " + temp_array.length);
					numberOfAvailableHotels = temp_array.length - 1;
					numHotels.setText(numberOfAvailableHotels.toString());
					
					/* read the board file and save it to theBoard String array */
					try {
						Scanner myScanner = new Scanner(currGame);
						while (myScanner.hasNextLine()) {
							String currLine = myScanner.nextLine();
							for (String currChar : currLine.split(",")) {
								theBoard.add(currChar);
							}
						}
						mainLayer.revalidate();
						mainLayer.repaint();
						/* Main interaction with the player's actions/clicks happens through the currentGame reference */
						currentGame = new GameLogic(this_pointer);
						mainLayer.setGamePtr(currentGame);
						
						/* test copy paste from card */
						List<String> allContents2;
						File thisFolder = new File(gameFolder);					
						allContents2 = new ArrayList<String>(Arrays.asList(thisFolder.list()));
						Iterator<String> iter = allContents2.iterator();					
						while (iter.hasNext()) {
							String currString = iter.next();
							if (currString.equals("board.txt")) {
								iter.remove();
							}
						}
						
						Integer counter = 0;
						allHotels = new String[allContents2.size()];
						for (String currString : allContents2) {
							allHotels[counter] = currString;						
							counter++;
						}
						/* test end */
						gameIsOn = true;
						/* testing, print theBoard */
						counter = 0;
						for (String currChar : theBoard) {
							if (counter.equals(15)) {
								System.out.println();
								counter = 0;
							}
							System.out.print(currChar);
							counter++;
						}
						numOfTiles = theBoard.size();
						myScanner.close();
						/* initialize clock */
						totalTime.start();
						
						/* paint the board according to the read input */
						mainLayer.revalidate();
						mainLayer.repaint();
					} catch (FileNotFoundException e1) {
						System.out.println("Reading game file failed.");
						e1.printStackTrace();
					}	
					
				}
				else if (comboBox_game.getSelectedItem().toString().equals("Stop")) {
				/* Pause the game -> remove radio buttons and stop the clock */
					Enumeration<AbstractButton> enumeration = myGroup.getElements();
					while (enumeration.hasMoreElements()) {
						enumeration.nextElement().setEnabled(false);
					}
					/* stop clock */
					totalTime.getTimer().stop();
				}
				else if (comboBox_game.getSelectedItem().toString().equals("Cards")) {
				/* check if game is on */
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
				/* create pop-up dialog box with hotel's information */	
					String s = (String)JOptionPane.showInputDialog(null, 
							"Choose which hotel's card you want to see: ", "Hotel Card", 
							JOptionPane.PLAIN_MESSAGE, null, allHotels, allHotels[0]);
					
					if ((s != null) && (s.length() > 0)) {
						String hotelInfo = gameFolder + File.separator + s;
						try {
							Scanner myScanner = new Scanner(new File(hotelInfo));
							String hotelInformation = "";
							while (myScanner.hasNextLine()) {
								hotelInformation = hotelInformation + myScanner.nextLine() + "\n";
							}
							JOptionPane.showMessageDialog(null, hotelInformation);
							myScanner.close();
						} catch (FileNotFoundException e1) {
							e1.printStackTrace();
						}
					}
				}
				else if (comboBox_game.getSelectedItem().toString().equals("Exit")) {
					dispose();
				}
			}
		});
		
		// EventListener for the Statistics menu
		comboBox_statistics.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (comboBox_statistics.getSelectedItem().toString().equals("Hotels")) {
					
					/* It's a little messy */
					System.out.println("You selected Hotels!");
					
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					List<Tile> legitTiles = new ArrayList<Tile>();
					for (int i = 0; i < 12; i++) {
						for (int j = 0; j < 15; j++) {
							if (currentGame.getTileBoard()[i][j].getName().chars().allMatch(Character :: isDigit)) {
								legitTiles.add(currentGame.getTileBoard()[i][j]);
							}
						}
					}
					
					List<String> optionList = new ArrayList<String>();
					for (Tile currTile : legitTiles) {
						String output = "";
						MyTuple currPosition = currTile.getPosition();
						String s1 = currentGame.getAlphabet().get(currPosition.getY());
						String s2 = new Integer(currPosition.getX() + 1).toString();
						output = s1 + s2;
						optionList.add(output);
					}
					
					String[] inputList = optionList.toArray(new String[optionList.size()]);
					String playerChoice = (String)JOptionPane.showInputDialog(null, "Choose Hotel: ", "Hotel", JOptionPane.PLAIN_MESSAGE, null, inputList, inputList[0]);
					
					if (playerChoice == null) return;
					
					char[] parts = playerChoice.toCharArray();
					Integer y = parts[0] - 'a';
					Integer x = Integer.parseInt(playerChoice.substring(1)) - 1;
					
					System.out.println("You typed " + currentGame.getAlphabet().get(y) + new Integer(x + 1).toString() + " right???");
					
					String output = "";
					
					String symbol = "Symbol: " + currentGame.getTileBoard()[x][y].getName();
					output += symbol + "\n";
					
					output += "Name of Hotel: " + currentGame.getTileBoard()[x][y].getNameHotel() + "\n";
					
					if (currentGame.getTileBoard()[x][y].isOwned())
						output += "Owned by: Player " + new Integer(currentGame.getTileBoard()[x][y].getOwner()+1) + "\n";
					else
						output += "is owned by nobody\n";
					
					output += "CurrentLevel of Expansion: " + currentGame.getTileBoard()[x][y].getCurrentLevelOfExpansion() + "\n";
					output += "Max Level of Expansion: " + currentGame.getTileBoard()[x][y].getMaxLevelOfExpansion() + "\n";
					
					JOptionPane.showMessageDialog(null, output);
				}
				else if (comboBox_statistics.getSelectedItem().toString().equals("Entrances")) {
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					Integer numberOfEntrancesOwnedByPlayer1 = currentGame.getPlayers().get(0).getNumberOfEntrances();
					Integer numberOfEntrancesOwnedByPlayer2 = currentGame.getPlayers().get(1).getNumberOfEntrances();
					Integer numberOfEntrancesOwnedByPlayer3 = currentGame.getPlayers().get(2).getNumberOfEntrances();
					
					String output = "Player1: " + numberOfEntrancesOwnedByPlayer1 + "\nPlayer2: " + numberOfEntrancesOwnedByPlayer2;
					output = output + "\nPlayer3: " + numberOfEntrancesOwnedByPlayer3;
					JOptionPane.showMessageDialog(null, output);
				}
				else if (comboBox_statistics.getSelectedItem().toString().equals("Profits")) {
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					Integer maxMoneyPlayer1 = currentGame.getPlayers().get(0).getMaxMoney();
					Integer maxMoneyPlayer2 = currentGame.getPlayers().get(1).getMaxMoney();
					Integer maxMoneyPlayer3 = currentGame.getPlayers().get(2).getMaxMoney();
					
					String output = "Player1: " + maxMoneyPlayer1;
					output = output + "\nPlayer2: " + maxMoneyPlayer2;
					output = output + "\nPlayer3: " + maxMoneyPlayer3;
					JOptionPane.showMessageDialog(null, output);
				}
			}
		});
		
		
		rollDice_button.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (rollDice_button.isSelected()) {
					
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					Integer dice_result = new Random().nextInt(6) + 1;
					currentGame.setCurrDiceResult(dice_result);
					currentGame.executeNewDiceRoll();
					
				}
				
				
			}
		});
		
		reqBuild_button.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (reqBuild_button.isSelected()) {
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					Tile[][] TileBoard = currentGame.getTileBoard();
					Tile currTile = TileBoard[currentGame.getPlayers().get(currentGame.getCurrentPlayer()).getPosition().getX()][currentGame.getPlayers().get(currentGame.getCurrentPlayer()).getPosition().getY()];
					
					if (!currTile.getName().equals("H")) {
						textArea.append("\nSorry! You can't buy any real estate! You're not on a H tile!\n\n");
						return;
					}
					
					currentGame.requestRealEstatePurchase();
					lblWhichOne.setVisible(true);
					sideLayer.add(ReqRealEstateBox);
					revalidate();
					repaint();
				}
			}
		});
		
		buyH_button.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (buyH_button.isSelected()) {
				
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					Integer currPlayer = currentGame.getCurrentPlayer();
					Tile[][] TileBoard = currentGame.getTileBoard();
					Integer x = currentGame.getPlayers().get(currPlayer).getPosition().getX();
					Integer y = currentGame.getPlayers().get(currPlayer).getPosition().getY();
					Tile currTile = TileBoard[x][y];
					
					if (!currTile.getName().equals("E")) {
						textArea.append("Sorry! You can't buy any hotels! You're not an E tile!\n\n");
						return;
					}
							
					currentGame.reqNewHotelOrNewEntrance("h");
					
				}
			}
		});
		
		buyEntr_button.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (buyEntr_button.isSelected()) {
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					Integer currPlayer = currentGame.getCurrentPlayer();
					Tile[][] TileBoard = currentGame.getTileBoard();
					Integer x = currentGame.getPlayers().get(currPlayer).getPosition().getX();
					Integer y = currentGame.getPlayers().get(currPlayer).getPosition().getY();
					Tile currTile = TileBoard[x][y];
					
					if (!currTile.getName().equals("E")) {
						textArea.append("Sorry! You can't buy any entrances! You're not an E tile!\n\n");
						return;
					}
							
					currentGame.reqNewHotelOrNewEntrance("e");
					
				}
			}
		});
		
		reqMoney_button.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (reqMoney_button.isSelected()) {
					
					if (gameIsOn.equals(false)) {
						JOptionPane.showMessageDialog(null, "Pick a game first!");
						return;
					}
					
					Boolean hasPassedThroughTheBank = false;
					List<Tile> hasPassedThrough = currentGame.getPlayers().get(currentGame.getCurrentPlayer()).getHasPassedThrough();
					for (Tile currTile : hasPassedThrough) {
						if (currTile.getName().equals("B"))
							hasPassedThroughTheBank = true;
					}
					
					if (hasPassedThroughTheBank)
						currentGame.reqMoneyFromBank();
					else {
						textArea.append("\nYou haven't passed by the bank this turn! No money!\n\n");
					}
				}
			}
		});
		
		/* This is the combobox handler used for selecting which tile a player wants to buy */
		ReqRealEstateBox.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				
				if (!ReqRealEstateBox.hasFocus()) return;
				
				currentGame.completeRealEstatePurchase(ReqRealEstateBox.getSelectedItem().toString());
				lblWhichOne.setVisible(false);
				sideLayer.remove(ReqRealEstateBox);
				return;
			}
		});
		
		/* This is the combobox handler used for selecting which tile a player wants to build upon or buy an entrance for*/
		comboBoxChooseHotelToBuild.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				if (!comboBoxChooseHotelToBuild.hasFocus()) return;
				
				if (currentGame.getBuyHotelOrEntranceFlag().equals(true)) {
					currentGame.completeHotelPurchase(comboBoxChooseHotelToBuild.getSelectedItem().toString());
					lblWhichOne.setVisible(false);
					sideLayer.remove(comboBoxChooseHotelToBuild);
					revalidate();
					repaint();
					return;
				}
				
				
				if (currentGame.getBuyHotelOrEntranceFlag().equals(false)) {
					currentGame.completeEntrancePurchase(comboBoxChooseHotelToBuild.getSelectedItem().toString());
					lblWhichOne.setVisible(false);
					sideLayer.remove(comboBoxChooseHotelToBuild);
					revalidate();
					repaint();
					return;
				}
				
			}
		});
		
		tglbtnPassTurn.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent arg0) {
				currentGame.getNextPlayer();
				System.out.println("Next Player is Player" + new Integer(currentGame.getCurrentPlayer()+1));
				
				
				getColorLed().setForeground(currentGame.getPlayers().get(currentGame.getCurrentPlayer()).getColor());
				String nextPlayerPos = currentGame.getAlphabet().get(currentGame.getPlayers().get(currentGame.getCurrentPlayer()).getPosition().getY()) + new Integer(currentGame.getPlayers().get(currentGame.getCurrentPlayer()).getPosition().getX()+1).toString();
				getcurrPos().setText(nextPlayerPos);
				
				lblWhichOne.setVisible(false);
				sideLayer.remove(comboBoxChooseHotelToBuild);
				sideLayer.remove(ReqRealEstateBox);
				
				rollDice_button.setEnabled(true);
				
				revalidate();
				repaint();
			}
		});

	}

	
	private void initComponents() {
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 1007, 778);
		contentPane = new JPanel();
		
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(null);
		
		String[] gameOptions = {"Start", "Stop", "Cards", "Exit"};
		comboBox_game = new JComboBox(gameOptions);
		comboBox_game.setBounds(6, 20, 114, 22);
		contentPane.add(comboBox_game);
		
		String[] statisticsOptions = {"Hotels", "Entrances", "Profits"};
		comboBox_statistics = new JComboBox(statisticsOptions);
		comboBox_statistics.setBounds(132, 20, 114, 22);
		contentPane.add(comboBox_statistics);
		
		lblGame = new JLabel("Game");
		lblGame.setFont(new Font("Meslo LG S", Font.BOLD, 14));
		lblGame.setBounds(6, 6, 101, 16);
		contentPane.add(lblGame);
		
		lblStatistics = new JLabel("Statistics");
		lblStatistics.setFont(new Font("Meslo LG S", Font.BOLD, 14));
		lblStatistics.setBounds(132, 7, 114, 16);
		contentPane.add(lblStatistics);
		
		upperLayer = new JPanel();
		upperLayer.setBounds(6, 54, 977, 29);
		contentPane.add(upperLayer);
		upperLayer.setLayout(null);
		
		lblPlayer1 = new JLabel("Player 1: ");
		lblPlayer1.setBounds(18, 6, 55, 16);
		upperLayer.add(lblPlayer1);
		
		lblPlayer2 = new JLabel("Player 2: ");
		lblPlayer2.setBounds(151, 6, 55, 16);
		upperLayer.add(lblPlayer2);
		
		lblPlayer3 = new JLabel("Player 3: ");
		lblPlayer3.setBounds(274, 6, 55, 16);
		upperLayer.add(lblPlayer3);
		
		money1 = new JLabel("");
		money1.setBounds(71, 6, 55, 16);
		upperLayer.add(money1);
		
		money2 = new JLabel("");
		money2.setBounds(207, 6, 55, 16);
		upperLayer.add(money2);
		
		money3 = new JLabel("");
		money3.setBounds(330, 6, 55, 16);
		upperLayer.add(money3);
		
		lblAvailableHotels = new JLabel("Available Hotels: ");
		lblAvailableHotels.setBounds(397, 6, 94, 16);
		upperLayer.add(lblAvailableHotels);
		
		lblTotalTime = new JLabel("Total Time:");
		lblTotalTime.setBounds(570, 6, 70, 16);
		upperLayer.add(lblTotalTime);
		
		numHotels = new JLabel("");
		numHotels.setBounds(503, 6, 26, 16);
		upperLayer.add(numHotels);
		
		totalTime = new DigitalClock(gameIsOn);
		totalTime.setBounds(652, 3, 70, 22);
		upperLayer.add(totalTime);
		
		tglbtnPassTurn = new JToggleButton("Pass Turn");
		tglbtnPassTurn.setBounds(825, 0, 127, 28);
		upperLayer.add(tglbtnPassTurn);
		
		mainLayer = new MainGrid(this_pointer);
		mainLayer.setBounds(6, 126, 764, 585);
		contentPane.add(mainLayer);
		mainLayer.setLayout(null);
		
		JLabel label = new JLabel("1");
		label.setFont(new Font("SansSerif", Font.BOLD, 20));
		label.setForeground(Color.WHITE);
		label.setBounds(734, 27, 30, 16);
		mainLayer.add(label);
		
		JLabel label_1 = new JLabel("2");
		label_1.setForeground(Color.WHITE);
		label_1.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_1.setBounds(734, 71, 55, 16);
		mainLayer.add(label_1);
		
		JLabel label_2 = new JLabel("3");
		label_2.setForeground(Color.WHITE);
		label_2.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_2.setBounds(734, 116, 55, 16);
		mainLayer.add(label_2);
		
		JLabel label_3 = new JLabel("4");
		label_3.setForeground(Color.WHITE);
		label_3.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_3.setBounds(734, 167, 55, 16);
		mainLayer.add(label_3);
		
		JLabel label_4 = new JLabel("5");
		label_4.setForeground(Color.WHITE);
		label_4.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_4.setBounds(734, 212, 55, 16);
		mainLayer.add(label_4);
		
		JLabel label_5 = new JLabel("6");
		label_5.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_5.setForeground(Color.WHITE);
		label_5.setBounds(734, 262, 55, 16);
		mainLayer.add(label_5);
		
		JLabel label_6 = new JLabel("7");
		label_6.setForeground(Color.WHITE);
		label_6.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_6.setBounds(734, 311, 55, 16);
		mainLayer.add(label_6);
		
		JLabel label_7 = new JLabel("8");
		label_7.setForeground(Color.WHITE);
		label_7.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_7.setBounds(734, 358, 55, 16);
		mainLayer.add(label_7);
		
		JLabel label_8 = new JLabel("9");
		label_8.setForeground(Color.WHITE);
		label_8.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_8.setBounds(734, 405, 55, 16);
		mainLayer.add(label_8);
		
		JLabel label_9 = new JLabel("10");
		label_9.setForeground(Color.WHITE);
		label_9.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_9.setBounds(734, 447, 55, 16);
		mainLayer.add(label_9);
		
		JLabel label_10 = new JLabel("11");
		label_10.setForeground(Color.WHITE);
		label_10.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_10.setBounds(734, 498, 55, 16);
		mainLayer.add(label_10);
		
		JLabel label_11 = new JLabel("12");
		label_11.setForeground(Color.WHITE);
		label_11.setFont(new Font("SansSerif", Font.BOLD, 20));
		label_11.setBounds(734, 545, 55, 16);
		mainLayer.add(label_11);
		
		sideLayer = new JPanel();
		sideLayer.setBounds(773, 126, 210, 372);
		contentPane.add(sideLayer);
		sideLayer.setLayout(null);
		
		rollDice_button = new JRadioButton("Roll dice & result");
		rollDice_button.setBounds(6, 6, 115, 18);
		sideLayer.add(rollDice_button);
		
		reqBuild_button = new JRadioButton("Request building & result");
		reqBuild_button.setBounds(6, 36, 190, 18);
		sideLayer.add(reqBuild_button);
		
		buyH_button = new JRadioButton("Buy hotel");
		buyH_button.setBounds(6, 66, 115, 18);
		sideLayer.add(buyH_button);
		
		buyEntr_button = new JRadioButton("Buy entrance");
		buyEntr_button.setBounds(6, 96, 115, 18);
		sideLayer.add(buyEntr_button);
		
		reqMoney_button = new JRadioButton("Request +1000 from bank");
		reqMoney_button.setBounds(6, 126, 179, 25);
		sideLayer.add(reqMoney_button);
		
		myGroup = new ButtonGroup();
		myGroup.add(rollDice_button);
		myGroup.add(reqBuild_button);
		myGroup.add(buyH_button);
		myGroup.add(buyEntr_button);
		myGroup.add(reqMoney_button);
		
		ColorLed = new JLabel("•");
		ColorLed.setFont(new Font("SansSerif", Font.PLAIN, 63));
		ColorLed.setBounds(78, 163, 53, 47);
		ColorLed.setForeground(Color.black);
		sideLayer.add(ColorLed);
		
		lblCurrentPosition = new JLabel("Current Position");
		lblCurrentPosition.setBounds(51, 209, 115, 16);
		sideLayer.add(lblCurrentPosition);
		
		currPos = new JLabel("");
		currPos.setFont(new Font("Menlo", Font.BOLD, 24));
		currPos.setBounds(78, 237, 68, 32);
		sideLayer.add(currPos);
		
		ReqRealEstateBox = new JComboBox();
		ReqRealEstateBox.setBounds(51, 321, 109, 26);
		
		lblWhichOne = new JLabel("which one?");
		lblWhichOne.setBounds(68, 299, 78, 16);
		sideLayer.add(lblWhichOne);
		lblWhichOne.setVisible(false);
		
		comboBoxChooseHotelToBuild = new JComboBox();
		comboBoxChooseHotelToBuild.setBounds(62, 327, 78, 26);
		
		scrollPane = new JScrollPane();
		scrollPane.setBounds(783, 510, 196, 201);
		contentPane.add(scrollPane);
		textArea = new JTextArea("Hello!\n", 5, 5);
		scrollPane.setViewportView(textArea);
		
		JLabel lblA = new JLabel("a");
		lblA.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblA.setBounds(44, 107, 22, 16);
		contentPane.add(lblA);
		
		lblB = new JLabel("b");
		lblB.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblB.setBounds(91, 108, 22, 16);
		contentPane.add(lblB);
		
		lblC = new JLabel("c");
		lblC.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblC.setBounds(139, 106, 27, 22);
		contentPane.add(lblC);
		
		lblD = new JLabel("d");
		lblD.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblD.setBounds(191, 108, 22, 16);
		contentPane.add(lblD);
		
		JLabel lblE = new JLabel("e");
		lblE.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblE.setBounds(232, 108, 27, 16);
		contentPane.add(lblE);
		
		JLabel lblF = new JLabel("f");
		lblF.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblF.setBounds(283, 108, 22, 16);
		contentPane.add(lblF);
		
		JLabel lblG = new JLabel("g");
		lblG.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblG.setBounds(327, 95, 22, 29);
		contentPane.add(lblG);
		
		JLabel lblH = new JLabel("h");
		lblH.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblH.setBounds(369, 108, 32, 16);
		contentPane.add(lblH);
		
		JLabel lblI = new JLabel("i");
		lblI.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblI.setBounds(424, 108, 22, 16);
		contentPane.add(lblI);
		
		JLabel lblJ = new JLabel("j");
		lblJ.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblJ.setBounds(468, 95, 22, 32);
		contentPane.add(lblJ);
		
		JLabel lblK = new JLabel("k");
		lblK.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblK.setBounds(516, 107, 22, 19);
		contentPane.add(lblK);
		
		JLabel lblL = new JLabel("l");
		lblL.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblL.setBounds(565, 108, 22, 16);
		contentPane.add(lblL);
		
		JLabel lblM = new JLabel("m");
		lblM.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblM.setBounds(603, 108, 27, 16);
		contentPane.add(lblM);
		
		JLabel lblN = new JLabel("n");
		lblN.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblN.setBounds(648, 108, 27, 16);
		contentPane.add(lblN);
		
		JLabel lblO = new JLabel("o");
		lblO.setFont(new Font("SansSerif", Font.BOLD, 20));
		lblO.setBounds(699, 108, 27, 16);
		contentPane.add(lblO);
	}
}
