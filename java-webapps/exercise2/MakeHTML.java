package ask2_a_teliko;

import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.stream.StreamResult;
import javax.xml.transform.stream.StreamSource;

public class MakeHTML {
	public static void main(String[] args) throws TransformerException {
		TransformerFactory tff = TransformerFactory.newInstance();
		String myString1 = "src\\ask2_a_teliko\\StyleSheet.xsl";
		String myString2 = "src\\ask2_a_teliko\\books.xml";
		String myString3 = "src\\ask2_a_teliko\\books.html";
		Transformer tf = tff.newTransformer(new StreamSource(myString1));
		StreamSource ss = new StreamSource(myString2);
		StreamResult sr = new StreamResult(myString3);
		tf.transform(ss, sr);
		System.out.println("Done");
	}
}
