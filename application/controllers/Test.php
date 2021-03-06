<?php defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function cek_khs_double()
    {
        $a = array();
        // $this->db->where('krs_id', );
        $this->db->select('krs_id,nilai');
        foreach ($this->db->get('akademik_khs')->result() as $rw) {
            $this->db->select('krs_id');
            $this->db->where('krs_id', $rw->krs_id);
            $cek = $this->db->get('akademik_khs');
            if ($cek->num_rows() > 1) {
                log_data($rw->krs_id);
                array_push($rw->krs_id, $a);
            }
        }
        // log_r($a);
    }

    public function delete_khs_double()
    {
        $sql = "DELETE FROM akademik_khs WHERE krs_id IN (SELECT dd FROM aa GROUP BY dd) and nilai is null ";
        // foreach ($this->db->query($sql)->result() as $key => $rw) {
        //     log_data($rw);
        // }
        $this->db->query($sql);
        echo "berhasil";
    }

    public function cek_krs_inkhs()
    {
        $this->db->select('krs_id');
        $db = $this->db->get('akademik_krs');
        foreach ($db->result() as $rw) {
            $cek = $this->db->get_where('akademik_khs', array('krs_id'=>$rw->krs_id));
            if ($cek->num_rows() == 0) {
                $this->db->insert('akademik_khs', array('krs_id'=>$rw->krs_id));
            }
        }
    }

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
