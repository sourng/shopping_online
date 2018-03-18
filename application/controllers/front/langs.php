<?php 
$lang=$this->session->userdata('site_lang');
       // $data['page']=$page;

        if($lang!=''){
            $data['langs']=$lang;        
            // $data['page_detail']=$this->m_crud->get_by_sql("SELECT * FROM tbl_pages WHERE page_name='". $page ."' and lang='". $lang ."'");   
            $data['page_detail']=$this->m_crud->get_by_sql("SELECT * FROM tbl_pages WHERE  lang='". $lang ."'");           
        }else{
                $lang='english';
                $data['langs']=$lang;        
                // $data['page_detail']=$this->m_crud->get_by_sql("SELECT * FROM tbl_pages WHERE page_name='". $page ."' and lang='". $lang ."'");
                $data['page_detail']=$this->m_crud->get_by_sql("SELECT * FROM tbl_pages WHERE lang='". $lang ."'");
        }
?>