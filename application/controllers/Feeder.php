<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Feeder extends CI_Controller
{
	
    public function import_mhs()
    {
        // Load database kedua
        $feeder = $this->load->database('feeder', TRUE);

        // get batas registrasi tahun akademik yang aktif
        $thun_admk  = $this->db->get_where('akademik_tahun_akademik',array('status'=>'y'))->row_array();
        //cek tahun akademik skrg
        $thn_akademik = $thun_admk['keterangan'];
        foreach ($this->db->get('v_import_mhs')->result() as $rw) {
            $data = array(
                'nik'=> '123456789',
                'nipd'=> $rw->nim,
                'nm_pd'=> $rw->nama,
                'tmpt_lahir'=> $retVal = ($rw->tempat_lahir == '') ? '-' : $rw->tempat_lahir,
                'tgl_lahir'=> $rw->tanggal_lahir,
                'jk' => $retVal = ($rw->gender == '1') ? 'L' : 'P' ,
                'id_agama'=> $rw->agama_id,
                'a_terima_kps'=> 0,
                'kewarganegaraan'=> $rw->kewarganegaraan,
                'id_jns_daftar'=> 1,
                'kode_jurusan'=> get_data('akademik_konsentrasi','konsentrasi_id',$rw->konsentrasi_id,'kode_prodi'),
                'tgl_masuk_sp'=> $rw->tgl_masuk_kuliah,
                'mulai_smt'=> $thn_akademik,
                'ds_kel'=> $retVal = ($rw->kelurahan == '') ? '-' : $rw->kelurahan,
                'id_wil'=> $retVal = ($rw->kecamatan == '') ? '016405' : $rw->kecamatan,
                'nm_ibu_kandung'=> $retVal = ($rw->nama_ibu == '') ? '-' : $rw->nama_ibu,
                'biaya_masuk_kuliah'=> 5000000,
                'status_error' => 0,
            );
            // log_r($data);
            $feeder->insert('mhs', $data);
        }
        
        ?>
        <script type="text/javascript">
            alert('Berhasil Import Mahasiswa Ke Import feeder');
            window.location="http://localhost/feeder-importer/admina/index.php/mahasiswa";
        </script>
        <?php
    }

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
                'status_error' => 0,
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
                'status_error' => 0,
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