package gamaws.db;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.apache.commons.lang3.StringUtils;

import gamaws.utils.DBConnection;
import gamaws.utils.Webpage;
public class WebpageToGamaWSDB {
	
	public static void deleteAllWebpage() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_webpage;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all webpage");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_webpage", 1);
		}
	}
	
	private static List<Webpage> readWebpageFromMenu() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		String query = "select id, short_title, filename_gh from gm_menu "
				+ "where filename_gh IS NOT NULL;";
		
		List<Webpage> listWebpage = new ArrayList<Webpage>();
		try {
			if(dbc.prepareStatement(query)){
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
				while (dbc.getResultSet().next()) {
					Webpage webpage = new Webpage(0, 
							dbc.getResultSet().getString("short_title"), 
							getWebpageCategory(dbc.getResultSet().getString("filename_gh")), 
							dbc.getResultSet().getInt("id"));
					listWebpage.add(webpage);
		        }
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
		System.out.println("read " + listWebpage.size() + " Webpages");
		return listWebpage;
	}
	
	private static String getWebpageCategory(String filename_gh){
		String category = filename_gh.split("/")[2];
		System.out.println(category);
		if(StringUtils.containsIgnoreCase(category, "GamlReference"))
			return "gamlRefPage";
		else{
			if(StringUtils.containsIgnoreCase(category, "ModelLibrary")){
				return "modelPage";
			} else{
				return "docPage";
			}
		}
	}
	
	private static void writeWebpageToDB(List<Webpage> listWepage){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String query = "INSERT INTO gm_webpage"
					+ "(name, webpageCategory, idMenu) VALUES"
					+ "(?,?,?)";
			
			if(dbc.prepareStatement(query)){
				int i = 0;
				for(Webpage webpage : listWepage){
					i++;
				
					dbc.getPreparedStatement().setString(1, webpage.getName());
					dbc.getPreparedStatement().setString(2, webpage.getWebpageCategory());
					dbc.getPreparedStatement().setInt(3, webpage.getIdMenu());
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == listWepage.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " webpages");
		            }
				}
				
				dbc.getConnect().commit();
				dbc.getConnect().setAutoCommit(true);
			}
			
		} catch (SQLException e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
	}
	
	
	public static void writeWebpageToDB(){
		//deleteAllWebpage();
		List<Webpage> listWebpage = readWebpageFromMenu();
		writeWebpageToDB(listWebpage);
	}

	
	public static void main(String[] args){
		//deleteAllKeyword();
		//writeKeywordToGamaWSDB();
		writeWebpageToDB();
		//verifyKeywordList(readKeywordFromFile());
		//escapeSpecialCharacters();
	}
}
