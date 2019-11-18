<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwalKuliah extends CI_Model {

	var $table  =   "jadwal_kuliah";

	public function dataJadwalMatkul()
	{	
		$this->db->select(['a.id_jadwal','a.angkatan_id','a.jam_mulai','a.jam_selesai','a.matkul_id','a.dosen_id','a.hari_id','b.nama_matkul','c.nama_kelas','d.nama','e.nama_hari']);
		$this->db->from('jadwal_kuliah a');
		$this->db->join('matkul b', 'b.matkul_id = a.matkul_id','left');
		$this->db->join('kelas c', 'c.kelas_id = a.kelas_id', 'left');
		$this->db->join('dosen d', 'd.dosen_id = a.dosen_id','left');
		$this->db->join('hari e', 'e.hari_id = a.hari_id', 'left');
		$this->db->order_by('angkatan_id','asc');
		$query = $this->db->get();
		return $query->result();
	
			// $this->db->select("*");
			// $this->db->from($this->table);
			// // $this->db->order_by('nama_matkul', 'desc');
			// $query = $this->db->get();
			// return $query;
		
	}	

	public function getJadwalKuliah()
	{	
		$query = $this->db->where(['id_jadwal'=>'1'])
						  ->get($this->table);
		if ($query->num_rows() > 0) {
			return $query->row()->id_jadwal;
		}
	}

	public function addJadwalKuliah($data)
	{
		$this->db->insert($this->table, $data);
		return true;
	}
	public function getJadwalKuliahEdit($id_jadwal)
	{
		$query = $this->db->where(['id_jadwal'=>$id_jadwal])
						  ->get('jadwal_kuliah');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
	}
	public function M_Editjadwal($data,$id)
	  {
	    $this->db->where('id_jadwal', $id);
	    $this->db->update($this->table, $data);
	    return true;
	  }
	public function deleteJadwalMatkul($jadwal_kuliah_id)
	{
		$this->db->where('id_jadwal', $jadwal_kuliah_id);
		$this->db->delete($this->table);
		return true;
	}


}

/* End of file m_jadwalKuliah.php */
/* Location: ./application/models/m_jadwalKuliah.php */