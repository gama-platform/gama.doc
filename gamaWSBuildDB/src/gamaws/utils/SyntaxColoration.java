package gamaws.utils;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.nio.channels.FileChannel;
import java.nio.file.Files;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;

public class SyntaxColoration {
	
	public static String KEYWORD_FILE = "../keywords.xml";
	public static String MARKDOWN_EXTRA_FILE = "../application/frontend/libraries/MarkdownExtra.php";
	public static String[] LIST_CATEGORY = {"statement","type","operator","facet","literal"};
	public static String[] LIST_SPECIAL_CHAR = {"-", ":", "!", "?", "/", ".", "^", "@", "*", "+", "<", ">", "="};
	public static String[] LIST_UNDETECTED_STATEMENT = {"species","global","grid","model","import","output","init"};
	public static String[] LIST_LITERAL = {"true","false","unknown"};
	
	private static Map<String,ArrayList<String>> keywordMap = new HashMap<String,ArrayList<String>>();

	public static void generateColoration() throws ParserConfigurationException, SAXException, IOException {
		File keywordFile = new File(KEYWORD_FILE);
		if (!keywordFile.exists()) {
			System.out.println("WARNING : Impossible to find the file "+keywordFile.getAbsolutePath()+
					". Please generate it from the Processor before running it !");
			return;
		}
		
		// store all the words in map
		Document doc = createDoc(keywordFile);
		NodeList nl = doc.getElementsByTagName("keyword");
		for(int i = 0; i<nl.getLength(); i++){
			String category = ((Element)nl.item(i)).getElementsByTagName("category").item(0).getTextContent();
			String name = ((Element)nl.item(i)).getElementsByTagName("name").item(0).getTextContent();
			if (!keywordMap.containsKey(category)) {
				ArrayList<String> elemToAdd = new ArrayList<String>();
				elemToAdd.add(name);
				keywordMap.put(category, elemToAdd);
			}
			else {
				ArrayList<String> elemToAdd = keywordMap.get(category);
				elemToAdd.add(name);
				keywordMap.put(category, elemToAdd);
			}
		}
		
		// read and write the file MarkdownExtra
		
		// copy MarkdownExtra
		File markdownExtraFile = new File(MARKDOWN_EXTRA_FILE);
		File markdownExtraFileCopy = new File("MarkdownExtraCopy.md");
		Files.deleteIfExists(markdownExtraFileCopy.toPath());
		markdownExtraFileCopy.createNewFile();
		copyFile(markdownExtraFile, markdownExtraFileCopy);
		
		// read the temporary file line after line
		BufferedReader in = new BufferedReader(new FileReader(markdownExtraFileCopy));
		
		FileWriter fw=new FileWriter(markdownExtraFile);
		BufferedWriter out= new BufferedWriter(fw);
		
		String line = null;
		boolean automaticGeneratedPart=false;
		while ((line = in.readLine()) != null) {
			// change the title of the page (# Title) to the correct latex title
			if (line.contains("# end of the automatically generated part")) {
				automaticGeneratedPart = false;
			}
			if (line.contains("# this part is automatically generated, please don't change it")) {
				automaticGeneratedPart = true;
				// generate automatically the text from the map
				// write the first line
				out.write(line);
				out.newLine();
				// write all the categories
				for (int i = 0 ; i < LIST_CATEGORY.length ; i++ ) {
					ArrayList<String> listKeywords = keywordMap.get(LIST_CATEGORY[i]);
					if (listKeywords == null) {
						listKeywords = new ArrayList<String>();
					}
					out.write("# list of "+LIST_CATEGORY[i]+"\n");
					out.write("$"+LIST_CATEGORY[i]+"Pattern = '/\\b(");
					boolean firstWordWritten = false;
					if (LIST_CATEGORY[i] == "statement") {
						for (String undetectStatement : LIST_UNDETECTED_STATEMENT) {
							if (firstWordWritten) {
								out.write("|");
							}
							firstWordWritten = true;
							out.write(undetectStatement);
						}
					}
					if (LIST_CATEGORY[i] == "literal") {
						for (String literal : LIST_LITERAL) {
							if (firstWordWritten) {
								out.write("|");
							}
							firstWordWritten = true;
							out.write(literal);
						}
					}
					for (String keyword : listKeywords) {
						if (!containsSpecialChar(keyword)) {
							if (firstWordWritten) {
								out.write("|");
							}
							firstWordWritten = true;
							out.write(keyword);
						}
					}
					out.write(")\\b");
					if (LIST_CATEGORY[i] == "facet") {
						out.write("\\:");
					}
					out.write("/';\n");
				}
			}
			if (!automaticGeneratedPart) {
				out.write(line);
				out.newLine();
			}
		}
		
		in.close();			
		out.close();
		
		// delete the temporary file
		Files.deleteIfExists(markdownExtraFileCopy.toPath());
	}
	
	public static boolean containsSpecialChar(String keyword) {
		boolean result = false;
		for (String str : LIST_SPECIAL_CHAR) {
			if (keyword.contains(str)) {
				result = true;
			}
		}
		return result;
	}
	
	public static Document createDoc(String xml) throws ParserConfigurationException, SAXException, IOException{
		// Creation of the DOM source
		File fileXml = new File(xml);
		
		return createDoc(fileXml);
	}
	
	public static Document createDoc(File XMLFile) throws ParserConfigurationException, SAXException, IOException{
		// Creation of the DOM source
		DocumentBuilderFactory fabriqueD = DocumentBuilderFactory.newInstance();
		DocumentBuilder builder = fabriqueD.newDocumentBuilder();
		Document document = builder.parse(XMLFile);
		
		return document;
	}
	
	@SuppressWarnings("resource")
	public static void copyFile(File sourceFile, File destFile) throws IOException {
	    if(!destFile.exists()) {
	        destFile.createNewFile();
	    }

	    FileChannel source = null;
	    FileChannel destination = null;

	    try {
	        source = new FileInputStream(sourceFile).getChannel();
	        destination = new FileOutputStream(destFile).getChannel();
	        destination.transferFrom(source, 0, source.size());
	    }
	    finally {
	        if(source != null) {
	            source.close();
	        }
	        if(destination != null) {
	            destination.close();
	        }
	    }
	}
}
