<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
    {
        parent::__construct();

        $this->load->helper('url'); 
        $this->load->library('session');
        $this->load->library('encryption'); 
		$this->load->model('usuario_model', 'usuario');
    }
	public function index(){
		if(isset($this->session->idrol ) && !empty($this->session->idrol )){
            if ($this->session->idrol == 1) {
                //DOCENTE
                redirect('Principal/'); 
            }else{
              
                redirect('Dashboard/'); 
            }
        }else{
            redirect('Principal/');
        }
	  
    }
   
	public function admin()
    {
        $this->load->library('session');
        if ($this->session->idrol == 1) {
            // DOCENTE
            redirect('Welcome/');
        } elseif ($_POST) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            $result = $this->usuario->loginUsuarioInterno($usuario);

            if ($result) { 
                if (password_verify($password, $result->password)) {
                    $this->session->set_userdata([
                        'user_id' => $result->idusuario,
                        'idrol' => $result->idrol,
                        'nombre' => $result->nombre,
                        'apellidop' => $result->apepaterno,
                        'apellidom' => $result->apematerno,
                    ]);
					//echo $this->session->idrol;
                    redirect('/Dashboard/');
                } else {
                    $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
                    redirect('/Admin/login');
                } 
            } else {
                   $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
				   redirect('/Admin/login');
            }
        } else {
			//echo "nO ". $_POST['usuario'];
			redirect('/Admin/login');
        }
    }

    public function externo()
    {
        $this->load->library('session');
        if ($this->session->idrol == 1) {
            // DOCENTE
            redirect('Welcome/');
        } elseif ($_POST) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            $result = $this->usuario->loginUsuarioExterno($usuario);

            if ($result) { 
                if (password_verify($password, $result->password)) {
                    $this->session->set_userdata([
                        'user_id' => $result->idusuario,
                        'idrol' => $result->idrol,
                        'nombre' => $result->nombre,
                        'apellidop' => $result->apepaterno,
                        'apellidom' => $result->apematerno,
                    ]);
					//echo $this->session->idrol;
                    redirect('/Principal/');
                } else {
                    $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
                    redirect('/Principal/login');
                } 
            } else {
                   $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
				   redirect('/Principal/login');
            }
        } else {
			//echo "nO ". $_POST['usuario'];
			redirect('/Principal/login');
        }
    }
	public function logouta()
    {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/Admin');
    }
    public function logoute()
    {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/Welcome');
    }

}
