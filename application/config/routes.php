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
$route['categories/pages.html/(:any)'] = 'front/categories/pages/$1';
$route['categories/pages.html'] = 'front/categories/pages';

$route['categories/find.html'] = 'front/categories/find';
$route['categories/find.html/(:any)'] = 'front/categories/find/$1';
$route['categories/find.html/(:any)/(:any)'] = 'front/categories/find/$1/$2';

// By Brands
// $route['brands.html/(:any)'] = 'front/categories/brand/$1';
$route['brands/find.html/(:any)'] = 'front/brands/find/$1';
$route['brands/find.html/(:any)/(:any)'] = 'front/brands/find/$1/$2';

$route['brands/findpage/(:any)'] = 'front/brands/findpage/$1';
$route['brands/findpage/(:any)/(:any)'] = 'front/brands/findpage/$1/$2';


// categories/find.html
// $route['categories/find.html'] = 'front/categories/find';
$route['categories/findpage/(:any)'] = 'front/categories/findpage/$1';
$route['categories/findpage/(:any)/(:any)'] = 'front/categories/findpage/$1/$2';

$route['categories/details/(:any)'] = 'front/categories/details/$1';
$route['home/details/(:any)'] = 'front/home/details/$1';



$route['ads/(:any)/(:any)'] = 'front/details/index/$1/$2';
// category_id/product_id
$route['(:any)/(:any)'] = 'front/details/index/$1/$2';



//categories/details/1
//$route['admin/manage-users.html/(:any)/(:any)'] = 'admin/users/users/manage_users/$1/$2';


//Profiles
$route['profile.html'] = 'front/profile';
$route['profile.html/my-ads'] = 'front/profile/my_ads';
$route['profile.html/favourite-ads'] = 'front/profile/favourite_ads';
$route['profile.html/archived-ads'] = 'front/profile/archived_ads';
$route['profile.html/pending-ads'] = 'front/profile/pending_ads';
$route['profile.html/delete-ads'] = 'front/profile/delete_ads';
$route['profile.html/delete-ads1'] = 'front/profile/delete_ads1';




// favourite
// archived
// pending
// delete
// front/profile/favourite_ads


$route['register.html'] = 'front/Register';
$route['register.html/signup'] = 'front/Register/signup';

$route['login.html'] = 'front/login';


// Logout
$route['logout'] = 'admin/Admin_Login/logout';
