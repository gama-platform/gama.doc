package gamaws.utils;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class MenuContent {
	Integer id;
	Integer parentId;
	String title; 
	String shortTitle;
	String description; 
	String alias; 
	Integer previous; 
	Integer type;
	String filenameGh;
	
	

	public MenuContent(Integer id, Integer parentId, String title, String shortTitle, String description, String alias,
			Integer previous, Integer type, String filenameGh) {
		super();
		this.id = id;
		this.parentId = parentId;
		this.title = title;
		this.shortTitle = shortTitle;
		this.description = description;
		this.alias = alias;
		this.previous = previous;
		this.type = type;
		this.filenameGh = filenameGh;
	}

	@Override
	public String toString() {
		return "MenuContent [id=" + id + ", parentId=" + parentId + ", title=" + title + ", shortTitle=" + shortTitle
				+ ", description=" + description + ", alias=" + alias + ", previous=" + previous + ", type=" + type
				+ ", filenameGh=" + filenameGh + "]";
	}

	public static List<MenuContent> writeResultSet(ResultSet resultSet){
		List<MenuContent> lmc = new ArrayList<>();
		try {
			while (resultSet.next()) {
				Integer id = resultSet.getInt("id");
				Integer parentId = resultSet.getInt("parent_id");
				String title = resultSet.getString("title");
				String sTitle = resultSet.getString("short_title");
				String description = resultSet.getString("description");
				String alias = resultSet.getString("alias");
				Integer previous = resultSet.getInt("previous");
				Integer type = resultSet.getInt("type");
				String filenameGh = resultSet.getString("filename_gh");
				MenuContent mc = new MenuContent(id, parentId, title, sTitle, description, alias, previous, type, filenameGh);
				lmc.add(mc);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return lmc;
	}



	public Integer getId() {
		return id;
	}



	public void setId(Integer id) {
		this.id = id;
	}



	public Integer getParentId() {
		return parentId;
	}



	public void setParentId(Integer parentId) {
		this.parentId = parentId;
	}



	public String getTitle() {
		return title;
	}



	public void setTitle(String title) {
		this.title = title;
	}

	

	public String getShortTitle() {
		return shortTitle;
	}

	public void setShortTitle(String shortTitle) {
		this.shortTitle = shortTitle;
	}

	public String getDescription() {
		return description;
	}



	public void setDescription(String description) {
		this.description = description;
	}



	public String getAlias() {
		return alias;
	}



	public void setAlias(String alias) {
		this.alias = alias;
	}



	public Integer getPrevious() {
		return previous;
	}



	public void setPrevious(Integer previous) {
		this.previous = previous;
	}

	public Integer getType() {
		return type;
	}

	public void setType(Integer type) {
		this.type = type;
	}
	
	public String getFilenameGh() {
		return filenameGh;
	}

	public void setFilenameGh(String filenameGh) {
		this.filenameGh = filenameGh;
	}

	public static int findIdofMenuContentName(String name, List<MenuContent> lmc){
		for(MenuContent mc : lmc){
			if(mc.getShortTitle().equalsIgnoreCase(name)){
				return mc.id;
			}
		}
		return -1;
	}
	
}
