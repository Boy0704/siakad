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
