<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {

	var $table = "users";

	public static function tgl_id($date, $bln='')
  {
 		 $str = explode('-', $date);
 		 $bulan = array(
 			 '01' => 'Januari',
 			 '02' => 'Februari',
 			 '03' => 'Maret',
 			 '04' => 'April',
 			 '05' => 'Mei',
 			 '06' => 'Juni',
 			 '07' => 'Juli',
 			 '08' => 'Agustus',
 			 '09' => 'September',
 			 '10' => 'Oktober',
 			 '11' => 'November',
 			 '12' => 'Desember',
 		 );
 		 if ($bln == '') {
 			 $hasil = $str['0'] . " " . $bulan[$str[1]] . " " .$str[2];
 		 }else {
 			 $hasil = $bulan[$str[1]];
 		 }
 		 return $hasil;
  }
	
	public function cek_filename($file='')
	{
		$data = "images/user.png";
		if ($file != '') {
			if(file_exists("$file")){
				$data = $file;
			}
		}

		return $data;
	}

	public function m_dataUsers()
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->order_by('username', 'asc');
		$query = $this->db->get();
		return $query;
	}

	public function getAllUsers()
	{
		$query = $this->db->where(['user_id'=>'1'])
						  ->get($this->table);
			if ($query->num_rows() > 0)
			{
			return $query->row()->user_id;
			}
	}

	public function M_insertUsers($data)
	{
		$this->db->insert('users', $data);
		return true;
	}

	public function update($id,$data)
   {
     $this->db->where('user_id', $id);
     $this->db->update('users', $data);
   }

}

/* End of file m_users.php */
/* Location: ./application/models/m_users.php */
