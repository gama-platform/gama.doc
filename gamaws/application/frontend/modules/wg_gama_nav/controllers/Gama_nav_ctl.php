

<?php

/**
 * Created by PhpStorm.
 * User: langthang
 * Date: 12/2/15
 * Time: 2:42 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Gama_nav_ctl extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    function getMenu(){
        $rows = $this->getMenuItems();
        foreach($rows as $key=>$row){
            $rows[$key]->link = site_url($row->alias);
        }
        return $this->load->view('gama_nav_view',array('rows'=>$rows, 'controller'=>$this), true);
    }

    function getSubMenu($sub_item_id){
        $rows = $this->getMenuSubItems($sub_item_id);
        foreach($rows as $key=>$row){
            $rows[$key]->link = site_url($row->alias);
        }
        return $rows;
        //return $this->load->view('gama_nav_view',array('rows'=>$rows), true);
    }

    function getMenuItems(){
        $query = "SELECT id,title,description,alias FROM gm_menu WHERE parent_id = 1 ORDER BY previous ASC";
        return $this->db->query($query)->result();
    }

    function getMenuSubItems($sub_item_id){
        $query = "SELECT id,title,description,alias FROM gm_menu WHERE parent_id = $sub_item_id ORDER BY previous ASC";
        return $this->db->query($query)->result();
    }
}
?>