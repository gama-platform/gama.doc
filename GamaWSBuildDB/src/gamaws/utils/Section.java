package gamaws.utils;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Stack;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


public class Section implements Iterable<Section> {

	private List<Section> children;
	private String text;
	private int depth;
	private Section parent;
	private Section previous;

	static final int root_depth = 0; //  // number of dashes precede the root

	public Section(String text, int depth) {
		this.text = text;
		this.depth = depth;
		this.children = new ArrayList<Section>();
		this.parent = null;
		this.previous = null;
	}

	public Section(String text, int depth, Section parent, Section previous) {
		this.text = text;
		this.depth = depth;
		this.children = new ArrayList<Section>();
		this.parent = parent;
		this.previous = previous;
	}

	public void addChild(Section child) {
		if (children == null) {
			children = new ArrayList<Section>();
		}
		if (child != null) {
			children.add(child);
		}
	}
	
	public Section getLastChild() {
		if (children.isEmpty()) {
			return null;
		}
		return children.get(children.size()-1);
	}
	
	public boolean isRoot() {
		return parent == null;
	}

	public boolean isLeaf() {
		return children.size() == 0;
	}
	
	@Override
	public Iterator<Section> iterator() {
		SectionIter iter = new SectionIter(this);
		return iter;
	}

	private static int getLevelOfSection(String line){
		if(line.equals("root"))
			return 0;
		
		String pattern = "^([-])*";
		Pattern r = Pattern.compile(pattern);
		Matcher m = r.matcher(line.trim());
		if (m.find()) {
			return m.end() + 1;
		}
		return 0;
	}
	
	public static Section parseTree(String path){
		Section first = new Section("root", root_depth);
		Section prev = first;
		try {
			BufferedReader br = new BufferedReader(new FileReader(path));
			for (String line; (line = br.readLine()) != null; ) {
			    if (prev == null && Section.getLevelOfSection(line) == 0) {
			    	Section root = new Section(line.replaceAll("^([-])*", ""), root_depth);
			        prev = root;
			    }
			    else {
			        int t_depth = Section.getLevelOfSection(line);
			        if (t_depth > prev.getDepth()){
			            // assuming that empty sections are not allowed
			        	Section parent = prev;
			        	Section t_section_prev = parent.getLastChild();
			            Section t_section = new Section(line.replaceAll("^([-])*", ""), t_depth, parent, prev);
			            prev.addChild(t_section);
			            prev = t_section;
			        }
			        else if (t_depth == prev.getDepth()) {
			        	Section parent = prev.getParent();
			        	Section t_section_prev = parent.getLastChild();
			            Section t_section = new Section(line.replaceAll("^([-])*", ""), t_depth, parent, prev);
			            prev.getParent().addChild(t_section);
			            //prev = prev.getParent();
			            prev = t_section;
			        }
			        else {
			            while (t_depth < prev.getDepth()) {
			                prev = prev.getParent();
			            }
			            // at this point, (t_depth == prev.getDepth()) = true
			            Section parent = prev.getParent();
			        	Section t_section_prev = parent.getLastChild();
			            Section t_section = new Section(line.replaceAll("^([-])*", ""), t_depth, parent, prev);
			            prev.getParent().addChild(t_section);
			            prev = t_section;
			            //prev = prev.getParent();
			        }
			    }
			}
			br.close();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return first;
	}
	
	public List<Section> getChildren() {
		return children;
	}

	public void setChildren(List<Section> children) {
		this.children = children;
	}

	public String getText() {
		return text;
	}

	public void setText(String text) {
		this.text = text;
	}

	public int getDepth() {
		return depth;
	}

	public void setDepth(int depth) {
		this.depth = depth;
	}

	public Section getParent() {
		return parent;
	}

	public void setParent(Section parent) {
		this.parent = parent;
	}

	public Section getPrevious() {
		return previous;
	}

	public void setPrevious(Section previous) {
		this.previous = previous;
	}

	public static int getRootDepth() {
		return root_depth;
	}
	
	public static void main(String[] args){
		String str = "* [Ant Foraging (Charts examples)](references#Ants(ForagingandSorting)AntForaging(Chartsexamples))";
		System.out.println(changeLinkWithAnchorPath(str));
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
			System.out.println("oldPath " + oldPath);
			String newPath = oldPath.replaceAll("[^a-zA-Z0-9_-]", "");
			System.out.println("newPath " + newPath);
			String newStringMatched = stringMatched.replaceFirst(Pattern.quote("#" + oldPath), "#" + newPath);
			System.out.println("newStringMatched " + newStringMatched);
			str = str.replace(stringMatched, newStringMatched + "{.internal-link-anchor}");
		}
		return str;
	}
	
}
