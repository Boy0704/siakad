<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_log extends CI_Model {

	public function save_log($param)
    {
        $sql        = $this->db->insert_string('tabel_log',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }

    public function data_tabel_log()
    {   	
		$this->db->select('*');
		$this->db->from('tabel_log');
		$this->db->order_by('log_id', 'asc');
		$query = $this->db->get();
		return $query;	
    }

    public function data_log()
    {   	
		$query = $this->db->query('SELECT * from tabel_log order by log_id desc');
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

}

/* End of file m_log.php */
/* Location: ./application/models/m_log.php */