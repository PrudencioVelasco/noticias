<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Noticia extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->library('session');
        $this->load->library('encryption'); 
        $this->load->model('noticia_model', 'noticia');
        $this->load->model('comentario_model', 'comentario');
        $this->load->helper('url');
    }

    public function inicio()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/noticia/index');
        $this->load->view('admin/footer');
    }
    public function detalle($idnoticia)
    {
        # code...

        if (isset($idnoticia) && !empty($idnoticia)) {
            $this->load->view('admin/header');
            $this->load->view('admin/noticia/detalle');
            $this->load->view('admin/footer');
        }
    }
    public function comentarios($idnoticia)
    {
        # code...

        if (isset($idnoticia) && !empty($idnoticia)) {
            $data = array(
                'idnoticia' => $idnoticia
            );
            $this->load->view('admin/header');
            $this->load->view('admin/noticia/comentarios', $data);
            $this->load->view('admin/footer');
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

    public function todasNoticias()
    {
        $query = $this->noticia->todasNoticias();

        if ($query) {
            $result['noticias'] = $this->noticia->todasNoticias();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function noticiasPrincipal()
    {
        $query = $this->noticia->noticiasPrincipal();

        if ($query) {
            $result['noticias'] = $this->noticia->noticiasPrincipal();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
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
    public function buscarNoticias()
    {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->noticia->buscarNoticias($value);
        if ($query) {
            $result['noticias'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function eliminarNoticia()
    {
        # code...
        $idnoticia = $this->input->get('idnoticia');
        $validar = $this->noticia->validarEliminarNoticia($idnoticia);
        $validarimagen = $this->noticia->imagenesNoticia($idnoticia);

        if (!$validar && ! $validarimagen) {
            $eliminar  = $this->noticia->eliminarNoticia($idnoticia);
            if ($eliminar) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede eliminar la noticia porque tiene relación con otras tablas.'
                );
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No se puede eliminar la noticia porque tiene relación con otras tablas.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function eliminarComentario()
    {
        # code...
        $idcomentario = $this->input->get('idcomentario');
        $validar = $this->comentario->validarEliminarComentario($idcomentario);

        if (!$validar) {
            $eliminar  = $this->comentario->eliminarComentario($idcomentario);
            if ($eliminar) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede eliminar el comentario porque tiene relación con otras tablas.'
                );
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No se puede eliminar el comentario porque tiene relación con otras tablas.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function eliminarImagen()
    {
        # code...
        $idimagen = $this->input->get('idimagen');
         
            $eliminar  = $this->noticia->eliminarImagen($idimagen);
            if ($eliminar) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede eliminar la imagen.'
                );
            }
        
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function agregarComentario()
    {

        $config = array(
            array(
                'field' => 'comentario',
                'label' => 'El comentario',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'comentario' => form_error('comentario'),
            );
        } else {
            $comentario = trim($this->input->post('comentario'));
            $idnoticia = trim($this->input->post('idnoticia'));
            $data = array(
                'idnoticia' => $idnoticia,
                'comentario' => $comentario,
                ' 	idcomentariopadre ' => 0,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );

            $this->comentario->registrarComentario($data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function agregarComentarioReplay()
    {

        $config = array(
            array(
                'field' => 'comentario',
                'label' => 'El comentario',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'comentario' => form_error('comentario'),
            );
        } else {
            $comentario = trim($this->input->post('comentario'));
            $idnoticia = trim($this->input->post('idnoticia'));
            $idcomentario = $this->input->post('idcomentario');
            $data = array(
                'idnoticia' => $idnoticia,
                'comentario' => $comentario,
                'idcomentariopadre ' => $idcomentario,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );

            $this->comentario->registrarComentario($data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function modificarComentario()
    {

        $config = array(
            array(
                'field' => 'comentario',
                'label' => 'El comentario',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'comentario' => form_error('comentario'),
            );
        } else {
            $comentario = trim($this->input->post('comentario'));
            $idcomentario = $this->input->post('idcomentario');
            $data = array(
                'comentario' => $comentario,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );

            $this->comentario->modificarComentario($idcomentario, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    function genera_codigo($longitud)
    {
        $caracteres = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $codigo = '';

        for ($i = 1; $i <= $longitud; $i++) {
            $codigo .= $caracteres[rand(0, 35)];
        }

        return $codigo;
    }




    public function agregarNoticia()
    {
        $config = array(
            array(
                'field' => 'titulo',
                'label' => 'Titulo de la noticia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
            array(
                'field' => 'contenido',
                'label' => 'Redactar noticia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'titulo' => form_error('titulo'),
                'contenido' => form_error('contenido'),
            );
        } else {
            $titulo = trim($this->input->post('titulo'));
            $contenido = trim($this->input->post('contenido'));
            echo count(($_FILES['files']['name']));
            if (!empty($_FILES['files']) && count(($_FILES['files']['name'])) > 0) {

                $datanoticia = array(
                    'titulo' => $titulo,
                    'contenido' => $contenido,
                    'idusuario' => $this->session->user_id,
                    //'idusuario' => 1,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );

                $idnoticia = $this->noticia->registrarNoticia($datanoticia);

                $data = array();

                $count_images = count($_FILES['files']['name']);


                $config = array(
                    'upload_path'   => './assets/imagenesnoticias/',
                    'allowed_types' => 'jpg|gif|png',
                    'overwrite'     => 1,
                );

                $this->load->library('upload', $config);

                $images = array();

                foreach ($_FILES['files']['name'] as $key => $image) {
                    $_FILES['images[]']['name'] = $_FILES['files']['name'][$key];
                    $_FILES['images[]']['type'] = $_FILES['files']['type'][$key];
                    $_FILES['images[]']['tmp_name'] = $_FILES['files']['tmp_name'][$key];
                    $_FILES['images[]']['error'] = $_FILES['files']['error'][$key];
                    $_FILES['images[]']['size'] = $_FILES['files']['size'][$key];

                    $fileName = 'image' . rand(100000, 999999) . date("Y-m-d")  . '_' . $image;

                    $images[] = $fileName;

                    $config['file_name'] = $fileName;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('images[]')) {
                        $this->upload->data();
                        $dataimagen = array(
                            'idnoticia' => $idnoticia,
                            'nombreimagen' => $fileName
                        );
                        $this->noticia->registrarImagenNoticia($dataimagen);
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "No se subio las imagenes de la noticia."
                        );
                    }
                } 
            } else {
                $datanoticia = array(
                    'titulo' => $titulo,
                    'contenido' => $contenido, 
                    'idusuario' =>  $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );

                $this->noticia->registrarNoticia($datanoticia);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function modificarNoticia()
    {
        $config = array(
            array(
                'field' => 'titulo',
                'label' => 'Titulo de la noticia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
            array(
                'field' => 'contenido',
                'label' => 'Redactar noticia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'titulo' => form_error('titulo'),
                'contenido' => form_error('contenido'),
            );
        } else {
            $idnoticia = trim($this->input->post('idnoticia'));
            $titulo = trim($this->input->post('titulo'));
            $contenido = trim($this->input->post('contenido')); 

            if (!empty($_FILES['files']) && count(($_FILES['files']['name'])) > 0) {

                $datanoticia = array(
                    'titulo' => $titulo,
                    'contenido' => $contenido, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );

                 $this->noticia->modificarNoticia($idnoticia,$datanoticia);

                $data = array();

                $count_images = count($_FILES['files']['name']);


                $config = array(
                    'upload_path'   => './assets/imagenesnoticias/',
                    'allowed_types' => 'jpg|gif|png',
                    'overwrite'     => 1,
                );

                $this->load->library('upload', $config);

                $images = array();

                foreach ($_FILES['files']['name'] as $key => $image) {
                    $_FILES['images[]']['name'] = $_FILES['files']['name'][$key];
                    $_FILES['images[]']['type'] = $_FILES['files']['type'][$key];
                    $_FILES['images[]']['tmp_name'] = $_FILES['files']['tmp_name'][$key];
                    $_FILES['images[]']['error'] = $_FILES['files']['error'][$key];
                    $_FILES['images[]']['size'] = $_FILES['files']['size'][$key];

                    $fileName = 'image' . rand(100000, 999999) . date("Y-m-d")  . '_' . $image;

                    $images[] = $fileName;

                    $config['file_name'] = $fileName;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('images[]')) {
                        $this->upload->data();
                        $dataimagen = array(
                            'idnoticia' => $idnoticia,
                            'nombreimagen' => $fileName
                        );
                        $this->noticia->registrarImagenNoticia($dataimagen);
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "No se subio las imagenes de la noticia."
                        );
                    }
                } 
            } else {
                $datanoticia = array(
                    'titulo' => $titulo,
                    'contenido' => $contenido, 
                    'idusuario' =>  $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );

                $this->noticia->modificarNoticia($idnoticia,$datanoticia);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
}
