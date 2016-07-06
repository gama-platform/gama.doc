<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * --------------------------------------------------
 * Sample widgets
 * --------------------------------------------------
 * @param string $widgets
 * @param string $class
 * @param string $view_dir
 * @return void
 * --------------------------------------------------
 */
class Learning_path_ctl extends MX_Controller
{

	private $module, $class, $view_dir;
	/**
	 * --------------------------------------------------
	 * controller constructor
	 * --------------------------------------------------
	 * @access public
	 * @return void
	 * --------------------------------------------------
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->class = "Learning_path_ctl";
		$this->module = "wg_learning_path";
		$this->router->fetch_class();
    }

	/**
	 * --------------------------------------------------
	 * home page for the  widgets
	 * --------------------------------------------------
	 * @access public
	 * @return void
	 * --------------------------------------------------
	 */

	private function getListOfConceptsFromHttpHeader(){
		return $this->input->post('currentPath');
	}

	function getConceptList(){
		$list_concepts_id = $this->getListOfConceptsFromHttpHeader();
		$list_concepts_id = array_reverse($list_concepts_id);
		$last = 1;
		foreach ($list_concepts_id as $id_concept) {
			$concept = $this->findConceptbyIdConcept($id_concept);
			$active = "";
			if($last == count($list_concepts_id)) {
				$active = " active";
			}
			if($concept != null){
				//var_dump($id_concept);
				//var_dump($concept);
				$url = site_url($this->getRoute($concept->file_gh, $concept->webpage_anchor, $concept->webpage_name));

				echo '<div class="post"> <div class="post-inner"> <a  class="gama_learing_path_item  '. $active . '" id="' . $concept->id_concept . '" onclick="gotoLearningPath(' . "this," . "'" . $url . "'" . '); return false;">'
					. $concept->description
					. ' <span class="gama_search_item_blue '. $active . ' ">[' . str_replace('\n', ' ', $concept->learning_concept_name) . ']</span> '
					.'</a></div></div>';

				/*echo '<div class="post"> <div class="post-inner"> <a  class="gama_learing_path_item'. $active . '" id="' . $concept->id_concept . '"'  . 'href="' . $url . '"' . '>'
					. $concept->description
					. ' <span class="gama_search_item_blue '. $active . ' ">[' . $concept->id_concept . ']</span> '
					.'</a></div></div>';*/
			}else{
				echo '<div class="post"> <div class="post-inner"> '
					. ' <span class="gama_search_item_blue  '. $active . ' ">[' . $id_concept . ']</span> '
					.'</div></div>';
			}
			$last ++;
		}
	}

	function findConceptbyIdConcept($id_concept){
		$query_keyword = "SELECT DISTINCT gm_menu.description as description, gm_learning_concept.name as learning_concept_name, gm_webpage.id as webpage_id, "
			. " gm_menu.alias as webpage_name, gm_webpage.webpageCategory as webpage_category, gm_learning_concept.idConcept as id_concept, "
			. " gm_association_webpage_learning_concept.beginAnchor as webpage_anchor, gm_menu.filename_gh as file_gh "
			. " FROM gm_association_webpage_learning_concept INNER JOIN gm_learning_concept ON gm_learning_concept.id = gm_association_webpage_learning_concept.idConcept "
			. " INNER JOIN gm_webpage ON gm_association_webpage_learning_concept.idWebpage = gm_webpage.id "
			. " INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id WHERE gm_learning_concept.idConcept like '" . $id_concept . "'";
		return $this->db->query($query_keyword)->row();
	}

	function getRoute($filename_gh, $anchor, $webpage_name){
		//echo explode("/", $filename_gh, 3)[1];
		if (strcmp(explode("/", $filename_gh, 3)[1], 'References') == 0){

			return "references#" . $webpage_name . "#" . $anchor;
		}
		else{
			if (strcmp(explode("/", $filename_gh, 3)[1], 'Tutorials') == 0){
				return "tutorials#" . $webpage_name . "#" . $anchor;
			}
			else{
				return $webpage_name . "#" . $anchor;
			}
		}
	}
}

/**
 * --------------------------------------------------
 * LOCATION
 * --------------------------------------------------
 * ./application/modules/sample/controllers/sample.php
 * --------------------------------------------------
 */