package gamaws.utils;

import java.util.ArrayList;
import java.util.List;

public class Keyword {
	public final static String KEYWORD_TAG = "keyword";
	public final static String ID_TAG = "id";
	public final static String NAME_TAG = "name";
	public final static String CATEGORY_TAG = "category";
	public final static String ASSOCICATED_KEYWORD_TAG = "associatedKeyword";
	public final static String ASSOCICATED_KEYWORD_LIST_TAG = "associatedKeywordList";
	
	protected String id;
	protected String name;
	protected String category;
	protected List<String> associatedKeywordList;
	
	public Keyword(String id, String name, String category, List<String> associatedKeywordList) {
		this.id = id;
		this.name = name;
		this.category = category;
		this.associatedKeywordList = associatedKeywordList;
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getCategory() {
		return category;
	}

	public void setCategory(String category) {
		this.category = category;
	}

	public List<String> getAssociatedKeywordList() {
		return associatedKeywordList;
	}

	public void setAssociatedKeywordList(List<String> associatedKeywordList) {
		this.associatedKeywordList = associatedKeywordList;
	}
	
	@Override
	public boolean equals(Object obj) {
	    if (obj == null) {
	        return false;
	    }
	    if (!Keyword.class.isAssignableFrom(obj.getClass())) {
	        return false;
	    }
	    final Keyword other = (Keyword) obj;
	    if(this.id.equalsIgnoreCase(other.getId()) 
				|| (this.name.equalsIgnoreCase(other.getName()) 
						&& this.category.equalsIgnoreCase(other.getCategory()))){
				return true;
	    }
		return false;
	}

	@Override
	public int hashCode() {
	    int hash = 3;
	    hash = 53 * hash + (this.id != null ? this.id.hashCode() : 0);
	    return hash;
	}
	
	public static void main(String[] args){
		Keyword a = new Keyword("taolao", "qsd", "az", null);
		Keyword b = new Keyword("taolao", "qsdaze", "qsd", null);
		List<Keyword> lt = new ArrayList<Keyword>();
		lt.add(a);
		System.out.println(lt.contains(b));
		
	}
	
}
