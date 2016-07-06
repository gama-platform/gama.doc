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
class Gama_search_ctl extends MX_Controller
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
		$this->class = "Gama_search_ctl";
		$this->module = "wg_gama_search";
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
	public function index()
	{
		$this->template->write_view("metatag","metatag",
			array('meta_title'=>$this->config->item('meta_title'),
				'meta_keywords'=>$this->config->item('meta_keywords'),
				'meta_description'=>$this->config->item('meta_description')
			)
		);
		$this->load->module('wg_gama_nav/gama_nav_ctl');
		$header['gama_nav'] = $this->gama_nav_ctl->getMenu();

		//$search_view['chapters'] = $this->getChapters();
		$search_view['controller'] = $this;

		$this->template->write_view("header","header", $header);
		$this->template->write_view("footer","footer");
		$this->template->write_view("content","gama_search_view", $search_view);
		$this->template->write_view("scrolltotop","scrolltotop");
		$this->template->render();
	}

	private function getKeywordFromHttpHeader(){
        $keyword = trim($this->input->post('keyword'));
		$keyword = preg_replace(' /\s\s+/', ' ', $keyword);
        $keyword = preg_replace(' / /', '_', $keyword);
        $keyword = preg_replace('/-/', '_', $keyword);
        return preg_replace('/\_+/', '_', $keyword);
	}

	private function getWebpageFromHttpHeader(){
		return $this->input->post('webpage');
	}

	private function getKeywordActiveFromHttpHeader(){
		return $this->input->post('anchor');
	}

	public function getKeywordList(){
		$keyword = $this->getKeywordFromHttpHeader();
		$list_keyword = $this->findExactKeywords($keyword);
		$this->getKeywordListOfExactKeyword($list_keyword, $keyword);

		$list_keyword_partial = $this->findKeywords($keyword);
		$this->getKeywordListOfPartialKeyword($list_keyword_partial, $keyword);
	}

	private function getKeywordListOfExactKeyword($list_keyword, $keyword){
		foreach ($list_keyword as $kw) {

			// put in bold the written text
			if((strcmp($kw->category_id, "9") !== 0)
				&& (strcmp($kw->category_id, "10") !== 0)
				&& (strcmp($kw->category_id, "11") !== 0)){
				$kw_bold = str_ireplace($keyword, '<b>'.$keyword.'</b>', $kw->keyword_name)
					." <span class='gama_search_item_blue'>(". trim($kw->category_name).")</span>";
				echo '<li><a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $kw->keyword_name).'\', \''.str_ireplace("'", "\'", $kw->keyword_id).'\')">'.$kw_bold.'</a></li>';
			} else {
				// for article a
				if(strcmp($kw->category_id, "11") == 0){
					$list_ass_keyword = $this->findAssociatedKeywords($kw->idKeywordMD);
					foreach ($list_ass_keyword as $akw) {
						$akw_bold = str_ireplace($keyword, '<b>'.$keyword.'</b>', $kw->keyword_name)
							."<span class='gama_search_item_green'> is a </span>".$kw->category_name."<span class='gama_search_item_green'> of </span>". $akw->category_name . " <span class='gama_search_item_strong'>" . $akw->keyword_name . "</span>";
						echo '<li> <a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $akw->keyword_name).'\', \''.str_ireplace("'", "\'", $akw->keyword_id).'\')">'.$akw_bold.'</a></li>';
					}
				} else{
					// for article an
					$list_ass_keyword = $this->findAssociatedKeywords($kw->idKeywordMD);
					foreach ($list_ass_keyword as $akw) {
						$akw_bold = str_ireplace($keyword, '<b>'.$keyword.'</b>', $kw->keyword_name)
							."<span class='gama_search_item_green'> is an </span>".$kw->category_name."<span class='gama_search_item_green'> of </span>". $akw->category_name . " <span class='gama_search_item_strong'>" . $akw->keyword_name . "</span>";
						echo '<li> <a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $akw->keyword_name).'\', \''.str_ireplace("'", "\'", $akw->keyword_id).'\')">'.$akw_bold.'</a></li>';
					}
				}
				foreach ($list_ass_keyword as $aakw) {
					$list_ass_keyword_second = $this->findAssociatedKeywordsInversely($aakw->idKeywordMD);
					foreach ($list_ass_keyword_second as $aakws) {
						$akw_bold = $aakws->keyword_name
							."<span class='gama_search_item_green'> is associated with </span>". " <span class='gama_search_item_strong'>" . $aakw->keyword_name . "</span>";
						echo '<li> <a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $aakws->keyword_name).'\', \''.str_ireplace("'", "\'", $aakws->keyword_id).'\')">'.$akw_bold.'</a></li>';
					}
				}
			}
		}

		$list_alias_keyword = $this->findAliasKeywords($keyword);
		foreach ($list_alias_keyword as $alias_kw) {
			$alias_kw_bold = "<span class='gama_search_item_green'> do you mean the </span>" .$alias_kw->category_name . " "
				. " <span class='gama_search_item_strong'>"
				. str_ireplace($keyword, '<b>'.$keyword.'</b>', $alias_kw->keyword_name)
				. "</span>";
			// add new option
			echo '<li><a class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $alias_kw->keyword_name).'\', \''.str_ireplace("'", "\'", $alias_kw->keyword_id).'\')">'.$alias_kw_bold.'</a></li>';
		}
	}

	private function getKeywordListOfPartialKeyword($list_keyword, $keyword){

		foreach ($list_keyword as $kw) {

			// put in bold the written text
			if((strcmp($kw->category_id, "9") !== 0)
				&& (strcmp($kw->category_id, "10") !== 0)
				&& (strcmp($kw->category_id, "11") !== 0)){
				$kw_bold = str_ireplace($keyword, '<b>'.$keyword.'</b>', $kw->keyword_name)
						." <span class='gama_search_item_blue'>(". trim($kw->category_name).")</span>";
				// add new option
				echo '<li><a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $kw->keyword_name).'\', \''.str_ireplace("'", "\'", $kw->keyword_id).'\')">'.$kw_bold.'</a></li>';
				//echo $country_name;
			} else {
				if(strcmp($kw->category_id, "11") == 0){
					$list_ass_keyword = $this->findAssociatedKeywords($kw->idKeywordMD);
					//echo count($list_ass_keyword);
					foreach ($list_ass_keyword as $akw) {
						$akw_bold = str_ireplace($keyword, '<b>'.$keyword.'</b>', $kw->keyword_name)
							."<span class='gama_search_item_green'> is a </span>".$kw->category_name."<span class='gama_search_item_green'> of </span>". $akw->category_name . " <span class='gama_search_item_strong'>" . $akw->keyword_name . "</span>";
						// add new option
						echo '<li> <a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $akw->keyword_name).'\', \''.str_ireplace("'", "\'", $akw->keyword_id).'\')">'.$akw_bold.'</a></li>';
					}
				} else{

					$list_ass_keyword = $this->findAssociatedKeywords($kw->idKeywordMD);
					//echo count($list_ass_keyword);
					foreach ($list_ass_keyword as $akw) {
						$akw_bold = str_ireplace($keyword, '<b>'.$keyword.'</b>', $kw->keyword_name)
							."<span class='gama_search_item_green'> is an </span>".$kw->category_name."<span class='gama_search_item_green'> of </span>". $akw->category_name . " <span class='gama_search_item_strong'>" . $akw->keyword_name . "</span>";
						// add new option
						echo '<li> <a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $akw->keyword_name).'\', \''.str_ireplace("'", "\'", $akw->keyword_id).'\')">'.$akw_bold.'</a></li>';
					}
				}
			}
		}
		if(count($list_keyword) === 0){
			$list_alias_keyword = $this->findPartialAliasKeywords($keyword);
			foreach ($list_alias_keyword as $alias_kw) {
				$alias_kw_bold = "<span class='gama_search_item_green'> do you mean the </span>" .$alias_kw->category_name . " "
					. " <span class='gama_search_item_strong'>"
					. str_ireplace($keyword, '<b>'.$keyword.'</b>', $alias_kw->keyword_name)
					. "</span>";
				// add new option
				echo '<li><a class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $alias_kw->keyword_name).'\', \''.str_ireplace("'", "\'", $alias_kw->keyword_id).'\')">'.$alias_kw_bold.'</a></li>';
			}
		}
	}

	function findExactKeywords($keyword){
		$keyword = '"'.$keyword.'"';
		$query_keyword = "SELECT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_keyword INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			. " WHERE gm_keyword.name LIKE " . $keyword;
		$list_keyword = $this->db->query($query_keyword)->result();
		return $list_keyword;
	}

	function findKeywords($m_keyword){
		$keyword = '"%'.$m_keyword.'%"';
		$not_keyword = '"'.$m_keyword.'"';
		$query_keyword = "SELECT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_keyword INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			. " WHERE gm_keyword.name LIKE " . $keyword . " and gm_keyword.name NOT LIKE " . $not_keyword;
		$list_keyword = $this->db->query($query_keyword)->result();
		return $list_keyword;
	}

	function findAssociatedKeywordsInversely($idKeywordMD){
		$idKeywordMD = '"'.$idKeywordMD.'"';
		$query_keyword = "(SELECT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_keyword INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			. " WHERE gm_keyword.id IN "
			. " (SELECT gm_association_keywork_category.idAssociatedKeyword "
			. " FROM gm_association_keywork_category "
			. " INNER JOIN gm_keyword ON gm_keyword.id = gm_association_keywork_category.idKeyword "
			. " WHERE SUBSTRING(gm_keyword.idKeywordMD, 1, 50) = SUBSTRING(" . $idKeywordMD . ", 1, 50)))"
		    . " UNION (SELECT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_keyword INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			. " WHERE SUBSTRING(gm_category.name, 1, 50) = SUBSTRING('concept', 1, 50) "
			. " AND gm_keyword.id IN  "
			. " (SELECT gm_association_keywork_category.idKeyword "
			. " FROM gm_association_keywork_category "
			. " INNER JOIN gm_keyword ON gm_keyword.id = gm_association_keywork_category.idAssociatedKeyword "
			. " WHERE SUBSTRING(gm_keyword.idKeywordMD, 1, 50) = SUBSTRING(" . $idKeywordMD . ", 1, 50)))";
		$list_keyword = $this->db->query($query_keyword)->result();
		return $list_keyword;
	}

	function findAssociatedKeywords($idKeywordMD){
		$idKeywordMD = '"'.$idKeywordMD.'"';
		$query_keyword = "SELECT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_keyword INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			. " WHERE gm_keyword.id IN "
			. " (SELECT gm_association_keywork_category.idAssociatedKeyword "
			. " FROM gm_association_keywork_category "
			. " INNER JOIN gm_keyword ON gm_keyword.id = gm_association_keywork_category.idKeyword "
			. " WHERE SUBSTRING(gm_keyword.idKeywordMD, 1, 50) = SUBSTRING(" . $idKeywordMD . ", 1, 50))";
		$list_keyword = $this->db->query($query_keyword)->result();
		return $list_keyword;
	}

	function findAliasKeywords($keyword){
		$keyword = '"'.$keyword.'"';
		$query_keyword = "SELECT DISTINCT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_alias INNER JOIN gm_keyword ON SUBSTRING(gm_alias.attachedKeywordName, 1, 50) = SUBSTRING(gm_keyword.name, 1, 50)"
			. " INNER JOIN gm_category ON gm_category.id = gm_keyword.idCategory"
			. " WHERE gm_alias.name LIKE " . $keyword;
		return $this->db->query($query_keyword)->result();
	}

	function findPartialAliasKeywords($m_keyword){
		$not_keyword = '"'.$m_keyword.'"';
		$keyword = '"%'.$m_keyword.'%"';
		$query_keyword = "SELECT DISTINCT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, gm_category.id as category_id, gm_category.name as category_name "
			. " FROM gm_alias INNER JOIN gm_keyword ON SUBSTRING(gm_alias.attachedKeywordName, 1, 50) = SUBSTRING(gm_keyword.name, 1, 50)"
			. " INNER JOIN gm_category ON gm_category.id = gm_keyword.idCategory"
			. " WHERE gm_alias.name LIKE " . $keyword . " and gm_alias.name NOT LIKE " . $not_keyword;
		return $this->db->query($query_keyword)->result();
	}

	public function getWebpageList(){
		$keyword = $this->input->post('keyword_id');

		$list_webpage_docpage = $this->findWebpagesByDocpage($keyword, null);
        if(count($list_webpage_docpage) > 0){
            echo '<div class="'.'input-container-header'.'"> Documentation </div>';
            foreach($list_webpage_docpage as $webpage){
                //echo $webpage->file_gh. $webpage->webpage_anchor. $webpage->webpage_name;
                $url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
                echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'. $webpage->description .'</a></li>';

            }
        }

		/*$list_webpage_refpage = $this->findWebpagesByRefpage($keyword);
		echo '<div class="'.'input-container-header'.'">GAML References </div>';
		foreach($list_webpage_refpage as $webpage){
			$url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
			echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'. $webpage->description .'</a></li>';

		}*/

        $this->listWebpageRefpage($keyword);

		$list_webpage_modelpage = $this->findWebpagesByModelLib($keyword, null);
        if(count($list_webpage_modelpage) > 0) {
            echo '<div class="' . 'input-container-header' . '">Model Library</div>';
            foreach ($list_webpage_modelpage as $webpage) {
                $url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
                echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">' . $webpage->description . '</a></li>';

            }
        }
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

	// pay attention to gm_webpage.name as webpage_name or gm_menu.alias as webpage_name
	function findWebpagesByDocpage($keyword, $webpage){
		$filter_webpage = "";
		if ($webpage != null){
			$filter_webpage = " and gm_menu.alias not like '" . $webpage . "'";
		}
		$query_keyword = "SELECT DISTINCT gm_menu.description as description, gm_keyword.name as keyword_name, gm_webpage.id as webpage_id, "
			. " gm_menu.alias as webpage_name, gm_webpage.webpageCategory as webpage_category, "
			. " gm_association_webpage_keywork.anchor as webpage_anchor, gm_menu.filename_gh as file_gh "
			. " FROM gm_association_webpage_keywork INNER JOIN gm_keyword ON gm_keyword.id = gm_association_webpage_keywork.idKeyword "
			. " INNER JOIN gm_webpage ON gm_association_webpage_keywork.idWebpage = gm_webpage.id "
			. " INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id WHERE gm_keyword.id = " . $keyword
			. " and gm_webpage.webpageCategory like '%docPage%' " . $filter_webpage;
		return $this->db->query($query_keyword)->result();
	}

	function findWebpagesByRefpage($keyword, $webpage){
		$filter_webpage = "";
		if ($webpage != null){
			$filter_webpage = " and gm_menu.alias not like '" . $webpage . "'";
		}
		$query_keyword = "SELECT DISTINCT gm_menu.description as description, gm_keyword.name as keyword_name, gm_webpage.id as webpage_id, "
            . " gm_menu.alias as webpage_name, gm_webpage.webpageCategory as webpage_category, gm_category.name as category_name, "
            . " gm_association_webpage_keywork.anchor as webpage_anchor, gm_menu.filename_gh as file_gh "
            . " FROM gm_association_webpage_keywork "
            . " INNER JOIN gm_keyword ON gm_keyword.id = gm_association_webpage_keywork.idKeyword "
            . " INNER JOIN gm_category ON gm_keyword.idCategory = gm_category.id "
            . " INNER JOIN gm_webpage ON gm_association_webpage_keywork.idWebpage = gm_webpage.id "
            . " INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id WHERE gm_keyword.id = " . $keyword
            . " and gm_webpage.webpageCategory like '%gamlRefPage%' " . $filter_webpage . " ORDER BY gm_category.id ";
		return $this->db->query($query_keyword)->result();
	}

    function findWebpagesByRefpageWithFilterCategories($keyword, $webpage){
		$filter_webpage = "";
		if ($webpage != null){
			$filter_webpage = " and gm_menu.alias not like '" . $webpage . "'";
		}
        $query_keyword = "SELECT DISTINCT gm_menu.description as description, gm_keyword.name as keyword_name, gm_webpage.id as webpage_id, "
            . " gm_menu.alias as webpage_name, gm_webpage.webpageCategory as webpage_category, gm_category.name as category_name, "
            . " gm_association_webpage_keywork.anchor as webpage_anchor, gm_menu.filename_gh as file_gh "
            . " FROM gm_association_webpage_keywork "
            . " INNER JOIN gm_keyword ON gm_keyword.id = gm_association_webpage_keywork.idKeyword "
            . " INNER JOIN gm_category ON gm_keyword.idCategory = gm_category.id "
            . " INNER JOIN gm_webpage ON gm_association_webpage_keywork.idWebpage = gm_webpage.id "
            . " INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id WHERE gm_keyword.id = " . $keyword
            . " and gm_webpage.webpageCategory like '%gamlRefPage%'" .$filter_webpage;
        //echo $this->db->query($query_keyword)->result_array();
        return $this->db->query($query_keyword)->result_array();
    }

	function findWebpagesByModelLib($keyword, $webpage){
		$filter_webpage = "";
		if ($webpage != null){
			$filter_webpage = " and gm_menu.alias not like '" . $webpage . "'";
		}
		$query_keyword = "SELECT DISTINCT gm_menu.description as description, gm_keyword.name as keyword_name, gm_webpage.id as webpage_id, "
			. " gm_menu.alias as webpage_name, gm_webpage.webpageCategory as webpage_category, "
			. " gm_association_webpage_keywork.anchor as webpage_anchor, gm_menu.filename_gh as file_gh "
			. " FROM gm_association_webpage_keywork INNER JOIN gm_keyword ON gm_keyword.id = gm_association_webpage_keywork.idKeyword "
			. " INNER JOIN gm_webpage ON gm_association_webpage_keywork.idWebpage = gm_webpage.id "
			. " INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id WHERE gm_keyword.id = " . $keyword
			. " and gm_webpage.webpageCategory like '%modelPage%' " . $filter_webpage;
		return $this->db->query($query_keyword)->result();
	}


    function getCategoryList(){
        $query = "SELECT gm_category.name as category_name FROM gm_category";
        return $this->db->query($query)->result();
    }

    function filterArrays($arrayValues, $key, $value) {
        return array_filter($arrayValues,
            function($entry) use ($key, $value) {
                return $entry[$key] == $value;
            }
        );
    }

	function listWebpageRefpage($keyword_id){
		$keyword = $this->getKeyword($keyword_id);
		$list_keywords = [];
		if(strcmp($keyword->category_id, "1") == 0){
			$list_keywords = $this->findAssociatedKeywordsInversely($keyword->idKeywordMD);
		} else{
			$list_keywords[] = $keyword;
		}

		$list_webpage_refpage = [];
		foreach ($list_keywords as $kw) {
			$arr = $this->findWebpagesByRefpageWithFilterCategories($kw->keyword_id, null);
			array_splice($list_webpage_refpage, count($list_webpage_refpage), 0, $arr);
		}

		//print_r($list_webpage_refpage);
		if(count($list_webpage_refpage) > 0){
			$list_categories = $this->getCategoryList();
			echo '<div class="'.'input-container-header'.'">GAML References</div>';
			foreach($list_categories as $category){
				$list_webpage_refpage_category = $this->filterArrays($list_webpage_refpage,'category_name', $category->category_name);
				if(count($list_webpage_refpage_category) > 0){
					echo '<div class="'.'input-container-header-refpage'.'">' . trim($category->category_name) . '</div>';
				}
				foreach($list_webpage_refpage_category as $webpage){
					$url = site_url($this->getRoute($webpage['file_gh'], $webpage['webpage_anchor'], $webpage['webpage_name']));
					echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'. $webpage['keyword_name'] .'</a></li>';
					//var_dump($url);
				}
			}
		}
	}


	//-============== SEARCH BY WEBPAGE

	public function getAutomaticKeywordList(){
		$webpage = $this->getWebpageFromHttpHeader();
		$list_keyword = $this->findKeywordsInWebpage($webpage);
		foreach($list_keyword as $keyword){
			$list_keyword_exact = $this->findExactKeywords($keyword->keyword_name);
			$this->getKeywordListOfExactKeyword($list_keyword_exact, $keyword->keyword_name);

			//$list_keyword_partial = $this->findKeywords($keyword);
			//$this->getKeywordListOfPartialKeyword($list_keyword_partial, $keyword);
		}
	}

	private function showKeywordList($list_keyword){
		foreach($list_keyword as $keyword){

			if((strcmp($keyword->category_id, "9") !== 0)
				&& (strcmp($keyword->category_id, "10") !== 0)
				&& (strcmp($keyword->category_id, "11") !== 0)){
				$kw_bold = $keyword->keyword_name;
					//." <span class='gama_search_item_blue'>(". trim($keyword->category_name).")</span>";
				echo '<li><a  class="gama_search_item" onclick="setItem(\''.str_ireplace("'", "\'", $keyword->keyword_name).'\', \''.str_ireplace("'", "\'", $keyword->keyword_id).'\')">'.$kw_bold.'</a></li>';
			}
		}
	}

	function getAutomaticWebpageList(){
		$webpage = $this->getWebpageFromHttpHeader();
		$list_keyword = $this->findKeywordsInWebpage($webpage);
		if(strcmp($this->getCategoryOfWebpage($webpage), "docPage") == 0){
			$this->getWebpagesOfDocpageFromKeywords($list_keyword, $webpage);
		}
		if(strcmp($this->getCategoryOfWebpage($webpage), "gamlRefPage") == 0){
			$this->getWebpagesOfRefpageFromKeywords($list_keyword, $webpage);
		}
		if(strcmp($this->getCategoryOfWebpage($webpage), "modelPage") == 0){
			$this->getWebpagesOfModelLibpageFromKeywords($list_keyword, $webpage);
		}
	}

	private function getWebpagesOfRefpageFromKeywords($list_keyword, $webpage){
		$anchor = $this->getKeywordActiveFromHttpHeader();
		$keyword = $this->findKeywordByAnchor($anchor);

		$this->getWebpagesOfDocpageFromKeywordsByDocpage($keyword, $webpage);
		$this->getWebpagesOfDocpageFromKeywordsByModelLib($keyword, $webpage);
	}

	private function getWebpagesOfModelLibpageFromKeywords($list_keyword, $webpage){
		$this->getWebpagesOfDocpageFromKeywordsByDocpage($list_keyword, $webpage);
		$this->getWebpagesOfDocpageFromKeywordsByRefpage($list_keyword, $webpage);
	}

	private function getWebpagesOfDocpageFromKeywords($list_keyword, $webpage){
		$this->getWebpagesOfDocpageFromKeywordsByDocpageWithHeaderConcept($list_keyword, $webpage);
		$this->getWebpagesOfDocpageFromKeywordsByRefpageWithHeaderConceptAndOthers($list_keyword, $webpage);
		$this->getWebpagesOfDocpageFromKeywordsByModelLibWithHeaderConcept($list_keyword, $webpage);
		$this->getConceptKeywordsByDocpageWithoutHeaderConcept($list_keyword, $webpage);
	}

	private function findKeywordByAnchor($anchor){
		$anchor = '"'.$anchor.'"';
		$query = "SELECT DISTINCT gm_keyword.name as keyword_name, gm_keyword.id as keyword_id, gm_keyword.id, gm_keyword.idKeywordMD, "
			." gm_category.id as category_id, gm_category.name as category_name, gm_webpage.webpageCategory as webpage_category "
			." FROM gm_keyword INNER JOIN gm_association_webpage_keywork ON gm_keyword.id = gm_association_webpage_keywork.idKeyword "
			. " INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			." INNER JOIN gm_webpage ON gm_webpage.id = gm_association_webpage_keywork.idWebpage "
			." INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id "
			." WHERE gm_association_webpage_keywork.anchor like " . $anchor;
		return $this->db->query($query)->result();
	}


	private function getWebpagesOfDocpageFromKeywordsByDocpage($list_keyword, $webpage_name){

		foreach ($list_keyword as $aakw) {
			$list_ass_keyword_second = $this->findAssociatedKeywordsInversely($aakw->idKeywordMD);
			array_splice($list_keyword, count($list_keyword), 0, $list_ass_keyword_second);
		}

		$flag_title = 0;
		foreach($list_keyword as $keyword_ele){
			$keyword = $keyword_ele->keyword_id;

			$list_webpage_docpage = $this->findWebpagesByDocpage($keyword, $webpage_name);
			if(count($list_webpage_docpage) > 0 && $flag_title == 0){
				echo '<div class="'.'input-container-header'.'"> Documentation </div>';
				$flag_title = 1;
			}
			foreach($list_webpage_docpage as $webpage){
				//echo $webpage->file_gh. $webpage->webpage_anchor. $webpage->webpage_name;
				$url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
				echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'
					. $webpage->description
					. ' <span class="gama_search_item_blue">[' . $keyword_ele->keyword_name . '<span class="gama_search_item_green"> (' . $keyword_ele->category_name . ') </span>]</span> '
					.'</a></li>';

			}
		}
	}

	private function getWebpagesOfDocpageFromKeywordsByDocpageWithHeaderConcept($list_keyword, $webpage_name){
		$flag_title = 0;
		foreach($list_keyword as $keyword_ele){
			if((strcmp($keyword_ele->category_id, "1") == 0) && $keyword_ele->is_header) {
				$keyword = $keyword_ele->keyword_id;
				$list_webpage_docpage = $this->findWebpagesByDocpage($keyword, $webpage_name);
				if (count($list_webpage_docpage) > 0 && $flag_title == 0) {
					echo '<div class="' . 'input-container-header' . '"> Documentation </div>';
					$flag_title = 1;
				}
				foreach ($list_webpage_docpage as $webpage) {
					//echo $webpage->file_gh. $webpage->webpage_anchor. $webpage->webpage_name;
					$url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
					echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'
						. $webpage->description
						. ' <span class="gama_search_item_blue">[' . $keyword_ele->keyword_name . '<span class="gama_search_item_green"> (' . $keyword_ele->category_name . ') </span>]</span> '
						. '</a></li>';

				}
			}
		}
	}

	private function getConceptKeywordsByDocpageWithoutHeaderConcept($list_keyword, $webpage_name){
		foreach($list_keyword as $index => $keyword_ele){
			if(!(strcmp($keyword_ele->category_id, "1") == 0) || $keyword_ele->is_header) {
				unset($list_keyword[$index]);
			}
		}
		if(count($list_keyword) > 0){
			echo '<div class="'.'input-container-header-other'.'"> Other concepts associated </div>';
		}
		$this->showKeywordList($list_keyword);
	}

	private function getWebpagesOfDocpageFromKeywordsByRefpage($list_keyword, $webpage_name){
		$flag_title = 0;
		$list_filter_refpage  = [];
		foreach($list_keyword as $keyword_ele) {
			//$keyword_id = $keyword_ele->keyword_id;

			//$keyword = $this->getCategoryOfKeyword($keyword_id);
			$list_keywords = [];
			if((strcmp($keyword_ele->category_id, "1") == 0)){
				$list_keywords = $this->findAssociatedKeywordsInversely($keyword_ele->idKeywordMD);
			} else{
				$list_keywords[] = $keyword_ele;
			}

			$list_webpage_refpage = [];
			foreach ($list_keywords as $kw) {
				$arr = $this->findWebpagesByRefpageWithFilterCategories($kw->keyword_id, $webpage_name);
				array_splice($list_webpage_refpage, count($list_webpage_refpage), 0, $arr);
			}

			array_splice($list_filter_refpage, count($list_filter_refpage), 0, $list_webpage_refpage);

			//print_r($list_filter_refpage);

		}
		//print_r($list_filter_refpage);

		if(count($list_filter_refpage) > 0){
			if($flag_title == 0){
				echo '<div class="'.'input-container-header'.'">GAML References</div>';
				$flag_title = 1;
			}
			$list_categories = $this->getCategoryList();
			foreach($list_categories as $category){
				$list_webpage_refpage_category = $this->filterArrays($list_filter_refpage,'category_name', $category->category_name);

				if(count($list_webpage_refpage_category) > 0){
					/*if(strcmp($keyword->category_id, "1") == 0){
						echo '<div class="'.'input-container-header-refpage'.'">' . trim($category->category_name)
							. ' <span class="gama_search_item_white"> associated with </span>'
							. '<span class="gama_search_item_blue">[ ' . $keyword_ele->keyword_name . '<span class="gama_search_item_green"> (' . $keyword_ele->category_name . ') </span> ] </span> '
							. ' </div>';
					}
					else{*/
					echo '<div class="'.'input-container-header-refpage'.'">' . trim($category->category_name)
						. ' </div>';
					/*}*/

				}
				$list_exist_anchor = [];
				foreach($list_webpage_refpage_category as $webpage){
					if(!in_array($webpage['webpage_anchor'], $list_exist_anchor)){
						$list_exist_anchor[] = $webpage['webpage_anchor'];
						$url = site_url($this->getRoute($webpage['file_gh'], $webpage['webpage_anchor'], $webpage['webpage_name']));
						echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'. $webpage['keyword_name'] .'</a></li>';
						//var_dump($url);
					}
				}
			}
		}
	}

	private function getWebpagesOfDocpageFromKeywordsByRefpageWithHeaderConceptAndOthers($list_keyword, $webpage_name){
		$list_filter_refpage  = [];
		foreach($list_keyword as $keyword_ele) {
			$list_keywords = [];
			if((strcmp($keyword_ele->category_id, "1") == 0)){
				if($keyword_ele->is_header){
					$list_keywords = $this->findAssociatedKeywordsInversely($keyword_ele->idKeywordMD);
				}
			} else{
				$list_keywords[] = $keyword_ele;
			}

			$list_webpage_refpage = [];
			foreach ($list_keywords as $kw) {
				$arr = $this->findWebpagesByRefpageWithFilterCategories($kw->keyword_id, $webpage_name);
				array_splice($list_webpage_refpage, count($list_webpage_refpage), 0, $arr);
			}
			array_splice($list_filter_refpage, count($list_filter_refpage), 0, $list_webpage_refpage);
		}
		//print_r($list_filter_refpage);

		if(count($list_filter_refpage) > 0){
			echo '<div class="'.'input-container-header'.'">GAML References</div>';
			$list_categories = $this->getCategoryList();
			foreach($list_categories as $category){
				$list_webpage_refpage_category = $this->filterArrays($list_filter_refpage,'category_name', $category->category_name);

				if(count($list_webpage_refpage_category) > 0){
					echo '<div class="'.'input-container-header-refpage'.'">' . trim($category->category_name)
						. ' </div>';

				}
				$list_exist_anchor = [];
				foreach($list_webpage_refpage_category as $webpage){
					if(!in_array($webpage['webpage_anchor'], $list_exist_anchor)) {
						$list_exist_anchor[] = $webpage['webpage_anchor'];
						$url = site_url($this->getRoute($webpage['file_gh'], $webpage['webpage_anchor'], $webpage['webpage_name']));
						echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">' . $webpage['keyword_name'] . '</a></li>';
						//var_dump($url);
					}
				}
			}
		}
	}


	private function getWebpagesOfDocpageFromKeywordsByModelLib($list_keyword, $webpage_name){
		$flag_title = 0;
		foreach($list_keyword as $keyword_ele) {
			$keyword = $keyword_ele->keyword_id;

			$list_webpage_modelpage = $this->findWebpagesByModelLib($keyword, $webpage_name);
			if (count($list_webpage_modelpage) > 0 && $flag_title == 0) {
				echo '<div class="' . 'input-container-header' . '"> Model library </div>';
				$flag_title = 1;
			}
			foreach ($list_webpage_modelpage as $webpage) {
				$url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
				echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'
					. $webpage->description
					. ' <span class="gama_search_item_blue">[' . $keyword_ele->keyword_name . '<span class="gama_search_item_green"> (' . $keyword_ele->category_name . ') </span>]</span> '
					 . '</a></li>';

			}
		}
	}

	private function getWebpagesOfDocpageFromKeywordsByModelLibWithHeaderConcept($list_keyword, $webpage_name){
		$flag_title = 0;
		foreach($list_keyword as $keyword_ele) {
			if((strcmp($keyword_ele->category_id, "1") == 0) && $keyword_ele->is_header)
			{
				$keyword = $keyword_ele->keyword_id;

				$list_webpage_modelpage = $this->findWebpagesByModelLib($keyword, $webpage_name);
				if (count($list_webpage_modelpage) > 0 && $flag_title == 0) {
					echo '<div class="' . 'input-container-header' . '"> Model library </div>';
					$flag_title = 1;
				}
				foreach ($list_webpage_modelpage as $webpage) {
					$url = site_url($this->getRoute($webpage->file_gh, $webpage->webpage_anchor, $webpage->webpage_name));
					echo '<li> <a  class="gama_search_item" onclick="gotoSearchResult(' . "'" . $url . "'" . ');">'
						. $webpage->description
						. ' <span class="gama_search_item_blue">[' . $keyword_ele->keyword_name . '<span class="gama_search_item_green"> (' . $keyword_ele->category_name . ') </span>]</span> '
						. '</a></li>';

				}
			}
		}
	}

	private function findKeywordsInWebpage($webpage){
		$webpage = '"'.$webpage.'"';
		$query = "SELECT DISTINCT gm_keyword.name as keyword_name, gm_keyword.id as keyword_id, gm_keyword.idKeywordMD, gm_association_webpage_keywork.isInHeader as is_header, "
			." gm_category.id as category_id, gm_category.name as category_name, gm_webpage.webpageCategory as webpage_category "
			." FROM gm_keyword INNER JOIN gm_association_webpage_keywork ON gm_keyword.id = gm_association_webpage_keywork.idKeyword "
			. " INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory "
			." INNER JOIN gm_webpage ON gm_webpage.id = gm_association_webpage_keywork.idWebpage "
			." INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id "
			." WHERE gm_menu.alias like " . $webpage;
		return $this->db->query($query)->result();
	}

	function getKeyword($keyword){
		$query = "SELECT gm_keyword.id as keyword_id, gm_keyword.name as keyword_name, gm_keyword.idKeywordMD, "
			." gm_category.id as category_id, gm_category.name as category_name"
			." FROM gm_keyword INNER JOIN gm_category ON gm_category.id=gm_keyword.idCategory"
			." WHERE gm_keyword.id = " . $keyword;
		return $this->db->query($query)->row();
	}

	function getCategoryOfWebpage($webpage){
		$webpage = '"'.$webpage.'"';
		$query = "SELECT gm_webpage.webpageCategory as webpage_category "
			." FROM gm_webpage "
			." INNER JOIN gm_menu ON gm_webpage.idMenu = gm_menu.id "
			." WHERE gm_menu.alias like " . $webpage;
		$result = $this->db->query($query)->row();
		if($result)
			return $result->webpage_category;
		else
			return null;
	}
}

/**
 * --------------------------------------------------
 * LOCATION
 * --------------------------------------------------
 * ./application/modules/sample/controllers/sample.php
 * --------------------------------------------------
 */