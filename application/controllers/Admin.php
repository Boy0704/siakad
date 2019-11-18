<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller 
{

	var $title = "siakad.ac.id";

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Chart_model', 'Query'));
	}
	
	public function password($pass)
    {
    	echo password_hash($pass, PASSWORD_DEFAULT);
    }
	
	public function reset_akun()
    {
    	$ambildata = $this->db->query("SELECT * FROM `student_mahasiswa` WHERE nim LIKE '16%'")->result();
    	foreach ($ambildata as $rw) {
    		$username = $rw->nim;
    		$nama = $rw->nama;
    		$password = '$2y$10$zWxT3sEVhPe1jKboHTY/5OJ2PDKeGXX2Z/dUj.qWyhtren.LK2smi';
    		$level = 4;
    		$keterangan = $rw->mahasiswa_id;
    		$konsentrasi_id = 3;
    
    		$data = array(
    			'username' => $username,
    			'nama' => $nama,
    			'password' => $password,
    			'level' => $level,
    			'keterangan' => $keterangan,
    			'konsentrasi_id' => $konsentrasi_id,
    		);
    		$this->db->insert('app_users', $data);
    
    		echo "berhasil" ;
    
    	}
    }

	public function index()
	{
		
		if ($this->session->userdata('level') == 1) 
		{
			$data['title']     = $this->title;
			$data['mahasiswa'] = $this->Query->get_num_rowsMahasiswa();
			$data['dosen']     = $this->Query->get_num_rowsDosen();
			$data['matkul']    = $this->Query->get_num_rowsMatkul();
			$data['makul_list']     = $this->Query->list_posting_matkul();
			$data['mahasiswa_list']     = $this->Query->list_posting_mahasiswa();
			$data['dosen_list']     = $this->Query->list_posting_dosen();
			$data['users_list']     = $this->Query->list_posting_users();
			$data['char_data'] = $this->Chart_model->statistik_mahasiswa();
			$this->load->view('admin',$data);
		}
		else{
			echo "<script>alert('anda tidak punya akses disini')</script>";
			redirect(base_url(),'refresh');
		}
				
	}
	

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */