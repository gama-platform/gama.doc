package gamaws.utils;

import java.util.List;

public class WebpageLearningConcept {
	protected int idWebpage;
	protected int idLearningConcept;
	protected String beginAnchor;
	
	public WebpageLearningConcept(int idWebpage, int idKeyword, String anchor) {
		super();
		this.idWebpage = idWebpage;
		this.idLearningConcept = idKeyword;
		this.beginAnchor = anchor;
	}

	public int getIdWebpage() {
		return idWebpage;
	}

	public void setIdWebpage(int idWebpage) {
		this.idWebpage = idWebpage;
	}

	public int getIdLearningConcept() {
		return idLearningConcept;
	}

	public void setIdLearningConcept(int idLearningConcept) {
		this.idLearningConcept = idLearningConcept;
	}

	public String getBeginAnchor() {
		return beginAnchor;
	}

	public void setBeginAnchor(String anchor) {
		this.beginAnchor = anchor;
	}
	
	
	
	
}
