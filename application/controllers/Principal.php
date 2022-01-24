<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	function __construct()
    {
        parent::__construct();

        $this->load->helper('url'); 
        $this->load->library('session');
        $this->load->library('encryption'); 
        $this->load->library('permission');
		$this->load->model('noticia_model', 'noticia');
        $this->load->model('comentario_model', 'comentario');
    }
    public function index()
    {
        
        $this->load->view('usuario/inicio');
    }
	public function login()
	{
		$this->load->view('usuario/login');
	}
    
    public function leer($idnoticia)
    { 
        $data = array(
            'idnoticia'=>$idnoticia
        );
        $this->load->view('usuario/detalle',$data);
    }
    public function noticiasPrincipal()
    {
        $query = $this->noticia->todasNoticias();
        $usersList_array = array();
        $user_array = array();
        $note_array = array(); 

        if ($query) {
            foreach ($query as $row) {
                $user_array["idnoticia"] = $row->idnoticia;
                $user_array["titulo"] = $row->titulo;
                $user_array["contenido"] = $row->contenido;
                $user_array["fecharegistro"] = $row->fecharegistro;
                $user_array["nombre"] = $row->nombre;
                $user_array["apepaterno"] = $row->apepaterno;
                $user_array["apematerno"] = $row->apematerno; 
                $user_array["imagenes"] = array();
                $documentos = $this->noticia->imagenesNoticia($row->idnoticia);
                if ($documentos) {
                    foreach ($documentos as $documento) {
                        $note_array["idimagen"] = $documento->idimagen;
                        $note_array["nombreimagen"] = $documento->nombreimagen;  
                        array_push($user_array['imagenes'], $note_array);
                    }
                }
                array_push($usersList_array, $user_array);
            }
        }

        if (isset($usersList_array) && !empty($usersList_array)) {

            echo json_encode($usersList_array, JSON_PRETTY_PRINT);
        }
    }

    public function buscarNoticias()
    {
        $value = $this->input->post('text');
        $query = $this->noticia->buscarNoticias($value);
        $usersList_array = array();
        $user_array = array();
        $note_array = array(); 

        if ($query) {
            foreach ($query as $row) {
                $user_array["idnoticia"] = $row->idnoticia;
                $user_array["titulo"] = $row->titulo;
                $user_array["contenido"] = $row->contenido;
                $user_array["fecharegistro"] = $row->fecharegistro;
                $user_array["nombre"] = $row->nombre;
                $user_array["apepaterno"] = $row->apepaterno;
                $user_array["apematerno"] = $row->apematerno; 
                $user_array["imagenes"] = array();
                $documentos = $this->noticia->imagenesNoticia($row->idnoticia);
                if ($documentos) {
                    foreach ($documentos as $documento) {
                        $note_array["idimagen"] = $documento->idimagen;
                        $note_array["nombreimagen"] = $documento->nombreimagen;  
                        array_push($user_array['imagenes'], $note_array);
                    }
                }
                array_push($usersList_array, $user_array);
            }
        }

        if (isset($usersList_array) && !empty($usersList_array)) {

            echo json_encode($usersList_array, JSON_PRETTY_PRINT);
        }
    }
    public function getItem($idnoticia)
    {
        $data = [];
        $parent_key = '0';
        $row = $this->comentario->todosComentarios($idnoticia);
        if (!empty($row) && !empty($row)) {
            $data = $this->membersTree($parent_key, $idnoticia);
        }
        echo json_encode(array_values($data));
    }
    public function membersTree($parent_key, $idnoticia)
    {
        $row1 = [];
        $row = $this->comentario->todosComentariosIdPadre($parent_key, $idnoticia);

        if (isset($row) && !empty($row)) {
            foreach ($row as $key => $value) {
                $row1[$key]['idcomentario'] = $value['idcomentario'];
                $row1[$key]['comentario'] = $value['comentario'];
                $row1[$key]['fecharegistro'] = $value['fecharegistro'];
                $row1[$key]['nombre'] = $value['nombre'];
                $row1[$key]['apepaterno'] = $value['apepaterno'];
                $row1[$key]['apematerno'] = $value['apematerno'];
                $row1[$key]['idrol'] = $value['idrol'];
                $row1[$key]['idusuario'] = $value['idusuario'];
                $row1[$key]['unombre'] = $value['unombre'];
                $row1[$key]['uapepaterno'] = $value['uapepaterno'];
                $row1[$key]['uapematerno'] = $value['uapematerno'];
                $row1[$key]['nodes'] = array_values($this->membersTree($value['idcomentario'], $idnoticia));
            }
        }
        return $row1;
    }
    public function imagenesNoticia($idnoticia)
    {
        // $idnoticia = $this->input->get('idnoticia');
        //echo $idnoticia;
        //echo"s";
        $query = $this->noticia->imagenesNoticia($idnoticia);

        if ($query) {
            $result['imagenes'] =   $query = $this->noticia->imagenesNoticia($idnoticia);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function detalleNoticia($idnoticia)
    {
        $query = $this->noticia->detalleNoticia($idnoticia);

        if ($query) {
            $result['detallenoticia'] =  $this->noticia->detalleNoticia($idnoticia);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
}
