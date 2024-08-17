package CVShop;

import java.util.Hashtable;

public class CVCatalog {
	private Hashtable catalog;

	public CVCatalog() {
		catalog = new Hashtable();

		addV(new VehicleBean("Buick", new ManBean("General Motors", 1908, "USA"), "1948"));
		addV(new VehicleBean("Mustang", new ManBean("Ford", 1903, "USA"), "1960"));
		addV(new VehicleBean("4CV", new ManBean("Citroen", 1919, "France"), "1950"));
		addV(new VehicleBean("Jeep", new ManBean("General Motors", 1908, "USA"), "1942"));
		addV(new VehicleBean("Beatle", new ManBean("Volkswagen", 1937, "Germany"), "1938"));
	}

	public void addV(VehicleBean vObj) {
		if (vObj == null) {
			throw new IllegalArgumentException("The object provided cannot be null");
		}
		catalog.put(vObj.getVModel(), vObj);
		System.out.println("Addition at server level: " + vObj.getVModel());
	}

	public VehicleBean getVehicleBean(String model) {
		if (model == null) {
			throw new IllegalArgumentException("carModel cannot be null");
		}
		return (VehicleBean)catalog.get(model);
	}

	public Hashtable listV() {
		return catalog;
	}
}
