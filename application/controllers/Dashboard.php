<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $title  = "Dashboard";
	var $folder = "login";
	public function index()
	{	
		$title = $this->title;

        $this->load->view('login/dashboard', ['title'=>$title]);	  			
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */