package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.sql.SQLException;
import java.util.List;
import java.util.Map;

import gamaws.utils.CheckURL;
import gamaws.utils.DBConnection;
import gamaws.utils.MenuContent;
import gamaws.utils.Section;

public class TreeMenuToGamaWSDB {
	
	private static final String FILE_TREE_MENU_ORIGINAL = "WebsiteTreeStructure.txt";
	private static final String FILE_TREE_MENU_CORRECT = "WebsiteTreeStructureModified.txt";
	private static final String MODEL_LIBRARY_DIRECTORY = "References/ModelLibrary";
	private static final String PLUGIN_DOC_DIRECTORY = "References/PluginDocumentation";
	private static final String COMMUNITY_DIRECTORY = "Community";
	
	public static void main(String[] args) {
		try {
			int code = System.in.read();
			switch (code) {
	            case 49:  
            		//refreshDB();
            		//System.out.println("cleared");
	            	CheckURL.buildFileMap();
	            	WebpageToGamaWSDB.deleteAllWebpage();
	            	deleteAllMenu(4);
	            	writeTreeMenuToDB();
					System.out.println("wrote");
                    break;
	            case 50:  
	            	WebpageToGamaWSDB.deleteAllWebpage();
	            	deleteAllMenu(4);
            		System.out.println("cleared");
                    break;
	            case 51: 
	            	CheckURL.buildFileMap();
	            	readAndRewriteImagesSourceInMDFile();
					System.out.println("wrote");
	                break;
	            default:
	            	break;
			}
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public static void writeTreeMenuToDB(){
		Section treeRoot = Section.parseTree(CheckURL.pathToContent + File.separator + FILE_TREE_MENU_CORRECT);
		System.out.println(CheckURL.fileMap.keySet());
		for (Section node : treeRoot) {
			if(node.getDepth() > 2){
				String filename = CheckURL.fileMap.get(node.getText() + ".md");
				System.out.println("filename: " + filename);
				System.out.println("title: " + node.getText());
				//System.out.println("PaTitle: " + node.getParent().getText());
				//System.out.println("PrTitle: " + node.getPrevious().getText());
				Integer parentId;
				if(getMenuByName(node.getParent().getText()) != null){
					parentId = getMenuByName(node.getParent().getText()).getId();
					System.out.println("parentId: " + parentId);
					if (parentId == 7) {
						int i = 0;
						i = 5;
					}
				}
				else{
					continue;
				}
				String title;
				if(filename == null){
					title = node.getText();
				}else{
					try {
						System.out.println(CheckURL.pathToContent + File.separator + filename);
						title = CheckURL.getTitle(new File(CheckURL.pathToContent + File.separator + filename));
					} catch (IOException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
						continue;
					}
				}
				
				String sTitle = node.getText();
				String description = title;
				//String alias = sTitle.replaceAll("\\s+", "");
				String alias = sTitle.replaceAll("[^a-zA-Z0-9_-]", "");
				Integer previousId = parentId;
				if(node.getPrevious() != null)
					previousId = getMenuByName(node.getPrevious().getText()).getId();
				Integer type = 4;
				String filenameGh = filename;
				MenuContent mc = new MenuContent(
						-1, parentId, title, sTitle, description, alias, previousId, type, filenameGh);
				writeMenuToDB(mc);
			}
		}
	}
	
	public static void readAndRewriteImagesSourceInMDFile() {
		for (Map.Entry<String, String> entry : CheckURL.fileMap.entrySet()){
			try {
				CheckURL.readAndRewriteImagesSourceInMDFile(new File(CheckURL.pathToContent + File.separator + entry.getValue()));
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
	
	
	public static void deleteAllMenu(int level) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		if(dbc.prepareStatement("delete from gm_menu where type= "+level)){
			try {
				dbc.getPreparedStatement().setInt(1, level);
				dbc.getPreparedStatement().executeUpdate();
            	System.out.println("deleted all menu level "+level);
			} catch (Exception e) {
				e.printStackTrace();
			} finally {
				dbc.close();
				DBConnection.resetAutoIncrement("gm_menu", 26);
				System.out.println("reset auto inscrease");
			}
		}
	}

	public List<MenuContent> readMenu() {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		if(dbc.prepareStatement("select * from gm_menu where type= ? ; ")){
			try {
				dbc.getPreparedStatement().setInt(1, 4);
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
			} catch (Exception e) {
				e.printStackTrace();
			} finally {
				dbc.close();
			}
		}
		return MenuContent.writeResultSet(dbc.getResultSet());
	}
	
	public static MenuContent getMenuByName(String shortname) {
		MenuContent mc = null;
		DBConnection dbc = new DBConnection();
		dbc.connect();
		if(dbc.prepareStatement("select * from gm_menu where short_title= ? ; ")){
			try {
				dbc.getPreparedStatement().setString(1, shortname);
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
				List<MenuContent> lmc = MenuContent.writeResultSet(dbc.getResultSet());
				if(!lmc.isEmpty())
					mc = lmc.get(0);
			} catch (Exception e) {
				e.printStackTrace();
			} finally {
				dbc.close();
			}
		}
		return mc;
	}
	
	public List<MenuContent> readFixedMenu() {
		List<MenuContent> lmc = null;
		DBConnection dbc = new DBConnection();
		dbc.connect();
		if(dbc.prepareStatement("select * from gm_menu where not type= ? ; ")){
			try {
				dbc.getPreparedStatement().setInt(1, 4);
				dbc.getPreparedStatement().executeUpdate();
				dbc.setResultSet(dbc.getPreparedStatement().executeQuery());
				lmc = MenuContent.writeResultSet(dbc.getResultSet());
			} catch (Exception e) {
				e.printStackTrace();
			} finally {
				dbc.close();
			}
		}
		return lmc;
		
	}
	
	public static void writeMenuToDB(MenuContent mc){
		DBConnection dbc = new DBConnection();
		dbc.connect();
		String insertMenuContent = "INSERT INTO gm_menu"
				+ "(parent_id, title, short_title, description, alias, previous, type, filename_gh) VALUES"
				+ "(?,?,?,?,?,?,?,?)";
		if(dbc.prepareStatement(insertMenuContent)){
			try {
				dbc.getPreparedStatement().setInt(1, mc.getParentId());
				dbc.getPreparedStatement().setString(2, mc.getTitle());
				dbc.getPreparedStatement().setString(3, mc.getShortTitle());
				dbc.getPreparedStatement().setString(4, mc.getDescription());
				dbc.getPreparedStatement().setString(5, mc.getAlias());
				dbc.getPreparedStatement().setInt(6, mc.getPrevious());
				dbc.getPreparedStatement().setInt(7, mc.getType());
				dbc.getPreparedStatement().setString(8, mc.getFilenameGh());
				dbc.getPreparedStatement().executeUpdate();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} finally {
				dbc.close();
			}
		}
	}
	
	public void writeMenuToDB(List<MenuContent> content){
		
		DBConnection dbc = new DBConnection();
		dbc.connect();
		String insertMenuContent = "INSERT INTO gm_menu"
				+ "(parent_id, title, short_title, description, alias, previous, type, filename_gh) VALUES"
				+ "(?,?,?,?,?,?,?,?)";
		try {
			dbc.getConnect().setAutoCommit(false);
			if(dbc.prepareStatement(insertMenuContent)){
				int i = 0;
				for(MenuContent mc : content){
					i++;
					
					dbc.getPreparedStatement().setInt(1, mc.getParentId());
					dbc.getPreparedStatement().setString(2, mc.getTitle());
					dbc.getPreparedStatement().setString(3, mc.getShortTitle());
					dbc.getPreparedStatement().setString(4, mc.getDescription());
					dbc.getPreparedStatement().setString(5, mc.getAlias());
					dbc.getPreparedStatement().setInt(6, mc.getPrevious());
					dbc.getPreparedStatement().setInt(7, mc.getType());
					dbc.getPreparedStatement().setString(8, mc.getFilenameGh());
					dbc.getPreparedStatement().addBatch();
					
					if (i % 1000 == 0 || i == content.size()) {
						int [] updateCounts = dbc.getPreparedStatement().executeBatch(); 
						System.out.println("inserted " + updateCounts.length + " menu content webpage");
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
	
	public static void readModelLibraryAndPluginDocumentationToTreeStructureFile() throws IOException{
		String originalFile = CheckURL.pathToContent + File.separator + FILE_TREE_MENU_ORIGINAL;
		String modifiedFile = CheckURL.pathToContent + File.separator + FILE_TREE_MENU_CORRECT;
		
		FileInputStream fis = new FileInputStream(originalFile);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";
		while ((line = br.readLine()) != null) {
			if (input == "")
				input = changeLine(line);
			else
				input = input + '\n' + changeLine(line);
		}
		br.close();

		FileOutputStream fileOut = new FileOutputStream(modifiedFile);
		fileOut.write(input.getBytes());
		fileOut.close();
	}

	private static String changeLine(String line) throws IOException {
		if(line.trim().equals("-Tutorials")){
			line = "-ThematicTutorials";
		}
		if(line.trim().equals("References")){
			line = line + "\n" + addModelLibrary();
		}
		if(line.trim().equals("Community")){
			line = addPluginDocumentation() + "\n" + line;
			line = line + "\n" + addCommunity();
		}
		System.out.println(line);
		return line;
	}

	private static String addCommunity() throws IOException {
		String path = CheckURL.pathToContent + File.separator + COMMUNITY_DIRECTORY;
		return listDirectory(path, 0, 0);
	}

	private static String addPluginDocumentation() {
		String path = CheckURL.pathToContent + File.separator + PLUGIN_DOC_DIRECTORY;
		return "-PluginDocumentation" + "\n" + listDirectory(path, 0, 1);
	}

	private static String addModelLibrary() {
		String path = CheckURL.pathToContent + File.separator + MODEL_LIBRARY_DIRECTORY;
		return "-ModelLibrary" + "\n" + listDirectory(path, 0, 1);
	}
	
	public static String listDirectory(String dirPath, int level, int levelPrefix) {
		String line = "";
	    File dir = new File(dirPath);
	    File[] firstLevelFiles = dir.listFiles();
	    if (firstLevelFiles != null && firstLevelFiles.length > 0) {
	        for (File aFile : firstLevelFiles) {
	        	if(!checkDoubleNameFileDir(aFile, firstLevelFiles)){
	        		line = line + addPrefixToFileName(aFile.getName(), level, levelPrefix) + "\n";
	        	}
	            if (aFile.isDirectory()) {
	            	line = line + listDirectory(aFile.getAbsolutePath(), level + 1, levelPrefix);
	            }
	        }
	    }
	    return line;
	}
	
	private static boolean checkDoubleNameFileDir(File file, File[] files){
		
		for(File f : files){
			if(file.isFile() && f.isDirectory()){
				if(CheckURL.removeExtension(file.toString()).equals(f.toString())){
					return true;
				}
			}
		}
		return false;
	}
	
	private static String addPrefixToFileName(String filename, int level, int levelPrefix){
		String prefix = "";
		int i = 0;
		while(i <= level + levelPrefix){
			prefix = prefix + "-";
			i++;
		}
		return prefix + CheckURL.removeExtension(filename);
	}
}
