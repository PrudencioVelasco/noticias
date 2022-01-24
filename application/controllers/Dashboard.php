<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller { 

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url'); 
        $this->load->library('session');
        $this->load->library('encryption'); 
    }

    public function index()
	{  
        $this->load->view('admin/header');
        $this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	   
    
	} 
     

}