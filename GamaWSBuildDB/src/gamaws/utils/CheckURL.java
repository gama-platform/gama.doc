package gamaws.utils;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class CheckURL {

	public static final String localPathFileName = "localPath.txt";
	public static final String githubContentUrl = "";
	public static String pathToContent;
	public static Map<String, String> fileMap = new HashMap<String, String>();
	public static ArrayList<File> mdFiles = new ArrayList<File>();
	
	static{
		// find the local path to the wiki content
		try {
			if (!loadPathToContent()){
				System.out.println("cannot read local path content or it does not exist");
				System.exit(1);
			}
		} catch (FileNotFoundException e) {
			e.printStackTrace();
			System.exit(1);
		}
		if (!checkIfFolderExists(pathToContent)){
			System.out.println("content folder does not exist");
			System.exit(1);
		}
    }
	
	public static void main(String[] args) {
		if(buildFileMap()){
			try {
				int code = System.in.read();
				switch (code) {
		            case 49:  
		            	readAndRewriteImagesSourceInMDFile();
	                    break;
		            case 50:  
		            	readAndRewriteInternalAnchorMDFile();
	                    break;
		            case 51:  
		            	breakTableofImagesSourceInMDFile();
	                    break;
		            case 52:  
		            	changeStyleImagesInMDFile();
	                    break;
		            case 53:  
		            	readAndRewriteInternalLinkMDFile();
	                    break;
		            case 54:  
		            	changeExternalLinkInMDFile();
	                    break;
		            default: 
		            	readAndRewriteImagesSourceInMDFile();
		            	readAndRewriteInternalLinkMDFile();
		            	readAndRewriteInternalAnchorMDFile();
		            	breakTableofImagesSourceInMDFile();
		            	changeStyleImagesInMDFile();
		            	changeExternalLinkInMDFile();
		            	break;
				}
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
	
	public static void readAndRewriteImagesSourceInMDFile(){
		System.out.println("readAndRewriteImagesSourceInMDFile");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				readAndRewriteImagesSourceInMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end readAndRewriteImagesSourceInMDFile");
	}

	public static void  readAndRewriteInternalAnchorMDFile(){
		System.out.println("readAndRewriteInternalAnchorMDFile");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				readAndRewriteInternalAnchorMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end readAndRewriteInternalAnchorMDFile");
	}
	
	public static void readAndRewriteMDFileForVariousChanges(){
		System.out.println("readAndRewriteMDFileForVariousChanges");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				readAndRewriteMDFileForVariousChanges(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end readAndRewriteMDFileForVariousChanges");
	}
	
	public static void  breakTableofImagesSourceInMDFile(){
		System.out.println("breakTableofImagesSourceInMDFile");
		for (int i = 0; i < mdFiles.size(); i++) {
			if ( (i % mdFiles.size()/100) == 0) {
				System.out.print(".");
			}
			if (i == (mdFiles.size()-1)) {
				System.out.println(".");
			}
			try {
				breakTableofImagesSourceInMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end breakTableofImagesSourceInMDFile");
	}

	public static void  changeStyleImagesInMDFile(){
		System.out.println("changeStyleImagesInMDFile");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				changeStyleImagesInMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end changeStyleImagesInMDFile");
	}
	
	public static void  readAndRewriteInternalLinkMDFile(){
		System.out.println("readAndRewriteInternalLinkMDFile");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				readAndRewriteInternalLinkMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end readAndRewriteInternalLinkMDFile");
	}
	
	public static void changeExternalLinkInMDFile(){
		System.out.println("changeExternalLinkInMDFile");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				changeExternalLinkInMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end changeExternalLinkInMDFile");
	}
	
	public static void changeInternalLinkWithAnchorInMDFile(){
		System.out.println("changeInternalLinkWithAnchorInMDFile");
    	for (int i = 0; i < mdFiles.size(); i++) {
			try {
				changeInternalLinkWithAnchorInMDFile(mdFiles.get(i));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("end changeInternalLinkWithAnchorInMDFile");
	}
	
	public static void removeConflitFolder(){

		// get all folders in the content folder
		ArrayList<File> listFiles = new ArrayList<File>();
		
		getAllFolders(CheckURL.pathToContent + File.separator + "Tutorials", listFiles);
		getAllFolders(CheckURL.pathToContent + File.separator + "References", listFiles);

		for (int i = 0; i < listFiles.size(); i++) {
			String filePathName = listFiles.get(i).getAbsolutePath();
			String fileName;
			filePathName = filePathName.replace(pathToContent, githubContentUrl);
			filePathName.replace("\\", "/");
			String[] filePathNameSplitted = filePathName.split("/");
			fileName = filePathNameSplitted[filePathNameSplitted.length - 1];
			for (int j = i+1; j < listFiles.size(); j++) {
				if (listFiles.get(j).getName().replace(" ", "").equalsIgnoreCase(fileName.replace(" ", ""))) {
					System.out.println("----> Changing : folder " + fileName + " conflit !");
					System.out.println("----> Changing : folder " + listFiles.get(j).getAbsolutePath() + " conflit !");
					Path newPathFile;
					try {
						changeConflitFileNameOfCorrespondFolder(listFiles.get(j).getAbsolutePath());
						newPathFile = changeConflitFileName(listFiles.get(j).getAbsolutePath());
						listFiles.remove(j);
						listFiles.add(j, newPathFile.toFile());
					} catch (IOException e) {
						e.printStackTrace();
					}
				}
			}
			
		}
	}
	
	private static void changeConflitFileNameOfCorrespondFolder(String folder) throws IOException{
		Path srcPath = FileSystems.getDefault().getPath(folder + ".md");
		Path file = srcPath.getName(srcPath.getNameCount()-1);
		Path parent = srcPath.getName(srcPath.getNameCount()-2);
		Path destPath = FileSystems.getDefault().getPath(srcPath.getParent() + File.separator + parent + file);
		Files.move(srcPath, destPath, StandardCopyOption.REPLACE_EXISTING);
	}
	
	public static boolean buildFileMap(){

		// get all the md files in the content folder
		ArrayList<File> listFiles = new ArrayList<File>();
		getFilesFromFolder(pathToContent, listFiles);
		mdFiles = filterFilesByExtension(listFiles, "md");
		for (int i=0; i < mdFiles.size() ; i++) {
			File f = mdFiles.get(i);
			if (f.getAbsolutePath().contains("WikiOnly")) {
				mdFiles.remove(f);
				i--;
			}
		}

		// init the map <fileName,relativePath>. If 2 fileNames are the same,
		// write error message
		if (!initMap(mdFiles))
			return false;
		
		return true;
	}

	private static boolean loadPathToContent() throws FileNotFoundException {
		boolean result = false;
		Path relativePath = Paths.get(localPathFileName);
		String relativePathString = relativePath.toAbsolutePath().toString();
		File f = new File(relativePathString);
		if (!f.exists()) {
			f.getParentFile().mkdirs();
			try {
				f.createNewFile();
			} catch (IOException e) {
				e.printStackTrace();
			}
			System.out.println("The file " + f.getAbsolutePath() + " has been created.");
		}

		Scanner scanner = new Scanner(f);
		String content = "";
		BufferedReader br = new BufferedReader(new FileReader(f.getAbsolutePath()));
		try {
			if (br.readLine() != null) {
				result = true;
				content = scanner.useDelimiter("\\Z").next();
			}
			br.close();
		} catch (IOException e) {
			e.printStackTrace();
		}

		String outputMsg = (result) ? "The path for your content directory is : " + content
				: "The file " + f.getAbsolutePath()
						+ " is empty.\nPlease set the path to the content and run again the application.";
		pathToContent = content;

		System.out.println(outputMsg);
		scanner.close();
		return result;
	}

	private static boolean checkIfFolderExists(String folderPath) {
		File f = new File(folderPath);
		if (f.exists() && f.isDirectory())
			return true;
		System.out.println("FATAL ERROR : Folder " + folderPath + " does not exist.");
		return false;
	}

	private static boolean checkIfFileExists(String filePath) {
		File f = new File(filePath);
		if (f.exists() && !f.isDirectory())
			return true;
		System.out.println("----> ERROR : File " + filePath + " does not exist.");
		return false;
	}

	private static void getFilesFromFolder(String folderPath, ArrayList<File> files) {
		File folder = new File(folderPath);
		File[] fList = folder.listFiles();
		for (File file : fList) {
			if (file.isFile()) {
				files.add(file);
			} else if (file.isDirectory()) {
				getFilesFromFolder(file.getAbsolutePath(), files);
			}
		}
	}
	
	private static void getAllFolders(String folderPath, ArrayList<File> folders) {
		File folder = new File(folderPath);
		File[] fList = folder.listFiles();
		for (File file : fList) {
			if (file.isDirectory()) {
				folders.add(file);
				getAllFolders(file.getAbsolutePath(), folders);
			}
		}
	}

	private static boolean initMap(ArrayList<File> fileList) {
		for (int i = 0; i < fileList.size(); i++) {
			String filePathName = fileList.get(i).getAbsolutePath();
			String fileName;
			filePathName = filePathName.replace(pathToContent, githubContentUrl);
			filePathName.replace("\\", "/");
			String[] filePathNameSplitted = filePathName.split("/");
			fileName = filePathNameSplitted[filePathNameSplitted.length - 1];
			// verify it the file does not exist yet in the map
			if (fileMap.containsKey(fileName)) {
				System.out.println("----> Changing : filename " + fileName + " conflit !");
				Path newPathFile;
				try {
					newPathFile = changeConflitFileName(fileList.get(i).getAbsolutePath());
					fileList.remove(i);
					fileList.add(i, newPathFile.toFile());
					fileMap.put(newPathFile.getName(newPathFile.getNameCount()-1).toString(), newPathFile.toString().replace(pathToContent, githubContentUrl));
				} catch (IOException e) {
					e.printStackTrace();
					return false;
				}
			} else{
				fileMap.put(fileName, filePathName);
			}
		}
		System.out.println("List of the referenced files : " + fileMap.keySet());
		return true;
	}
	
	private static Path changeConflitFileName(String srcFile) throws IOException{
		Path srcPath = FileSystems.getDefault().getPath(srcFile);
	
		Path file = srcPath.getName(srcPath.getNameCount()-1);
		Path parent = srcPath.getName(srcPath.getNameCount()-2);
		Path destPath = FileSystems.getDefault().getPath(srcPath.getParent() + File.separator + parent + file);
		
		Files.move(srcPath, destPath, StandardCopyOption.REPLACE_EXISTING);
		return destPath;
	}

	private static ArrayList<File> filterFilesByExtension(ArrayList<File> inputList, String ext) {
		ArrayList<File> result = new ArrayList<File>();
		for (int i = 0; i < inputList.size(); i++) {
			if (inputList.get(i).getAbsoluteFile().toString().endsWith(ext))
				result.add(inputList.get(i));
		}
		return result;
	}
	
	public static String getTitleOfPlugin(File file) throws IOException {
		String title = removeExtension(file.getName().split("_")[1]);
		String[] titles = title.split("\\.");
		title = titles[titles.length - 2] + " . " + titles[titles.length - 1];
		return title;
	}

	public static String getTitle(File file) throws IOException {
		
		if(file.getName().split("_")[0].contains("Extension")){
			return getTitleOfPlugin(file);
		}

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String title = "";

		while ((line = br.readLine()) != null) {
			if (line.trim().startsWith("#")) {
				String pattern = "[^a-zA-Z0-9]+";
				Pattern r = Pattern.compile(pattern);
				// Now create matcher object.
				Matcher m = r.matcher(line);
				if (m.find()) {
					title = line.replace(m.group(0), "").trim();
					break;
				}
			}
		}
		br.close();
		System.out.println("title : " + title);
		title = title.split("#")[0];
		return title;
	}

	public static void breakTableofImagesSourceInMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";
		String nextLine = "";

		while ((line = br.readLine()) != null) {
			if(isTableOfImages(line)) {
				line = line.replace("|", "");
				nextLine = br.readLine();
				if(nextLine != null && !isTable(nextLine)){
					line =  line + '\n' + nextLine;
				}
			}
			if (input == "")
				input = line;
			else{
				input = input + '\n' + line;
			}
			
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	private static boolean isTable(String str) {
		Pattern pattern1 = Pattern.compile("[^\n]*?\\|[^\n]*?");
		Matcher matcher1 = pattern1.matcher(str);
		if(matcher1.find())
			return true;
		return false;
	}
	
	private static boolean isTableOfImages(String str) {
		if(CheckURL.isTable(str)){
			if(str.contains("resources/images/")){
				return true;
			}
		}
		return false;
	}
	
	public static void changeStyleImagesInMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		while ((line = br.readLine()) != null) {
			if (input == "")
				input = changeStyleImagesPath(line);
			else
				input = input + '\n' + changeStyleImagesPath(line);
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	private static String changeStyleImagesPath(String str) {
		Pattern pattern = Pattern.compile("(!\\[.*?\\]\\(.*?\\))");
		Matcher matcher = pattern.matcher(str);
		String mStr = "";
		/*while (matcher.find()) {
			String stringMatched = matcher.group(0);
			//stringMatched = "<a class="+'"'+"col-sm-12 col-xs-12"+'"'+">" + stringMatched + "</a>";
			stringMatched = stringMatched + "{.image-wrapper .col-lg-12 .col-md-12 .col-sm-12 .col-xs-12}";
			mStr= mStr + stringMatched;
		}
		if (mStr.equals(""))
			mStr = str;
		return mStr;*/
		while (matcher.find()) {
			String stringMatched = matcher.group(0);
			str = str.replace(stringMatched, stringMatched + "{.img-responsive}");
			}
		return str;
	}
	
	///
		public static void changeInternalLinkWithAnchorInMDFile(File file) throws IOException {
			System.out.println("reading internal link anchor of file " + file.getAbsolutePath());
			FileInputStream fis = new FileInputStream(file);
			BufferedReader br = new BufferedReader(new InputStreamReader(fis));

			String line = null;
			String input = "";

			while ((line = br.readLine()) != null) {
				if (input == "")
					input = changeLinkWithAnchorPath(line);
				else
					input = input + '\n' + changeLinkWithAnchorPath(line);
			}
			br.close();
			// write the new String with the replaced line OVER the same file
			FileOutputStream fileOut = new FileOutputStream(file);
			fileOut.write(input.getBytes());
			fileOut.close();
		}
		
		public static String changeLinkWithAnchorPath(String str) {
			//buildFileMap();
			//Pattern pattern = Pattern.compile("(\\[.*?\\]\\([\\S]+#.*?\\))");
			//Pattern pattern = Pattern.compile("(\\[.*?\\]\\(([\\S]+#.*?)(\\(([\\S]+.*?)*|\\))\\)?)"); // good
			Pattern pattern = Pattern.compile("(\\[*?\\]\\(([\\S]+#.*?)([^()]*|\\(([^()]*|\\([^()]*\\))*\\))*\\))"); // trick
			
			Matcher matcher = pattern.matcher(str);
			while (matcher.find()) {
				System.out.println("adding internal link anchor " + matcher.group(0));
				String stringMatched = matcher.group(0);
				
				String oldPath = "";
				String[] link = stringMatched.split("#");
				if(link.length < 3 ){
					oldPath = link[1].substring(0, link[1].lastIndexOf(")"));
				}else{
					oldPath = link[1];
				}
				String newPath = oldPath.replaceAll("[^a-zA-Z0-9_-]", "");
				String newStringMatched = stringMatched.replaceFirst(Pattern.quote("#" + oldPath), "#" + newPath);
						
				str = str.replace(stringMatched, newStringMatched + "{.internal-link-anchor}");
			}
			return str;
		}
	
	
	///
	public static void changeExternalLinkInMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		while ((line = br.readLine()) != null) {
			if (input == "")
				input = changeExternalPath(line);
			else
				input = input + '\n' + changeExternalPath(line);
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	public static String changeExternalPath(String str) {
		//buildFileMap();
		Pattern pattern = Pattern.compile("(\\[.*?\\]\\(.*?\\))");
		Matcher matcher = pattern.matcher(str);
		while (matcher.find()) {
			String stringMatched = matcher.group(0);
			System.out.println(stringMatched);
			String oldPath = stringMatched.substring(stringMatched.lastIndexOf("(") + 1, stringMatched.lastIndexOf(")"));
			//System.out.println(stringMatched);
			String notAnchor = oldPath.split("#", 2)[0];
			Object path = fileMap.get(notAnchor.trim()+ ".md");
			if (path != null) {
				String filePath = (String)path;
				String newPath = filePath.split("/", 3)[1].toLowerCase() + "#" + oldPath;
				String newStringMatched = replaceLast(stringMatched, oldPath, newPath);
				str = str.replace(stringMatched, newStringMatched);
			}
		}
		return str;
	}
	
	 public static String replaceLast(String text, String regex, String replacement) {
	        return text.replaceFirst("(?s)(.*)" + regex, "$1" + replacement);
	    }
	///
	
	
	
	public static void readAndRewriteImagesSourceInMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		while ((line = br.readLine()) != null) {
			if (input == "")
				input = changeImagesPath(line, file, "");
			else
				input = input + '\n' + changeImagesPath(line, file, "");
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	private static String changeImagesPath(String str, File file, String residus) {
		Pattern pattern = Pattern.compile("(.*\\0133.*\\0135\\050)([^\\043].*?)(\\051.*)");
		Matcher matcher = pattern.matcher(str);
		if (matcher.find()) {
			String firstPart = changeImagesPath(matcher.group(1), file,
					matcher.group(2) + matcher.group(3));
			String stringMatched = matcher.group(2);
			String newURL = stringMatched;
			if (stringMatched.startsWith("resources/images/") 
					|| stringMatched.startsWith("resources/other/")) {
				newURL = Paths.get(pathToContent).getFileName() + File.separator + newURL;
				str = firstPart + newURL + matcher.group(3);
				//str = str.replace("|", " ");
				//str = "<a class='col-sm-12 col-xs-12'>" + str + "</a>";
				//if(!str.endsWith("{.center-image }"))
				//	str = str + "{.center-image }";
			}
		}
		return str;
	}
	
	public static void readAndRewriteInternalAnchorMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		while ((line = br.readLine()) != null) {
			if (input == "")
				input = changeAnchorFormat(line);
			else
				input = input + '\n' + changeAnchorFormat(line);
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	public static String changeAnchorFormat(String str){
		String cloneStr = str;
		if(str.trim().startsWith("#")){
			if(!str.endsWith("}")){
				cloneStr = cloneStr.toLowerCase();
				cloneStr = cloneStr.replace("#", "");
				cloneStr = cloneStr.trim();
				cloneStr = cloneStr.replaceAll("\\s+", " ");
				cloneStr = cloneStr.replaceAll("[^a-zA-Z0-9 _-]+", "");
				cloneStr = cloneStr.replace("_", "-");
				cloneStr = cloneStr.trim();
				cloneStr = cloneStr.replace(" ", "-");
				cloneStr = cloneStr.replaceAll("\\-+", "-");
				// trouble with special characters
				if(cloneStr.trim().equals("")){
					return str;
				}
				cloneStr = " ## {#" + cloneStr + "}";
				cloneStr = str + cloneStr;
			}
		}
		return cloneStr;
	}
	
	public static void readAndRewriteMDFileForVariousChanges(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		while ((line = br.readLine()) != null) {
			// remove all "{.internal-link-anchor}"
			line = line.replace("{.internal-link-anchor}", "");
			if (input == "") {
				input = line;
			}
			else {
				if (line.contains("Top of the page")) {
					// do nothing
					System.out.println("found a \"top of the page\" structure !");
				}
				else {
					// copy the line
					input += '\n' + line;
				}
			}
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	public static void readAndRewriteInternalLinkMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		String menu = getMenu(file.getAbsolutePath());
		while ((line = br.readLine()) != null) {
			if (input == "")
				input = changeLinkFormat(line, menu);
			else
				input = input + '\n' + changeLinkFormat(line, menu);
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	public static String changeLinkFormat(String str, String menu){
		Pattern pattern = Pattern.compile("(\\[.*?\\]\\(\\#.*?\\))");
		Matcher matcher = pattern.matcher(str);
		while (matcher.find()) {
			String strMatched = matcher.group(0);
			String strReplaced = strMatched.replace("](#", "]("+ menu + "#");
			str = str.replace(strMatched, strReplaced);
		}
		return str;
	}
	
	private static String getMenu(String absFileName){
		if(absFileName.contains("gm_wiki" + File.separator + "References" + File.separator))
			return "references";
		if(absFileName.contains("gm_wiki" + File.separator + "Tutorials" + File.separator))
			return "tutorials";
		return "";
	}

	private static void readAndRewriteMDFile(File file) throws IOException {

		FileInputStream fis = new FileInputStream(file);
		BufferedReader br = new BufferedReader(new InputStreamReader(fis));

		String line = null;
		String input = "";

		while ((line = br.readLine()) != null) {
			if (input == "")
				input = recursiveFindAndReplaceRegex(line, file, "");
			else
				input = input + '\n' + recursiveFindAndReplaceRegex(line, file, "");
		}
		br.close();

		// write the new String with the replaced line OVER the same file
		FileOutputStream fileOut = new FileOutputStream(file);
		fileOut.write(input.getBytes());
		fileOut.close();
	}
	
	private static String recursiveFindAndReplaceRegex(String str, File file, String residus) {
		String path = file.getParent();
		Pattern pattern = Pattern.compile("(.*\\0133.*\\0135\\050)([^\\043].*?)(\\051.*)");
		Matcher matcher = pattern.matcher(str);
		if (matcher.find()) {
			String firstPart = recursiveFindAndReplaceRegex(matcher.group(1), file,
					matcher.group(2) + matcher.group(3));
			String stringMatched = matcher.group(2);
			String newURL = stringMatched;
			if (stringMatched.startsWith("images" + File.separator) || stringMatched.startsWith("images/")) {
				// case of image link. Image links are relative path
				checkIfFileExists(path + File.separator + matcher.group(2));
			} else {
				// case of other links, have to be in githubUrl format.
				// extract the filename
				String fileName = stringMatched.split(
						File.separator + File.separator)[stringMatched.split(File.separator + File.separator).length
								- 1];

				// if the link contains an anchor, extract the anchor
				String anchor = "";
				if (fileName.contains("#")) {
					anchor = "#" + fileName.split("#")[1];
					fileName = fileName.split("#")[0];
				}

				// make changes (in case it is an old version)
				if (!fileName.endsWith(".md"))
					fileName = fileName + ".md";
				if (fileName.startsWith("G__"))
					fileName = fileName.replace("G__", "");
				if (fileName.startsWith("Tutorial__"))
					fileName = fileName.replace("Tutorial__", "");

				// check if the file exists in the map
				if (!fileMap.containsKey(fileName)) {
					System.out.println(
							"----> ERROR in file " + file.getName() + ": " + fileName + " is not a referenced file...");
				} else {
					// find in the map the correct URL to put
					newURL = fileMap.get(fileName) + anchor;
					if (!newURL.equals(stringMatched))
						System.out.println("----> MODIFICATION : " + stringMatched + " changed into " + newURL);
				}
			}
			str = firstPart + newURL + matcher.group(3);
		}
		return str;
	}
	
	public static String removeExtension(String str) {
        if (str == null) 
        	return null;
        int pos = str.lastIndexOf(".");
        if (pos == -1)
        	return str;
        return str.substring(0, pos);
    }

	public static String correctAnchorFormat(final String str){
		// trouble with special characters
		
		return str.replaceAll("[^a-zA-Z0-9]", "-");
	}
}
