<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {
	var $title = "Laporan Jadwal Kuliah";

	public function __construct(){
		parent::__construct();
		 $this->load->library('zend');
		 $this->load->model('M_angkatan');
		 $this->load->database();
	}

	public function index()
	{
		redirect(base_url());
	}
	public function cetakMahasiswa()
	{
		$this->load->model('Query');
	    $data = $this->Query->data_Mahasiswa();
	    $jumlah  = $this->Query->get_num_rowsMahasiswa();
	    $this->load->view('laporan/cetakMahasiswa',['data'=>$data,'jumlah_mahasiswa'=>$jumlah]);
	}

	public function cetakKartu()
	{
		$this->load->model('Query');
	    $data = $this->Query->data_Mahasiswa();
	    $jumlah  = $this->Query->get_num_rowsMahasiswa();
	    $this->load->view('laporan/kartu_mahasiswa',['data'=>$data,'jumlah_mahasiswa'=>$jumlah]);
	}

	public function cetakMahasiswaExel()
	{
		$this->load->model('Query');
	    $data = $this->Query->data_Mahasiswa();
	    $jumlah  = $this->Query->get_num_rowsMahasiswa();
	    $this->load->view('laporan/exel/cetakMahasiswaExel',['data'=>$data,'jumlah_mahasiswa'=>$jumlah]);
	}

	public function cetakJadwalMatakuliah()
	{
		$this->load->model('M_jadwalKuliah');
	    $data = $this->M_jadwalKuliah->dataJadwalMatkul();
	    $title = $this->title;
	    $this->load->view('laporan/cetakJadwalkuliah',['title'=>$title,'data'=>$data]);
	}
	public function cetakDosen()
	{
		$this->load->model('M_dosen');
		$data = $this->M_dosen->dataDosen();
		$title = $this->title;
		$this->load->view('laporan/cetakDosen',['data'=>$data,'title'=>$title]);
	}
	public function cetakBiodataMhs($mahasiswa_id)
	{
		$this->load->model('Query');
      	$data['record'] = $this->Query->get_mahasiswa_one($mahasiswa_id);
      	$data['angkatan'] = $this->M_angkatan->getAngkatan();
        $data['semester'] = $this->db->get('semester')->result();
      	$data['title'] = $this->title;
      	$this->load->view('laporan/cetakBiodataMhs', $data);
	}

	public function generate($kode)
    {
        // we load zend barcode
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text' => $kode));

    }
    public function barcode($kode)
    {
    	$this->load->library('ciqrcode');
 		// $kode = $kode;
 		QRcode::png($kode,
		$outfile = false,
		$level = QR_ECLEVEL_H,
		$size = 3,
		$margin = 2,
		$saveandprint = false
		);
    }
	
	public function cetakJadwalPerkelas($kelas_id)
	{	
		
        $this->load->model('M_angkatan');
        $data['data'] =  $this->M_angkatan->m_cetakkelas($kelas_id);
        $this->load->view('laporan/laporanperkelas/cetakjadwalkelas',$data);	  
	}

}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */