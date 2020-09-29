<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_mhs extends CI_Model {


	// Fungsi untuk melakukan proses upload file
	public function upload_file($filename){
		$this->load->library('upload'); // Load librari upload

		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '2048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;

		$this->upload->initialize($config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
	public function insert_multiple($data){
		$this->db->insert_batch('siswa', $data);
	}

	public function cek_sks_old($nim,$semester_aktif)
	{
		return 24;
		exit();
		$semester_old = $semester_aktif-1;
		if ($semester_old==0) {
			$semester_old = Null;
		}
		$cek_data = $this->db->get_where('student_mahasiswa', array('nim'=>$nim,'semester'=>$semester_old));
		if ($cek_data->num_rows()==0) {
			$ip = 0;
		}else {
			$ip = $cek_data->row()->ipk;
		}
		if ($ip >= "0" AND $ip <= "1.50") {
			$sks = 24;
		}elseif ($ip >= "1.51" AND $ip <= "1.99") {
			$sks = 15;
		}elseif ($ip >= "2.00" AND $ip <= "2.49") {
			$sks = 18;
		}elseif ($ip >= "2.50" AND $ip <= "2.99") {
			$sks = 21;
		}else {
			$sks = 30;
		}
		return $sks;
	}
}
