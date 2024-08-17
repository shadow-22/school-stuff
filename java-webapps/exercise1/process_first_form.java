import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;

public class process_first_form extends HttpServlet {
	
	public void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// ######### product lists ############
		String[] toyList = {"Batman", "Pokemon", "Yugioh"};
		String[] householdList = {"TV", "Fridge", "Fork"};
		String[] bookList = {"Piter Pan", "The Programming Language C", "Wealth of Nations"};
		// ######### service lists ############
		String[] tripList = {"By plane", "By bus", "By sea"};
		String[] repairList = {"Repair car", "Repair computer", "Repair door"};
		String[] teachList = {"Teach math", "Teach Programming", "Teach Physics"};
		PrintWriter output;
		output = response.getWriter();
		output.println("<html><head><title>Choose</title>");
		// ############# some CSS ###############
		output.println("<style type='text/css'>");
		output.println("body{text-align: center;");
		output.println("color: white;");
		output.println("background-image: url('background.jpeg')}");
		output.println("</style></head><body>");
		// ######################################
		if (request.getParameter("productType") != null) {
			// output.println("<p style='color: white; text-align: center; font-size: 32px;'>You chose a product type.</p>");
			output.println("<form action='http://localhost:8080/ergasia1_diadiktyo&efarmoges/third_page' method='post'>");
			switch(request.getParameter("productType")) {
				case "Toys":
					output.println("<select name='toy'>");
					for (int i = 0; i < toyList.length; i++)
						output.println("<option value='" + toyList[i] + "'>" + toyList[i] + "</option>");
					break;
				case "HouseHold items":
					output.println("<select name='household_item'>");
					for (int i = 0; i < householdList.length; i++)
						output.println("<option value='" + householdList[i] + "'>" + householdList[i] + "</option>");
					break;
				case "Books":
					output.println("<select name='book'>");
					for (int i = 0; i < bookList.length; i++)
						output.println("<option value='" + bookList[i] + "'>" + bookList[i] + "</option>");
					break;
			}
			output.println("</select><br><br>");
			output.println("<input type='submit' name='submit' value='Submit'");
		} else if (request.getParameter("serviceType") != null) {
			// output.println("<p style='color: white; text-align: center; font-size: 32px;'>You chose a service type.</p>");
			output.println("<form action='http://localhost:8080/ergasia1_diadiktyo&efarmoges/third_page' method='post'>");
			switch(request.getParameter("serviceType")) {
			case "Trips":
			output.println("<select name='trip'>");
			for (int i = 0; i < tripList.length; i++)
			output.println("<option value='" + tripList[i] + "'>" + tripList[i] + "</option>");
			break;
			case "Repair":
			output.println("<select name='repair'>");
			for (int i = 0; i < repairList.length; i++)
			output.println("<option value='" + repairList[i] + "'>" + repairList[i] + 
			"</option>");
			break;
			case "Teaching":
			output.println("<select name='teaching'>");
			for (int i = 0; i < teachList.length; i++)
			output.println("<option value='" + teachList[i] + "'>" + teachList[i] + "</option>");
			break;
			}
			output.println("</select><br><br>");
			output.println("<input type='submit' name='submit' value='Submit'></form>");
		}
		output.println("</body></html>");
		output.close();
	}
}
