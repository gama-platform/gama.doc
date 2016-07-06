package gamaws.utils;

import java.io.File;
import java.io.IOException;
import java.nio.file.FileAlreadyExistsException;
import java.nio.file.FileSystems;
import java.nio.file.FileVisitOption;
import java.nio.file.FileVisitResult;
import java.nio.file.FileVisitor;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.SimpleFileVisitor;
import java.nio.file.attribute.BasicFileAttributes;
import java.util.EnumSet;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.apache.commons.lang3.StringEscapeUtils;

import gamaws.db.KeywordToGamaWSDB;
import gamaws.db.TreeMenuToGamaWSDB;

public class Test {
	public static void main(String[] args) {
		try {
			String ROOT = "/mnt/DA96A5EB96A5C879/Copy/project/gamaws/gm_wiki/References/ModelLibrary";
			//String ROOT = "/mnt/DA96A5EB96A5C879/Copy/project/gamaws/gm_wiki/";
			//String ROOT = "/mnt/DA96A5EB96A5C879/Copy/project/gamaws/gm_wiki/References/PluginDocumentation";
			//String ROOT = "/mnt/DA96A5EB96A5C879/Copy/project/gamaws/gm_wiki/Community";
			//addCommunity(ROOT);
			//String line = listDirectory(ROOT, 0);
			//System.out.println(TreeMenuToGamaWSDB.listDirectory(ROOT, 0, 1));
			//System.out.println(line);
			//String str= "rtant[global variables to manage time](#cycle)qsdqs";
			//testLinkAnchor(str);
			changeConflitFileNameAndItFolder(ROOT, "test");
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	private static Path changeConflitFileNameAndItFolder(String srcFile, String conflitFile) throws IOException{
		Path srcPath = FileSystems.getDefault().getPath(srcFile);
		Path file = srcPath.getName(srcPath.getNameCount()-1);
		Path parent = srcPath.getName(srcPath.getNameCount()-2);
		Path destPath = FileSystems.getDefault().getPath(srcPath.getParent() + File.separator + parent + file);
		System.out.println(file);
		System.out.println(parent);
		System.out.println(destPath);
		System.out.println(srcPath);
		/*if(file.endsWith(fileName)){
			String newFileName = path.getName(path.getNameCount()-2).toString();
			Path destFile = FileSystems.getDefault().getPath(newFileName);
			Files.move(path, destFile, StandardCopyOption.REPLACE_EXISTING);
			return destFile;
		}*/
		return srcPath;
	}

	private static String addCommunity(String path) throws IOException {
		String line = "";
		/*Files.walkFileTree(Paths.get(path), new SimpleFileVisitor<Path>() {
				
				String line = "";
				@Override
				public FileVisitResult preVisitDirectory(Path dir, BasicFileAttributes attrs) throws IOException {
					System.out.println("Processing directory:" + dir.getFileName().toString());
					line = line + addPrefixToFileName(Paths.get(path).getParent().relativize(dir).toString());
					return FileVisitResult.CONTINUE;
				}

				@Override
				public FileVisitResult visitFile(Path file, BasicFileAttributes attrs) throws IOException {
					System.out.println("Processing file:" + file.getFileName().toString());
					line = line + addPrefixToFileName(Paths.get(path).getParent().relativize(file).toString());
					return FileVisitResult.CONTINUE;
				}
				
				
			});*/
		return line;
	}
	
	private static String addPrefixToFileName(String filePath){
		String[] filenames = filePath.split(File.separator);
		String prefix = "";
		int i = 0;
		while(i < filenames.length){
			prefix = prefix + "-";
			i++;
		}
		String last =  prefix + filenames[filenames.length-1];
		return last;
	}
	
	private static String addPrefixToFileName(String filename, int level){
		String prefix = "";
		int i = 0;
		while(i <= level+1){
			prefix = prefix + "-";
			i++;
		}
		return prefix + filename;
	}
	
	public static String listDirectory(String dirPath, int level) {
		String line = "";
	    File dir = new File(dirPath);
	    File[] firstLevelFiles = dir.listFiles();
	    if (firstLevelFiles != null && firstLevelFiles.length > 0) {
	        for (File aFile : firstLevelFiles) {
	        	line = line + addPrefixToFileName(aFile.getName(), level) + "\n";
	            if (aFile.isDirectory()) {
	            	line = line + listDirectory(aFile.getAbsolutePath(), level + 1);
	            }
	        }
	    }
	    return line;
	}
	
	private static void testLinkAnchor(String str){
		Pattern pattern = Pattern.compile("(\\[.*?\\]\\([\\S]+#.*?\\))");
		Matcher matcher = pattern.matcher(str);
		while (matcher.find()) {
			String stringMatched = matcher.group(0);
			System.out.println(stringMatched);
		}
	}
}
