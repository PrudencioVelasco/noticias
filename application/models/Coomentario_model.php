<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Comentario_model extends CI_Model
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

    public function todosComentarios($idnoticia)
    {
        $this->db->select("c.idcomentario, c.idnoticia, c.comentario, DATE_FORMAT(c.fecharegistro,'%d/%m/%Y') as fecharegistro, p.nombre, p.apepaterno,p.apematerno, r.idrol, u.nombre as unombre, u.apepaterno as uapepaterno, u.apematerno as uapematerno");
        $this->db->from('tblcomentario c'); 
        $this->db->join('tblusuario u', 'u.idusuario = c.idusuario');  
        $this->db->join('tblpersonal p','p.idpersonal = u.idpersonal','left');
        $this->db->join('tblrol r','u.idrol = r.idrol');
        $this->db->join('tblpersonal p2','u.idpersonal = p2.idpersonal','left');
        $this->db->where('c.idnoticia',$idnoticia);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
  
    public function todosComentariosIdPadre($idcomentario,$idnoticia)
    {
        $this->db->select("c.idcomentario, c.idnoticia, c.comentario, DATE_FORMAT(c.fecharegistro,'%d/%m/%Y') as fecharegistro, p.nombre, p.apepaterno,p.apematerno, r.idrol, u.nombre as unombre, u.apepaterno as uapepaterno, u.apematerno as uapematerno,u.idusuario");
        $this->db->from('tblcomentario c'); 
        $this->db->join('tblusuario u', 'u.idusuario = c.idusuario');  
        $this->db->join('tblpersonal p','p.idpersonal = u.idpersonal','left');
        $this->db->join('tblrol r','u.idrol = r.idrol');
        $this->db->join('tblpersonal p2','u.idpersonal = p2.idpersonal','left');
        $this->db->where('c.idcomentariopadre',$idcomentario); 
        $this->db->where('c.idnoticia',$idnoticia); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function validarEliminarComentario($idcomentario)
    {
        $this->db->select("c.idcomentario, c.idnoticia, c.comentario, DATE_FORMAT(c.fecharegistro,'%d/%m/%Y') as fecharegistro");
        $this->db->from('tblcomentario c');  
        $this->db->where('c.idcomentariopadre',$idcomentario); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function registrarComentario($data)
    {
        $this->db->insert('tblcomentario', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function modificarComentario($id, $field)
    {
        $this->db->where('idcomentario', $id);
        $this->db->update('tblcomentario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    } 
    public function eliminarComentario($idcomentario)
    { 
        $this->db->where('idcomentario', $idcomentario);
        //$this->db->where('idcomentariopadre', 0);
        $this->db->delete('tblcomentario');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
 
}
