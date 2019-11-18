<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

	public function pesan()
	{
		// echo "<script>alert('Anda Tidak Punya Hak Akses Disini')</script>";
		redirect(base_url());
	}

}

/* End of file message.php */
/* Location: ./application/controllers/message.php */