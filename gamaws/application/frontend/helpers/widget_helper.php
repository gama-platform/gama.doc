<?

if(function_exists("widget")){

	function widget($name='')
	{
		# code...

		$ci = & get_instance();
	    $ci->load->widget($name);
	    echo $ci->$name->run();

	}

}

?>