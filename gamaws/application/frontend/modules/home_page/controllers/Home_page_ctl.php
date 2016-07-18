<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_page_ctl extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct() {
        parent::__construct();

		$this->template->set_template('home');  //load home template
		//load area of template
		$this->template->write_view("metatag","metatag",
			array('meta_title'=>$this->config->item('meta_title'),
				'meta_keywords'=>$this->config->item('meta_keywords'),
				'meta_description'=>$this->config->item('meta_description')
			)
		);

		/*$this->load->widget("wg_gama_nav");
		$data['wg_gama_nav'] = $this->wg_gama_nav->run();*/

        $this->load->module('wg_gama_nav/gama_nav_ctl');
        $data['gama_nav'] = $this->gama_nav_ctl->getMenu();

        $this->template->write_view("header","header", $data);
		$this->template->write_view("footer","footer");
		$this->template->write_view("scrolltotop","scrolltotop");
    }

	public function index()
	{
        $this->template->write_view('content','home_page/home_page');
		$this->template->render();
	}
}
