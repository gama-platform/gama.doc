<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller']                        = "user/User_ctl";
$route['default_controller']                        = "home_page/home_page_ctl";
//$route['default_controller']                        = "user/login_ctl";
$route['404_override']                              = 'errors/errors_ctl';
$route['translate_uri_dashes']                      = FALSE;


$route['home_page']               		 	        = "home_page/home_page_ctl/index";
$route['login']               		 	            = "user/login_ctl/index";
$route['logout']               		 		        = "user/login_ctl/logout";

$route['getting_started']               	        = "getting_started/getting_started_ctl/index";
$route['download']               	                = "download_gama/download_gama_ctl/index";
$route['intro_gama']               	                = "intro_gama/intro_gama_ctl/index";
$route['community']               	                = "forum/forum_ctl/index";
$route['communication']               	            = "communication/communication_ctl/index";
$route['event']               	                    = "event/event_ctl/index";
$route['references']               	                = "documentation/documentation_ctl/index";
$route['tutorials']               	                = "tutorials/tutorials_ctl/index";
$route['developers']               	                = "developers/developers_ctl/index";
$route['search']               	                    = "wg_gama_search/gama_search_ctl/index";