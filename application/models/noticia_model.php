<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Noticia_model extends CI_Model
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

    public function todasNoticias()
    {
        $this->db->select("n.idnoticia, n.titulo, n.contenido, DATE_FORMAT(n.fecharegistro,'%d/%m/%Y') as fecharegistro, p.nombre, p.apepaterno,p.apematerno");
        $this->db->from('tblnoticia n');
        $this->db->join('tblusuario u', 'u.idusuario = n.idusuario');  
        $this->db->join('tblpersonal p','p.idpersonal = u.idpersonal');
        $this->db->join('tblrol r','u.idrol = r.idrol');
        $this->db->where('r.idrol',2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function validarEliminarNoticia($idnoticia)
    {
        $this->db->select("c.*");
        $this->db->from('tblcomentario c');
        $this->db->where('c.idnoticia',$idnoticia);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function imagenesNoticia($idnoticia)
    {
        $this->db->select("n.idimagen,n.idnoticia,n.nombreimagen");
        $this->db->from('tblimagen n');
        $this->db->where('n.idnoticia',$idnoticia);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleNoticia($idnoticia)
    {
        $this->db->select("n.idnoticia, n.titulo, n.contenido, DATE_FORMAT(n.fecharegistro,'%d/%m/%Y') as fecharegistro, p.nombre, p.apepaterno,p.apematerno");
        $this->db->from('tblnoticia n');
        $this->db->join('tblusuario u', 'u.idusuario = n.idusuario');  
        $this->db->join('tblpersonal p','p.idpersonal = u.idpersonal');
        $this->db->join('tblrol r','u.idrol = r.idrol');
        $this->db->where('n.idnoticia',$idnoticia);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function registrarNoticia($data)
    {
        $this->db->insert('tblnoticia', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function registrarImagenNoticia($data)
    {
        $this->db->insert('tblimagen', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function eliminarNoticia($idnoticia)
    { 
        $this->db->where('idnoticia', $idnoticia);
        $this->db->delete('tblnoticia');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function eliminarImagen($idimagen)
    { 
        $this->db->where('idimagen', $idimagen);
        $this->db->delete('tblimagen');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarNoticias($match)
    {
        $field = 'n.titulo,' . "' '" . ',n.contenido,' . "' '" . ',p.nombre,' . "' '" . ',p.apepaterno,' . "' '" . ',p.apematerno';
        $this->db->select("n.idnoticia, n.titulo, n.contenido, DATE_FORMAT(n.fecharegistro,'%d/%m/%Y') as fecharegistro, p.nombre, p.apepaterno,p.apematerno");
        $this->db->from('tblnoticia n');
        $this->db->join('tblusuario u', 'n.idusuario = n.idusuario');  
        $this->db->join('tblpersonal p','p.idpersonal = u.idpersonal');
        $this->db->join('tblrol r','u.idrol = r.idrol');
        $this->db->where('r.idrol',2);
        $this->db->like('concat(' . $field . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function modificarNoticia($id, $field)
    {
        $this->db->where('idnoticia', $id);
        $this->db->update('tblnoticia', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    } 
}
