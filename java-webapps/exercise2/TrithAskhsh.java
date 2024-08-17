package pckg1;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletConfig;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.UnavailableException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.sax.SAXSource;
import javax.xml.transform.stream.StreamResult;
import javax.xml.transform.stream.StreamSource;
import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;

@WebServlet("/TrithAskhsh")
public class TrithAskhsh extends HttpServlet {
	private static final long serialVersionUID = 1L;
	 
	ServletContext ctx;
	String absPath;
	SAXSource xsltDoc;
	TransformerFactory tF;
	Transformer myTransformer;
	Document doc;
	String xmlChoice;
	
	public void init(ServletConfig config) throws UnavailableException {
		System.out.println("Init start.");
		
		try {
			ctx = config.getServletContext();
			absPath = ctx.getRealPath("/WEB-INF/StyleSheet.xsl");
			xsltDoc = new SAXSource(new InputSource(absPath));
			tF = TransformerFactory.newInstance();
			DocumentBuilderFactory fact = 
			DocumentBuilderFactory.newInstance();
			fact.setNamespaceAware(true);
			DocumentBuilder builder = fact.newDocumentBuilder();
			doc = builder.parse("file:///" + absPath);
			System.out.println("Name of document element is " + 
			doc.getDocumentElement().getNodeName());
		} catch(Exception e) {
			e.printStackTrace();
		}

		System.out.println("Init end");
	}


	private void changeDomByColor(Document doc, String color) {
		NodeList nl = doc.getElementsByTagName("h1");
		Attr a = doc.createAttribute("style");
		a.setValue("background-color:" + color);
		nl.item(0).getAttributes().setNamedItem(a);
	}

	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		System.out.println("doGet start");
		PrintWriter output;
		response.setContentType("text/html");
		output = response.getWriter();
		output.println("<html><head><title>");
		output.println("Welcome");
		output.println("</title></head><body>");
		output.println("<h1 text-align:'center'>Hello</h1>");
		output.println("<form action='http://localhost:8080/Ergasia2_Ask3_Test1/TrithAskhsh' method='post'>");
		output.println("<input type='radio' name='color' value='red'>Red</input>");
		output.println("<input type='radio' name='color' value='blue'>Blue</input>");
		output.println("<input type='radio' name='color' value='green'>Green</input>");
		output.println("<br><br>");
		output.println("<select name='xmlChoice'>");
		output.println("<option value='cars.xml'>Cars</option>");
		output.println("<option value='employees.xml'>Employees</option>");
		output.println("<option value='books.xml'>Books</option>");
		output.println("</select>");
		output.println("<input type='submit' value='ok'></form></body></html>");
		output.close();
		System.out.println("doGet stop");
	}

	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		System.out.println("doPost start");
		System.out.println("Name of document element(at the post) is " + 
		doc.getDocumentElement().getNodeName());
		String color = request.getParameter("color");
		String xmlChoice = request.getParameter("xmlChoice");
		System.out.println("You chose " + xmlChoice);
		System.out.println("You selected the color " + color);
		System.out.println(doc.getElementsByTagName("h1").item(0).getAttributes().getNamed
		Item("style").getNodeName());
		changeDomByColor(doc, color);
		System.out.println(doc.getElementsByTagName("h1").item(0).getAttributes().getNamed
		Item("style").getNodeName());
		PrintWriter pwr = response.getWriter();
		
		try {
			DOMSource ds = new DOMSource(doc);
			System.out.println(((Document)ds.getNode()).getDocumentElement().getNodeName() 
			+" " +((Document)ds.getNode()).getDocumentElement().getNodeValue());
			myTransformer = tF.newTransformer(ds);
			StreamSource xmlSource = new 
			StreamSource(ctx.getResourceAsStream("/WEB-INF/" + xmlChoice));
			System.out.println("Sending back the xml transformed into html");
			// in order to put in http body
			response.setContentType("text/html");
			myTransformer.transform(xmlSource, new StreamResult(pwr));
			pwr.println("The response sent back as a page!");
			pwr.close();
		} catch(Exception e) {
			e.printStackTrace();
		}

		System.out.println("doPost stop");
	}

}
