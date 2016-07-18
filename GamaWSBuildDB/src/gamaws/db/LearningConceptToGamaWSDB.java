package gamaws.db;

import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.DocumentBuilder;
import org.w3c.dom.Document;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;
import gamaws.utils.Keyword;
import gamaws.utils.LearningConcept;
import gamaws.utils.Topic;

import org.w3c.dom.Node;
import org.w3c.dom.Element;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class LearningConceptToGamaWSDB {
	
	static List<LearningConcept> learningConceptList = new ArrayList<LearningConcept>();
	
	private static final String LEARING_CONCEPTS_FILE = "learningGraph.xml";
	
	static {
		readLearningConceptsFromPreFile();
	}
	
	public static void deleteAllLearningConcept() {
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
	
	public static void deleteAllAssociatedLearningConcept() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_association_learning_concepts;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all gm_association_learning_concepts");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_association_learning_concepts", 1);
		}
	}
	
	
	public static void writeAssociatedLearningConceptToDB(){
		writeAssociatedLearningConceptToDB(learningConceptList);
	}
	
	private static void writeAssociatedLearningConceptToDB(List<LearningConcept> listLearningConcept){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertLearningConcept = "INSERT INTO gm_association_learning_concepts"
					+ "(idConcept, idPrerequisites) VALUES"
					+ "(?,?)";
			
			if(dbc.prepareStatement(insertLearningConcept)){
				int count = 0;
			    for (int i=0; i<listLearningConcept.size(); i++) {
			    	count++;
			    	for (int j=0; j<listLearningConcept.get(i).m_prerequisitesList.size(); j++) {
			    		
		    			dbc.getPreparedStatement().setInt(1, findLearningConcept(listLearningConcept.get(i).m_id));
						dbc.getPreparedStatement().setInt(2, findLearningConcept(listLearningConcept.get(i).m_prerequisitesList.get(j)));
						dbc.getPreparedStatement().addBatch();
						//if (count % 1000 == 0 || count == listKeyword.size()) {
						//	int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						//	System.out.println("inserted " + updateCounts.length + " AssociatedKeyword");
			            //}
		    		}
			    }
			    int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
				System.out.println("inserted " + updateCounts.length + " AssociatedKeyword");
				dbc.getConnect().commit();
				dbc.getConnect().setAutoCommit(true);
			}
			
		} catch (SQLException e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
	}
	
	public static int findLearningConcept(String idConcept) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		String query = "SELECT gm_learning_concept.id FROM gm_learning_concept" 
					+ " WHERE gm_learning_concept.idConcept like '" + idConcept + "';";
		try {
			if(dbc.prepareStatement(query)){
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
				while (dbc.getResultSet().next()) {
		            int id = dbc.getResultSet().getInt("id");
		            return id;
		        }
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
		return -1;
	}
	
	public static void writeLearningConceptsToDB(){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertConcept = "INSERT INTO gm_learning_concept"
					+ "(name, description, idConcept) VALUES"
					+ "(?,?,?)";
			
			if(dbc.prepareStatement(insertConcept)){
				int i = 0;
				for(LearningConcept concept : learningConceptList){
					i++;
					System.out.println(concept.m_id);
					dbc.getPreparedStatement().setString(1, concept.m_name);
					dbc.getPreparedStatement().setString(2, concept.m_description);
					dbc.getPreparedStatement().setString(3, concept.m_id);
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == learningConceptList.size()) {
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
	
	
	public static void writeLearningConceptToGamaWSDB(){
		System.out.println("begin write LearningConcepts to DB");
		writeLearningConceptsToDB();
		System.out.println("end write LearningConcepts to DB");
	}

	
	private static void readLearningConceptsFromPreFile(){
///////// read the xml ///////////
		float coeff = 700;
		
	    try {
	    	DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
	    	DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
	    	Document doc = dBuilder.parse(CheckURL.pathToContent + File.separator + LEARING_CONCEPTS_FILE);
	    			
	    	doc.getDocumentElement().normalize();
	    			
	    	NodeList nList = doc.getElementsByTagName("learningConcept");

	    	for (int temp = 0; temp < nList.getLength(); temp++) {

	    		Node nNode = nList.item(temp);
	    				
	    		if (nNode.getNodeType() == Node.ELEMENT_NODE) {

	    			Element eElement = (Element) nNode;
	    			
	    			String id = eElement.getAttribute("id");
	    			float x = Float.valueOf(eElement.getAttribute("x"))*coeff;
	    			float y = Float.valueOf(eElement.getAttribute("y"))*coeff;
	    			String name = eElement.getElementsByTagName("name").item(0).getTextContent();
	    			String description = eElement.getElementsByTagName("description").item(0).getTextContent();
	    			List<String> listPrerequisite = new ArrayList<String>();
	    			for (int i=0; i < eElement.getElementsByTagName("prerequisite").getLength(); i++) {
		    			listPrerequisite.add(eElement.getElementsByTagName("prerequisite").item(i).getTextContent());
	    			}
	    			LearningConcept newLearningConcept = new LearningConcept(id,name,description,x,y,listPrerequisite);
	    			learningConceptList.add(newLearningConcept);
	    		}
	    	}
	    
    	} catch (Exception e) {
    		e.printStackTrace();
        }
	    
	    ///////// check the values ///////////
	    
	    List<String> listConceptNames = new ArrayList<String>();
	    for (int i=0; i<learningConceptList.size(); i++) {
	    	listConceptNames.add(learningConceptList.get(i).m_id);
	    	System.out.println("reading " + learningConceptList.get(i).m_id);
	    }
	    for (int i=0; i<learningConceptList.size(); i++) {
	    	// check if all the "prerequisite" are learningConceptID.
	    	for (int j=0; j<learningConceptList.get(i).m_prerequisitesList.size(); j++) {
	    		if (!listConceptNames.contains(learningConceptList.get(i).m_prerequisitesList.get(j))) {
	    			System.out.println("ERROR !!!! The name "
	    		+learningConceptList.get(i).m_prerequisitesList.get(j)+" is not a learning concept id");
	    		}
	    	}
	    }
	}
	
	
	public static void checkLearningConceptFromMDFile() {
		System.out.println("readLearningConceptFromMDFile " + CheckURL.mdFiles.size());
    	for (int i = 0; i < CheckURL.mdFiles.size(); i++) {
			try {
				FileInputStream fis = new FileInputStream(CheckURL.mdFiles.get(i));
				BufferedReader br = new BufferedReader(new InputStreamReader(fis));

				String line = null;
				while ((line = br.readLine()) != null) {
					LearningConcept newLearningConcept = checkExistConcepts(line, learningConceptList);
					if(newLearningConcept != null){
						System.out.println("where is this ? " + newLearningConcept.m_id);
						//learningConceptList.add(newLearningConcept);
					}
				}
				br.close();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end readLearningConceptFromMDFile");
	}
	
	private static LearningConcept checkExistConcepts(String line, List<LearningConcept> listLearningConceptExists){
		Pattern pattern = Pattern.compile("(\\[\\/\\/\\]\\:( *)\\#( *)\\((startConcept( *)\\|).*?\\))");
		Matcher matcher = pattern.matcher(line);
		String stringMatched = "";
		if(matcher.find()) {
			stringMatched = matcher.group(0);
			System.out.println("found : " + stringMatched);
			stringMatched = stringMatched.split("\\|")[1];
			stringMatched = stringMatched.split("\\)")[0];
			
			String id = stringMatched;
			List<String> listPrerequisite = new ArrayList<String>();
			
			LearningConcept newLearningConcept = new LearningConcept(id,"","",0,0,listPrerequisite);
			
			if(!listLearningConceptExists.contains(newLearningConcept)){
				return newLearningConcept;
			}else{
				System.out.println("yeah, it's here");
			}
		}
		return null;
	}

	public static void main(String[] args) throws FileNotFoundException {
		if(CheckURL.buildFileMap()){
			WebpageLearningConceptToGamaWSDB2.deleteAllWebpageLearningConcept();
			LearningConceptToGamaWSDB.deleteAllAssociatedLearningConcept();
			LearningConceptToGamaWSDB.deleteAllLearningConcept();
			LearningConceptToGamaWSDB.writeLearningConceptsToDB();
			LearningConceptToGamaWSDB.writeAssociatedLearningConceptToDB();
			
			//LearningConceptToGamaWSDB.checkLearningConceptFromMDFile();
			//LearningConceptToGamaWSDB.writeLearningConceptToGamaWSDB();
			//LearningConceptToGamaWSDB.writeAssociatedLearningConceptToDB();
			
			//WebpageLearningConceptToGamaWSDB2.writeAnchorOfLearningConceptToMDFileAndBD();
		}
	}

}
