package CVShop;

import java.net.URL;
import java.util.Enumeration;
import java.util.Hashtable;
import java.util.Vector;
import org.apache.soap.Constants;
import org.apache.soap.Fault;
import org.apache.soap.SOAPException;

import org.apache.soap.encoding.SOAPMappingRegistry;
import org.apache.soap.encoding.soapenc.BeanSerializer;

import org.apache.soap.rpc.Call;
import org.apache.soap.rpc.Parameter;
import org.apache.soap.rpc.Response;

import org.apache.soap.util.xml.QName;

public class CVAdderLister {
	public void addlist(URL url, String model, ManBean manufacturer, String year) throws SOAPException {
		VehicleBean vObj = new VehicleBean(model, manufacturer, year);

		SOAPMappingRegistry reg = new SOAPMappingRegistry();
		BeanSerializer serializer = new BeanSerializer();
		reg.mapTypes(Constants.NS_URI_SOAP_ENC, new QName("urn:VBean_xmlns", "vObj"), VehicleBean.class, serializer, serializer);
		reg.mapTypes(Constants.NS_URI_SOAP_ENC, new QName("urn:MBean_xmlns", "manufacturer"), ManBean.class, serializer, serializer);

		Call call = new Call();
		call.setSOAPMappingRegistry(reg);
		call.setTargetObjectURI("urn:CVehicleCatalog");
		call.setMethodName("addV");
		call.setEncodingStyleURI(Constants.NS_URI_SOAP_ENC);

		// #### adding ####
		System.out.println("Adding vehicle model " + model + " by " + manufacturer);
		Vector params = new Vector();
		params.addElement(new Parameter("vObj", VehicleBean.class, vObj, null));
		call.setParams(params);

		Response response;
		response = call.invoke(url, "");
		if (!response.generatedFault()) {
			System.out.println("Server reported NO FAULT while adding vehicle");
		} else {
			Fault fault = response.getFault();
			System.out.println("Server reported FAULT while adding:");
			System.out.println(fault.getFaultString());
		}

		// #### listing ####
		call.setMethodName("listV");
		call.setParams(null);
		response = call.invoke(url, "");

		Parameter returnValue = response.getReturnValue();
		Hashtable catalog = (Hashtable)returnValue.getValue();
		Enumeration e = catalog.keys();
		while (e.hasMoreElements()) {
			String VModel = (String)e.nextElement();
			VehicleBean vo = (VehicleBean)catalog.get(VModel);
			System.out.println(" " + vo.getVModel() + " by " + vo.getVManufacturer() + ", year " + vo.getVYear());
		}
	}

	public static void main(String[] args) {
		if (args.length != 6) {
			System.out.println("Put url, model, manufacturer name, manufacturer year, manufacturer country & vehicle year as arguments");
			return;
		}

		try {
			URL urlink = new URL(args[0]);

			String model = args[1];
			String manufacturerName = args[2];
			Integer manufacturerYear = Integer.parseInt(args[3]);
			String manufacturerCountry = args[4];
			String year = args[5];
			ManBean manufacturer = new ManBean(manufacturerName, manufacturerYear, manufacturerCountry);
			CVAdderLister adderlister = new CVAdderLister();
			adderlister.addlist(urlink, model, manufacturer, year);
		} catch(Exception e) {
			e.printStackTrace();
		}
	}

}
