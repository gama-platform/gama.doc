package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStreamReader;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;
import gamaws.utils.WebpageKeyword;
public class WebpageKeywordToGamaWSDB {
	
	public static void deleteAllWebpageKeyword() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("delete from gm_association_webpage_keywork;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("deleted all association_webpage_keywork");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
			DBConnection.resetAutoIncrement("gm_association_webpage_keywork", 1);
		}
	}
	
	public static int findKeywordByIdKeywordMD(String idKeywordMD) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		int id = -1;
		String query = "select * from gm_keyword where idKeywordMD like '" + idKeywordMD + "';";
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
	
	private static void writeAnchorOfKeywordToDB(List<WebpageKeyword> listWK){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			dbc.getConnect().setAutoCommit(false);
			
			String query = "INSERT INTO gm_association_webpage_keywork"
					+ "(idWebpage, idKeyword, anchor, isInHeader) VALUES"
					+ "(?,?,?,?)";
			
			if(dbc.prepareStatement(query)){
				int i = 0;
				for(WebpageKeyword wk : listWK){
					i++;
				
					dbc.getPreparedStatement().setInt(1, wk.getIdWebpage());
					dbc.getPreparedStatement().setInt(2, wk.getIdKeyword());
					dbc.getPreparedStatement().setString(3, wk.getAnchor());
					dbc.getPreparedStatement().setBoolean(4, wk.isInHeader());
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == listWK.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " webpage_keyword");
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
	
	public static void writeAnchorOfKeywordToMDFileAndBD() {
		List<WebpageKeyword> listWK = new ArrayList<WebpageKeyword>();
		
		System.out.println("addAnchorOfKeywordToMDFile");
    	for (int i = 0; i < CheckURL.mdFiles.size(); i++) {
    		listWK.addAll(addAnchorOfKeywordToMDFile(CheckURL.mdFiles.get(i)));
		}
		System.out.println("end addAnchorOfKeywordToMDFile");
		
		if(!listWK.isEmpty()){
			deleteAllWebpageKeyword();
			writeAnchorOfKeywordToDB(listWK);
		}
	}
	
	private static boolean isHeaderLine(String line){
		System.out.println(line);
		if(line.trim().startsWith("#") && line.endsWith("}")){
			return true;
		}
		return false;
	}
	
	private static int getPositionOfHeaderLine(File file){
		int pos = 0;
		try {
			FileInputStream fis = new FileInputStream(file);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));
			String line = null;
			while ((line = br.readLine()) != null) {
				pos ++;
				if(isHeaderLine(line)){
					break;
				}
			}
			br.close();
		} catch (Exception e){
			e.printStackTrace();
		}
		return pos;
	}
	
	public static List<WebpageKeyword> addAnchorOfKeywordToMDFile(File file){
		List<WebpageKeyword> listWK = new ArrayList<WebpageKeyword>();
		int posHeaderLine = getPositionOfHeaderLine(file);
		try {
			FileInputStream fis = new FileInputStream(file);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));

			String line = null;
			String input = "";
			int anchorNo = 0;
			int lineNumber = 0;
			boolean isHeader = false;
			while ((line = br.readLine()) != null) {
				lineNumber++;
				if(lineNumber < posHeaderLine){
					isHeader = true;
				}else{
					isHeader = false;
				}
				if (input == ""){
					input = input + line;
					
				} else{
					input = input + '\n' + line;
				}
				WebpageKeyword wk = addAnchorOfKeywordToMDFile(line, anchorNo, 
						CheckURL.removeExtension(file.getName()), isHeader);
				if(wk != null){
					listWK.add(wk);
					String strKey = "<div class='" + "gama-keyword-style" 
									+ "' id ='" + wk.getAnchor() + "'></div>";
					input = input + '\n' + strKey;
					//input = input + '\n' + "## {#" + wk.getAnchor() + "}";
					//input = input + '\n' + "##{.gama-keyword-style}";
					anchorNo++;
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
	
	private static WebpageKeyword addAnchorOfKeywordToMDFile(String line, int anchorNo, String webpageName, boolean isHeader){
		Pattern pattern = Pattern.compile("(\\[\\/\\/\\]\\:( *)\\#( *)\\((keyword( *)\\|).*?\\))");
		Matcher matcher = pattern.matcher(line);
		String stringMatched = "";
		if(matcher.find()) {
			stringMatched = matcher.group(0);
			System.out.println("found : " + stringMatched);
			stringMatched = stringMatched.split("\\|")[1];
			stringMatched = stringMatched.split("\\)")[0];
			
			String idKeywordMD = stringMatched;
			int idKeyword = findKeywordByIdKeywordMD(idKeywordMD);
			int idWebpage = findWebpageByName(webpageName);
			if(idKeyword != -1 && idWebpage != -1){
				String anchor = idWebpage + "_" + anchorNo + "_" + idKeyword + "_" + CheckURL.correctAnchorFormat(idKeywordMD);
				WebpageKeyword wk = new WebpageKeyword(idWebpage, idKeyword, anchor, isHeader);
				return wk;
			}
		}
		return null;
	}

	
	public static void main(String[] args){
		//writeAnchorOfKeywordToMDFileAndBD();
		String filename = "/mnt/DA96A5EB96A5C879/Copy/project/gamaws/gm_wiki/Tutorials/LearnGAMLStepByStep/DefiningAdvancedSpecies/GridSpecies.md";
		//addAnchorOfKeywordToMDFile(new File(filename));
		System.out.println(getPositionOfHeaderLine(new File(filename)));
	}
}
