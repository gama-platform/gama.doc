package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;

public class CategoryToGamaWSDB {
	
	private static final String CATEGORY_FILE = "category.txt";
	
	public static void deleteAllCategory() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_category;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all category");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_category", 1);
		}
	}
	
	private static void writeCategoryToDB(List<String> listCategory){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertCategory = "INSERT INTO gm_category"
					+ "(name) VALUES"
					+ "(?)";
			
			if(dbc.prepareStatement(insertCategory)){
				int i = 0;
				for(String category : listCategory){
					i++;
					
					dbc.getPreparedStatement().setString(1, category);
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == listCategory.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " category");
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
	
	
	public static void writeCategoryToGamaWSDB(){
		//deleteAllCategory();
		List<String> listCategory = readCategorysFromFile();
		writeCategoryToDB(listCategory);
	}
	
	private static List<String> readCategorysFromFile(){
		List<String> listCategory = new ArrayList<String>();
		try{
			FileInputStream fis = new FileInputStream(CheckURL.pathToContent + File.separator + CATEGORY_FILE);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));
	
			String line = null;
			while ((line = br.readLine()) != null) {
				listCategory.addAll(Arrays.asList(line.split(",")));
			}
			br.close();
		}
		catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return listCategory;
	}
	
	public static void main(String[] args){
		deleteAllCategory();
		writeCategoryToGamaWSDB();
	}
}
