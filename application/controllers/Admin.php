<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller { 

    function __construct() {
        parent::__construct();
        
        $this->load->helper('url'); 
        $this->load->library('session');
        $this->load->library('encryption'); 
    }

    public function index()
	{  
        if(isset($this->session->idrol ) && !empty($this->session->idrol )){
            if ($this->session->idrol == 1) {
                //DOCENTE
                redirect('Welcome/'); 
            }else{
              
                redirect('Dashboard/'); 
            }
        }else{
            redirect('Admin/login');  
        }
	   
    
	} 
    public function  login(){
        $this->load->view('admin/login'); 
    }
     

}
