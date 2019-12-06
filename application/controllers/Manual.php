<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manual extends CI_Controller {

	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function set_login_mahasiswa()
	{
		foreach ($this->db->get('student_mahasiswa')->result() as $key => $value) {
			$data = array(
				'username' => $value->nim,
				'nama' => $value->nama,
				'password' => '$2y$10$ltjta77Cq.KmAgFumQt8hOJM/x.ZxyahSLGG/00Y00EDifCRFSQ0i',
				'level' => 4,
				'keterangan' => $value->mahasiswa_id,
				'konsentrasi_id' => $value->konsentrasi_id
			);
			$cek_nim = $this->db->get_where('app_users', array('username'=>$value->nim))->num_rows();
			if ($cek_nim == 1) {
				$d_update = array(
					'nama' => $value->nama,
					'password' => '$2y$10$ltjta77Cq.KmAgFumQt8hOJM/x.ZxyahSLGG/00Y00EDifCRFSQ0i',
					'level' => 4,
					'keterangan' => $value->mahasiswa_id,
					'konsentrasi_id' => $value->konsentrasi_id
				);
				$this->db->where('username', $value->nim);
				$this->db->update('app_users', $d_update);
				echo "berhasil update ".$value->nim." <br>";
			} elseif($cek_nim == 0) {
				$this->db->insert('app_users', $data);
				echo "berhasil insert ".$value->nim." <br>";
			}
		}
	}

}
