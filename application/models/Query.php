<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Model {

	public function user_data($username, $password)
	{
		// $passwordx          =   $this->m_hashed->hash_verify($password, $password);
        $sql    =   "SELECT * FROM app_users as a, student_mahasiswa as b a.username=$username and a.password=$password";
		return $this->db->query($sql)->result();
	}

	public function waktu()
	{
		date_default_timezone_set('Asia/Jakarta');
		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$jam = date("H:i:s");
		return $hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y")." ".$jam;
	}


	public function get_num_rows()
	{	
		$query = $this->db->get('users');
		return $query->num_rows();

	}

	public function get_num_rowsMahasiswa()
	{	
		$query = $this->db->get('student_mahasiswa');
		return $query->num_rows();

	}

	public function get_num_rowsDosen()
	{	
		$query = $this->db->query("SELECT dosen_id FROM app_dosen WHERE dosen_id !=0");
		return $query->num_rows();

	}

	public function get_num_rowsMatkul()
	{	
		$query = $this->db->get('makul_matakuliah');
		return $query->num_rows();

	}

	public function list_posting_matkul()
	{
		$query = $this->db->query('SELECT * from makul_matakuliah order by makul_id desc limit 1');
		//lihat apakah ada data dalam tabel
		$num = $query->num_rows();
		if($num>0){
			//Mengirimkan data array hasil query
			return $query->result();
			//Function result() hampir sama dengan function mysql_fetch_array()
		}
		else{
			return 0;
			//Kirimkan 0 jika tidak ada datanya
		}
	}

	public function list_posting_mahasiswa()
	{
		$query = $this->db->query('SELECT * from student_mahasiswa order by mahasiswa_id desc limit 1');
		//lihat apakah ada data dalam tabel
		$num = $query->num_rows();
		if($num>0){
			//Mengirimkan data array hasil query
			return $query->result();
			//Function result() hampir sama dengan function mysql_fetch_array()
		}
		else{
			return 0;
			//Kirimkan 0 jika tidak ada datanya
		}
	}

	public function list_posting_dosen()
	{
		$query = $this->db->query('SELECT * from app_dosen order by dosen_id desc limit 1');
		//lihat apakah ada data dalam tabel
		$num = $query->num_rows();
		if($num>0){
			//Mengirimkan data array hasil query
			return $query->result();
			//Function result() hampir sama dengan function mysql_fetch_array()
		}
		else{
			return 0;
			//Kirimkan 0 jika tidak ada datanya
		}
	}

	public function list_posting_users()
	{
		$query = $this->db->query('SELECT * from app_users order by id_users desc limit 1');
		//lihat apakah ada data dalam tabel
		$num = $query->num_rows();
		if($num>0){
			//Mengirimkan data array hasil query
			return $query->result();
			//Function result() hampir sama dengan function mysql_fetch_array()
		}
		else{
			return 0;
			//Kirimkan 0 jika tidak ada datanya
		}
	}
	

	public function deleteMahasiswa($mahasiswa_id)
	{	
		// kueri delete tb_anggota where id_anggota=..
		$this->db->where('mahasiswa_id', $mahasiswa_id);
		$this->db->delete('student_mahasiswa');
	}
// 	public function delenqs($id) {
//     $this->db->where('id', $id);
//     $this->db->delete('enquiry');

// }

	public function getMahasiswa($mahasiswa_id)
	{
		$query = $this->db->where(['mahasiswa_id'=>$mahasiswa_id])
						  ->get('student_mahasiswa');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		
	}

	 function get_mahasiswa_one($mahasiswa_id) {
        $this->db->where('mahasiswa_id', $mahasiswa_id);
        $result = $this->db->get('student_mahasiswa');
        return $result->row();
    }

	public function EditMahasiswa($data, $mahasiswa_id)
	{		
		$this->db->where('mahasiswa_id', $mahasiswa_id);
		$this->db->update('student_mahasiswa', $data);
	}

    //fungsi update ke database
     function get_update($data,$where){
       $this->db->where($where);
       $this->db->update('student_mahasiswa', $data);
       return TRUE;
    }


  function cek_kode($kode)
  {
    return $this->db
      ->select('mahasiswa_id')
      ->where('nim', $kode)
      ->limit(1)
      ->get('student_mahasiswa');
  }
 
  //fungsi delete ke database
  function get_delete($where){
       $this->db->where('mahasiswa_id',$where);
       $this->db->delete("student_mahasiswa");
       return TRUE;
    }
 
//fungsi untuk menampilkan data per satuan dari tabel database
    function get_byimage($where) {
        $this->db->from("student_mahasiswa");
        $this->db->where('mahasiswa_id',$where);
        $query = $this->db->get();
 
        //cek apakah ada data
        if ($query->num_rows() == 1) {
            return $query->row();
        }
    }
}

/* End of file query.php */
/* Location: ./application/models/query.php */

