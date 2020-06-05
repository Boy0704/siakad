<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Keuangan_hth extends CI_Controller
{
	
    public function index()
    {
        $data['title']=  'Keuangan H2H Bank BSM';
        $this->template->load('template', 'keuangan_hth/add_tagihan',$data);
    }

    

    public function simpan_tagihan($kode_prodi)
    {
        
    }

    public function import_tagihan()
    {
        $this->session->set_flashdata('message',alert_biasa('Tagihan gagal di import, karena data sudah ada','error'));
        redirect('Keuangan_hth/index','refresh');
    }

    public function import_excel()
    {

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/import_tagihan.xlsx'); // Load file yang tadi diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
        
        //skip untuk header
        unset($sheet[1]);

        // log_r($sheet);
        $x = 1;

        $a = array();
        $b = array();

        foreach ($sheet as $rw) {
            
            
            $nim = $rw['B'];
            $kode_periode = $rw['D'];
            $nama_periode = nama_periode(substr($kode_periode, 0,4));
            $nama = $rw['C'];
            $angkatan = get_data('student_angkatan','angkatan_id',get_data('student_mahasiswa','nim',$nim,'angkatan_id'),'keterangan');
            $konsentrasi_id = get_data('student_mahasiswa','nim',$nim,'konsentrasi_id');
            $kode_prodi = get_data('akademik_konsentrasi','konsentrasi_id',$konsentrasi_id,'kode_prodi');
            $nama_prodi = get_data('akademik_konsentrasi','konsentrasi_id',$konsentrasi_id,'nama_konsentrasi');
            $total_tagihan = $rw['E'];
            $id_record_tagihan = $kode_prodi.time().$x;

            $data = array(
                'id_record_tagihan' => $id_record_tagihan,
                'nomor_pembayaran'=>$nim.$kode_periode,
                'nama'=>$nama,
                'kode_prodi'=>$kode_prodi,
                'nama_prodi'=>$nama_prodi,
                'kode_periode'=>$kode_periode,
                'nama_periode'=>$nama_periode,
                'is_tagihan_aktif'=>1,
                'waktu_berlaku'=> get_waktu(),
                'waktu_berakhir'=> date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d')))),
                'strata' => 'S1',
                'angkatan'=> $angkatan,
                'urutan_antrian' => 1,
                'total_nilai_tagihan' => $total_tagihan,
                'nomor_induk'=>$nim,
                'pembayaran_atau_voucher'=>'PEMBAYARAN'
            );

            array_push($a, $data);

            $detail_tagihan = array(
                'id_record_detil_tagihan' => time().$x,
                'id_record_tagihan' => $id_record_tagihan,
                'urutan_detil_tagihan' => 1,
                'kode_jenis_biaya' => '001',
                'label_jenis_biaya' => $rw['A'],
                'label_jenis_biaya_panjang' => 'pembayaran '.$rw['A'],
                'nilai_tagihan' => $total_tagihan
            );

            array_push($b, $detail_tagihan);


            

            // if ($simpan_tagihan && $simpan_d_tagihan) {
            //     // $this->session->set_flashdata('message', alert_biasa('Tagihan berhasil dibuat','success'));
            //     // redirect('bayar_dinamis/index/'.$nim,'refresh');
            //     echo "berhasil <br>";
                
            // } else {
            //     // $this->session->set_flashdata('message', alert_biasa('Tagihan gagal dibuat','info'));
            //     // redirect('bayar_dinamis/index/'.$nim,'refresh');
            //     echo "gagal <br>";
            // }
            $x++;
            

        }

        
        $keuangan = $this->load->database('keuangan', TRUE);
        // log_data($data);
        // log_r($detail_tagihan);
        $simpan_tagihan =$keuangan->insert_batch('tagihan', $a);
        $simpan_d_tagihan =$keuangan->insert_batch('detil_tagihan', $b);

        echo "<h2>SELESAI</h2>";
    }

    public function pembayaran()
    {
        $this->load->view('keuangan_hth/proses_hth');
    }
	



}

/* End of file Keuangan_hth.php */
/* Location: ./application/controllers/Keuangan_hth.php */