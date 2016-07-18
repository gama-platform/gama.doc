<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>
<style>
#content{
	background:url(<?php echo base_url('images/404-bg.jpg') ?>) center center;
}
#content .main{background:none repeat scroll 0 0 rgba(0, 0, 0, 0);}
</style>
<script>
	jQuery(document).ready(function(){
		jQuery('#content').wrap('<a href="<?php echo base_url() ?>" />');
	});
</script>