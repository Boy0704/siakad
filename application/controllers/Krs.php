<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs extends MY_Controller {

    var $folder =   "krs";
    var $tables =   "akademik_krs";
    var $pk     =   "krs_id";
    var $title  =   "Kartu Rencana Studi";
    private $filename = "import_data_krs"; // Kita tentukan nama filenya

    function __construct() {
        parent::__construct();
        $level = $this->session->userdata('level');
        if ($level == 3) {
            $this->load->view('404/404');
        }
        $this->load->model('Import_krs');
        $this->load->model('Import_mhs');
    }

    public function index()
    {
        $this->lihat();
    }

    function form_import()
    {
        $data = array(); // Buat variabel $data sebagai array

        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->Import_krs->upload_file($this->filename);

            if($upload['result'] == "success"){ // Jika proses upload sukses
                // Load plugin PHPExcel nya
                include APPPATH.'third_party/PHPExcel/PHPExcel.php';

                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

                // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
                // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
                $data['sheet'] = $sheet;
            }else{ // Jika proses upload gagal
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }

        $data['title'] = "Import KRS";
        $this->template->load('template', $this->folder.'/import_krs',$data);
    }

    public function aksi_import(){
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database

        $numrow = 1;
        foreach($sheet as $row){
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            $prodi_id = getField('akademik_prodi', 'prodi_id', 'kode_prodi', $row['G']);
            $konsentrasi_id = getField('akademik_konsentrasi', 'konsentrasi_id', 'prodi_id', $prodi_id);
            $makul_id = getField('makul_matakuliah', 'makul_id', 'kode_makul', $row['D']);
            $thn = substr($row['C'], 0,4);
            $angkatan_id = getField('student_angkatan', 'angkatan_id', 'keterangan', $thn);
            $semester = substr($row['C'], 4,1);
            $id_jadwal = $this->db->get_where('akademik_jadwal_kuliah',array('konsentrasi_id'=>$konsentrasi_id,'makul_id'=>$makul_id,'semester'=>$semester))->row_array();

            if(empty($row['A']) && empty($row['B']) && empty($row['C']) && empty($row['D']) && empty($row['E']) && empty($row['F']) && empty($row['G']))
                continue;

            if($numrow > 1){
              if ($id_jadwal['jadwal_id']!='') {
                $data = array(
                    'nim'               =>$row['A'],
                    'jadwal_id'         =>$id_jadwal['jadwal_id'],
                    'semester'          =>$semester
                );
                $this->db->insert('akademik_krs', $data);
                $id_krs= $this->db->get_where('akademik_krs',array('nim'=>$row['A'],'jadwal_id'=>$id_jadwal['jadwal_id'],'semester'=>$semester))->row_array();
                $this->db->insert('akademik_khs',array('krs_id'=>$id_krs['krs_id'],'mutu'=>0,'confirm'=>'1'));
              }
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><i class="fa fa-check"></i> Success!</strong> Data KRS Berhasil ditambahkan.
                </div>');
            redirect(site_url('krs'));

    }

    public function export($prodi='',$konsentrasi='',$tahun_angkatan='',$id=''){
      if ($prodi=='' or $konsentrasi=='' or $tahun_angkatan=='' or $id=='') {
        redirect('404');
      }
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $nim            =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);

        $kode_prodi = getField('akademik_prodi', 'kode_prodi', 'prodi_id', $prodi);
        $angkatan   = getField('student_angkatan', 'keterangan', 'angkatan_id', $tahun_angkatan);
        $kelas      = getField('kelas', 'kelas_id', 'angkatan_id', $tahun_angkatan);
        $thn_aktif  = getField('akademik_tahun_akademik', 'keterangan', 'tahun_akademik_id', $thn);

                  $this->db->join('akademik_jadwal_kuliah','akademik_jadwal_kuliah.jadwal_id=akademik_krs.jadwal_id');
                  $this->db->join('makul_matakuliah','makul_matakuliah.makul_id=akademik_jadwal_kuliah.makul_id');
                  $this->db->join('student_mahasiswa','student_mahasiswa.nim=akademik_krs.nim');
                  $this->db->where('akademik_jadwal_kuliah.konsentrasi_id',"$konsentrasi");
                  $this->db->where('akademik_jadwal_kuliah.semester',"$semester_aktif");
                  if ($id!=null) {
                    $this->db->where('akademik_krs.nim',"$nim");
                  }
        $select = $this->db->get('akademik_krs')->result();
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);

        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);

        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),//warna font hitam
                'name' => 'Calibri'
            )
        );
        /*start - BLOCK UNTUK BORDER*/
        $thick = array ();
        $thick['borders']=array();
        $thick['borders']['allborders']=array();
        $thick['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN ;
        $objPHPExcel->getActiveSheet()->getStyle ( 'A1:G1' )->applyFromArray ($thick);
        /*end - BLOCK UNTUK BORDER*/
        /*start - BLOCK UNTUK BG COLOR*/
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('C1:D1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');
        $objPHPExcel->getActiveSheet()->getStyle('F1:G1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');
        /*end - BLOCK UNTUK BG COLOR*/

        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        // $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Export Data dengan PHPExcel')
            ->setCellValue('A1', 'NIM')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Semester')
            ->setCellValue('D1', 'Kode Matakuliah')
            ->setCellValue('E1', 'Nama Matakuliah')
            ->setCellValue('F1', 'Kelas')
            ->setCellValue('G1', 'Kode Prodi');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 2;
        foreach ($select as $row):
          /*start - BLOCK UNTUK BORDER*/
            $objPHPExcel->getActiveSheet()->getStyle ( 'A'.$counter.':G'.$counter )->applyFromArray ($thick);
          /*end - BLOCK UNTUK BORDER*/
            $ex->setCellValue('A'.$counter, $row->nim);
            $ex->setCellValue('B'.$counter, strtoupper($row->nama));
            $ex->setCellValue('C'.$counter, $thn_aktif);
            $ex->setCellValue('D'.$counter, strtoupper($row->kode_makul));
            $ex->setCellValue('E'.$counter, strtoupper($row->nama_makul));
            $ex->setCellValue('F'.$counter, $kelas);
            $ex->setCellValue('G'.$counter, $kode_prodi);
            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("Anwar-kun | asprogram.com")
            ->setLastModifiedBy("Anwar-kun")
            ->setTitle("Export PHPExcel Test Document")
            ->setSubject("Export PHPExcel Test Document")
            ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("PHPExcel");
        $objPHPExcel->getActiveSheet()->setTitle('Data KRS');

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Export KRS '. date('Ymd') .'.xlsx"');

        $objWriter->save('php://output');
    }

    function lihat()
    {
        // log_r($this->session->userdata());
        $level = $this->session->userdata('level');
        if ($level == 1 OR $level == 2) {
            $data['title']=  $this->title;
            $data['tahun_angkatan']=  $this->db->get('akademik_tahun_akademik')->result();
            $this->template->load('template', $this->folder.'/view',$data);
        }
        elseif ($level == 4)
        {
            $data['title']  =  "Kartu Rencana Studi";
            $id             =  $this->session->userdata('keterangan');
            $data['mhs']    =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                                FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                                WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
            $data['semester_aktif'] =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
            $data['thn']            =  get_tahun_ajaran_aktif('tahun_akademik_id');

        
            $this->template->load('template', $this->folder.'/krsmahasiswa',$data);
            if($id == 399){
                ?>
                <script>
                alert('Krs anda masih belum lengkap');
                window.location="<?php echo base_url() ?>";
                </script>
                <?php
            } else {
                
            }

        }
        else
        {
            $this->load->view('404/404');
        }

    }

    function jumlah_sks()
    {
      if ($_GET['oke']=='sip') {
        $id             =  $this->session->userdata('keterangan');
        $mhs            =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                            FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                            WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');

        $d    = $this->db->query($mhs)->row();
        $nim  =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
        $krs  =   "SELECT sum(mm.sks) as sks
                    FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                    WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and jk.tahun_akademik_id='$thn' and ak.nim='$nim' and ak.semester='".$d->semester_aktif."'";
        $data =  $this->db->query($krs)->row()->sks;
        echo $data;
      }
    }

    public function belanjaMatakuliah()
    {
        $data['title'] = "Kontrak Matakuliah";
        $mahasiswa_id= $this->session->userdata('keterangan');
        $data['nim'] =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $mahasiswa_id);
        $this->template->load('template', $this->folder.'/belanjaMatakuliah',$data);
    }

    function loaddata()
    {
        $id             =  $_GET['id_mahasiswa'];
        $mhs            =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                            FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                            WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $d              = $this->db->query($mhs)->row_array();
        $nim            =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
        $krs            =   "SELECT ak.krs_id,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and jk.tahun_akademik_id='$thn' and ak.nim='$nim' and ak.semester='".$d['semester_aktif']."'";

        $data           =  $this->db->query($krs);
        $max_sks = $this->Import_mhs->cek_sks_old($nim,$semester_aktif);
        echo "
        <table class='table table-bordered'>
         <tr>
        <td colspan=6>
        <button onclick='loadtablemapel($id)' class='btn btn-primary btn-sm'><i class='fa fa-shopping-cart'></i> Input KRS</button> ";
        echo anchor('cetak/cetakkrs/'.$d['nim'].'/'.$semester_aktif,'<i class="fa fa-print"></i> Cetak KRS',array('class'=>'btn btn-default btn-sm','target'=>'_blank'));
        echo anchor('cetak/kum/'.$d['nim'].'/'.$semester_aktif,'<i class="fa fa-print"></i> Cetak KUM',array('class'=>'btn btn-default btn-sm','target'=>'_blank'));
        echo "
        </tr>
        <tr>
            <td width='150'>NAMA</td><td>".  strtoupper($d['nama'])."</td>
            <td width=100>NIM</td><td>".  strtoupper($d['nim'])."</td><td rowspan='2' width='70'><img src='".  base_url()."assets/images/avatar.png' width='50'></td>
        </tr>
        <tr>
            <td>Jurusan / Prodi</td><td>".  strtoupper($d['nama_prodi'].' / '.$d['nama_konsentrasi'])."</td>
            <td>SEMESTER</td><td>".$d['semester_aktif']."</td>
        </tr>
        </table>

        <table class='table table-bordered' id='daftarkrs'>
        <tr class='alert-info'><th width='5'>No</th>
        <th width='80'>KODE</th>
        <th>NAMA MATAKULIAH</th>
        <th width=10>SKS</th>
        <th>DOSEN PENGAPU</th>
        <th width='10'>Hapus</th></tr>";
        $sks=0;
        if($data->num_rows()<1)
        {
            echo "<tr><td colspan=6 align='center' class='warning'>DATA KRS TIDAK DITEMUKAN</td></tr>";
        }
        else
        {
            $no=1;

            foreach ($data->result() as $r)
            {
                echo "<tr id='krshide$r->krs_id'>
                    <td align='center'>$no</td>
                    <td align='center'>".  strtoupper($r->kode_makul)."</td>
                    <td>".  strtoupper($r->nama_makul)."</td>
                    <td align='center'>".  $r->sks."</td>
                    <td>".  strtoupper($r->nama_lengkap)."</td>
                    <td align='center'><a href='javascript:void(0)' class='btn btn-sm btn-danger fa fa-trash-o' title='Batal Ambil Matakuliah' onclick='hapus($r->krs_id)'></a></td>
                    </tr>";
                $no++;
                $sks=$sks+$r->sks;
            }
        }
    if ($sks>$max_sks) {
        echo "<script>swal('Info','Maksimal Pengambilan KRS Adalah $max_sks SKS, silahkan dikurangi KRS nya!!','info')</script>";
    }
    echo"<tr><td colspan='3' align='right'>Total SKS</td><td align='center'>$sks</td><td colspan=2></td></tr>

        </table>";
    }

    function post()
    {
        // $id             =  $_GET['id_mahasiswa'];
        $id_mahasiswa   =   $_GET['mahasiswa_id'];
        $jadwal_id      =   $_GET['jadwal_id'];
        $nim=  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id_mahasiswa);
        $smt=  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id_mahasiswa);

        $mhs            =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                            FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                            WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id_mahasiswa";
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id_mahasiswa);
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $d    = $this->db->query($mhs)->row();
        $krs  =   "SELECT sum(mm.sks) as sks
                    FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                    WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and jk.tahun_akademik_id='$thn' and ak.nim='$nim' and ak.semester='".$d->semester_aktif."'";
        $jml_sks =  $this->db->query($krs)->row()->sks;
        // $max_sks = $this->Import_mhs->cek_sks_old($nim,$smt);
        $max_sks = 30;

        if ($jml_sks>=$max_sks) {
          echo json_encode(array('status'=>'0','max_sks'=>$max_sks));
        }else{
          $data           =   array(  'nim'=>$nim,
                                      'semester'=>$smt,
                                      'jadwal_id'=>$jadwal_id);

          // $krs            =   "SELECT sum(mm.sks) as sks
          //                     FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak WHERE jk.makul_id=mm.makul_id and jk.jadwal_id=ak.jadwal_id and ak.nim=181401001";

          // $data           =  $this->db->query($krs)->result();
          // $maksimalsks = 0;
          // foreach ($data as $r) {
          //     $maksimalsks = $r->sks;
          // }
          // $data = array('sks' => $maksimalsks );
          // echo json_encode($data);
          // exit();
          $this->db->insert($this->tables,$data);
          $id_krs= $this->db->get_where('akademik_krs',array('nim'=>$nim,'jadwal_id'=>$jadwal_id))->row_array();
          $this->db->insert('akademik_khs',array('krs_id'=>$id_krs['krs_id'],'mutu'=>0,'confirm'=>'2'));
          echo json_encode(array('status'=>'1','max_sks'=>$max_sks));
        }
    }

    function tampilkanmahasiswa()
    {
        $konsentrasi    =   $_GET['konsentrasi'];
        $tahun_angkatan =   $_GET['tahun_angkatan']; // tahun_akademik_id
        $query="SELECT mahasiswa_id,nama from student_mahasiswa where semester_aktif!='0' and angkatan_id='$tahun_angkatan' and konsentrasi_id='$konsentrasi'";
        $data=  $this->db->query($query)->result();
        foreach ($data as $r)
        {
            // echo "<option onclick='loaddata($r->mahasiswa_id)'>".  strtoupper($r->nama)."</option>";
            echo "<option value='$r->mahasiswa_id'>".  strtoupper($r->nama)."</option>";
        }
    }



    function loadmapel()
    {
        $konsentrasi = $_GET['konsentrasi'];
        $mahasiswa_id=$_GET['mahasiswa_id'];
        $nim=  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $mahasiswa_id);
        $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $semester_aktif=  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $mahasiswa_id);
        //jumlah sks
        $krs            =   "SELECT sum(mm.sks) as sks
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak WHERE jk.makul_id=mm.makul_id and jk.jadwal_id=ak.jadwal_id and ak.nim=$nim and ak.semester=$semester_aktif";

        $data           =  $this->db->query($krs)->result();
        // log_r($this->db->last_query());
        // print_r($data->sks);
        $sksbatas = 0;
        foreach ($data as $r)
        {
           $sksbatas = $r->sks;
        }


        $konsentrasi = $_GET['konsentrasi'];
        $mahasiswa_id=$_GET['mahasiswa_id'];
        $nim=  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $mahasiswa_id);
        echo"<table class='table table-bordered'>
            <tr class='alert-info'><th colspan=5>DAFTAR MATAKULIAH</th><th colspan=2><button onclick='loaddata($mahasiswa_id)' class='btn btn-primary btn-sm'><i class='fa fa-mail-reply-all'></i> Kembali</button></th></tr>
            <tr class='alert-info'><th width=10>No</th><th width=20>Kode</th>
            <th>Nama Matakuliah</th>
            <th>Dosen</th>
            <th width=60>SKS</th><th width=60>JAM</th><th>Ambil</th></tr>";
            // dapatkan jumlah semester dari kosentrasi yang diminta
            $data=  $this->db->get_where('akademik_konsentrasi',array('konsentrasi_id'=>$konsentrasi))->row_array();
            $jmlSemester=$data['jml_semester'];
            for($i=1;$i<=$jmlSemester;$i++)
            {
                echo"<tr class='warning'><td colspan=9>Semester $i</td></tr>";
                //tampilkan data Makul di KRS
                $query          =   "SELECT mm.kode_makul,mm.sks,mm.jam,mm.kode_makul,mm.nama_makul,mm.sks,jk.jadwal_id,ds.nama_lengkap
                                    FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ds
                                    WHERE mm.makul_id=jk.makul_id and mm.konsentrasi_id=$konsentrasi and mm.semester=$i and ds.dosen_id=jk.dosen_id and  jk.tahun_akademik_id='$thn' and jk.jadwal_id not in(select jadwal_id from akademik_krs where nim='$nim')";
                $makul          = $this->db->query($query)->result();
                // log_r($this->db->last_query());
                $no=1;
                foreach ($makul as $m)
                {
                    echo "<tr id='hide$m->jadwal_id'><td>$no</td>
                        <td>".  strtoupper($m->kode_makul)."</td>
                        <td>".  strtoupper($m->nama_makul)."</td>
                        <td>".  strtoupper($m->nama_lengkap)."</td>
                        <td>$m->sks sks</td>
                        <td>$m->jam Jam</td>";
                        if ($sksbatas>20) {
                             echo "<td width='10' id='ambil' align='center'><span class='btn btn-sm btn-primary disabled' title='SKS MAKSIMUM'>Ambil</span></td>";
                        }
                        else{
                             echo "<td width='10' id='ambil' align='center'><span class='btn btn-sm btn-primary' onclick='ambil($m->jadwal_id,$mahasiswa_id)' title='Ambil Matakuliah'>Ambil</span></td>";
                        }

                         echo "</tr>";
                    $no++;
                }

            }
            echo "<table>";
    }


    function delete()
    {
        $id=$_GET['krs_id'];
        $this->Mcrud->delete($this->tables,  $this->pk,  $id);
        $this->Mcrud->delete('akademik_khs',  $this->pk,  $id);
    }
}
