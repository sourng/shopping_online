<?php 

 
// custom paging configuration
$config['num_links'] = 3;
$config['use_page_numbers'] = TRUE;
$config['reuse_query_string'] = TRUE;
 
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';
 
$config['first_link'] = 'First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';
 
$config['last_link'] = 'Last';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';
 
$config['next_link'] = 'Next​​ <i class="fa fa-chevron-right"></i>';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '<i class="fa fa-chevron-left"></i> Prev';
$config['prev_tag_open'] = '<li class="prevlink">';
$config['prev_tag_close'] = '</li>';

 $config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="active"><a>';
$config['cur_tag_close'] = '</a></li>';  