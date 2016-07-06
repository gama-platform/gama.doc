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
class Tutorials_ctl extends MX_Controller
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
		$this->class = "Tutorials_ctl";
		$this->module = "tutorials";
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
		$data = array();

		$this->template->write_view("metatag","metatag",
			array('meta_title'=>$this->config->item('meta_title'),
				'meta_keywords'=>$this->config->item('meta_keywords'),
				'meta_description'=>$this->config->item('meta_description')
			)
		);
		$this->load->module('wg_gama_nav/gama_nav_ctl');
		$header['gama_nav'] = $this->gama_nav_ctl->getMenu();

		$tutorials_view['chapters'] = $this->getChapters();
		$tutorials_view['gama_step_by_step'] = $this->getSectionsGAMAStepByStep();
		$tutorials_view['recipes'] = $this->getSectionsRecipes();
		$tutorials_view['thematic_tutorials'] = $this->getSectionsThematicTutorials();
		$tutorials_view['controller'] = $this;

		$this->template->write_view("header","header", $header);
		$this->template->write_view("footer","footer");
		$this->template->write_view("content","tutorials_view", $tutorials_view);
		$this->template->write_view("scrolltotop","scrolltotop");
		$this->template->render();
	}

	function getChapters(){
		$rows = $this->getMenuSubItems('2');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSectionsGAMAStepByStep(){
		$rows = $this->getMenuSubItems('9');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSectionsRecipes(){
		$rows = $this->getMenuSubItems('6');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSectionsThematicTutorials(){
		$rows = $this->getMenuSubItems('10');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSubMenu($sub_item_id){
		$rows = $this->getMenuSubItems($sub_item_id);
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
		//return $this->load->view('gama_nav_view',array('rows'=>$rows), true);
	}

	function getSubMenuAsString($sub_item_id){
		$rows = $this->getMenuSubItems($sub_item_id);
		$str = "<ul class='sidebar-popover-ul'>";
		foreach($rows as $row){
			$str = $str."<li>".$row->title."</li>";
		}
		return $str."</ul>";
		//return $this->load->view('gama_nav_view',array('rows'=>$rows), true);
	}

	function getMenuSubItems($sub_item_id){
		$query = "SELECT id,title,description,alias,filename_gh FROM gm_menu WHERE parent_id = $sub_item_id ORDER BY previous ASC";
		return $this->db->query($query)->result();
	}
}

/**
 * --------------------------------------------------
 * LOCATION
 * --------------------------------------------------
 * ./application/modules/sample/controllers/sample.php
 * --------------------------------------------------
 */