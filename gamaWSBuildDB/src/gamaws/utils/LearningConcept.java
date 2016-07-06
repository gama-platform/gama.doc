package gamaws.utils;

import java.util.List;

public class LearningConcept {
	public String m_id;
	public String m_name;
	public String m_description;
	public List<String> m_prerequisitesList;
	public float m_xPos;
	public float m_yPos;
	
	public LearningConcept(String id, String name, String description, float xPos, float yPos, List<String> prerequisitesList) {
		m_id = id;
		m_name = name;
		m_description = description;
		m_xPos = xPos;
		m_yPos = yPos;
		m_prerequisitesList = prerequisitesList;
	}
	
	
	
	@Override
	public boolean equals(Object obj) {
	    if (obj == null) {
	        return false;
	    }
	    if (!LearningConcept.class.isAssignableFrom(obj.getClass())) {
	        return false;
	    }
	    final LearningConcept other = (LearningConcept) obj;
	    if(this.m_id.equalsIgnoreCase(other.m_id)){
				return true;
	    }
		return false;
	}

	@Override
	public int hashCode() {
	    int hash = 3;
	    hash = 53 * hash + (this.m_id != null ? this.m_id.hashCode() : 0);
	    return hash;
	}
}
