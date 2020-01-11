<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function ip($nim,$semester)
    {
        $CI =& get_instance();
        $data = $CI->db->query("SELECT SUM(sks * mutu)/SUM(sks) as ipk FROM `v_khs` WHERE nim='$nim' and semester='$semester'")->row()->ipk;
        return $data;
    }

    function ipk($nim)
    {
        $CI =& get_instance();
        $data = $CI->db->query("SELECT SUM(sks * mutu)/SUM(sks) as ipk FROM `v_khs` WHERE nim='$nim' ")->row()->ipk;
        return $data;
    }

    function get_data($tabel,$primary_key,$id,$select)
    {
        $CI =& get_instance();
        $data = $CI->db->query("SELECT $select FROM $tabel where $primary_key='$id' ")->row_array();
        return $data[$select];
    }

    function cek_semester($nim,$thn_akademik)
    {
        $semester = 0;
        $nim_sub = substr($nim, 0,2);
        $thn_akademik_sub = substr($thn_akademik, 2,2);
        $thn_akademik_ak = substr($thn_akademik, 4,1);
        // log_r($thn_akademik_ak);
        if ($nim_sub == $thn_akademik_sub && $thn_akademik_ak == 1) {
            $semester = 1;
        } elseif ($nim_sub == $thn_akademik_sub && $thn_akademik_ak == 2) {
            $semester = 2;
        } elseif ($nim_sub < $thn_akademik_sub && $thn_akademik_ak == 1) {
            $hitung = (($thn_akademik_sub - $nim_sub)*2)+1;
            $semester = $hitung;
        } elseif ($nim_sub < $thn_akademik_sub && $thn_akademik_ak == 2) {
            $hitung = (($thn_akademik_sub - $nim_sub)*2)+1;
            $semester = $hitung;
        }
        // log_r($semester);
        return $semester;
    }

    function log_r($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        exit;
    }

    function log_data($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        // exit;
    }

    function alert_biasa($pesan,$type)
    {
        return 'swal("'.$pesan.'", "You clicked the button!", "'.$type.'");';
    }


    function helper_log($tipe = "", $str = ""){

    $CI =& get_instance();
 
    if (strtolower($tipe) == "login"){
        $log_tipe   = 0;
    }
    elseif(strtolower($tipe) == "logout")
    {
        $log_tipe   = 1;
    }
    elseif(strtolower($tipe) == "add"){
        $log_tipe   = 2;
    }
    elseif(strtolower($tipe) == "edit"){
        $log_tipe   = 3;
    }
    else{
        $log_tipe   = 4;
    }
                 
    // paramter
    $param['log_user']      = $CI->session->userdata('user_role_id');
    $param['log_tipe']      = $log_tipe;
    $param['log_desc']      = $str;
    
    //load model log
    $CI->load->model('m_log');
    //save to database
    $CI->m_log->save_log($param);
 
}


?>
