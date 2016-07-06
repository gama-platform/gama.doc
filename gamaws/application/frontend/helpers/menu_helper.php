<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		Mai The Phuong
 * @copyright	Copyright (c) 2012, Freelancer.
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Menu Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 */

// ------------------------------------------------------------------------

/**
 * Menu display
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('menu_admin'))
{
	function menu_admin()
	{
		
		$CI =&get_instance();
		$user = $CI->session->userdata('users');
		$output=array();  
		$menutype = $CI->db->get('fv_menu_types')->result_array();
		if(isset($user['user_id']) && $user['user_id']>0){
			if (isset($CI->session->userdata['hidemenu']) && $CI->session->userdata['hidemenu']===true) {
				 // Print the logout message
				 $output[]='<ul id="menu">
						<li class="disabled"><a>Site</a></li>
						<li class="disabled"><a>Content</a></li>
						<li class="disabled"><a>Modules</a></li>
						</ul>';
			} else {
				// Print the logout message
				$output[]='<ul id="menu">
						<li><a>Site</a>
							<ul>
								<li class=""><a class="icon-16-cpanel" href="'.base_url().'index.php">Control Panel</a></li>
								<li class="separator"><span></span></li>
								<li class=""><a class="icon-16-user" href="'.base_url().'index.php/user">User Manager</a></li>
							</ul>
						</li>
						
						<li><a>Content</a>
							<ul>
							<li><a class="icon-16-article" href="'.base_url().'index.php/content/article">Article Manager</a></li>
							<li><a class="icon-16-section" href="'.base_url().'index.php/content/section">Section Manager</a></li>
							<li><a class="icon-16-category" href="'.base_url().'index.php/content/category">Category Manager</a></li>
							</ul>
						</li>
						<li><a>Modules</a>
							<ul>
							<li><a class="icon-16-article" href="'.base_url().'index.php/location">Location Manager</a></li>
							<li><a class="icon-16-article" href="'.base_url().'index.php/job">Jobs</a>
									<ul>
										<li><a class="icon-16-article" href="'.base_url().'index.php/job/category">Category</a>
											
										</li>
										<li><a class="icon-16-article" href="'.base_url().'index.php/job">Jobs</a>
											
										</li>
										<li><a class="icon-16-article" href="'.base_url().'index.php/job/type">Type</a>
											
										</li>
										<li><a class="icon-16-article" href="'.base_url().'index.php/job/skill_category">Skill</a>
											
										</li>
									</ul>
								</li>
							<li><a class="icon-16-article" href="'.base_url().'index.php/event">Event Manager</a></li>
							</ul>
						</li>
						</ul>';
			}
			
		}
		
		return implode(' ',$output);
	}
}
/**
 * Menu display
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('menu_frontend'))
{
	function menu_frontend()
	{
		
		$CI =&get_instance();
		$CI->load->helper('url');
		$output = array();
		$output[] = '<ul class="sf-menu">';
		$output[] = '<li class="current">
					<a href="#a">Trang chủ</a>
					</li>
					';
		$output[] = '<li>
					<a href="#a">Hồ sơ freelancers</a>
					</li>
					';
		$output[] = '<li>
					<a href="#a">Freelancer jobs</a>
					<ul>
						<li><a href="#a">Dự án mới nhất</a><li>
						<li><a href="#a">Dự án được quan tâm nhất</a><li>
						<li><a href="#a">Dự án theo danh mục</a><li>
					</ul>
					</li>
					';
		$output[] = '<li>
					<a href="'.base_url('blog/section/index/9').'">Blog kỹ năng</a>
					</li>
					';
		$output[] = '<li>
					<a href="#a">Thư viện</a>
					</li>
					';
		$output[] = '<li>
					<a href="#a">Cộng đồng</a>
					</li>
					';
		$output[] = '<li>
					<a href="#a">Sự kiện</a>
					</li>
					';	
		$output[] = '</ul>';
		return implode(' ',$output);
	}
}
/**
 * SubMenu display
 *
 * @access	public
 * @param array $data(array(array('title'=>title,'link'=>link,'active'=>true)))
 * @return	string
 */
if ( ! function_exists('submenu_admin'))
{
	function submenu_admin($data=array())
	{
		
		$CI =&get_instance();
		
		$output=array();  
		if(count($data)>0){
			$output[]=' <div id="submenu-box">
						<div class="t">
							<div class="t">
								<div class="t"></div>
							</div>
						</div>
						<div class="m">
						<ul id="submenu">';
			for($i=0;$i<count($data);$i++){
				$title = '';
				$link = '';
				$class= '';
				if(isset($data[$i]['title'])) $title = $data[$i]['title'];
				if(isset($data[$i]['link'])) $link = $data[$i]['link'];
				if(isset($data[$i]['active']) && $data[$i]['active']===TRUE) $class = 'class="active"';
				$output[]='<li><a '.$class.' href="'.$link.'">'.$title.'</a></li>';
			}
			
			$output[]='</ul>
						 <div class="clr"></div>
					</div>
					<div class="b">
						<div class="b">
							<div class="b"></div>
						</div>
					</div>
				</div>
					';
		}
		return implode(' ',$output);
	}
}
/**
 * Toolbar display
 *
 * @access	public
 * @param string title
 * @param array $data(array(array('action'=>delete,'task'=>delete)))
 * @return	string
 */
if ( ! function_exists('toolbar_admin'))
{
	function toolbar_admin($title='',$data=array())
	{
		
		$CI =&get_instance();
		
		$output=array(); 
		if($title || count($data)>0){
			$output[]='<div id="toolbar-box">
                        <div class="t">
                            <div class="t">
                                <div class="t"></div>
                            </div>
                        </div>
                    <div class="m">';
			
			if(count($data)>0){
				$output[]='<div class="toolbar" id="toolbar">
							<table class="toolbar">
							<tbody><tr>';
				for($i=0;$i<count($data);$i++){
					// delete button
					if(isset($data[$i]['action']) && strtolower($data[$i]['action'])==='delete'){
						$output[]='<td class="button" id="toolbar-delete">
	<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert(\'Please make a selection from the list to delete\');}else{  submitbutton(\''.((isset($data[$i]['task']) && $data[$i]['task'])?$data[$i]['task']:'remove').'\')}" class="toolbar">
	<span class="icon-32-delete" title="'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Delete').'"></span>'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Delete').'</a></td>';
					}
					// edit button
					if(isset($data[$i]['action']) && strtolower($data[$i]['action'])==='edit'){
						$output[]='<td class="button" id="toolbar-edit">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert(\'Please make a selection from the list to edit\');}else{ submitbutton(\''.((isset($data[$i]['task']) && $data[$i]['task'])?$data[$i]['task']:'edit').'\')}" class="toolbar">
<span class="icon-32-edit" title="'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Edit').'"></span>'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Edit').'</a></td>';
					}
					
					// new button
					if(isset($data[$i]['action']) && strtolower($data[$i]['action'])==='new'){
						$output[]='<td class="button" id="toolbar-new">
<a href="#" onclick="javascript: submitbutton(\''.((isset($data[$i]['task']) && $data[$i]['task'])?$data[$i]['task']:'add').'\')" class="toolbar">
<span class="icon-32-new" title="'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'New').'"></span>'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'New').'</a></td>';
					}
					// save button
					if(isset($data[$i]['action']) && strtolower($data[$i]['action'])==='save'){
						$output[]='<td class="button" id="toolbar-save">
<a href="#" onclick="javascript: submitbutton(\''.((isset($data[$i]['task']) && $data[$i]['task'])?$data[$i]['task']:'save').'\')" class="toolbar">
<span class="icon-32-save" title="'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Save').'"></span>'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Save').'</a></td>';
					}
					// cancel button
					if(isset($data[$i]['action']) && strtolower($data[$i]['action'])==='cancel'){
						$output[]='<td class="button" id="toolbar-cancel">
<a href="#" onclick="javascript: submitbutton(\''.((isset($data[$i]['task']) && $data[$i]['task'])?$data[$i]['task']:'cancel').'\')" class="toolbar">
<span class="icon-32-cancel" title="'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Cancel').'"></span>'.((isset($data[$i]['title']) && $data[$i]['title'])?$data[$i]['title']:'Cancel').'</a></td>';
					}
				}
				$output[]='</tr></tbody></table></div>';
			}
			if($title){
				$output[]='<div class="header icon-48-generic">
							'.$title.'
						</div>';
			} 
				$output[]='
						 <div class="clr"></div>
				</div>
                    <div class="b">
                    <div class="b">
                        <div class="b"></div>
                    </div>
                </div>
  			</div>
					';
		}
		return implode(' ',$output);
	}
}

/* End of file user_helper.php */
/* Location: ./system/helpers/user_helper.php */