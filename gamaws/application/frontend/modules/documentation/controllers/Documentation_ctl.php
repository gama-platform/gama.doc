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
class Documentation_ctl extends MX_Controller
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
		$this->class = "Documentation_ctl";
		$this->module = "documentation";
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
		$data['gama_nav'] = $this->gama_nav_ctl->getMenu();

		$ref_view['models_library'] = $this->getSectionsModelsLibrary();
		$ref_view['platform_documentation'] = $this->getSectionsPlatformDocumentation();
		$ref_view['plugin_documentation'] = $this->getSectionsPluginDocumentation();
		$ref_view['gaml_references'] = $this->getSectionsGAMLReferences();
		$ref_view['controller'] = $this;

		$this->template->write_view("header","header", $data);
		$this->template->write_view("footer","footer");
		$this->template->write_view("content","documentation_view",$ref_view);
		$this->template->write_view("scrolltotop","scrolltotop");
		$this->template->render();
	}

	function getSectionsModelsLibrary(){
		$rows = $this->getMenuSubItems('11');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSectionsPlatformDocumentation(){
		$rows = $this->getMenuSubItems('12');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSectionsGAMLReferences(){
		$rows = $this->getMenuSubItems('13');
		foreach($rows as $key=>$row){
			$rows[$key]->link = site_url($row->alias);
		}
		return $rows;
	}

	function getSectionsPluginDocumentation(){
		$rows = $this->getMenuSubItems('19');
		foreach($rows as $key=>$row){
			$link = trim($row->alias);
			//$link = preg_replace('/[^A-Za-z0-9\-]/', '', $link);
			$rows[$key]->link = $link;
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