<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'front/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Categories
$route['categories.html'] = 'front/categories';

// Detail Details
$route['categories.html'] = 'front/categories';
$route['Details.html'] = 'front/categories/details';


$route['register.html'] = 'front/Register';
$route['register.html/signup'] = 'front/Register/signup';

$route['login.html'] = 'front/login';



