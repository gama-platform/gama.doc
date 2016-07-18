

<?php

/**
 * Created by PhpStorm.
 * User: langthang
 * Date: 12/2/15
 * Time: 2:42 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Menu_sidebar_ctl extends MX_Controller {

    public function __construct() {
        parent::widgets();
    }

    function run(){
        $rows = $this->getMenuItems();
        foreach($rows as $key=>$row){
            $rows[$key]->link = base_url('blog-ky-nang/'.$row->alias.'.html');
        }
        return $this->build('blog_categories_view',array('rows'=>$rows));
    }

    function getMenuItems(){
        $query = "SELECT id,title,description FROM gm_menu WHERE parent_id = 1 ORDER BY ordering ASC";
        return $this->db->query($query)->result();
    }
    function getMenuSubItems($sub_item_id){
        $query = "SELECT id,title,description FROM gm_menu WHERE parent_id = $sub_item_id ORDER BY ordering ASC";
        return $this->db->query($query)->result();
    }
}
?>