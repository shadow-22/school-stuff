import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;

public class process_second_form extends HttpServlet {
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		Cookie cookies[];
		cookies = request.getCookies();
		PrintWriter output = response.getWriter();
		String bought = "";
		output.println("<html><head><title>Success</title>");
		output.println("<style type='text/css'>");
		output.println("body{text-align: center;");
		output.println("color: white;");
		output.println("background-image: url('background.jpeg')}");
		output.println("</style>");
		output.println("<link rel='stylesheet' type='text/css' href='myStyle.css'>");
		output.println("</head><body>");
		
		if (request.getParameter("toy") != null) {
			switch(request.getParameter("toy")) {
				case "Batman":
					bought = "Batman";
					break;
				case "Pokemon":
					bought = "Pokemon";
					break;
				case "Yugioh":
					bought = "Yugioh";
					break;
			}
		} else if (request.getParameter("household_item") != null) {
			switch(request.getParameter("household_item")) {
				case "TV":
					bought = "TV";
					break;
				case "Fridge":
					bought = "Fridge";
					break;
				case "Fork":
					bought = "Fork";
					break;
			}
		} else if (request.getParameter("book") != null) {
			switch(request.getParameter("book")) {
				case "Piter Pan":
					bought = "Piter Pan book";
					break;
				case "The Programming Language C":
					bought = "The Programming Language C book";
					break;
				case "Wealth of Nations":
					bought = "Wealth of Nations book";
					break;
			}
		} else if (request.getParameter("trip") != null) {
			switch(request.getParameter("trip")) {
				case "By plane":
					bought = "By plane trip";
					break;
				case "By bus":
					bought = "By bus trip";
					break;
				case "By sea":
					bought = "By sea trip";
					break;
			}
		} else if (request.getParameter("repair") != null) {
			switch(request.getParameter("repair")) {
				case "Repair car":
					bought = "car repair service";
					break;
				case "Repair computer":
					bought = "computer repair service";
					break;
				case "Repair door":
					bought = "door repair service";
					break;
			}
		} else if (request.getParameter("teaching") != null) {
			switch(request.getParameter("teaching")) {
				case "Teach math":
					bought = "math teaching service";
					break;
				case "Teach Programming":
					bought = "programming teaching service";
					break;
				case "Teach Physics":
					bought = "physics teaching service";
					break;
			}
		}

		if (cookies.length > 0) {
			for (int i = 0; i < cookies.length; i++) {
				if (cookies[i].getName().equals("myName")) {
					output.println("<h2 style>");
					output.println("Your name is " + cookies[i].getValue() + " and you just bought a " + bought);
					output.println("</h2>");
				}
			}
		}
		output.println("</body></html>");
		output.close();
	}
}
