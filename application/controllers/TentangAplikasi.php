<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TentangAplikasi extends CI_Controller {

	public function index()
	{
		$title['title'] = "Tentang Aplikasi";
		$this->load->view('login/tentang',$title);
	}

}

/* End of file tentangAplikasi.php */
/* Location: ./application/controllers/tentangAplikasi.php */