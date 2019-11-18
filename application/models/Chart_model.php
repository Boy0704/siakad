<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_model extends CI_Model {

	public function statistik_mahasiswa()
	{
		return $this->db->query('
			SELECT b.keterangan,
			(SELECT count(angkatan_id) FROM student_mahasiswa a WHERE b.angkatan_id = a.angkatan_id) AS offers FROM student_angkatan b WHERE b.angkatan_id IN (SELECT angkatan_id FROM student_mahasiswa WHERE b.angkatan_id = angkatan_id) ORDER BY b.keterangan ASC')->result_array();
	}



	public function getChartData()
	{  
	    $sql = "SELECT b.keterangan, count(a.angkatan_id) as jumlah FROM student_mahasiswa as a
	    		LEFT JOIN student_angkatan b ON a.angkatan_id = b.angkatan_id GROUP BY a.angkatan_id ORDER BY keterangan ASC";
	    $query = $this->db->query($sql);
	    return $query->result();
	}
}

/* End of file chart_model.php */
/* Location: ./application/models/chart_model.php */