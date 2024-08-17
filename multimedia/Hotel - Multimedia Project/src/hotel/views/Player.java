package hotel.views;

import java.awt.Color;
import java.util.ArrayList;
import java.util.List;

public class Player {
	private Integer money;
	private Integer maxMoney;
	/* All Tiles owned by the Player*/
	private List<Tile> TilesOwned;
	private Color PColor;
	private MyTuple Position;
	/* Index of the position of the player in the Path vector */
	private Integer index;
	/* For the GUI */
	private Integer numberOfEntrances;
	private Boolean isBankrupt;
	/* Current path - is emptied with every new dice roll */
	private List<Tile> hasPassedThrough;
	
	public Player(MyTuple playerPosition, Color playerColor) {
		money = 1200;
		TilesOwned = new ArrayList<Tile>();
		Position = playerPosition;
		PColor = playerColor;
		maxMoney = money;
		index = 0;
		numberOfEntrances = 0;
		isBankrupt = false;
		hasPassedThrough = new ArrayList<Tile>();		
	}
	/* setters - getters */
	public void setNumberOfEntrances(Integer a) {
		numberOfEntrances = a;
	}
	
	public List<Tile> getHasPassedThrough() {
		return hasPassedThrough;
	}
	
	public List<Tile> getTilesOwned() {
		return this.TilesOwned;
	}
	
	public Boolean isBankrupt() {
		return isBankrupt;
	}
	
	public void setIsBankrupt(Boolean a) {
		isBankrupt = a;
	}
	
	public Integer getNumberOfEntrances() {
		return numberOfEntrances;
	}
	
	public Integer getMoney() {
		return money;
	}
	
	public Color getColor() {
		return PColor;
	}
	
	public MyTuple getPosition() {
		return Position;
	}
	
	public Integer getMaxMoney() {
		return maxMoney;
	}
	
	public Integer getIndex() {
		return index;
	}
	
	public void setIndex(Integer index) {
		this.index = index;
	}
	
	public void setMoney(Integer newMoney) {
		if (newMoney > maxMoney)
			maxMoney = newMoney;
		money = newMoney;
	}
	
	public void setPosition(MyTuple newPosition) {
		this.Position = newPosition;
	}

}
