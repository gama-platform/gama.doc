package gamaws.utils;

public class Webpage {

	protected int id;
	protected String name;
	protected String webpageCategory;
	protected int idMenu;
	
	public Webpage(int id, String name, String webpageCategory, int idMenu) {
		this.id = id;
		this.name = name;
		this.webpageCategory = webpageCategory;
		this.idMenu = idMenu;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getWebpageCategory() {
		return webpageCategory;
	}

	public void setWebpageCategory(String webpageCategory) {
		this.webpageCategory = webpageCategory;
	}

	public int getIdMenu() {
		return idMenu;
	}

	public void setIdMenu(int idMenu) {
		this.idMenu = idMenu;
	}
	
	
	
}
