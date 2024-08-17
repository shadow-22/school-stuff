package hotel.views;

/* Little helper class */
public class MyTuple {
	
	private Integer x, y;
	
	public MyTuple() {
		setX(null);
		setY(null);
	}
	
	public MyTuple(Integer a, Integer b) {
		setX(a);
		setY(b);
	}

	public Integer getX() {
		return x;
	}

	public void setX(Integer x) {
		this.x = x;
	}

	public Integer getY() {
		return y;
	}

	public void setY(Integer y) {
		this.y = y;
	}
	

}
