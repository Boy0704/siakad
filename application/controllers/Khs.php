<?php
class khs extends MY_Controller{

    var $folder =   "khs";
    var $tables =   "akademik_khs";
    var $pk     =   "khs_id";
    var $title  =   "Kartu Hasil Studi";
    private $filename = "import_data_khs"; // Kita tentukan nama filenya

    function __construct() {
        parent::__construct();
        $this->load->model('Import_khs');
    }

    function index()
    {
        $level = $this->session->userdata('level');
        if ($level == 1 OR $level ==2 OR $level ==6) {
             $data['title']=  $this->title;
            $data['tahun_angkatan']=  $this->db->get('student_angkatan')->result();
            $this->template->load('template', $this->folder.'/view',$data);
        }
        elseif ($level = 4)
        {
                $data['title'] = "Kartu Hasil Studi";
                $level = $this->session->userdata('level');
                $id             =  $this->session->userdata('keterangan');
                // $semester       =  $_GET['semester'];
                $semester =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
                $mhs            =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                                    FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                                    WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
                $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
                $data['d']              = $this->db->query($mhs)->row_array();
                $data['nim']            =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
                $this->template->load('template', $this->folder.'/khsmahasiswa',$data);
        }
        else
        {
            $this->load->view('404/404');
        }
    }

    function form_import()
    {
        $data = array(); // Buat variabel $data sebagai array

        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->Import_khs->upload_file($this->filename);

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

        $data['title'] = "Import KHS";
        $this->template->load('template', $this->folder.'/import_khs',$data);
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
            $prodi_id = getField('akademik_prodi', 'prodi_id', 'kode_prodi', $row['J']);
            $konsentrasi_id = getField('akademik_konsentrasi', 'konsentrasi_id', 'prodi_id', $prodi_id);
            $makul_id = getField('makul_matakuliah', 'makul_id', 'kode_makul', $row['C']);
            $thn = substr($row['E'], 0,4);
            $angkatan_id = getField('student_angkatan', 'angkatan_id', 'keterangan', $thn);
            $semester = substr($row['E'], 4,1);
            $id_jadwal = $this->db->get_where('akademik_jadwal_kuliah',array('konsentrasi_id'=>$konsentrasi_id,'makul_id'=>$makul_id,'semester'=>$semester))->row_array();

            $krs_id = $this->db->get_where('akademik_krs',array('nim'=>$row['A'],'jadwal_id'=>$id_jadwal['jadwal_id']))->row_array();

            if(empty($row['A']) && empty($row['B']) && empty($row['C']) && empty($row['D']) && empty($row['E']) && empty($row['F']) && empty($row['G']) && empty($row['H']) && empty($row['I']) && empty($row['J']))
                continue;

            if($numrow > 1){
              if ($krs_id['krs_id']!='') {
                $data = array(
                    'krs_id'  =>$krs_id['krs_id'],
                    'mutu'    =>$row['H'],
                    'kehadiran'=>0,
                    'tugas'    =>0,
                    'nilai'   =>$row['I'],
                    'grade'   =>$row['G'],
                    'confirm' =>1
                );
                $this->db->insert('akademik_khs', $data);
              }
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><i class="fa fa-check"></i> Success!</strong> Data KHS Berhasil ditambahkan.
                </div>');
            redirect(site_url('khs'));

    }

    public function export($prodi='',$konsentrasi='',$tahun_angkatan='',$id='',$semester_sel){
      if ($prodi=='' or $konsentrasi=='' or $tahun_angkatan=='' or $id=='') {
        redirect('404');
      }
      if ($semester_sel==0) {
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
      }else {
        $semester_aktif = $semester_sel;
      }
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);

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
        $objPHPExcel->getActiveSheet()->getStyle ( 'A1:J1' )->applyFromArray ($thick);
        /*end - BLOCK UNTUK BORDER*/
        /*start - BLOCK UNTUK BG COLOR*/
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('E1:J1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');
        /*end - BLOCK UNTUK BG COLOR*/

        $objPHPExcel->getActiveSheet()->getStyle("A1:J1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        // $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Export Data dengan PHPExcel')
            ->setCellValue('A1', 'NIM')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Kode Matakuliah')
            ->setCellValue('D1', 'Nama Matakuliah')
            ->setCellValue('E1', 'Semester')
            ->setCellValue('F1', 'Kelas')
            ->setCellValue('G1', 'Nilai Huruf')
            ->setCellValue('H1', 'Nilai Indeks')
            ->setCellValue('I1', 'Nilai Angka')
            ->setCellValue('J1', 'Kode Prodi');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 2;
        foreach ($select as $row):
          /*start - BLOCK UNTUK BORDER*/
            $objPHPExcel->getActiveSheet()->getStyle ( 'A'.$counter.':J'.$counter )->applyFromArray ($thick);
          /*end - BLOCK UNTUK BORDER*/
          $nilai_huruf  = $this->db->get_where('akademik_khs', array('krs_id'=>$row->krs_id))->row()->grade;
          $nilai_indeks = $this->db->get_where('akademik_khs', array('krs_id'=>$row->krs_id))->row()->mutu;
          $nilai_angka  = $this->db->get_where('akademik_khs', array('krs_id'=>$row->krs_id))->row()->nilai;
            $ex->setCellValue('A'.$counter, $row->nim);
            $ex->setCellValue('B'.$counter, strtoupper($row->nama));
            $ex->setCellValue('C'.$counter, strtoupper($row->kode_makul));
            $ex->setCellValue('D'.$counter, strtoupper($row->nama_makul));
            $ex->setCellValue('E'.$counter, $thn_aktif);
            $ex->setCellValue('F'.$counter, $kelas);
            $ex->setCellValue('G'.$counter, $nilai_huruf);
            $ex->setCellValue('H'.$counter, $nilai_indeks);
            $ex->setCellValue('I'.$counter, $nilai_angka);
            $ex->setCellValue('J'.$counter, $kode_prodi);
            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("Anwar-kun | asprogram.com")
            ->setLastModifiedBy("Anwar-kun")
            ->setTitle("Export PHPExcel Test Document")
            ->setSubject("Export PHPExcel Test Document")
            ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("PHPExcel");
        $objPHPExcel->getActiveSheet()->setTitle('Data KHS');

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Export KHS '. date('Ymd') .'.xlsx"');

        $objWriter->save('php://output');
    }

    function loaddata()
    {
        $level = $this->session->userdata('level');
        $id             =  $_GET['id_mahasiswa'];
        $semester       =  $_GET['semester'];
        $mhs            =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                            FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                            WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        $d              = $this->db->query($mhs)->row_array();
        $nim            =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
        if ($d['semester_aktif']==0) {
          $smstr_aktif = '-';
        }else {
          $smstr_aktif = $d['semester_aktif'];
        }
        echo "
        <table class='table table-bordered'>
        <tr>
            <td width='150'>NAMA</td><td>".  strtoupper($d['nama'])."</td>
            <td width=100>NIM</td><td>".  strtoupper($d['nim'])."</td><td rowspan='2' width='70'><img src='".  base_url()."assets/images/avatar.png' width='50'></td>
        </tr>
        <tr>
            <td>Jurusan, Prodi</td><td>".  strtoupper($d['nama_prodi'].' / '.$d['nama_konsentrasi'])."</td>
            <td>Semester</td><td>".$smstr_aktif."</td>
        </tr>
        </table>

        <table class='table table-bordered' id='daftarkrs'>
        <tr class='alert-info'>
            <th>No</th>
            <th>KODE MP</th>
            <th>NAMA MATAKULIAH</th>
            <th>DOSEN PENGAPU</th>
            <th>Nilai</th>
            <th>Grade</>
            <th>SKS</th>
            <th>Mutu</th>
            <th>Sks x Mutu</th>
        ";
            // if ($level == 1 OR $level == 2) {
            //     echo "<th>Konfirm</th>";
            // }
        echo "<th>Konfirm</th>
        </tr>";
        // semua semester
        if($semester==0)
        {
            // foreach semester dari semester aktif
            for($smt=1;$smt<=$d['semester_aktif'];$smt++)
            {
                echo "<tr class='warning'><th colspan='11'>SEMESTER $smt</th></tr>";
                if ($level == 1 OR $level == 2) {
                    $param = "";
                }
                else{
                    $param = "and kh.confirm='1'";
                }
                $krs            =   "SELECT kh.grade,kh.nilai,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.confirm,kh.khs_id,kh.kehadiran,kh.tugas
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                            app_dosen as ad,akademik_khs as kh
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                            and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$smt' $param group by mm.makul_id";
                $data           =  $this->db->query($krs);
                if($data->num_rows()<1)
                {
                    echo "<tr><td align='center' colspan='11'>Data Tidak Ditemukan</td></tr>";
                }
                else
                {
                    $no=1;
                    $sks=0;
                    $total=0;
                    foreach ($data->result() as $r)
                    {

                        // $confirm=$r->confirm==1?'Ya':'Tidak';
                        if ($level == 1 OR $level == 2) {
                            $btn=$r->confirm==1?'label label-success':'btn btn-xs btn-primary';
                            $namebtn=$r->confirm==1?'Diconfirm':'Konfirmasi';
                        }
                        else{
                            $btn=$r->confirm==1?'label label-success':'label label-primary';
                            $namebtn=$r->confirm==1?'Diconfirm':'Belum Dikonfirmasi';
                        }
                        $hasilkali = $r->sks * $r->mutu;
                        echo "<tr id='krshide$r->khs_id'>
                            <td align='center'>$no</td>
                            <td>".  strtoupper($r->kode_makul)."</td>
                            <td>".  strtoupper($r->nama_makul)."</td>
                            <td>".  strtoupper($r->nama_lengkap)."</td>
                            <td width=150>
                            <form action=\"khs/simpan_khs_manual/".$r->khs_id."\" method=\"post\">
                                <input type=\"text\" class=\"form-control input-sm\" name=\"nilai\" value=\"  ".$r->nilai." \" autocomplete=\"off\">
                            </form>
                            </td>
                            <td align='center'>".$r->grade."</td>
                            <td align='center'>".$r->sks."</td>
                            <td align='center'>$r->mutu</td>
                            <td align='center'>$hasilkali</td>
                            ";

                            echo "<td align='center'><i class='$btn' onclick='konfirm($r->khs_id)'>$namebtn</i></td>
                            </tr>";
                        $no++;
                        $sks=$sks+$r->sks;
                        $total+=$hasilkali;
                    }
                    // $krs  =   "SELECT avg(kh.mutu) as mutu
                    //         FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                    //         app_dosen as ad,akademik_khs as kh
                    //         WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                    //         and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$smt' $param";
                    // $sqlipk           =  $this->db->query($krs)->result();
                    // foreach ($sqlipk as $r) {
                    //      $ipk = number_format($r->mutu, 2);
                    //    }
                    $ipk = number_format($total/$sks, 2);

                    //simpan nilai index prestasi

                    //cek ip
                    $cekip = cek_ip($nim, $smt);
                    if ($cekip == 0 ) {
                        $this->db->insert('akademik_ip', array('nim'=>$nim, 'semester'=>$smt,'ip'=>$ipk));
                        // $ipk = get_ipk($nim);
                        $this->db->where('nim', $nim);
                        $this->db->update('student_mahasiswa', array('ipk'=>number_format($ipk, 2)));
                    } else{
                        // $ipk = get_ipk($nim);
                        $this->db->where('nim', $nim);
                        $this->db->update('student_mahasiswa', array('ipk'=>number_format($ipk, 2)));
                    }

                    echo"<tr>
                    <td colspan='6' align='right'>Total SKS</td>
                    <td align='center'>$sks</td>
                    <td colspan='2' align='left'>IP = ".$ipk."</td>
                    <td colspan='4'></td>
                    </tr>
            <tr>
            <td colspan=11>".anchor('cetak/cetakkhs/'.$smt.'/'.$id,'<i class="fa fa-print"></i> Cetak KHS',array('title'=>$this->title,'class'=>'btn btn-primary btn-sm', 'target'=>'_blank'))."

            ".anchor('','<i class="fa fa-bar-chart-o"></i> Grafik',array('Title'=>'Lihat Grafik','class'=>'btn btn-primary btn-sm'))."
            </td></tr>";
                }

            }
        }
        else
        {
            // KHS persemester
            if ($level == 1 OR $level == 2)
            {
                $param = "";
            }
            else
            {
                $param = "and kh.confirm='1'";
            }
            $krs       =   "SELECT kh.grade,kh.nilai,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.confirm,kh.khs_id,kh.tugas,kh.kehadiran
                            FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                            app_dosen as ad,akademik_khs as kh
                            WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                            and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$semester' $param group by mm.kode_makul";

            $data      =  $this->db->query($krs);
            $sks=0;
            if($data->num_rows()<1)
            {
                echo "<tr class='warning' align='center'><td colspan=11>DATA KHS TIDAK DITEMUKAN</td></tr>";
            }
            else
            {
                $no=1;
                $total=0;
                foreach ($data->result() as $r)
                {
                    // $confirm=$r->confirm==1?'Ya':'Tidak';
                    $btn=$r->confirm==1?'label label-success':'btn btn-xs btn-primary';
                    if ($level == 1 OR $level == 2) {

                        $namebtn=$r->confirm==1?'Diconfirm':'Konfirmasi';
                    }
                    else{
                        $namebtn=$r->confirm==1?'Diconfirm':'Belum Dikonfirmasi';
                    }
                    $hasilkali = $r->sks * $r->mutu;
                    echo "<tr id='krshide$r->khs_id'>
                        <td align='center'>$no</td>
                        <td>".  strtoupper($r->kode_makul)."</td>
                        <td>".  strtoupper($r->nama_makul)."</td>
                        <td>".  strtoupper($r->nama_lengkap)."</td>
                        <td width=150>
                            <form action=\"khs/simpan_khs_manual/".$r->khs_id."\" method=\"post\">
                                <input type=\"text\" class=\"form-control input-sm\" name=\"nilai\" value=\"  ".$r->nilai." \" autocomplete=\"off\">
                            </form>
                            </td>
                        <td>".$r->grade."</td>
                        <td align='center'>".  $r->sks."</td>
                        <td align='center'>$r->mutu</td>
                        <td align='center'>$hasilkali</td>
                        ";

                       echo  "
                        <td align='center'><i class='$btn' onclick='konfirm($r->khs_id)'>$namebtn</i></td>
                        </tr>";
                    $no++;
                    $sks=$sks+$r->sks;
                    $total+=$hasilkali;
                }
            }
             // $krs  =   "SELECT avg(kh.mutu) as mutu
             //                FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
             //                app_dosen as ad,akademik_khs as kh
             //                WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
             //                and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$semester' $param";
             //        $sqlipk           =  $this->db->query($krs)->result();
                    // foreach ($sqlipk as $r) {
                    //      $ipk = number_format($r->mutu, 2);
                    //    }

                    $ipk = number_format($total/$sks, 2);


        echo"<tr>
                <td colspan='6' align='right'>Total SKS</td>
                <td align='center'>$sks</td>
                <td colspan='2' align='left'>Index Prestasi = ".$ipk."</td>
                <td colspan='4'></td>
                </tr>
            <tr>
                <td colspan=11>".anchor('cetak/cetakkhs/'.$semester.'/'.$id,'<i class="fa fa-print"></i> Cetak KHS',array('title'=>$this->title,'class'=>'btn btn-primary btn-sm', 'target'=>'_blank'))."</td>
            </tr></table>";
        }
    }


    function semester_mhs()
    {
        $id=$_GET['id_mahasiswa'];
        $sms=  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        echo "<option value='0'>Semua Semester</option>";
        for($i=1;$i<=$sms;$i++)
        {
            echo "<option value='$i'> Semester $i</option>";
        }

    }

    function berinilai()
    {
        $level = $this->session->userdata('level');
        if ($level == 3)
        {
            $dosen  =  $this->session->userdata('keterangan');
            $thn    = get_tahun_ajaran_aktif('tahun_akademik_id');
            $query="SELECT mm.nama_makul,jk.jadwal_id
                    FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm
                    WHERE mm.makul_id=jk.makul_id and jk.dosen_id=$dosen and jk.tahun_akademik_id=$thn";
            $data['title']="Beri Nilai";
            $data['kelas']=  $this->db->query($query)->result();
            $this->template->load('template', $this->folder.'/berinilai',$data);
        }
        else{
           $this->load->view('404/404');
        }

    }

    function form_berinilai()
    {
        $jadwal_id=  $_GET['jadwal_id'];
        $thn      =  get_tahun_ajaran_aktif('tahun_akademik_id');
        $d        =  $this->db->query("SELECT ad.nama_lengkap,mm.nama_makul
                    FROM app_dosen as ad,makul_matakuliah as mm,akademik_jadwal_kuliah as jk
                    WHERE jk.makul_id=mm.makul_id and jk.dosen_id=ad.dosen_id and jk.jadwal_id=$jadwal_id")->row_array();
        $sql="  SELECT sm.nim,sm.nama,kh.mutu,kh.nilai,kh.khs_id,kh.tugas,kh.kehadiran,kh.grade
                FROM akademik_krs as ak,student_mahasiswa as sm,akademik_khs as kh,akademik_jadwal_kuliah as jk
                WHERE kh.krs_id=ak.krs_id and sm.nim=ak.nim and ak.jadwal_id='$jadwal_id' and jk.jadwal_id=ak.jadwal_id and jk.tahun_akademik_id='$thn' and sm.semester_aktif!=0 GROUP BY sm.nim ORDER BY sm.nama";
        echo " <table class='table table-bordered'>
              <tr class='alert-info'><th colspan=2>MATAKULIAH</th></tr>
               <tr><td width=120>Matakuliah</td><td>".  strtoupper($d['nama_makul'])."</td></tr>
               <tr><td>Dosen Pengapu</td><td>".  strtoupper($d['nama_lengkap'])."</td></tr>
               </table>
               <table class='table table-bordered'>
               <tr class='alert-info'><th colspan=7>FORM NILAI MAHASISWA</th></tr>
               <tr><th>No</th><th>NIM</th><th>NAMA MAHASISWA</th><th width=90>Nilai</th><th width=90>Mutu</th><th>Grade</th></tr>";
        $data=  $this->db->query($sql)->result();
        $no=1;
        foreach ($data as $r)
        {
            echo "<tr>
                <td width='7'>$no</td>
                <td width='70'>".  strtoupper($r->nim)."</td>
                <td>".  strtoupper($r->nama)."</td>
                <td align='center' width='90'>";
                // echo inputan('text', '','col-sm-12','Kehadiran', 0, $r->kehadiran,array('onkeyup'=>'simpankehadiran('.$r->khs_id.')','id'=>'ambilkehadiran'.$r->khs_id)).'</td><td>';
                // echo inputan('text', '','col-sm-12','Tugas ..', 0, $r->tugas,array('onkeyup'=>'simpantugas('.$r->khs_id.')','id'=>'ambiltugas'.$r->khs_id)).'</td><td>';
                echo inputan('text', '','col-sm-12','Nilai ...', 0, $r->nilai,array('onkeyup'=>'simpannilai('.$r->khs_id.')','id'=>'ambilnilai'.$r->khs_id)).'</td><td align="center">';
                // echo inputan('text', 'link','col-sm-12','Link ...', 1, $r->mutu,array('onkeyup'=>'simpan('.$r->khs_id.')','id'=>'ambil'.$r->khs_id));
                echo "<b style='font-size:20px' id='mutu_$r->khs_id'>$r->mutu</b>";
                echo"</td>
                    <td width='80' align='center'>";
                    echo "<b style='font-size:20px' id='grade_$r->khs_id'>$r->grade</b>";
                // echo editcombo('grade','app_nilai_grade','col-sm-14','grade','grade','',array('onChange'=>'simpangrade('.$r->khs_id.')','id'=>'ambilgrade'.$r->khs_id),  $r->grade);
                echo"</td>
                </tr>";
            $no++;
        }
        echo"  </table>";
    }


    function grade($nilai)
    {
        $set_nilai=  $this->db->get('app_nilai_grade')->result();
        foreach ($set_nilai as $s)
        {
            if($nilai >=$s->dari and $nilai <= $s->sampai)
            {
                return $s->grade;
            }
        }

    }

    function simpan_nilai()
    {
        akses_dosen();
        $id     =   $_GET['id'];
        $nilai  =   $_GET['nilai'];
        $this->Mcrud->update($this->tables,array('mutu'=>$nilai), $this->pk,$id);
    }

    function simpan_nilai_akhir()
    {
        akses_dosen();
        $id     =   $_GET['id'];
        $nilai  =   $_GET['nilai'];
        // switch ($nilai) {
        //   case $nilai <=50   : $grade = "E"; break;
        //   case $nilai <=52.5 : $grade = "D"; break;
        //   case $nilai <=55   : $grade = "D+"; break;
        //   case $nilai <=57.5 : $grade = "CD"; break;
        //   case $nilai <=60   : $grade = "C-"; break;
        //   case $nilai <=62.5 : $grade = "C"; break;
        //   case $nilai <=65   : $grade = "C+"; break;
        //   case $nilai <=67.5 : $grade = "BC"; break;
        //   case $nilai <=70   : $grade = "B-"; break;
        //   case $nilai <=72.5 : $grade = "B"; break;
        //   case $nilai <=75   : $grade = "B+"; break;
        //   case $nilai <=77.5 : $grade = "AB"; break;
        //   case $nilai <=80   : $grade = "A-"; break;
        //   case $nilai <=90   : $grade = "A"; break;
        //   case $nilai <=100  : $grade = "A+"; break;
        //   default: $grade="salah";$grade="-";
        // }
        // if ($grade=='A' or $grade=='A-' or $grade=='A+' or $grade=='AB') {
        //   $mutu = '4';
        // }elseif ($grade=='B' or $grade=='B-' or $grade=='B+' or $grade=='BC') {
        //   $mutu = '3';
        // }elseif ($grade=='C' or $grade=='C-' or $grade=='C+' or $grade=='CD') {
        //   $mutu = '2';
        // }elseif ($grade=='D' or $grade=='D-' or $grade=='D+' or $grade=='DE') {
        //   $mutu = '1';
        // }elseif ($grade=='E' or $grade=='E-' or $grade=='E+') {
        //   $mutu = '0';
        // }else {
        //   $mutu = '-';
        // }

        $grade = '';
        $mutu = '';
        $grade_nilai = $this->db->get('app_nilai_grade');
        foreach ($grade_nilai->result() as $rw) {
            if ($nilai >= $rw->dari && $nilai <= $rw->sampai) {
                $grade = $rw->grade;
                $mutu = $rw->mutu;
            }
            // echo $rw->dari.'<br>';
            // echo $grade;
        }
        // log_r($grade);
        
        $this->Mcrud->update($this->tables,array('nilai'=>$nilai,'mutu'=>$mutu,'grade'=>$grade), $this->pk,$id);

        echo json_encode(array('id'=>$id, 'mutu'=>$mutu, 'grade'=>$grade));
    }

    function simpan_kehadiran()
    {
        akses_dosen();
        $id     =   $_GET['id'];
        $nilai  =   $_GET['nilai'];
        $this->Mcrud->update($this->tables,array('kehadiran'=>$nilai), $this->pk,$id);
    }

    function simpan_tugas()
    {
        akses_dosen();
        $id     =   $_GET['id'];
        $nilai  =   $_GET['nilai'];
        $this->Mcrud->update($this->tables,array('tugas'=>$nilai), $this->pk,$id);
    }

    function simpan_grade()
    {
        akses_dosen();
        $id     =   $_GET['id'];
        $nilai  =   $_GET['nilai'];
        $this->Mcrud->update($this->tables,array('grade'=>$nilai), $this->pk,$id);
    }

    function tampilkanmahasiswa()
    {
        $konsentrasi    =   $_GET['konsentrasi'];
        $tahun_angkatan =   $_GET['tahun_angkatan']; // tahun_akademik_id
        $query="SELECT mahasiswa_id,nama from student_mahasiswa where angkatan_id='$tahun_angkatan' and konsentrasi_id='$konsentrasi'";// and semester_aktif!=0
        $data=  $this->db->query($query)->result();
        foreach ($data as $r)
        {
                   // echo "<option onclick='tampilkan_semester($r->mahasiswa_id)' value='$r->mahasiswa_id'>".  strtoupper($r->nama)."</option>";
            echo "<option value='$r->mahasiswa_id'>".  strtoupper($r->nama)."</option>";
        }
    }

    function konfirm()
    {
        akses_admin();
        $id=$_GET['khs_id'];
        $this->Mcrud->update($this->tables,array('confirm'=>1), $this->pk,$id);
    }

    function konfirm2()
    {
        // $id=$_GET['mahasiswa_id'];
        $id = $this->session->userdata('keterangan');
        $this->Mcrud->update('notifikasi',array('status'=>1), 'mahasiswa_id',$id);
    }

    function load()
    {

    }


    // TAMABAHAN INPUT KHS MANUAL

    function simpan_krs_manual()
    {
        if ($_POST == NULL) {
            $this->index();
        } else {
            $nim = $this->input->post('nim_mhs');
            $semester = $this->input->post('semester');
            $jadwal_id = $this->input->post('jadwal_id');
            
            $data = array(
                'nim' => $nim,
                'jadwal_id' => $jadwal_id,
                'semester' => $semester,
            );

            //cek semester aktif
            $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'nim', $nim);
            $this->db->where('nim', $nim);
            $this->db->update('student_mahasiswa', array('semester_aktif'=>$semester));

            //cek input 2 kli
            $cek_krs = $this->db->get_where('akademik_krs', array('jadwal_id'=>$jadwal_id,'nim'=>$nim,'semester'=>$semester))->num_rows();

            if ($cek_krs == NULL) {
                //lakukan simpan data
                $simpankrs = $this->db->insert('akademik_krs', $data);

                if ($simpankrs) {
                    //input data khs langsung
                    $ambil_krs_id = $this->db->get_where('akademik_krs', array('jadwal_id'=>$jadwal_id,'nim'=>$nim,'semester'=>$semester))->row();
                    // echo $this->db->last_query();
                    // print_r($data);
                    // echo $ambil_krs_id;
                    $this->db->insert('akademik_khs',array('krs_id'=>$ambil_krs_id->krs_id));
                    $this->index();
                }
            } else {
                //ulangi input data
                ?>
                <script type="text/javascript">
                    alert('KRS sudah ada ! silahkan ulangi lagi');
                    window.location="<?php echo base_url() ?>khs";
                </script>
                <?php
            }

            
        }
    }


    function simpan_khs_manual($id)
    {
        $nilai = $this->input->post('nilai');
        $mutu = 0;
        $nilai_huruf = '-';
        //bandingkan dengan grade nilai
        $grade_nilai = $this->db->get('app_nilai_grade');
        foreach ($grade_nilai->result() as $row) {
            if ($row->sampai >= $nilai && $row->dari <= $nilai) {
                $mutu = $row->mutu;
                $nilai_huruf = $row->grade;
            }
        }

        // echo $nilai.'<br>';
        // echo $mutu.'<br>';
        // echo $nilai_huruf.'<br>';

        $this->db->where('khs_id',$id);
        $update = $this->db->update('akademik_khs',array('nilai'=>$nilai,'mutu'=>$mutu,'grade'=>$nilai_huruf));
        if ($update) {
            ?>
            <script type="text/javascript">
                window.history.back();
            </script>
            <?php
        }
    }


    //-- TAMABAHAN INPUT KHS MANUAL



    function cetak()
    {
        $level = $this->session->userdata('level');
        if ($level = 4)
        {
                $data['title'] = "Kartu Hasil Studi";
                $level = $this->session->userdata('level');
                $id             =  $this->session->userdata('keterangan');
                // $semester       =  $_GET['semester'];
                $semester =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
                $mhs            =   "SELECT sm.mahasiswa_id,sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                                    FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                                    WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
                $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
                $data['d']              = $this->db->query($mhs)->row_array();
                $data['nim']            =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
                $this->template->load('template', $this->folder.'/sel_khsmahasiswa',$data);
        }
        else
        {
            $this->load->view('404/404');
        }
    }

    function loaddata_khs()
    {
        $level = $this->session->userdata('level');
        $id             =  $_GET['id_mahasiswa'];
        $semester       =  $_GET['semester'];
        $s1             =  $_GET['s1'];
        $s2             =  $_GET['s2'];
        $mhs            =   "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                            FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                            WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
        $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        $data['d']      = $this->db->query($mhs)->row_array();
        $data['nim']    =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
        $data['semester'] =  $s1;
        $data['semester2'] =  $s2;
        $this->load->view($this->folder.'/sel_view_khs',$data);
    }

    function cetak_khs($mahasiswa='',$semester='',$s1='',$s2='')
    {
      $this->load->library('cfpdf');
      if ($mahasiswa=='' or $semester=='' or $s1=='' or $s2=='') {redirect('404');}

          $sqlMHS     =   "SELECT ap.nama_prodi,ak.nama_konsentrasi,sm.nama,sm.nim,sm.semester_aktif
                          FROM student_mahasiswa as sm,akademik_prodi as ap,akademik_konsentrasi as ak
                          WHERE sm.konsentrasi_id=ak.konsentrasi_id and ak.prodi_id=ap.prodi_id and sm.mahasiswa_id=$mahasiswa";
          $m          =  $this->db->query($sqlMHS)->row_array();
          $khs        =   "SELECT kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.confirm,kh.khs_id,kh.tugas,kh.kehadiran
                           FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                           app_dosen as ad,akademik_khs as kh
                           WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                           and ak.nim='$m[nim]' and kh.krs_id=ak.krs_id and ak.semester>='$s1' and ak.semester<='$s2' and kh.confirm='1' GROUP BY kh.krs_id";

          if ($s1 > $s2) {
           $v_semester = '-';
          }else if ($s1 == $s2) {
           $v_semester = $s1;
          }else {
           $v_semester = "$s1 - $s2";
          }

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
         $pdf->Cell(190, 5, 'SEKOLAH TINGGI AGAMA ISLAM
', 0, 1, 'C');
         $pdf->SetFont('TIMES','',10);
         $pdf->Cell(190, 5, 'Toapaya Asri, Toapaya, Kabupaten Bintan, Kepulauan Riau 29132', 0, 1, 'C');
         $pdf->Cell(190, 4, 'Telp 813-6685-5307 E.Mail :  info@stainkepri.ac.id', 0, 1, 'C');
         $pdf->Cell(190, 5, 'Website : http://www.stainkepri.ac.id/', 0, 1, 'C');
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
         $pdf->Cell(20,5,' : '.  strtoupper($v_semester),0,1);

         $pdf->Cell(20,5,'JURUSAN',0,0);
         $pdf->Cell(80,5,' : '.  strtoupper($m['nama_prodi']),0,0);
           $pdf->Cell(30,5,'',0,0);
           $pdf->Cell(20,5,'',0,1);


         $pdf->Cell(20,5,'',0,0);
         $pdf->Cell(80,5,'',0,0);
           $pdf->Cell(30,5,'',0,0);
           $pdf->Cell(20,5,'',0,1);

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
                           and ak.nim='$m[nim]' and kh.krs_id=ak.krs_id and ak.semester>='$s1' and ak.semester<='$s2' and kh.confirm='1' GROUP BY kh.krs_id";
         $data = $this->db->query($sql)->result();
         if($this->db->query($khs)->num_rows()<1)
         {
             // $pdf->Cell(182, 7, 'DATA KHS TIDAK DITEMUKAN',1, 0,'C');
             $ipk = '0.00';
         }
         else
         {
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
           $ipk = number_format($total/$sks, 2);
         }
         // foreach ($data as $r) {
         //   $ipk = number_format($r->mutu, 2);
         // }


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
         $pdf->Cell(25, 5, 'JKetua Prodi,', 0, 1);
         $pdf->Cell(137, 10, '', 0, 0);
         $pdf->Cell(25, 10, '', 0, 1);
         $pdf->Cell(137, 5, '', 0, 0);
         $pdf->Cell(25, 5, 'ROSA RIYA SKM,M.KES,', 0, 0);
         $pdf->Output("$nim - KHS.pdf",'D');
    }

}
