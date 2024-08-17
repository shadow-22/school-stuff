package ask1_a_teliko;

import java.io.File;
import java.io.IOException;
import java.util.LinkedList;
import java.util.Queue;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NamedNodeMap;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

public class DomBFSTraversal {
	
	public static void main(String[] args) throws ParserConfigurationException, SAXException, IOException {
			File MyFile = new File("example.xml");
			Node root = makeXMLDOM(MyFile);
			BFSTraversal(root);
	}
	
	private static Node makeXMLDOM(File MyFile) throws ParserConfigurationException, SAXException, IOException {
		DocumentBuilderFactory MyFactory = DocumentBuilderFactory.newInstance();
		DocumentBuilder MyBuilder = MyFactory.newDocumentBuilder();
		Document MyDomTree = MyBuilder.parse("example.xml");
		MyDomTree.normalize();
		Element root = (Element)MyDomTree.getDocumentElement();
		return root;
	}

	private static void BFSTraversal(Node DomNode) {
		Queue<Node> Queue = new LinkedList<>();
		Queue.add(DomNode);
		Queue.add(null);
		int level = 1;
		System.out.println("#### Level: 0 ####");
		
		while (!Queue.isEmpty()) {
			Node CurrentNode = Queue.poll();
			if (CurrentNode == null) {
				if (!Queue.isEmpty()) {
					Queue.add(null);
					System.out.println("#### Level: " + level + " ####");
					level = level + 1;
				}
			} else {
				NodeList Children = CurrentNode.getChildNodes();
				int NumberOfChildren = Children.getLength();
				
				for (int i = 0; i < NumberOfChildren; i++) {
					Queue.add(Children.item(i));
				}

				if (CurrentNode.getNodeType() == Node.ELEMENT_NODE) {
					System.out.print(CurrentNode.getNodeName().trim());
					NamedNodeMap attributes = CurrentNode.getAttributes();
					if (attributes.getLength() != 0) {
						System.out.print(", attributes of " + 
						CurrentNode.getNodeName().trim() + ": ");
						for (int i = 0; i < attributes.getLength(); i++) {
							System.out.print(attributes.item(i) + " ");
						}
						System.out.println();
					} else {
					System.out.println();
					}
				} else if (CurrentNode.getNodeType() == Node.TEXT_NODE) {
					if (!CurrentNode.getTextContent().trim().isEmpty())
					System.out.println(CurrentNode.getTextContent().trim());
				}
			}
		}
	}
	
}
