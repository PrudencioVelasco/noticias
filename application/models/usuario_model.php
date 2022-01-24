<?php

class Usuario_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct()
    {
        $this->db->close();
    }

    

    public function loginUsuarioInterno($usuario)
    { 
        $this->db->select('u.*');
        $this->db->from('tblusuario u'); 
        $this->db->where('u.usuario', $usuario); 
        $this->db->where('u.idrol', 1); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function loginUsuarioExterno($usuario)
    { 
        $this->db->select('u.*');
        $this->db->from('tblusuario u'); 
        $this->db->where('u.usuario', $usuario); 
        $this->db->where('u.idrol', 1); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    
 
}
