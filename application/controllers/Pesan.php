<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
	var $title = "pesan";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		if (!$this->session->userdata('user_role_id')) 
		{
			redirect('login');	
		}
		elseif($this->session->userdata('user_role_id') !== 'admin'){
			redirect(base_url());
		}
		
		
	}

	public function index()
	{
		$data = $this->title;
		$this->load->view('pesan/kirim_pesan',['title'=>$data]);
	}

	public function sendmsg()
	{
		
		$this->form_validation->set_rules('mobile', 'mobile', 'required');
		$this->form_validation->set_rules('message', 'message', 'required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		if ($this->form_validation->run()) {
			$mobile = $this->input->post('mobile');
			$message = $this->input->post('message');

			$data = $this->input->post();
			unset($data['submit']);
			$encodeMessage = urlencode($message);;
			$autkey = "18cwok";
			$passkey= "yryTeL";
			$route  = "";

			$postData = array('autkey'=>$autkey,
							  'mobiles'=>$mobile,
							  'message'=>$encodeMessage,
							  // 'sender'=>$senderId,
							  'route'=>$route
							  );
			// $url = "http//api.";
			$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$autkey&passkey=$passkey&nohp=$mobile&pesan=$encodeMessage";

			$ch  = curl_init();
			curl_setopt_array($ch,array(
										CURLOPT_URL => $url,
										CURLOPT_RETURNTRANSFER => TRUE,
										CURLOPT_POST => TRUE,
										CURLOPT_POSTFIELDS => $postData
										));

			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


			$output = curl_exec($ch);
			if (curl_errno($ch))
			{
				echo 'error:' . curl_error($ch);
			}

			curl_close($ch);
			?>
				<p>response ID :<?php echo $output; ?> message berhasil di kirim</p>

			<?php
			



		} else {
			$this->index();
		}
		
	}

}

/* End of file pesan.php */
/* Location: ./application/controllers/pesan.php */