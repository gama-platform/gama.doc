package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.apache.commons.lang3.StringEscapeUtils;
import org.apache.commons.lang3.StringUtils;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;
import gamaws.utils.LearningConcept;
import gamaws.utils.Webpage;
import gamaws.utils.WebpageLearningConcept;
public class WebpageLearningConceptToGamaWSDB2 {
	
	public static void deleteAllWebpageLearningConcept() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_association_webpage_learning_concept;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all gm_association_webpage_learning_concept");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_association_webpage_learning_concept", 1);
		}
	}
	
	public static int findLearningConceptByIdLearningConceptMD(String idConcept) {
		System.out.println("idConcept : " + idConcept);
		DBConnection dbc = new DBConnection();
		dbc.connect();
		int id = -1;
		String query = "select * from gm_learning_concept where idConcept like '" + idConcept + "';";
		try {
			if(dbc.prepareStatement(query)){
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
				while (dbc.getResultSet().next()) {
		            id = dbc.getResultSet().getInt("id");
		            System.out.println("id : " + id);
		        }
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
		return id;
	}
	
	public static int findWebpageByName(String webpageName) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		int id = -1;
		String query = "select * from gm_webpage where name like '" + webpageName + "';";
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
	
	private static void writeAnchorOfLearningConceptToDB(List<WebpageLearningConcept> listWK){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String query = "INSERT INTO gm_association_webpage_learning_concept"
					+ "(idWebpage, idConcept, beginAnchor, endAnchor) VALUES"
					+ "(?,?,?,?)";
			
			if(dbc.prepareStatement(query)){
				int i = 0;
				for(WebpageLearningConcept wk : listWK){
					i++;
				
					dbc.getPreparedStatement().setInt(1, wk.getIdWebpage());
					dbc.getPreparedStatement().setInt(2, wk.getIdLearningConcept());
					dbc.getPreparedStatement().setString(3, wk.getBeginAnchor());
					dbc.getPreparedStatement().setString(4, "");
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == listWK.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " webpage_LearningConcept");
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
	
	public static void writeAnchorOfLearningConceptToMDFileAndBD() {
		List<WebpageLearningConcept> listWK = new ArrayList<WebpageLearningConcept>();
		
		System.out.println("addAnchorOfLearningConceptToMDFile");
    	for (int i = 0; i < CheckURL.mdFiles.size(); i++) {
    		listWK.addAll(addAnchorOfLearningConceptToMDFile(CheckURL.mdFiles.get(i)));
		}
		System.out.println("end addAnchorOfLearningConceptToMDFile");
		
		if(!listWK.isEmpty()){
			deleteAllWebpageLearningConcept();
			writeAnchorOfLearningConceptToDB(listWK);
		}
	}
	
	public static List<WebpageLearningConcept> addAnchorOfLearningConceptToMDFile(File file){
		List<WebpageLearningConcept> listWK = new ArrayList<WebpageLearningConcept>();
		try {
			FileInputStream fis = new FileInputStream(file);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));

			String line = null;
			String input = "";
			int anchorNo = 0;
			while ((line = br.readLine()) != null) {
				if (input == ""){
					input = input + line;
					
				} else{
					input = input + '\n' + line;
				}
				WebpageLearningConcept wk = addBeginAnchorOfLearningConceptToMDFile(line, anchorNo, CheckURL.removeExtension(file.getName()));
				if(wk != null){
					listWK.add(wk);
					String strKey = "<section class='concept-graph' markdown='1'"
									+ " id ='" + wk.getBeginAnchor() + "'>";
					input = input + '\n' + strKey;
					anchorNo++;
				}else {
					if(addEndAnchorOfLearningConceptToMDFile(line)){
						input = input + '\n' + "</section>";
					}
				}
			}
			br.close();

			// write the new String with the replaced line OVER the same file
			FileOutputStream fileOut = new FileOutputStream(file);
			fileOut.write(input.getBytes());
			fileOut.close();
		} catch (Exception e){
			e.printStackTrace();
		}
		return listWK;
	}
	
	private static WebpageLearningConcept addBeginAnchorOfLearningConceptToMDFile(String line, int anchorNo, String webpageName){
		Pattern pattern = Pattern.compile("(\\[\\/\\/\\]\\:( *)\\#( *)\\((startConcept( *)\\|).*?\\))");
		Matcher matcher = pattern.matcher(line);
		String stringMatched = "";
		if(matcher.find()) {
			stringMatched = matcher.group(0);
			System.out.println("found : " + stringMatched);
			stringMatched = stringMatched.split("\\|")[1];
			stringMatched = stringMatched.split("\\)")[0];
			
			String idLearningConceptMD = stringMatched;
			int idLearningConcept = findLearningConceptByIdLearningConceptMD(idLearningConceptMD);
			int idWebpage = findWebpageByName(webpageName);
			if(idLearningConcept != -1 && idWebpage != -1){
				String anchor = "concept_" + idWebpage + "_" + anchorNo + "_" + idLearningConcept + "_" + CheckURL.correctAnchorFormat(idLearningConceptMD);
				WebpageLearningConcept wk = new WebpageLearningConcept(idWebpage, idLearningConcept, anchor);
				return wk;
			}
		}
		return null;
	}
	
	private static boolean addEndAnchorOfLearningConceptToMDFile(String line){
		Pattern pattern = Pattern.compile("(\\[\\/\\/\\]\\:( *)\\#( *)\\((endConcept( *)\\|).*?\\))");
		Matcher matcher = pattern.matcher(line);
		String stringMatched = "";
		if(matcher.find()) {
			return true;
		}
		return false;
	}

	
	public static void main(String[] args){
		//writeAnchorOfLearningConceptToMDFileAndBD();
		String filename = "/mnt/DA96A5EB96A5C879/Copy/project/gamaws/gm_wiki/Tutorials/LearnGAMLStepByStep/DefiningAdvancedSpecies/GridSpecies.md";
		//addAnchorOfLearningConceptToMDFile(new File(filename));
		if(CheckURL.buildFileMap()){
			WebpageLearningConceptToGamaWSDB2.writeAnchorOfLearningConceptToMDFileAndBD();
		}
	}
}
