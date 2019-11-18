<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_kelas');
		$this->load->model('M_angkatan');
		if (!$this->session->userdata('user_role_id')) 
		{
			return redirect('login');
		} 
		elseif ($this->session->userdata('user_role_id') !== 'admin') 
		{
	        // echo "<script>alert('anda tidak punya akses di halaman ini  ');</script>";
	        redirect(base_url());
	    }
	}

	public function index()
	{
		$this->dataKelas();
	}
	public function inserted()
	{
		$this->dataKelas();
	}

	public function dataKelas()
	{

      $kelas = $this->M_kelas->dataKelas();
      $title = "Data Kelas";
      $this->load->view('kelas/data-kelas',['title'=>$title,'kelas'=>$kelas]); 
	}

	public function createKelas()
	{
	    $result = $this->M_kelas->getAllkelas();
	  	$angkatan = $this->M_angkatan->getAngkatan();
	        // $maxangkatan = $this->M_angkatan->getKodeAngkatan();
	  	$title = "Data Kelas";
	  	$this->load->view('kelas/createKelas',['result'=>$result,'title'=>$title,'angkatan'=>$angkatan]);
	}

	public function insertKelas()

   	{  
        $this->form_validation->set_rules('angkatan', 'Angkatan', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|is_unique[kelas.nama_kelas]');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() )
        {
            // pribadi
            $angkatan = $this->input->post('angkatan');
            $kelas = $this->input->post('kelas');
            $pecah = explode(',', $kelas);
            $no = 0;

          	foreach($pecah as $s)
          	{
				$query = $this->M_kelas->addKelas($angkatan, $s);
				$no++;
			}

			if ($query) {
				$this->session->set_flashdata('kelas_add', "<div>Kelas ". strtoupper($kelas)." Berhasil Di Simpan</div>");
			}
			else{
				$this->session->set_flashdata('kelas_add', 'Data gagal di tambahkan');
			}
			return redirect('Kelas/inserted');
			   
                
        }
        else
        {
            $this->createKelas();
        }
   	}

}


/* End of file kelas.php */
/* Location: ./application/controllers/kelas.php */