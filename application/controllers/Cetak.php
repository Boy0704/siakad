<?php
class cetak extends MY_Controller
{
    var $folder =   "krs";
    var $tables =   "akademik_krs";
    var $pk     =   "krs_id";
    var $title  =   "Cetak KRS";

    function __construct() {
        parent::__construct();
         $this->load->library('cfpdf');
    }

    function cetakkhs()
    {
        $mahasiswa  =   $this->uri->segment(4);
        $semester   =   $this->uri->segment(3);
        $sqlMHS     =   "SELECT ap.nama_prodi,ak.nama_konsentrasi,sm.nama,sm.nim,sm.semester_aktif
                        FROM student_mahasiswa as sm,akademik_prodi as ap,akademik_konsentrasi as ak
                        WHERE sm.konsentrasi_id=ak.konsentrasi_id and ak.prodi_id=ap.prodi_id and sm.mahasiswa_id=$mahasiswa";
        $m          =  $this->db->query($sqlMHS)->row_array();
        $khs        =   "SELECT kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.confirm,kh.khs_id,kh.tugas,kh.kehadiran
                         FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                         app_dosen as ad,akademik_khs as kh
                         WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                         and ak.nim='$m[nim]' and kh.krs_id=ak.krs_id and ak.semester='$semester' and kh.confirm='1' GROUP BY kh.krs_id";

        $nim = $m['nim'];
        $semester_old = $semester-1;
        if ($semester_old==0) {
        	$semester_old = Null;
        }
        $cek_data = $this->db->get_where('akademik_ip', array('nim'=>$nim,'semester'=>$semester_old));
        if ($cek_data->num_rows()==0) {
        	$ip = 0;
        }else {
          $ip = $cek_data->row()->ip;
        }
        $cek_data2 = $this->db->get_where('student_mahasiswa', array('nim'=>$nim,'semester'=>$semester_old));
        if ($cek_data2->num_rows()==0) {
        	$ipk = 0;
        }else {
          $ipk = $cek_data2->row()->ipk;
        }
        $pdf = new FPDF('p','mm','A4');
        $pdf->AddPage();
       // head
       $pdf->SetFont('TIMES','',16);
       $pdf->Cell(190, 5, 'SEKOLAH TINGGI ILMU KESEHATAN', 0, 1, 'C');
       $pdf->Cell(190, 5, 'KELUARGA BUNDA JAMBI', 0, 1, 'C');
       $pdf->SetFont('TIMES','',10);
       $pdf->Cell(190, 4, 'Kampus :  Talang Bakung, South Jambi, Jambi City, Jambi', 0, 1, 'C');
       $pdf->Cell(190, 5, 'Telp 813-6685-5307 E.Mail :  info@stikeskeluargabunda.ac.id', 0, 1, 'C');
       $pdf->Image(base_url().'images/logo/logouit.gif', 10, 8, 20);
       $pdf->Line(10, 30, 200, 30);

       $pdf->SetFont('TIMES','B',12);
       $pdf->Cell(1,2,'',0,1);
       $pdf->Cell(180, 8, 'KARTU HASIL STUDI (K H S)', 0, 1, 'C');
       $pdf->Cell(2, 2,'',0,1);
       // buat tabel disini
       $pdf->SetFont('TIMES','B',9);
       $pdf->Cell(20,5,'NIM',0,0);
       $pdf->Cell(80,5,' : '.  strtoupper($m['nim']),0,0);
       $pdf->Cell(30,5,'',0,0);
       $pdf->Cell(20,5,'',0,1);

       $pdf->Cell(20,5,'NAMA ',0,0);
       $pdf->Cell(80,5,' : '.  strtoupper($m['nama']),0,0);
       $pdf->Cell(30,5,'SEMESTER',0,0);
       $pdf->Cell(20,5,' : '.  strtoupper($m['semester_aktif']),0,1);

       $pdf->Cell(20,5,'JURUSAN',0,0);
       $pdf->Cell(80,5,' : '.  strtoupper($m['nama_prodi']),0,0);
    //   if ($semester>1) {
    //      $pdf->Cell(30,5,'IP SMSTR LALU',0,0);
    //      $pdf->Cell(20,5,' : '.  strtoupper($ip),0,1);
    //   }else {
    //      $pdf->Cell(30,5,'',0,0);
    //      $pdf->Cell(20,5,'',0,1);
    //   }

    //   $pdf->Cell(20,5,'',0,0);
    //   $pdf->Cell(80,5,'',0,0);
    //   if ($semester>1) {
    //      $pdf->Cell(30,5,'IPK SMSTR LALU',0,0);
    //      $pdf->Cell(20,5,' : '.  strtoupper($ipk),0,1);
    //   }else {
    //      $pdf->Cell(30,5,'',0,0);
    //      $pdf->Cell(20,5,'',0,1);
    //   }

       // kasi jarak
       $pdf->Cell(3,2,'',0,1);
       // kasi jarak
       $pdf->Cell(3,2,'',0,1);
       // kasi jarak
       $pdf->Cell(3,2,'',0,1);

       $pdf->Cell(7, 5, 'NO', 1, 0, 'C');
       $pdf->Cell(20, 5, 'KODE', 1, 0 , 'C');
       $pdf->Cell(65, 5, 'MATA KULIAH', 1, 0, 'C');
       $pdf->Cell(15, 5, 'SKS', 1, 0, 'C');
       $pdf->Cell(15, 5, 'NILAI', 1, 0, 'C');
       $pdf->Cell(15, 5, 'BOBOT', 1, 0, 'C');
       $pdf->Cell(15, 5, 'JUMLAH', 1, 0, 'C');
       $pdf->Cell(30, 5, 'KETERANGAN', 1, 1, 'C');

       $pdf->SetFont('times','',9);
       $i=1;
       $sks=0;
       $mutu=0;
       $jmutu=0;
       $total=0;
       $sql  = "SELECT avg(kh.mutu) as mutu from akademik_krs as ak, akademik_khs as kh,makul_matakuliah as mm,akademik_jadwal_kuliah as jk,app_dosen as ad WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                         and ak.nim='$m[nim]' and kh.krs_id=ak.krs_id and ak.semester='$semester' and kh.confirm='1' GROUP BY kh.krs_id";
       $data = $this->db->query($sql)->result();
       foreach ($this->db->query($khs)->result() as $r)
       {
            $pdf->Cell(7, 5, $i, 1, 0 , 'C');
            $pdf->Cell(20, 5, strtoupper($r->kode_makul), 1, 0);
            $pdf->Cell(65, 5, strtoupper($r->nama_makul), 1, 0);
            $pdf->Cell(15, 5, $r->sks, 1, 0,'C');
            $pdf->Cell(15, 5, $r->grade, 1, 0,'C');
            $pdf->Cell(15, 5, $r->mutu, 1, 0,'C');
            $pdf->Cell(15, 5, $r->sks * $r->mutu, 1, 0,'C');
            $pdf->Cell(30, 5,'', 1, 1,'C');
            $i++;
            $jmutu = $jmutu + ($r->sks * $r->mutu);
            $sks=$sks+$r->sks;
            $mutu=$mutu+$r->mutu;
            $total+=$r->sks * $r->mutu;
       }
       // foreach ($data as $r) {
       //   $ipk = number_format($r->mutu, 2);
       // }
       $ipk = number_format($total/$sks, 2);

       $pdf->SetFont('TIMES','B',9);
       $pdf->Cell(92, 5, 'TOTAL', 1, 0, 'C');
       $pdf->Cell(15, 5,$sks, 1, 0, 'C');
       $pdf->Cell(15, 5,'', 1, 0);
       $pdf->Cell(15, 5, $mutu, 1, 0, 'C');
       $pdf->Cell(15, 5, $jmutu, 1, 0, 'C');
       $pdf->Cell(30, 5, '', 1, 1, 'C');

       $pdf->Cell(182, 7, 'Index Predikat Kumulatif (IPK) = '.$ipk ,1, 0,'C');

       $pdf->SetFont('TIMES','',9);
       //kasih jarak
       $pdf->Cell(3,2,'',0,1);
       $pdf->Cell(3,2,'',0,1);

       // tanda tangan
       $pdf->Cell(137, 5, '', 0, 1);
       $pdf->Cell(137, 15, '', 0, 0);
       $pdf->Cell(25, 5, 'Jambi, '.  tgl_indo(waktu()), 0, 1);
       $pdf->Cell(137, 5, '', 0, 0);
       $pdf->Cell(25, 5, 'Ketua Program Studi,', 0, 1);
       $pdf->Cell(137, 10, '', 0, 0);
       $pdf->Cell(25, 10, '', 0, 1);
       $pdf->Cell(137, 5, '', 0, 0);
       $pdf->Cell(25, 5, 'ROSA RIYA SKM,M.KES,', 0, 0);
       $pdf->Output("$nim.pdf",'D');
    }

    // cetak kartu rencana studi
    function cetakkrs()
    {
        $id        =  $this->uri->segment(3);
        $profileSQL=    "SELECT sm.nama,sm.nim,ak.nama_konsentrasi,ap.nama_prodi FROM
                        student_mahasiswa  as sm,akademik_prodi as ap,akademik_konsentrasi as ak
                        WHERE sm.konsentrasi_id=ak.konsentrasi_id and ap.prodi_id=ak.prodi_id and sm.nim=$id";
        $data['profile']   = $this->db->query($profileSQL)->row_array();
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $profileSQL2    =  "SELECT ak.krs_id,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                            and jk.tahun_akademik_id='$thn' and ak.nim='".$this->uri->segment(3)."' and ak.semester='".$this->uri->segment(4)."'";
        $data['profile2']   = $this->db->query($profileSQL2)->row_array();
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $krs            =  "SELECT ak.krs_id,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                            and jk.tahun_akademik_id='$thn' and ak.nim='".$this->uri->segment(3)."' and ak.semester='".$this->uri->segment(4)."'";
                            
        $dosen = $this->db->query("SELECT dosen_pa from student_mahasiswa  where nim='$id' ")->row();
	$dosen_pa = $this->db->query("SELECT ad.nama_lengkap from app_dosen as ad, student_mahasiswa as sm where sm.dosen_pa=ad.dosen_id and ad.dosen_id='$dosen->dosen_pa' ")->row();
	$data['dosen_pa'] = $dosen_pa->nama_lengkap;

        $data['record2'] = $this->db->query($krs)->result();
        $this->load->view($this->folder.'/cetakkrs', $data);

    }

    // cetak kartu mhs
    function kartu_mhs()
    {
        $id        =  $this->uri->segment(3);
                     $this->db->join('app_users','app_users.username=student_mahasiswa.nim');
        $data['q'] = $this->db->get_where('student_mahasiswa', array('mahasiswa_id'=>"$id"))->row();
        if ($data['q']->mahasiswa_id=='') {
          redirect('404');
        }
        $this->load->view('mahasiswa/cetak_kartu', $data);
    }

    // Kartu Ujian Mahasiswa
    function kum()
    {
        $id        =  $this->uri->segment(3);
        $profileSQL=    "SELECT sm.nama,sm.nim,ak.nama_konsentrasi,ap.nama_prodi FROM
                        student_mahasiswa  as sm,akademik_prodi as ap,akademik_konsentrasi as ak
                        WHERE sm.konsentrasi_id=ak.konsentrasi_id and ap.prodi_id=ak.prodi_id and sm.nim=$id";
        $profile   = $this->db->query($profileSQL)->row_array();
        $pdf = new FPDF('L','mm','A5');
        $pdf->AddPage();
        $pdf->SetFont('TIMES','',17);
        $pdf->Cell(135,4,'AKADEMI KEBIDANAN',0,1, 'C');
        $pdf->Cell(130, 4, 'KELUARGA BUNDA JAMBI', 0, 1, 'C');
        $pdf->SetFont('TIMES','',10);
        $pdf->Cell(130, 4, 'Kampus : Talang Bakung, Jambi Sel., Kota Jambi, Jambi 36138', 0, 1, 'C');
        $pdf->Cell(130, 4, 'Telp / Fax 0813-6685-5307 E.Mail : email : info@akbidkeluargabunda.ac.id', 0, 1, 'C');
        $pdf->Image(base_url().'images/logo/logouit.gif', 10, 6, 20);
        $pdf->Line(11, 27, 120, 27);

        $pdf->Image(base_url().'/assets/images/bgkum.png', 128, 10, 70);
        $pdf->SetFont('TIMES','',12);
        $pdf->Text(131, 18, 'KARTU UJIAN MAHASISWA');
        $pdf->Text(131, 23, 'UJIAN TENGAH SEMESTER');
        $pdf->Text(131, 28, 'SEMESTER GANJIL T.A  ' . tahunajaran());
        $pdf->SetFont('TIMES','',10);

        // biodata
        $pdf->Cell(0, 3,'',0,1);
        $pdf->Cell(40, 5, 'NAMA', 0, 0);
        $pdf->Cell(40, 5, ' : '. strtoupper($profile['nama']), 0, 1);
        $pdf->Cell(40, 5, 'NIM / SEMESTER', 0, 0);
        $pdf->Cell(40, 5, ' : '.  strtoupper($profile['nim']) .' / '. strtoupper($this->uri->segment(4)), 0, 1);
        // $pdf->Cell(40, 5, 'SEMESTER', 0, 0);
        // $pdf->Cell(40, 5, ' : '.  strtoupper($this->uri->segment(4)), 0, 1);
        $pdf->Cell(40, 5, 'PROGRAM STUDI', 0, 0);
        $pdf->Cell(40, 5, ' : '.  strtoupper($profile['nama_prodi']), 0, 1);
        $pdf->Cell(40, 5, 'KONSENTRASI', 0, 0);
        $pdf->Cell(40, 5, ' : '.  strtoupper($profile['nama_konsentrasi']), 0, 1);

        $pdf->Cell(10, 3,'',0,1);
        $pdf->SetFont('TIMES','B',10);
        $pdf->Cell(40, 5, 'DAFTAR MATA KULIAH KONTRAK', 0, 1);
        $pdf->SetFont('TIMES','b',10);


        // data matakuliah
        // kasi jarak
       $pdf->Cell(20,3,'',0,1);

       $pdf->Cell(10, 5, 'NO', 1, 0, 'C');
       // $pdf->Cell(15, 5, 'SMT', 1, 0,'C');
       $pdf->Cell(75, 5, 'MATA KULIAH', 1, 0, 'C');
       $pdf->Cell(55, 5, 'DOSEN', 1, 0 , 'C');
       $pdf->Cell(30, 5, 'TANDA TANGAN', 1, 1, 'C');

       $pdf->SetFont('times','',10);
       $i=1;
       $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
       $krs            =   "SELECT ak.krs_id,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                            and jk.tahun_akademik_id='$thn' and ak.nim='".$this->uri->segment(3)."' and ak.semester='".$this->uri->segment(4)."'";
       foreach ($this->db->query($krs)->result() as $r)
       {
          $pdf->Cell(10, 5, $i, 1, 0, 'C');
          // $pdf->Cell(15, 5, 'SMT '.$this->uri->segment(4), 1, 0,'C');
          $pdf->Cell(75, 5, strtoupper($r->nama_makul), 1, 0);
          $pdf->Cell(55, 5, strtoupper($r->nama_lengkap), 1, 0);
          $pdf->Cell(30, 5, '', 1, 1);
          $i++;
       }

          $pdf->SetFont('times','',9);
          $pdf->Cell(300,7,ucwords('Catatan : selama ujian berlangsung KUM wajib dibawa dan mintalah tanda tangan kepada dosen')  ,0,1);
          $pdf->Cell(300,2,ucwords('               atau pengawas ujian, jika KUM tidak dibawa harus minta surat keterangan dari akademik.'),0,1);
          // tanda tangan
          // $pdf->Cell(150, 5, '', 0, 1);
          $pdf->Cell(150, 5, '', 0, 0);
          $pdf->Cell(150, 5, 'Kotamobagu, '.  tgl_indo(waktu()), 0, 1);
          $pdf->Cell(150, 5, '', 0, 0);
          $pdf->SetFont('times','b',10);
          $pdf->Cell(150, 5, 'Ketua Program Studi,', 0, 1);
          $pdf->Cell(150, 1, '', 0, 0);
          $pdf->Cell(150, 9, '', 0, 1);
          $pdf->Cell(150, 5, '', 0, 0);
          $pdf->Cell(150, 5, 'Ns. Ferlan A.Pondaag, M.Kep,', 0, 0);
          $pdf->Output();
    }

}
