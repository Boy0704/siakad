<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_agama extends CI_Model {

public function getAgama(){
  // $this->db->order_by('nama_agama','ASC');
  return $this->db->get("agama");
 }
 
}

/* End of file m_agama.php */
/* Location: ./application/models/m_agama.php */