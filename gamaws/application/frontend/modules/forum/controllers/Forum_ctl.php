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
class Forum_ctl extends MX_Controller
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
		$this->class = "Forum_ctl";
		$this->module = "forum";
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

		$this->template->write_view("header","header", $data);
		$this->template->write_view("footer","footer");
		$this->template->write_view("content","forum_view");
		$this->template->write_view("scrolltotop","scrolltotop");
		$this->template->render();
	}
}

/**
 * --------------------------------------------------
 * LOCATION
 * --------------------------------------------------
 * ./application/modules/sample/controllers/sample.php
 * --------------------------------------------------
 */