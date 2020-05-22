<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Keuangan_hth extends CI_Controller
{
	
    public function index()
    {
        $data['title']=  'Keuangan H2H Bank BSM';
        $this->template->load('template', 'keuangan_hth/add_tagihan',$data);
    }

    

    public function simpan_tagihan($kode_prodi)
    {
        
    }

    public function pembayaran()
    {
        $this->load->view('keuangan_hth/proses_hth');
    }
	



}

/* End of file Keuangan_hth.php */
/* Location: ./application/controllers/Keuangan_hth.php */