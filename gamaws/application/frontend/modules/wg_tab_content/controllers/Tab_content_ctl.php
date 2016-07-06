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
class Tab_content_ctl extends MX_Controller
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
		$this->class = "Tab_content_ctl";
		$this->module = "wg_tab_content";
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

	private function getMDPageFromHttpHeader(){
		return $this->input->post('mdpage');
	}

	function loadTabContent(){
		$mdpage = $this->getMDPageFromHttpHeader();
		$file_url = $this->getFileNameMDFromAlias($mdpage);
		if($file_url != null){
			$text = $this->url_get_contents(gama_wiki_url() . $file_url);
			echo MarkdownExtra::defaultTransform($text);
		}else{
			echo "";
		}
	}

	function getFileNameMDFromAlias($alias){
		$alias = '"'.$alias.'"';
		$query = "SELECT gm_menu.filename_gh FROM gm_menu WHERE gm_menu.alias LIKE " . $alias;
		$result = $this->db->query($query)->row();
		if($result)
			return $result->filename_gh;
		else
			return null;
	}

	private function url_get_contents2($url) {
		return file_get_contents($url);
	}

	private function url_get_contents($url) {

		//Set stream options
		/*$opts = array(
			'http' => array('ignore_errors' => true)
		);

		//Create the stream context
		$context = stream_context_create($opts);

		//Open the file using the defined context
		$file = file_get_contents($url, false, $context);
		return $file;*/
		/*if (!function_exists('curl_init')){
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;*/

		$url = str_replace(" ", '%20', $url);
		$ch = curl_init();
		$timeout = 5; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}
}

/**
 * --------------------------------------------------
 * LOCATION
 * --------------------------------------------------
 * ./application/modules/sample/controllers/sample.php
 * --------------------------------------------------
 */