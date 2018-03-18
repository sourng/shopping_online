<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'front/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Categories
$route['categories.html'] = 'front/categories';

// Detail Details
$route['categories.html'] = 'front/categories';
$route['categories/details/(:any)'] = 'front/categories/details/$1';
//categories/details/1
//$route['admin/manage-users.html/(:any)/(:any)'] = 'admin/users/users/manage_users/$1/$2';


$route['register.html'] = 'front/Register';
$route['register.html/signup'] = 'front/Register/signup';

$route['login.html'] = 'front/login';



