<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->session_cek();
	}
	
	function session_cek()
	{
		$u = $this->session->userdata('level');
		$p = $this->session->userdata('prodi_id');
		$x = $this->session->userdata('keterangan');

		$controller = $this->router->fetch_class();
		$method		= $this->router->fetch_method();

		if($controller == 'login')
		{
			if($method == 'index')
			{
				if( ! empty($u) OR ! empty($p) OR !empty($x))
				{
					
					if($u == 1)
					{
						redirect('admin');
					}
					elseif($u ==2)
					{
						redirect('mahasiswa');
					}
					elseif ($u==3) {
						redirect('dosen');
					}
					elseif ($u==4) {
						redirect('mahasiswa');
					}

					
				}
			}
		}
		else
		{
			if(empty($u))
			{
				redirect('login');
			}
		}


	}

}