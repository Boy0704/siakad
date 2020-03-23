<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function index()
   
    {
        // load from spark tool
        // $this->load->spark('recaptcha-library/1.0.1');
        // load from CI library
        // $this->load->library('recaptcha');

        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) and $response['success'] === true) {
               redirect('admin');
            }
        }

        $data = array(
            'widget' => $this->recaptcha->getWidget(),
            'script' => $this->recaptcha->getScriptTag(),
        );
        $this->load->view('recaptcha', $data);
    }
    
    function select2()
    {
        $this->load->view('tes_select2');
    }

    //import user dosen yg tidak ada
    public function import_user_dosen()
    {
        $dosen = $this->db->get('app_dosen');
        foreach ($dosen->result() as $rw) {
            $cek_user = $this->db->get_where('app_users', array('keterangan'=>$rw->dosen_id));
            if ($cek_user->num_rows() == 0) {
                //insert user dosen
                $this->db->insert('app_users', 
                    array(
                        'username'=>$rw->nidn,
                        'nama'=>$rw->nama_lengkap,
                        'password'=>hash_string("123456"),
                        'level'=>3,
                        'keterangan'=>$rw->dosen_id,
                        'konsentrasi_id'=>$rw->konsentrasi_id,
                    )
                );
                log_data('berhasil insert user dosen');
            } else {
                log_data('data sudah ada');
            }
        }
    }

    function a()
    {
        $semester = 0;
        $nim = '181010';
        $nim_sub = substr($nim, 0,2);
        $thn_akademik = '20201';
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
        log_r($semester);
    }


}
