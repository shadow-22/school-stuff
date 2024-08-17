package CVShop;

public class VehicleBean {
	String VModel;
	ManBean VManufacturer;
	String VYear;

	public VehicleBean() {

	}

	public VehicleBean(String model, ManBean manu, String year) {
		this.VModel = model;
		this.VManufacturer = manu;
		this.VYear = year;
	}

	public String getVModel() {
		return VModel;
	}

	public void setVModel(String model) {
		this.VModel = model;
	}

	public ManBean getVManufacturer() {
		return VManufacturer;
	}

	public void setVManufacturer(ManBean manu) {
		this.VManufacturer = manu;
	}

	public String getVYear() {
		return VYear;
	}

	public void setVYear(String year) {
		this.VYear = year;
	}

	public String toString() {
		return "'" + VModel + "' by " + VManufacturer + " (" + VYear + ")";
	}
}
