<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of widgets
 *
 * @author u.farooq
 * 
 * @property CI_DB_active_record $db
 */
class Widgets {
    //put your code here
    private $_ci;
    protected $parser_enable = FALSE;
    
    function __construct() {
        $this->widgets();
    }
    
    function widgets(){
        $this->_ci =& get_instance();
       // $this->_lang = $this->lang->active_lang;
        //$this->_domain_id = $this->sys_lib->domain_id;
    }

    function build($view,$data=array()){
        $view = get_class($this).'/'.$view;
        $subdir = '';
        if (strpos($view, '/') !== FALSE)
        {
                // explode the path so we can separate the filename from the path
                $x = explode('/', $view);

                // Reset the $class variable now that we know the actual filename
                $view = end($x);

                // Kill the filename from the array
                unset($x[count($x)-1]);

                // Glue the path back together, sans filename
                $subdir = implode($x, '/').'/';
        }

        $widget_view = APPPATH.'widgets/'.$subdir.'views/'.$view.EXT;

        if(file_exists($widget_view)){
            $widget_view = '../widgets/'.$subdir.'views/'.$view.EXT;
            if($this->parser_enable){
                $this->_ci->load->library('parser');
               return $this->_ci->parser->parse($widget_view,$data,TRUE);
            }
            else{
                return $this->_ci->load->view($widget_view,$data,TRUE);
            }
        }
        
        return FALSE;
    }
    
    function set_js($js = array(),$group = null,$combine = TRUE, $minify = TRUE) {
        
        if(is_null($group)){
            $this->carabiner->js($js,'',$combine,$minify);
        }
        else{
            $this->carabiner->group($group,array('js'=>$js));
        }
    }
    
    function set_css($css = array(),$group = null) {
        
        if(is_null($group)){
            $this->carabiner->css($css);
        }
        else{
            $this->carabiner->group($group,array('css'=>$css));
        }
    }

    function __get($var) {
        static $ci;
        isset($ci) OR $ci = get_instance();
        return $ci->$var;
    }

}
?>
