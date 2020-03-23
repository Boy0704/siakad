<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Feeder extends CI_Controller
{
	
	public function import_krs_feeder()
    {
        // Load database kedua
        $feeder = $this->load->database('feeder', TRUE);
        foreach ($this->db->get('v_import_krs')->result() as $rw) {
            $data = array(
                'nim' => $rw->nim,
                'nama' => $rw->nama,
                'kode_mk' => $rw->kode_makul,
                'nama_mk' => $rw->nama_makul,
                'nama_kelas' => $rw->nama_kelas,
                'semester' => $rw->semester,
                'kode_jurusan' => $rw->kode_jurusan,
                'status_eror' => 0,
            );
            $feeder->insert('krs', $data);
        }
        
        ?>
        <script type="text/javascript">
            alert('Berhasil Import Krs Ke Import feeder');
            window.location="http://localhost/feeder-importer/admina/index.php/krs";
        </script>
        <?php
    }

    public function import_khs_feeder()
    {
        // Load database kedua
        $feeder = $this->load->database('feeder', TRUE);
        foreach ($this->db->get('v_import_khs')->result() as $rw) {
            $data = array(
                'nim' => $rw->nim,
                'nama' => $rw->nama,
                'kode_mk' => $rw->kode_makul,
                'nama_mk' => $rw->nama_makul,
                'nama_kelas' => $rw->nama_kelas,
                'semester' => $rw->semester,
                'kode_jurusan' => $rw->kode_jurusan,
                'status_eror' => 0,
                'nilai_angka' => $rw->nilai_angka,
                'nilai_huruf' => $rw->nilai_huruf,
                'nilai_indek' => $rw->nilai_indek,
            );
            $feeder->insert('nilai', $data);
        }
        
        ?>
        <script type="text/javascript">
            alert('Berhasil Import KHS Ke Import feeder');
            window.location="http://localhost/feeder-importer/admina/index.php/nilai-perkuliahan";
        </script>
        <?php
    }
	


}

/* End of file Feeder.php */
/* Location: ./application/controllers/Feeder.php */