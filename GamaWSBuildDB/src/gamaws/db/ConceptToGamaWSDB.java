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

public class ConceptToGamaWSDB {
	
	private static final String CONCEPTS_FILE = "concepts.txt";
	
	public static void deleteAllConcept() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_learning_concept;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all Concept");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_learning_concept", 1);
		}
	}
	
	private static void writeConceptToDB(List<String> listConcept){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertConcept = "INSERT INTO gm_learning_concept"
					+ "(name) VALUES"
					+ "(?)";
			
			if(dbc.prepareStatement(insertConcept)){
				int i = 0;
				for(String Concept : listConcept){
					i++;
					
					dbc.getPreparedStatement().setString(1, Concept);
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == listConcept.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " Concept");
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
	
	
	public static void writeConceptToGamaWSDB(){
		deleteAllConcept();
		List<String> listConcept = readConceptsFromFile();
		writeConceptToDB(listConcept);
	}
	
	private static List<String> readConceptsFromFile(){
		List<String> listConcept = new ArrayList<String>();
		try{
			FileInputStream fis = new FileInputStream(CheckURL.pathToContent + File.separator + CONCEPTS_FILE);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));
	
			String line = null;
			while ((line = br.readLine()) != null) {
				listConcept.add(line);
			}
			br.close();
		}
		catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return listConcept;
	}
	
	public static void main(String[] args){
		deleteAllConcept();
		writeConceptToGamaWSDB();
	}
}
