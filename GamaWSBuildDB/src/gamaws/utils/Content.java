package gamaws.utils;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class Content {
	Integer id;
	Integer menuId;
	String filenameGh;
	Integer type;
	
	public Content(Integer id, Integer menuId, String filenameGh, Integer type) {
		super();
		this.id = id;
		this.menuId = menuId;
		this.filenameGh = filenameGh;
		this.type = type;
	}

	@Override
	public String toString() {
		return "Content [id=" + id + ", menu_id=" + menuId + ", filename_gh=" + filenameGh + ", type=" + type + "]";
	}
	
	public static List<Content> writeResultSet(ResultSet resultSet){
		List<Content> lmc = new ArrayList<>();
		try {
			while (resultSet.next()) {
				Integer id = resultSet.getInt("id");
				Integer menuId = resultSet.getInt("menu_id");
				String filenameGh = resultSet.getString("filename_gh");
				Integer type = resultSet.getInt("type");
				Content mc = new Content(id, menuId, filenameGh, type);
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
	public Integer getMenuId() {
		return menuId;
	}
	public void setMenuId(Integer menuId) {
		this.menuId = menuId;
	}
	public String getFilenameGh() {
		return filenameGh;
	}
	public void setFilenameGh(String filenameGh) {
		this.filenameGh = filenameGh;
	}
	public Integer getType() {
		return type;
	}
	public void setType(Integer type) {
		this.type = type;
	}
	
	
}
