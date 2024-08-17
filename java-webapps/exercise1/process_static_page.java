import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;

// ###################### FORM 1 ############################
public class process_static_page extends HttpServlet {
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		String[] productFamily = {"Toys", "Household items", "Books"};
		String[] serviceFamily = {"Trips", "Repair", "Teaching"};
		PrintWriter output;
		String name = request.getParameter("name");
		Cookie myCookie = new Cookie("myName", name);
		myCookie.setMaxAge(300);
		response.addCookie(myCookie);
		response.setContentType("text/html");
		output = response.getWriter();
		String choice = request.getParameter("choice");
		output.println("<html><head><title>Choose product type</title>");
		// ########## some CSS #############
		output.println("<style type='text/css'>");
		output.println("body{text-align: center;");
		output.println("color: white; background-image: url('background.jpeg')}");
		output.println("</style>");
		// #################################
		output.println("</head><body>");
		output.println("<form action='http://localhost:8080/ergasia1_diadiktyo&efarmoges/second_page' method='post'>");
		if (choice.equals("product")) {
			output.println("<select name='productType'>");
			for (int i = 0; i < productFamily.length; i++) {
				output.println("<option value='" + productFamily[i] + "'>" + productFamily[i] + "</option>");
			}
		} else if (choice.equals("service")) {
			output.println("<select name='serviceType'>");
			for (int i = 0; i < serviceFamily.length; i++) {
				output.println("<option value='" + serviceFamily[i] + "'>" + serviceFamily[i] + "</option>");
			}
		}
		output.println("</select><br><br>");
		output.println("<input type='submit' name='submit' value='Submit'></form>");
		output.println("</body></html>");
		output.close();
	}

	public void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
	// ############ do nothing ###############
	}
}