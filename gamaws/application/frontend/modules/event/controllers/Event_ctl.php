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
class Event_ctl extends MX_Controller
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
		$this->class = "Event_ctl";
		$this->module = "event";
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
		$this->template->write_view("header","header");
		$this->template->write_view("footer","footer");
		$this->template->write_view("content","event_view");
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