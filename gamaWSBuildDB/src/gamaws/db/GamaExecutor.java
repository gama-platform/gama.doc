package gamaws.db;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.nio.file.FileSystems;
import java.nio.file.FileVisitResult;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.SimpleFileVisitor;
import java.nio.file.StandardCopyOption;
import java.nio.file.attribute.BasicFileAttributes;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.xml.parsers.ParserConfigurationException;

import org.xml.sax.SAXException;

import gamaws.utils.CheckURL;
import gamaws.utils.SyntaxColoration;

public class GamaExecutor {
	
	public static final String checkoutScript = "push_wiki.sh";

	public static void main(String args[]) throws ParserConfigurationException, SAXException, IOException{
		/*try {
			
			//removeOccurencesFileNamesInModelLibrary();
		} catch (IOException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}*/
		CheckURL.removeConflitFolder();
		if(CheckURL.buildFileMap()){
			KeywordToGamaWSDB.escapeSpecialCharacters();
			SyntaxColoration.generateColoration();
			rewriteWebsiteTreeStructure();
			rewriteDB();
			rewriteMDFiles();
			rewriteLearningConcept();
			
			/*int code;
			try {
				code = System.in.read();
				switch (code) {
				case 49:  
					rewriteDB();
					break;
				case 50:  
					rewriteMDFiles();
					break;
				case 51:  
					rewriteWebsiteTreeStructure();
					break;
				default:
					KeywordToGamaWSDB.escapeSpecialCharacters();
					rewriteWebsiteTreeStructure();
					rewriteDB();
					rewriteMDFiles();
					
					rewriteLearningConcept();
					break;
				}
			} catch (IOException e) {
				e.printStackTrace();
			} */
		}
	}
	
	private static void checkoutGamaWsOnGithub(){
		
		try {
			Process p = Runtime.getRuntime().exec(CheckURL.pathToContent + File.separator + checkoutScript);
			p.waitFor();
			BufferedReader reader = new BufferedReader(new InputStreamReader(p.getInputStream()));
			String line = "";
			while ((line = reader.readLine()) != null){
				System.out.println(line);
			}
		} catch (IOException | InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}

	private static void rewriteDB(){
		WebpageLearningConceptToGamaWSDB2.deleteAllWebpageLearningConcept();
		LearningConceptToGamaWSDB.deleteAllAssociatedLearningConcept();
		LearningConceptToGamaWSDB.deleteAllLearningConcept();
		
		WebpageKeywordToGamaWSDB.deleteAllWebpageKeyword();
		WebpageToGamaWSDB.deleteAllWebpage();
		AliasToGamaWSDB.deleteAllAlias();
		KeywordToGamaWSDB.deleteAllAssociatedKeyword();
		KeywordToGamaWSDB.deleteAllKeyword();
		CategoryToGamaWSDB.deleteAllCategory();
		TreeMenuToGamaWSDB.deleteAllMenu(4);
		
		System.out.println("writing category");
		CategoryToGamaWSDB.writeCategoryToGamaWSDB();
		System.out.println("writing menu");
		TreeMenuToGamaWSDB.writeTreeMenuToDB();
		System.out.println("writing keyword");
		KeywordToGamaWSDB.writeKeywordToGamaWSDB();
		System.out.println("writing associatedKeyword");
		KeywordToGamaWSDB.writeAssociatedKeywordToDB();
		System.out.println("writing alias");
		AliasToGamaWSDB.writeAliasToGamaWSDB();
		System.out.println("writing webpage");
		WebpageToGamaWSDB.writeWebpageToDB();
	}
	
	private static void rewriteMDFiles(){
		System.out.println("modifying md files, removing \"top of the page\"");
		CheckURL.readAndRewriteMDFileForVariousChanges();
		System.out.println("modifying images source");
		CheckURL.readAndRewriteImagesSourceInMDFile();
		System.out.println("modifying internal link anchor");
		CheckURL.changeInternalLinkWithAnchorInMDFile();
		System.out.println("modifying external links");
		CheckURL.changeExternalLinkInMDFile();
		System.out.println("modifying internal links");
		CheckURL.readAndRewriteInternalLinkMDFile();
		System.out.println("modifying internal anchors");
		CheckURL.readAndRewriteInternalAnchorMDFile();
		System.out.println("modifying break table images source");
		CheckURL.breakTableofImagesSourceInMDFile();
		System.out.println("modifying images style");
		CheckURL.changeStyleImagesInMDFile();
		
		System.out.println("writing anchor of keywords");
		WebpageKeywordToGamaWSDB.writeAnchorOfKeywordToMDFileAndBD();
		System.out.println("---> END OF THE SCRIPT");
	}
	
	private static void rewriteLearningConcept(){
		
		LearningConceptToGamaWSDB.checkLearningConceptFromMDFile();
		LearningConceptToGamaWSDB.writeLearningConceptToGamaWSDB();
		LearningConceptToGamaWSDB.writeAssociatedLearningConceptToDB();
		
		WebpageLearningConceptToGamaWSDB2.writeAnchorOfLearningConceptToMDFileAndBD();
	}
	
	private static void rewriteWebsiteTreeStructure(){
		try {
			TreeMenuToGamaWSDB.readModelLibraryAndPluginDocumentationToTreeStructureFile();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private static void removeOccurencesFileNamesInModelLibrary() throws IOException {
		String path = CheckURL.pathToContent + File.separator + "References" + File.separator + "ModelLibrary";
		Map<String, String> listFileName = new HashMap<String, String>();
		listFileName.put("Tutorials", "");
		listFileName.put("References", "");
		removeOccurencesFileNames(path, listFileName);
	}
	
	private static void removeOccurencesFileNames(String path, final Map<String, String> listFileNames) throws IOException {
		//String path = CheckURL.pathToContent;
		Files.walkFileTree(Paths.get(path), new SimpleFileVisitor<Path>() {
				int count = 0;
				Map<String, String> listFileName = listFileNames; 
				@Override
				public FileVisitResult preVisitDirectory(Path dir, BasicFileAttributes attrs) throws IOException {
					//System.out.println("Processing directory:" + dir);
					//listFileName.add(arg0);
					if(isGamaWikiDir(dir)){
						if(listFileName.keySet().contains(dir.getFileName().toString())
								&& !listFileName.values().contains(CheckURL.removeExtension(dir.toString()))){
			
							Path dest = FileSystems.getDefault().getPath(dir.toString() + count);
							Path targetPath = dest.resolve(dir.relativize(dir));
							if(!Files.exists(targetPath)){
					            Files.createDirectory(targetPath);
					        }
							//Files.move(dir, dest, StandardCopyOption.REPLACE_EXISTING);
							listFileName.put(dest.getFileName().toString(), dest.toString());
							System.out.println("move from :" + dir);
							System.out.println("move to :" + dest);
							System.out.println("targetPath :" + targetPath);
							count ++;
						}else{
							listFileName.put(dir.getFileName().toString(),dir.toString());
						}
					}	
					return FileVisitResult.CONTINUE;
				}

				@Override
				public FileVisitResult visitFile(Path file, BasicFileAttributes attrs) throws IOException {
					//System.out.println("Processing file:" + file);
					if(isMDFile(file) 
							&& listFileName.keySet().contains(CheckURL.removeExtension(file.getFileName().toString()))
							&& !listFileName.values().contains(CheckURL.removeExtension(file.toString()))){
						Path dest = FileSystems.getDefault().getPath(CheckURL.removeExtension(file.toString()) + count + ".md");
						Files.move(file, dest, StandardCopyOption.REPLACE_EXISTING);
						listFileName.put(CheckURL.removeExtension(dest.getFileName().toString()), CheckURL.removeExtension(dest.toString()));
						System.out.println("move from :" + file);
						System.out.println("move to :" + dest);
						count ++;
					}else{
						listFileName.put(CheckURL.removeExtension(file.getFileName().toString()), CheckURL.removeExtension(file.toString()));
					}
					return FileVisitResult.CONTINUE;
				}
			});
	}
	
	/*private static void removeOccurencesFileNames() throws IOException {
		String path = CheckURL.pathToContent;
		Files.walkFileTree(Paths.get(path), new SimpleFileVisitor<Path>() {
				int count = 0;
				Map<String, String> listFileName = new HashMap<String, String>(); 
				@Override
				public FileVisitResult preVisitDirectory(Path dir, BasicFileAttributes attrs) throws IOException {
					//System.out.println("Processing directory:" + dir);
					//listFileName.add(arg0);
					if(isGamaWikiDir(dir)){
						if(listFileName.keySet().contains(dir.getFileName().toString())
								&& !listFileName.values().contains(CheckURL.removeExtension(dir.toString()))){
							Path dest = FileSystems.getDefault().getPath(dir.toString() + count);
							Files.move(dir, dest, StandardCopyOption.REPLACE_EXISTING);
							listFileName.put(dest.getFileName().toString(), dest.toString());
							System.out.println("move from :" + dir);
							System.out.println("move to :" + dest);
							count ++;
							dir  = dest;
						}else{
							listFileName.put(dir.getFileName().toString(),dir.toString());
						}
					}
					
					return FileVisitResult.CONTINUE;
				}
				
				@Override
	            public FileVisitResult postVisitDirectory(Path dir, IOException e)
	                    throws IOException {
	                if (e == null) {
	                    System.out.println("postVisitDirectory(" + dir + ")");
	                    return FileVisitResult.CONTINUE;
	                } else {
	                    throw e;
	                }
	            }

				@Override
				public FileVisitResult visitFile(Path file, BasicFileAttributes attrs) throws IOException {
					//System.out.println("Processing file:" + file);
					if(isMDFile(file) 
							&& listFileName.keySet().contains(CheckURL.removeExtension(file.getFileName().toString()))
							&& !listFileName.values().contains(CheckURL.removeExtension(file.toString()))){
						Path dest = FileSystems.getDefault().getPath(CheckURL.removeExtension(file.toString()) + count + ".md");
						Files.move(file, dest, StandardCopyOption.REPLACE_EXISTING);
						listFileName.put(CheckURL.removeExtension(dest.getFileName().toString()), CheckURL.removeExtension(dest.toString()));
						System.out.println("move from :" + file);
						System.out.println("move to :" + dest);
						count ++;
					}else{
						listFileName.put(CheckURL.removeExtension(file.getFileName().toString()), CheckURL.removeExtension(file.toString()));
					}
					return FileVisitResult.CONTINUE;
				}
			});
	}*/
	
	private static boolean isMDFile(Path filename){
		if(filename.toString().endsWith(".md")){
			return true;
		}
		return false;
	}
	
	private static boolean isGamaWikiDir(Path dir){
		Path references = FileSystems.getDefault().getPath(CheckURL.pathToContent + File.separator + "References");
		Path tutorials = FileSystems.getDefault().getPath(CheckURL.pathToContent + File.separator + "Tutorials");
		Path community = FileSystems.getDefault().getPath(CheckURL.pathToContent + File.separator + "Community");
		if(isChild(dir, references) 
				|| isChild(dir, tutorials) 
				|| isChild(dir, community)){
			return true;
		}
		return false;
	}
	

	//Check if childCandidate is child of path
	public static boolean isChild(Path childCandidate, Path path) {
	    return childCandidate.startsWith(path);
	}
}
