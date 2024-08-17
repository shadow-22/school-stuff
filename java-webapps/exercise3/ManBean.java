package CVShop;

public class ManBean {
	String ManName;
	Integer ManYear;
	String ManCountry;

	public ManBean() {

	}

	public ManBean(String name, Integer year, String country) {
		this.ManName = name;
		this.ManYear = year;
		this.ManCountry = country;
	}

	public String getManName() {
		return this.ManName;
	}

	public void setManName(String name) {
		this.ManName = name;
	}

	public Integer getManYear() {
		return this.ManYear;
	}

	public void setManYear(Integer year) {
		this.ManYear = year;
	}

	public String getManCountry() {
		return this.ManCountry;
	}

	public void setManCountry(String country) {
		this.ManCountry = country;
	}

	public String toString() {
		return "'" + ManName + "' funded in " + ManYear + "(" + ManCountry + ")";
	}
}
