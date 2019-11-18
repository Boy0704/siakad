<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelas extends CI_Model {


	public function getAllkelas()
	{
		$query = $this->db->where(['angkatan_id'=>'1'])
							  ->get("kelas");
			if ($query->num_rows() > 0) {
				return $query->row()->kelas_id;
			}
	}

	public function dataKelas()
	{
		$this->db->select('*');
		$this->db->from("kelas");
		$this->db->order_by('kelas_id', 'asc');
		$query = $this->db->get();
		return $query;
	}
	
	public function addKelas($angkatan, $s)
	{
		$query = "INSERT INTO kelas (angkatan_id, nama_kelas) VALUES ('$angkatan', '$s')"; 
		$this->db->query($query);
		return TRUE;
	}
}

/* End of file m_kelas.php */
/* Location: ./application/models/m_kelas.php */