package gamaws.utils;

import java.util.List;

public class WebpageKeyword {
	protected int idWebpage;
	protected int idKeyword;
	protected String anchor;
	protected boolean isInHeader;
	
	public WebpageKeyword(int idWebpage, int idKeyword, String anchor, boolean isInHeader) {
		super();
		this.idWebpage = idWebpage;
		this.idKeyword = idKeyword;
		this.anchor = anchor;
		this.isInHeader = isInHeader;
	}

	public int getIdWebpage() {
		return idWebpage;
	}

	public void setIdWebpage(int idWebpage) {
		this.idWebpage = idWebpage;
	}

	public int getIdKeyword() {
		return idKeyword;
	}

	public void setIdKeyword(int idKeyword) {
		this.idKeyword = idKeyword;
	}

	public String getAnchor() {
		return anchor;
	}

	public void setAnchor(String anchor) {
		this.anchor = anchor;
	}

	public boolean isInHeader() {
		return isInHeader;
	}

	public void setInHeader(boolean isInHeader) {
		this.isInHeader = isInHeader;
	}
	
	
	
	
}
