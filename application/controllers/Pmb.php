<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb extends CI_Controller {

	
	public function index()
	{
		$data['title']=  'Export PMB';
        $this->template->load('template', 'pmb/view',$data);
	}

	public function export()
	{
		$pmb = $this->load->database('pmb', TRUE);

		$tahun = $this->input->get('tahun');
		$pmb->like('tgldaftar', $tahun, 'after');
		$data['query'] = $pmb->get('peserta');
		$data['tahun'] = $tahun;
		$this->load->view('pmb/export',$data);
	}

}
