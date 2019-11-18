<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hari extends CI_Model {

	public function getHari()
	{
		return $this->db->get('hari');
	}

}

/* End of file m_hari.php */
/* Location: ./application/models/m_hari.php */