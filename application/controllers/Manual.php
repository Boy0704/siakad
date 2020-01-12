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

	public function import_mk()
	{
		if ($_FILES != NULL) {
			$filename = $_FILES['file']['name'];
			// log_r($_FILES);
			$data = array(); // Buat variabel $data sebagai array
		
			if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
				// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
				$upload = $this->Mcrud->upload_file($filename,'./excel','xlsx');
				
				if($upload['result'] == "success"){ // Jika proses upload sukses
					// Load plugin PHPExcel nya
					include APPPATH.'third_party/PHPExcel/PHPExcel.php';
					
					$excelreader = new PHPExcel_Reader_Excel2007();
					$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
					$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
					
					// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
					// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
					$data['sheet'] = $sheet; 
					$data['filename'] = $filename;
				}else{ // Jika proses upload gagal
					$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
				}
			}
			
			$this->load->view('manual_import/import_mk', $data);


		} else {
			$this->load->view('manual_import/import_mk');
		}
		
	}

	public function aksi_import_mk()
	{
		$filename = $this->input->post('filename');
		// log_r($filename);
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
					
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		//skip untuk header
		unset($sheet[1]);
		$this->db->truncate('makul_matakuliah');
		foreach ($sheet as $rw) {
			$data = array(
				'kode_makul' => $rw['A'],
				'nama_makul' => $rw['B'],
				'sks' => $rw['C'],
				'semester' => $rw['D'],
				'konsentrasi_id' => get_data('akademik_konsentrasi','kode_prodi',$rw['E'],'konsentrasi_id'),
				'kelompok_id' => $rw['F'],
				'aktif' => 'y',
				'jam' => $rw['C'],
			);
			$this->db->insert('makul_matakuliah', $data);
		}
		
	}

	



}
