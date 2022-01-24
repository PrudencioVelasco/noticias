<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permission
{

    private static $_CI;

    public function __construct()
    {
        self::$_CI = &get_instance();
        self::$_CI->load->database();
    }

    public static function grant($uri_pass)
    {
        $match = false;
        $user_id = $_SESSION['user_id'];
        $permissions = self::$_CI->db->select('p.uri, r.idrol')
            ->from('tblpermiso p')
            ->join('tblrol r', 'p.idrol = r.idrol')
            ->join('tblusuario u', 'u.idrol = r.idrol') 
            ->where('u.idusuario', $user_id)
            ->get()
            ->result();
        $resultado = array();
        foreach ($permissions as $value) {
            $porcion = explode("/", $uri_pass);
            $porcion2 = explode("/", $value->uri);

            if (isset($porcion[0]) && isset($porcion2[0])) {
                if (isset($porcion2[1])) {
                    if (($porcion2[1] == "*")) {

                        if (strtolower($porcion[0]) === strtolower($porcion2[0])) {
                            array_push($resultado, 1);
                        } else {
                            array_push($resultado, 0);
                        }
                    } else {
                        if (isset($porcion[0]) && isset($porcion[1])) {
                            if (strtolower($porcion[0] . '/' . $porcion[1]) == strtolower($value->uri)) {

                                array_push($resultado, 1);
                            } else {
                                array_push($resultado, 0);
                            }
                        } else {
                            array_push($resultado, 0);
                        }
                        // No es asterisco
                    }
                } else {
                    array_push($resultado, 0);
                }
            } else {
                array_push($resultado, 0);
            }
        }
        foreach ($resultado as $row) {

            if ($row == 1) {
                return true;
            }
        }

        // if all false
        if (!$match) {
            foreach ($permissions as $value) {
                switch ($value->id) {
                    case 1:
                        # EXTERNO
                        self::$_CI->session->set_flashdata('err', 'You don\'t have permissionss.');
                        redirect('Welcome/');
                        break;
                    case 2:
                        # INETNO
                        self::$_CI->session->set_flashdata('err', 'You don\'t have permissionss.');
                        redirect('Admin/');
                        break; 
                    default:
                        self::$_CI->session->set_flashdata('err', 'You don\'t have permissionss.');
                        redirect('Admin/');
                        break;
                }
            }
        }
    }

    public static function grantValidar($uri_pass)
    {
        $match = 0;
        $user_id = $_SESSION['user_id'];
        $permissions = self::$_CI->db->select('p.uri, r.idrol')
            ->from('tblpermiso p')
            ->join('tblrol r', 'p.idrol = r.idrol')
            ->join('tblusuario u', 'u.idrol = r.idrol') 
            ->where('u.idusuario', $user_id)
            ->get()
            ->result();
        // var_dump($permissions);
        foreach ($permissions as $permission) {
            $porcion = explode("/", $uri_pass);
            $porcion2 = explode("/", $permission->uri);

            if (isset($porcion[0]) && isset($porcion2[0])) {
                if (isset($porcion2[1])) {
                    if (($porcion2[1] == "*")) {
                        if (strtolower($porcion[0]) == strtolower($porcion2[0])) {
                            return $match = 1;
                        } else {
                            if (isset($porcion[0]) && isset($porcion[1])) {
                                if (strtolower($uri_pass) == strtolower($permission->uri)) {

                                    return  $match = 1;
                                }
                            }
                        }
                    } else {
                        if (strtolower($uri_pass) == strtolower($permission->uri)) {
                            return  $match = 1;
                        }
                    }
                }
            }
        }
        return $match;
        /* if (!$match) {
            foreach ($permissions as $value) {
                switch ($value->id) {
                    case 10:
                        # MAESTROS
                        return 0;
                        break;
                    case 11:
                        # TUTOR

                        return 0;
                        break;
                    case 12:
                        # ALUMNOS

                        return 0;
                        break;

                    default:

                        return 0;
                        break;
                }
            }
        }*/
    }

    public function __destruct()
    {
        self::$_CI->db->close();
    }
}
