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

	public function import_dosen($status)
	{
		$filename = 'upload dosen.xlsx';
		if ($status == '0') {
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			log_data($sheet);
		} else {
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			log_data($sheet);
			//skip untuk header
			unset($sheet[1]);
			// $this->db->truncate('makul_matakuliah');
			$no1=0;
			$no2=0;
			foreach ($sheet as $rw) {
				$data_insert = array(
					'nidn'=>$rw['A'],
					'nama_lengkap'=>$rw['B'],
					'prodi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['C'],'prodi_id'),
					'konsentrasi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['C'],'konsentrasi_id')
				);
				$this->db->insert('app_dosen', $data_insert);
				$id_dosen = $this->db->insert_id();

				$data_users = array(
					'username'=>$rw['A'],
					'password'=> hash_string("123456"),
					'keterangan'=>$id_dosen,
					'level'=>3,
					'konsentrasi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['C'],'konsentrasi_id')
				);
				$this->db->insert('app_users', $data_users);

			}
			echo "BERHASIL UPLOAD DATA DOSEN";
		}
	}

	public function import_mhs($status)
	{
		$filename = 'upload_mhs.xlsx';
		if ($status == '0') {
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			log_data($sheet);
		} else {
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			log_data($sheet);
			//skip untuk header
			unset($sheet[1]);
			// $this->db->truncate('makul_matakuliah');
			$no1=0;
			$no2=0;
			foreach ($sheet as $rw) {
				$data_insert = array(
					'nim'=>$rw['A'],
					'nama'=>$rw['B'],
					'status_mhs'=>$rw['C'],
					'konsentrasi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['D'],'konsentrasi_id'),
					'angkatan_id'=>get_data('student_angkatan','keterangan',$rw['F'],'angkatan_id')
				);
				$this->db->insert('student_mahasiswa', $data_insert);
				$id_mhs = $this->db->insert_id();

				$data_users = array(
					'username'=>$rw['A'],
					'password'=> hash_string("123456"),
					'keterangan'=>$id_mhs,
					'level'=>4,
					'konsentrasi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['D'],'konsentrasi_id')
				);
				$this->db->insert('app_users', $data_users);

			}
			echo "BERHASIL UPLOAD DATA MAHASISWA";
		}
	}

	public function import_khs_manual($status,$tahun_akademik_id=0)
	{
		$filename = 'KHS_GANJIL_2019.xlsx';
		if ($status == '0') {
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			log_data($sheet);
		} else {
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$filename.''); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			log_data($sheet);
			//skip untuk header
			unset($sheet[1]);
			// $this->db->truncate('makul_matakuliah');
			$no1=0;
			$no2=0;
			foreach ($sheet as $rw) {

				//cek makul_id
				$makul_id = get_data('makul_matakuliah','kode_makul',$rw['F'],'makul_id');

				//cek jadwal_id
				$jadwal_id = $this->db->get_where('akademik_jadwal_kuliah', array('makul_id'=>$makul_id,'tahun_akademik_id'=>$tahun_akademik_id))->row()->jadwal_id;
				// log_r($jadwal_id);

				//cek dosen_id
				$dosen_id = get_data('app_dosen','nidn',$rw['G'],'dosen_id');
				//update dosen
				$this->db->where('jadwal_id', $jadwal_id);
				$this->db->update('akademik_jadwal_kuliah', array('dosen_id'=>$dosen_id));

				$data_insert_krs = array(
					'nim'=>$rw['A'],
					'jadwal_id'=>$jadwal_id,
					'semester'=>$rw['C']
				);
				$this->db->insert('akademik_krs', $data_insert_krs);
				$krs_id = $this->db->insert_id();

				$data_khs = array(
					'krs_id'=>$krs_id,
					'mutu'=>$rw['E'],
					'nilai'=>$rw['B'],
					'grade'=>$rw['D'],
					'confirm'=>1
				);
				$this->db->insert('akademik_khs', $data_khs);

			}
			echo "BERHASIL UPLOAD KHS MAHASISWA";
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
		// $this->db->truncate('makul_matakuliah');
		$no1=0;
		$no2=0;
		foreach ($sheet as $rw) {

			$cek_mk = $this->db->get_where('makul_matakuliah', array('kode_makul'=>$rw['A'],'konsentrasi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['E'],'konsentrasi_id')));
			if ($cek_mk->num_rows() == 0) {
				$no1++;
				$data_insert = array(
					'kode_makul' => $rw['A'],
					'nama_makul' => $rw['B'],
					'sks' => $rw['C'],
					'semester' => $rw['D'],
					'konsentrasi_id' => get_data('akademik_konsentrasi','kode_prodi',$rw['E'],'konsentrasi_id'),
					'kelompok_id' => $rw['F'],
					'aktif' => 'y',
					'jam' => $rw['C'],
				);
				$this->db->insert('makul_matakuliah', $data_insert);
			}else {
				$no2++;
				$data_update = array(
					'nama_makul' => $rw['B'],
					'sks' => $rw['C'],
					'semester' => $rw['D'],
					'kelompok_id' => $rw['F'],
					'aktif' => 'y',
					'jam' => $rw['C'],
				);
				$this->db->where('kode_makul', $rw['A']);
				$this->db->where('konsentrasi_id', get_data('akademik_konsentrasi','kode_prodi',$rw['E'],'konsentrasi_id'));
				$this->db->update('makul_matakuliah', $data_update);
			}

			
		}
		echo $no1.'<br>';
		echo $no2.'<br>';
		
	}


	public function import_khs()
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
			
			$this->load->view('manual_import/import_khs', $data);


		} else {
			$this->load->view('manual_import/import_khs');
		}
		
	}

	public function aksi_import_khs()
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
