<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>
<?php
/**
** $custom_element : true | false | string
** true(default): use h1 tag
** false: return only string
** string: return string with rule <element ...>{page_title}</element>
**/
if(isset($page_title)){
	if(isset($custom_element) && is_string($custom_element)){
		echo str_replace("{page_title}",$page_title,$custom_element);
	}elseif(isset($custom_element) && $custom_element === false){
		echo $page_title;
	}else{
		echo '<h1>'.$page_title.'</h1>';
	}
}
?>
