<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

/*pages */
$route['about.html']='front/home/pages/about';
$route['services.html']='front/home/pages/services';
$route['contact.html']='front/home/pages/contact';
/*End pages */
$route['default_controller'] = 'front/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Categories
$route['categories.html'] = 'front/categories';

// Detail Details
$route['categories.html'] = 'front/categories';
$route['categories.html/(:any)'] = 'front/categories/find/$1';
$route['categories/details/(:any)'] = 'front/categories/details/$1';
$route['home/details/(:any)'] = 'front/home/details/$1';
//categories/details/1
//$route['admin/manage-users.html/(:any)/(:any)'] = 'admin/users/users/manage_users/$1/$2';


//Profiles
$route['profile.html'] = 'front/profile';
$route['profile/myads.html'] = 'front/profile/my_ads';
$route['profile.html'] = 'front/profile';
$route['profile.html'] = 'front/profile';
$route['profile.html'] = 'front/profile';


$route['register.html'] = 'front/Register';
$route['register.html/signup'] = 'front/Register/signup';

$route['login.html'] = 'front/login';


// Logout
$route['logout'] = 'admin/Admin_Login/logout';
