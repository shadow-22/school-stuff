package ask1_b_teliko;

import java.io.IOException;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import org.xml.sax.Attributes;
import org.xml.sax.ContentHandler;
import org.xml.sax.Locator;
import org.xml.sax.SAXException;
import org.xml.sax.XMLReader;

public class SAXTester implements ContentHandler {
	@SuppressWarnings("unused")
	private Locator Loc;
	static int Level;
	static String[] XMLTree;
	
	public static void main(String[] args) throws ParserConfigurationException, SAXException, IOException {
		// System.out.println("Here we go..");
		SAXTester MySAXTester = new SAXTester();
		MySAXTester.go();
	}

	private void go() throws ParserConfigurationException, SAXException, IOException {
		SAXParserFactory MyFactory = SAXParserFactory.newInstance();
		SAXParser MyParser = MyFactory.newSAXParser();
		XMLReader MyXMLReader = MyParser.getXMLReader();
		MyXMLReader.setContentHandler(this);
		MyXMLReader.parse("simple.xml");
		// System.out.println("\n################# OUTPUT #################");
		for (int i = 0; i <= 4; i++) {
			System.out.println("#### Level: " + i + "####");
			System.out.print(XMLTree[i]);
		}
	}

	@Override
	public void characters(char[] ch, int start, int length) throws SAXException {
		String myString = new String(ch, start, length);
		if (!myString.trim().isEmpty()) {
			// System.out.println("Characters: " + myString.trim());
			XMLTree[Level] += myString.trim() + "\n";
		}
	}

	@Override
	public void endDocument() throws SAXException {
	// System.out.println("End Document.");
	}

	@Override
	public void endElement(String uri, String localName, String qName) throws SAXException {
		// System.out.println("End Element: " + qName + " at line " + Loc.getLineNumber());
		Level--;
	}

	@Override
	public void endPrefixMapping(String prefix) throws SAXException {
	}

	@Override
	public void ignorableWhitespace(char[] ch, int start, int length) throws SAXException {
	}

	@Override
	public void processingInstruction(String target, String data) throws SAXException {
	}

	@Override
	public void setDocumentLocator(Locator locator) {
		this.Loc = locator;
	}

	@Override
	public void skippedEntity(String name) throws SAXException {
	}

	@Override
	public void startDocument() throws SAXException {
		// System.out.println("Start Document.");
		Level = 0;
		XMLTree = new String[5];
		for (int i = 0; i <= 4; i++)
		XMLTree[i] = "";
	}

	@Override
	public void startElement(String uri, String localName, String qName, Attributes atts) throws SAXException {
		// System.out.println("Start Element: " + qName + " at line " + Loc.getLineNumber());
		Level++;
		String CurrentElement = new String(qName);
		XMLTree[Level-1] += CurrentElement;
		if (atts.getLength() != 0) {
			XMLTree[Level-1] += " ,attributes-> ";
			for (int i = 0; i < atts.getLength(); i++) {
			XMLTree[Level-1] += atts.getQName(i) + ":" + atts.getValue(i);
			}
			XMLTree[Level-1] += "\n";
		} else {
			XMLTree[Level-1] += "\n";
		}
	}

	@Override
	public void startPrefixMapping(String prefix, String uri) throws SAXException {
	}

}
