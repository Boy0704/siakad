<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {
	
	var $title = "Gallery";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Query');
		if (!$this->session->userdata('user_role_id')) 
		{
      		return redirect('login');
    	}
	}

	public function index()
	{
    	$data = $this->Query->data_Mahasiswa();
		$title = $this->title;
		$this->load->view('gallery/gallery',['title'=>$title,'data'=>$data]);
	}

}

/* End of file gallery.php */
/* Location: ./application/controllers/gallery.php */