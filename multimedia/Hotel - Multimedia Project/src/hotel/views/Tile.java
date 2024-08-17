package hotel.views;

public class Tile {
	/* letter code as read from input boards.txt */
	private String name = "null";
	/* Position in GameLogic TileBoard array */
	private MyTuple Position;
	/* is it claimed by somebody? */
	private Boolean isOwned = false;
	/* if yes, who?
	 * 0 -> first player
	 * 1 -> second player
	 * 2 -> third player */
	private Integer owner = -1;
	/* construction level 
	 * -1 -> unclaimed land 
	 *  0 -> claimed land 
	 *  1 -> main hotel only 
	 *  2 -> 1st expansion
	 *  ...
	 *  */
	private Integer currentLevelOfExpansion = -1;	
	/* daily cost
	 * currentLevelOfExpansion >= 0 
	 * otherwise daily cost is 0 
	 * */
	private Integer dailyCost = 0;
	
	private Boolean isConfiscated = false;
	
	private Integer MaxLevelOfExpansion = -1;
	
	/* literal hotel name from file */
	private String nameHotel;
	
	private Boolean hasEntrance = false;
	
	private Tile entranceOf = null;
	
	public Tile() {
		
	}
	
	public Tile(String name, MyTuple Position) {
		this.name = name;
		this.Position = Position;
		isOwned = false;
		owner = -1;
		currentLevelOfExpansion = -1;
		dailyCost = 0;
		isConfiscated = false;
		nameHotel = "unknown";
		hasEntrance = false;
		entranceOf = null;
	}
	
	/* setters - getters */
	public void setEntranceOf(Tile a) {
		entranceOf = a;
	}
	
	public Tile getEntranceOf() {
		return entranceOf;
	}
	
	public void setHasEntrance(Boolean h) {
		hasEntrance = h;
	}
	
	public Boolean hasEntrance() {
		return hasEntrance;
	}
	
	public void setDailyCost(Integer newCost) {
		dailyCost = newCost;
	}
	
	public void setNameHotel(String a) {
		nameHotel = a;
	}
	
	public String getNameHotel() {
		return nameHotel;
	}
	
	public void setCurrentLevelOfExpansion(Integer a) {
		currentLevelOfExpansion = a;
	}
	
	public void setMaxLevelOfExpansion(Integer a) {
		MaxLevelOfExpansion = a;
	}
	
	public Integer getMaxLevelOfExpansion() {
		return MaxLevelOfExpansion;
	}
	
	public void isConfiscated(Boolean value) {
		isConfiscated = value;
	}
	
	public Boolean isConfiscated() {
		return isConfiscated;
	}
	
	public String getName() {
		return name;
	}
	
	public MyTuple getPosition() {
		return this.Position;
	}	
	
	public Boolean isOwned() {
		return isOwned;
	}
	
	public Integer getOwner() {
		return owner;
	}
	
	public Integer getDailyCost() {
		return dailyCost;
	}
	
	public Integer getCurrentLevelOfExpansion() {
		return currentLevelOfExpansion;
	}
	
	public void setIsOwned(Boolean value) {
		isOwned = value;
	}
	
	public void setOwner(Integer owner) {
		this.owner = owner;
	}
}
