package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.apache.commons.lang3.StringEscapeUtils;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;
import gamaws.utils.Keyword;

public class KeywordToGamaWSDB {
	
	private static final String KEYWORD_FILE_ORIGINAL = "keywords.xml";
	private static final String KEYWORD_FILE_VALIDATED = "keywords_validated.xml";
	
	public static void deleteAllKeyword() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_keyword;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all Keyword");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_keyword", 1);
		}
	}
	
	public static void deleteAllAssociatedKeyword() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_association_keywork_category;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all association_keywork_category");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_association_keywork_category", 1);
		}
	}
	
	public static int findCategory(String name) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		int id = -1;
		String query = "select * from gm_category where name like '%" + name + "%';";
		try {
			if(dbc.prepareStatement(query)){
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
				while (dbc.getResultSet().next()) {
					id = dbc.getResultSet().getInt("id");
		        }
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
		return id;
	}
	
	public static int findKeyword(String name, String category) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		String query = "SELECT gm_keyword.id FROM gm_keyword INNER JOIN gm_category ON gm_keyword.idCategory = gm_category.id" 
					+ " WHERE gm_keyword.name like '%" + name + "%' and gm_category.name like '%" + category + "%';";
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
	
	public static void writeAssociatedKeywordToDB(){
		//deleteAllAssociatedKeyword();
		List<Keyword> listKeyword = readKeywordFromFile();
		writeAssociatedKeywordToDB(listKeyword);
	}
	
	private static void writeAssociatedKeywordToDB(List<Keyword> listKeyword){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertKeyword = "INSERT INTO gm_association_keywork_category"
					+ "(idKeyword, idAssociatedKeyword) VALUES"
					+ "(?,?)";
			
			if(dbc.prepareStatement(insertKeyword)){
				int count = 0;
			    for (int i=0; i<listKeyword.size(); i++) {
			    	count++;
			    	for (int j=0; j<listKeyword.get(i).getAssociatedKeywordList().size(); j++) {
			    		for (int k=0; k<listKeyword.size(); k++) {
				    		if (listKeyword.get(i).getAssociatedKeywordList().get(j).equalsIgnoreCase(listKeyword.get(k).getId())) {
				    			//System.out.println("ouiiiiiiiiiiiiiiiii");
				    			//System.out.println("i found you !!!");
				    			if(listKeyword.get(k).getId().equalsIgnoreCase("skill_advanced_driving")){
				    				System.out.println(listKeyword.get(i).getAssociatedKeywordList().get(j));
				    			}
				    			
				    			//System.out.println("inserted1 " + listKeyword.get(i).getName() + findKeyword(listKeyword.get(i).getName(), listKeyword.get(i).getCategory()));
				    			//System.out.println("inserted2 " + listKeyword.get(k).getName() + findKeyword(listKeyword.get(k).getName(), listKeyword.get(k).getCategory()));

				    			dbc.getPreparedStatement().setInt(1, findKeyword(listKeyword.get(i).getName(), listKeyword.get(i).getCategory()));
								dbc.getPreparedStatement().setInt(2, findKeyword(listKeyword.get(k).getName(), listKeyword.get(k).getCategory()));
								dbc.getPreparedStatement().addBatch();
								
								//if (count % 1000 == 0 || count == listKeyword.size()) {
								//	int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
								//	System.out.println("inserted " + updateCounts.length + " AssociatedKeyword");
					            //}
				    		}
			    		}
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
	
	private static void writeKeywordToDB(List<Keyword> listKeyword){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String insertKeyword = "INSERT INTO gm_keyword"
					+ "(name, idCategory, idKeywordMD) VALUES"
					+ "(?,?,?)";
			
			if(dbc.prepareStatement(insertKeyword)){
				int i = 0;
				for(Keyword keyword : listKeyword){
					i++;
					
					if(findCategory(keyword.getCategory()) != -1){
						
						dbc.getPreparedStatement().setString(1, keyword.getName());
						dbc.getPreparedStatement().setInt(2, findCategory(keyword.getCategory()));
						dbc.getPreparedStatement().setString(3, keyword.getId());
						dbc.getPreparedStatement().addBatch();
					}
					else{
						System.out.println(keyword.getCategory());
					}
					
					if (i % 1000 == 0 || i == listKeyword.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " Keyword");
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
	
	
	public static void writeKeywordToGamaWSDB(){
		//deleteAllAssociatedKeyword();
		//deleteAllKeyword();
		
		List<Keyword> listKeyword = readKeywordFromFile();
		System.out.println("begin write keyword to DB");
		writeKeywordToDB(listKeyword);
		System.out.println("end write keyword to DB");
	}
	
	private static List<Keyword> readKeywordFromFile(){
		List<Keyword> listKeyword = readKeywordFromPreFile();
		List<Keyword> listAdditionalKeyword = readKeywordFromMDFile(listKeyword);
		listKeyword.addAll(listAdditionalKeyword);
		return listKeyword;
	}
	
	private static List<Keyword> readKeywordFromPreFile(){
		List<Keyword> listKeyword = new ArrayList<Keyword>();
		try{
			File file = new File(CheckURL.pathToContent + File.separator + KEYWORD_FILE_VALIDATED);
		    InputStream inputStream= new FileInputStream(file);
		    Reader reader = new InputStreamReader(inputStream,"UTF-8");
		    InputSource is = new InputSource(reader);
		    is.setEncoding("UTF-8");
		   
			DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
			DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
			Document doc = dBuilder.parse(is);
					
			doc.getDocumentElement().normalize();
					
			NodeList nList = doc.getElementsByTagName(Keyword.KEYWORD_TAG);

			for (int temp = 0; temp < nList.getLength(); temp++) {

				Node nNode = nList.item(temp);
						
				if (nNode.getNodeType() == Node.ELEMENT_NODE) {

					Element eElement = (Element) nNode;
					
					String id = eElement.getAttribute(Keyword.ID_TAG);
					String name = eElement.getElementsByTagName(Keyword.NAME_TAG).item(0).getTextContent();
					String category = eElement.getElementsByTagName(Keyword.CATEGORY_TAG).item(0).getTextContent();
					List<String> listAssociatedKeyword = new ArrayList<String>();
					for (int i=0; i < eElement.getElementsByTagName(Keyword.ASSOCICATED_KEYWORD_TAG).getLength(); i++) {
						listAssociatedKeyword.add(eElement.getElementsByTagName(Keyword.ASSOCICATED_KEYWORD_TAG).item(i).getTextContent());
					}
					Keyword newKeyword = new Keyword(id,name,category,listAssociatedKeyword);
					listKeyword.add(newKeyword);
					//findCategory(newKeyword.getCategory());
				}
			}
		}
		catch (IOException | SAXException | ParserConfigurationException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		System.out.println("read " + listKeyword.size() + " keywords");
		return listKeyword;
	}
	
	private static List<Keyword> readKeywordFromMDFile(List<Keyword> listKeywordExists) {
		List<Keyword> listKeyword = new ArrayList<Keyword>();
		System.out.println("readKeywordFromMDFile");
    	for (int i = 0; i < CheckURL.mdFiles.size(); i++) {
			try {
				FileInputStream fis = new FileInputStream(CheckURL.mdFiles.get(i));
				BufferedReader br = new BufferedReader(new InputStreamReader(fis));

				String line = null;
				while ((line = br.readLine()) != null) {
					Keyword newKeyword = parseNewKeywordCategory(line, listKeywordExists);
					if(newKeyword != null && !listKeyword.contains(newKeyword)){
						listKeyword.add(newKeyword);
					}
				}
				br.close();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end readKeywordFromMDFile");
		return listKeyword;
	}
	
	private static Keyword parseNewKeywordCategory(String line, List<Keyword> listKeywordExists){
		Pattern pattern = Pattern.compile("(\\[\\/\\/\\]\\:( *)\\#( *)\\((keyword( *)\\|).*?\\))");
		Matcher matcher = pattern.matcher(line);
		String stringMatched = "";
		if(matcher.find()) {
			stringMatched = matcher.group(0);
			System.out.println("found : " + stringMatched);
			stringMatched = stringMatched.split("\\|")[1];
			stringMatched = stringMatched.split("\\)")[0];
			
			String id = stringMatched;
			String name = stringMatched.split("\\_", 2)[1];
			String category = stringMatched.split("\\_", 2)[0];
			List<String> listAssociatedKeyword = new ArrayList<String>();
			Keyword newKeyword = new Keyword(id,name,category,listAssociatedKeyword);
			
			if(!listKeywordExists.contains(newKeyword)){
				return newKeyword;
			}
		}
		return null;
	}
	
	public static void verifyKeywordList(List<Keyword> keywordList){
		List<String> listKeywordNames = new ArrayList<String>();
	    for (int i=0; i<keywordList.size(); i++) {
	    	listKeywordNames.add(keywordList.get(i).getId());
	    }
	    for (int i=0; i<keywordList.size(); i++) {
	    	for (int j=0; j<keywordList.get(i).getAssociatedKeywordList().size(); j++) {
	    		if (!listKeywordNames.contains(keywordList.get(i).getAssociatedKeywordList().get(j))) {
	    			System.out.println("ERROR !!!! The name "
	    					+ keywordList.get(i).getAssociatedKeywordList().get(j)+" is not a legit name");
	    		}
	    	}
	    }
	}
	
	public static void escapeSpecialCharacters(){
		String str;
		try {
			String optLess = "operator_<"; 
			String optLessReplaced = "operator_&lt;"; 
			String optNotGreater = "operator_<=";
			String optNotGreaterReplaced = "operator_&lt;=";
			String keyLess = "<name><</name>";
			String keyLessReplaced = "<name>&lt;</name>";
			String keyNotLess = "<name><=</name>";
			String keyNotLessReplaced = "<name>&lt;=</name>";
			String keyDiff = "<name><></name>";
			String keyDiffReplaced = "<name>&lt;></name>";
			str = new String(Files.readAllBytes(Paths.get(CheckURL.pathToContent + File.separator + KEYWORD_FILE_ORIGINAL)));
			//String results = StringEscapeUtils.escapeXml11(str);
			
			//results = StringEscapeUtils.unescapeXml(results);
			str = str.replaceAll(optLess, optLessReplaced);
			str = str.replaceAll(optNotGreater, optNotGreaterReplaced);
			str = str.replaceAll(keyLess, keyLessReplaced);
			str = str.replaceAll(keyNotLess, keyNotLessReplaced);
			str = str.replaceAll(keyDiff, keyDiffReplaced);
			System.out.println(str);
			Files.write(Paths.get(CheckURL.pathToContent + File.separator + KEYWORD_FILE_VALIDATED), str.getBytes());
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public static void main(String[] args){
		//deleteAllKeyword();
		//writeKeywordToGamaWSDB();
		//writeAssociatedKeywordToDB();
		verifyKeywordList(readKeywordFromFile());
		//escapeSpecialCharacters();
	}
}
