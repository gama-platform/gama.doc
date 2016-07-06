package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;

public class AliasToGamaWSDB {
	
	private static final String ALIAS_FILE = "alias.txt";
	
	public static void deleteAllAlias() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_alias;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all alias");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_alias", 1);
		}
	}
	
	private static void writeAliasToDB(List<String> listAlias){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertAlias = "INSERT INTO gm_alias"
					+ "(name, attachedKeywordName) VALUES"
					+ "(?,?)";
			
			if(dbc.prepareStatement(insertAlias)){
				int i = 0;
				for(String alias : listAlias){
					i++;
					
					String[] keywords = alias.split(":");
					
					//System.out.println(i + ":" + listAlias.size() + keywords[0] + keywords[1]);
					if(keywords.length != 2) continue;
					
					dbc.getPreparedStatement().setString(1, keywords[0]);
					dbc.getPreparedStatement().setString(2, keywords[1]);
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == listAlias.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " alias");
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
	
	
	public static void writeAliasToGamaWSDB(){
		//deleteAllAlias();
		List<String> listAlias = readAliasFromFile();
		writeAliasToDB(listAlias);
	}
	
	private static List<String> readAliasFromFile(){
		List<String> listAlias = new ArrayList<String>();
		try{
			FileInputStream fis = new FileInputStream(CheckURL.pathToContent + File.separator + ALIAS_FILE);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));
	
			String line = null;
			while ((line = br.readLine()) != null) {
				listAlias.add(line);
			}
			br.close();
		}
		catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return listAlias;
	}
	
	public static void main(String[] args){
		deleteAllAlias();
		writeAliasToGamaWSDB();
	}
}
