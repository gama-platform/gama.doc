<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
$template_url = base_url("templates/fv");
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo isset($meta_title) ? $meta_title : '';?></title>
<meta name="description" content="<?php echo isset($meta_description) ? $meta_description : '' ;?>">
<meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : '' ;?>">
<meta content="freelancerviet.vn" name="author">
<link href="<?php echo isset($meta_gplus) ? $meta_gplus : '' ;?>" rel="author">
<meta content="freelancerviet.vn" name="copyright">
<meta content="<?php echo isset($fb_image) ? $fb_image : base_url('templates/freelancerviet/images/logo-fbshare.png') ;?>" property="og:image">
<meta content="<?php echo isset($fb_title) ? $fb_title : '' ;?>" property="og:title">
<meta content="<?php echo isset($fb_description) ? $fb_description : '' ;?>" property="og:description">
<meta content="vi_VN" property="og:locale">
<meta content="website" property="og:type">
 <meta property="fb:app_id" content="298590760253178" />
 <meta property="og:image:width" content="300" />
 <meta property="og:image:height" content="300" />
<meta content="freelancerviet.vn" property="og:site_name">
<meta content="<?php echo isset($tw_title) ? $tw_title : '' ;?>" name="twitter:title">
<meta content="<?php echo isset($tw_description) ? $tw_description : '' ;?>" name="twitter:description">
<meta content="<?php echo isset($tw_image) ? $tw_image : base_url('templates/freelancerviet/images/logo-fbshare.jpg') ;?>" name="twitter:image">
<meta name="robots" content="<?php echo isset($robots) ? $robots : 'index, follow' ;?>">