<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dosen extends CI_Model {

	var $table  =   "dosen";

	public function getAlldosen()
	{
		$query = $this->db->where(['dosen_id'=>'1'])
						  ->get($this->table);
			if ($query->num_rows() > 0)
			{
					return $query->row()->dosen_id;
			}
	}

	public function dataDosen()
	{
			$this->db->select("*");
			$this->db->from($this->table);
			$this->db->order_by('nip', 'asc');
			$query = $this->db->get();
			return $query;
		
	}	

	public function AddDosen($data)
	{
		$this->db->insert($this->table, $data);
		return true;
	}

	public function getDosen($dosen_id)
	{
		$query = $this->db->where(['dosen_id'=>$dosen_id])
						  ->get($this->table);
			if ($query->num_rows() > 0)
			{
			return $query->row();
			}
	}

	public function tampilkanDosen()
	{
		
		$this->db->order_by('nama', 'ASC');
		return $this->db->get($this->table);

	}

	public function EditDosen($data, $id)
	{		
		$this->db->where('dosen_id', $id);
		$this->db->update($this->table, $data);
		return true;
	}

	public function deleteDosen($dosen_id)
	{	
		// kueri delete tb_anggota where id_anggota=..
		$this->db->where(['dosen_id'=>$dosen_id])
				 ->delete($this->table);
		return true;
	}

}

/* End of file m_dosen.php */
/* Location: ./application/models/m_dosen.php */