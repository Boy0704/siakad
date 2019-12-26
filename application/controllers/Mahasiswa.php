<?php
class mahasiswa extends MY_Controller{

    var $folder =   "mahasiswa";
    var $tables =   "student_mahasiswa";
    var $pk     =   "mahasiswa_id";
    var $title  =   "Daftar Mahasiswa";
    private $filename = "import_data_mhs"; // Kita tentukan nama filenya

    function __construct() {
        parent::__construct();

        $this->load->model('Import_mhs');
    }



    function index()
    {
        $level = $this->session->userdata('level');
        if ($level==1 OR $level==2 OR $level==3 OR $level==6) {
            // $tahun="SELECT ta.keterangan,ta.tahun_akademik_id
            //     FROM student_mahasiswa as sm,akademik_tahun_akademik as ta
            //     WHERE ta.tahun_akademik_id=sm.angkatan_id
            //     group by ta.tahun_akademik_id";
            $data['title']=  $this->title;
            $data['desc']="";
            $data['tahun_angkatan']=  $this->db->get('akademik_tahun_akademik')->result();
            $this->template->load('template', $this->folder.'/view',$data);
        }
        else
        {
            $data['title'] = "Mahasiswa";
            $ses = $this->session->userdata('keterangan');
            $get="SELECT sm.*, a.keterangan AS agama, a.agama_id , sa.keterangan AS nama_angkatan
                FROM student_mahasiswa as sm,app_agama as a, student_angkatan as sa
                WHERE sm.mahasiswa_id='$ses' and a.agama_id=sm.agama_id and sa.angkatan_id=sm.angkatan_id";
            $data['record'] = $this->db->query($get)->row();
            $this->template->load('template', $this->folder.'/view',$data);
        }

    }

    function kelulusan()
    {
        $level = $this->session->userdata('level');
        if ($level==1 OR $level==2 OR $level==3 OR $level==6) {
            $tahun="SELECT ta.keterangan,ta.tahun_akademik_id
                FROM student_mahasiswa as sm,akademik_tahun_akademik as ta
                WHERE ta.tahun_akademik_id=sm.tahun_akademik_id
                group by ta.tahun_akademik_id";
            $data['title']=  $this->title;
            $data['desc']="";
            $data['tahun_angkatan']=  $this->db->get('akademik_tahun_akademik')->result();
            $this->template->load('template', $this->folder.'/kelulusan',$data);
        }
        else
        {
            $data['title'] = "Mahasiswa";
            $ses = $this->session->userdata('keterangan');
            $get="SELECT sm.*, a.keterangan , sa.keterangan AS nama_angkatan
                FROM student_mahasiswa as sm,app_agama as a, student_angkatan as sa
                WHERE sm.mahasiswa_id=$ses and sa.angkatan_id=sm.angkatan_id";
            $data['record'] = $this->db->query($get)->row();
            $this->template->load('template', $this->folder.'/kelulusan',$data);
        }

    }

    function form_import()
    {
        $data = array(); // Buat variabel $data sebagai array

        if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
            $upload = $this->Import_mhs->upload_file($this->filename);

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

        $data['title'] = "Import Mahasiswa";
        $this->template->load('template', $this->folder.'/import_mhs',$data);
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
            $prodi_id = getField('akademik_prodi', 'prodi_id', 'kode_prodi', $row['AT']);
            $konsentrasi_id = getField('akademik_konsentrasi', 'konsentrasi_id', 'prodi_id', $prodi_id);
            $thn = substr($row['N'], 0,4);
            $angkatan_id = getField('student_angkatan', 'angkatan_id', 'keterangan', $thn);

            if(empty($row['A']) && empty($row['B']) && empty($row['C']) && empty($row['D']) && empty($row['E']) && empty($row['F']) && empty($row['G']))
                continue;

            if($numrow > 1){

                $data = array(
                    'nim'               =>$row['A'],
                    'nama'              =>$row['B'],
                    'konsentrasi_id'    =>$konsentrasi_id,
                    'angkatan_id'       =>$angkatan_id,
                    'alamat'            =>$row['O'].' RT'.$row['P'].' RW'.$row['Q'].' '.$row['R'].' '.$row['S'].' '.$row['T'].' '.$row['U'],
                    'gender'            =>$row['E'],
                    'tempat_lahir'      =>$row['C'],
                    'tanggal_lahir'     =>$row['D'],
                    'jenis_kelamin'     =>$row['E'],
                    'nik'               =>$row['F'],
                    'agama_id'          =>$row['G'],
                    'nisn'              =>$row['H'],
                    'jalur_pendaftaran' =>$row['I'],
                    'npwp'              =>$row['J'],
                    'kewarganegaraan'   =>$row['K'],
                    'jenis_pendaftaran' =>$row['L'],
                    'tgl_masuk_kuliah'  =>$row['M'],
                    'mulai_semester'    =>$row['N'],
                    'jalan'             =>$row['O'],
                    'rt'                =>$row['P'],
                    'rw'                =>$row['Q'],
                    'nama_dusun'        =>$row['R'],
                    'kelurahan'         =>$row['S'],
                    'kecamatan'         =>$row['T'],
                    'kode_pos'          =>$row['U'],
                    'jenis_tinggal'     =>$row['V'],
                    'alat_transportasi' =>$row['W'],
                    'telp_rumah'        =>$row['X'],
                    'no_hp'             =>$row['Y'],
                    'email'             =>$row['Z'],
                    'terima_kps'        =>$row['AA'],
                    'no_kps'            =>$row['AB'],
                    'nik_ayah'          =>$row['AC'],
                    'nama_ayah'         =>$row['AD'],
                    'tgl_lahir_ayah'    =>$row['AE'],
                    'pendidikan_ayah'   =>$row['AF'],
                    'pekerjaan_id_ayah' =>$row['AG'],
                    'penghasilan_ayah'  =>$row['AH'],
                    'nik_ibu'           =>$row['AI'],
                    'nama_ibu'          =>$row['AJ'],
                    'tgl_lahir_ibu'     =>$row['AK'],
                    'pendidikan_ibu'    =>$row['AL'],
                    'pekerjaan_id_ibu'  =>$row['AM'],
                    'penghasilan_ibu'   =>$row['AN'],
                    'nama_wali'         =>$row['AO'],
                    'tgl_lahir_wali'    =>$row['AP'],
                    'pendidikan_wali'   =>$row['AQ'],
                    'pekerjaan_wali'    =>$row['AR'],
                    'penghasilan_wali'  =>$row['AS'],
                    'kode_prodi'        =>$row['AT'],
                    'jenis_pembiayaan'  =>$row['AU'],
                );

                $this->db->insert('student_mahasiswa', $data);
                $id             = getField('student_mahasiswa', 'mahasiswa_id', 'nim', $row['A']);
                $account        = array('username'=>$row['A'],'password'=>  hash_string($row['A']),'keterangan'=>$id,'level'=>4, 'konsentrasi_id'=>$konsentrasi_id);
                $this->db->insert('app_users',$account);

            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><i class="fa fa-check"></i> Success!</strong> Data Mahasiswa Berhasil ditambahkan.
                </div>');
            redirect(site_url('mahasiswa'));

    }


    public function export($prodi='',$konsentrasi='',$tahun_angkatan='',$kelulusan=''){
      if ($prodi=='' or $konsentrasi=='' or $tahun_angkatan=='') {
        redirect('404');
      }
        $kode_prodi = getField('akademik_prodi', 'kode_prodi', 'prodi_id', $prodi);
        if ($kelulusan!='') {
          $this->db->where('status_mhs',"lulus");
        }
        $select = $this->db->get('student_mahasiswa',array('kode_prodi'=>"$kode_prodi",'konsentrasi_id'=>"$konsentrasi",'angkatan_id'=>"$tahun_angkatan"))->result();
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        // for ($i='A'; $i <='AU' ; $i++) {
        //   $objPHPExcel->getActiveSheet()->getColumnDimension("$i")->setWidth(30);
        // }
        for($col = 'A'; $col !== 'AV'; $col++) {
            $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }
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
        $objPHPExcel->getActiveSheet()->getStyle ( 'A1:AU1' )->applyFromArray ($thick);
        /*end - BLOCK UNTUK BORDER*/
        /*start - BLOCK UNTUK BG COLOR*/
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('H1:J1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('K1:N1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('O1:R1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('S1:T1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('U1:Z1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('AA1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('AB1:AI1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('AJ1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('AK1:AS1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        $objPHPExcel->getActiveSheet()->getStyle('AT1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0000');//warna bg merah
        $objPHPExcel->getActiveSheet()->getStyle('AU1')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FF00');//warna bg hijau
        /*end - BLOCK UNTUK BG COLOR*/

        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        // $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');
        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Export Data dengan PHPExcel')
            ->setCellValue('A1', 'NIM')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'Tempat Lahir')
            ->setCellValue('D1', 'Tanggal Lahir')
            ->setCellValue('E1', 'Jenis Kelamin')
            ->setCellValue('F1', 'NIK')
            ->setCellValue('G1', 'Agama')
            ->setCellValue('H1', 'NISN')
            ->setCellValue('I1', 'Jalur Pendaftaran')
            ->setCellValue('J1', 'NPWP')
            ->setCellValue('K1', 'Kewarganegaraan')
            ->setCellValue('L1', 'Jenis Pendaftaran')
            ->setCellValue('M1', 'Tgl Masuk Kuliah')
            ->setCellValue('N1', 'Mulai Semester')
            ->setCellValue('O1', 'Jalan')
            ->setCellValue('P1', 'RT')
            ->setCellValue('Q1', 'RW')
            ->setCellValue('R1', 'Nama Dusun')
            ->setCellValue('S1', 'Kelurahan')
            ->setCellValue('T1', 'Kecamatan')
            ->setCellValue('U1', 'Kode Pos')
            ->setCellValue('V1', 'Jenis Tinggal')
            ->setCellValue('W1', 'Alat Transportasi')
            ->setCellValue('X1', 'Telp Rumah')
            ->setCellValue('Y1', 'No HP')
            ->setCellValue('Z1', 'Email')
            ->setCellValue('AA1', 'Terima KPS')
            ->setCellValue('AB1', 'No KPS')
            ->setCellValue('AC1', 'NIK Ayah')
            ->setCellValue('AD1', 'Nama Ayah')
            ->setCellValue('AE1', 'Tgl Lahir Ayah')
            ->setCellValue('AF1', 'Pendidikan Ayah')
            ->setCellValue('AG1', 'Pekerjaan Ayah')
            ->setCellValue('AH1', 'Penghasilan Ayah')
            ->setCellValue('AI1', 'NIK Ibu')
            ->setCellValue('AJ1', 'Nama Ibu')
            ->setCellValue('AK1', 'Tanggal Lahir Ibu')
            ->setCellValue('AL1', 'Pendidikan Ibu')
            ->setCellValue('AM1', 'Pekerjaan Ibu')
            ->setCellValue('AN1', 'Penghasilan Ibu')
            ->setCellValue('AO1', 'Nama Wali')
            ->setCellValue('AP1', 'Tanggal Lahir Wali')
            ->setCellValue('AQ1', 'Pendidikan Wali')
            ->setCellValue('AR1', 'Pekerjaan Wali')
            ->setCellValue('AS1', 'Penghasilan Wali')
            ->setCellValue('AT1', 'Kode Prodi')
            ->setCellValue('AU1', 'Jenis Pembiayaan');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 2;
        foreach ($select as $row):
          /*start - BLOCK UNTUK BORDER*/
            $objPHPExcel->getActiveSheet()->getStyle ( 'A'.$counter.':AU'.$counter )->applyFromArray ($thick);
          /*end - BLOCK UNTUK BORDER*/
            $ex->setCellValue('A'.$counter, $row->nim);
            $ex->setCellValue('B'.$counter, $row->nama);
            $ex->setCellValue('C'.$counter, $row->tempat_lahir);
            $ex->setCellValue('D'.$counter, $row->tanggal_lahir);
            $ex->setCellValue('E'.$counter, $row->gender);
            $ex->setCellValue('F'.$counter, $row->nik);
            $ex->setCellValue('G'.$counter, $row->agama_id);
            $ex->setCellValue('H'.$counter, $row->nisn);
            $ex->setCellValue('I'.$counter, $row->jalur_pendaftaran);
            $ex->setCellValue('J'.$counter, $row->npwp);
            $ex->setCellValue('K'.$counter, $row->kewarganegaraan);
            $ex->setCellValue('L'.$counter, $row->jenis_pendaftaran);
            $ex->setCellValue('M'.$counter, $row->tgl_masuk_kuliah);
            $ex->setCellValue('N'.$counter, $row->mulai_semester);
            $ex->setCellValue('O'.$counter, $row->jalan);
            $ex->setCellValue('P'.$counter, $row->rt);
            $ex->setCellValue('Q'.$counter, $row->rw);
            $ex->setCellValue('R'.$counter, $row->nama_dusun);
            $ex->setCellValue('S'.$counter, $row->kelurahan);
            $ex->setCellValue('T'.$counter, $row->kecamatan);
            $ex->setCellValue('U'.$counter, $row->kode_pos);
            $ex->setCellValue('V'.$counter, $row->jenis_tinggal);
            $ex->setCellValue('W'.$counter, $row->alat_transportasi);
            $ex->setCellValue('X'.$counter, $row->telp_rumah);
            $ex->setCellValue('Y'.$counter, $row->no_hp);
            $ex->setCellValue('Z'.$counter, $row->email);
            $ex->setCellValue('AA'.$counter, $row->terima_kps);
            $ex->setCellValue('AB'.$counter, $row->no_kps);
            $ex->setCellValue('AC'.$counter, $row->nik_ayah);
            $ex->setCellValue('AD'.$counter, $row->nama_ayah);
            $ex->setCellValue('AE'.$counter, $row->tgl_lahir_ayah);
            $ex->setCellValue('AF'.$counter, $row->pendidikan_ayah);
            $ex->setCellValue('AG'.$counter, $row->pekerjaan_id_ayah);
            $ex->setCellValue('AH'.$counter, $row->penghasilan_ayah);
            $ex->setCellValue('AI'.$counter, $row->nik_ibu);
            $ex->setCellValue('AJ'.$counter, $row->nama_ibu);
            $ex->setCellValue('AK'.$counter, $row->tgl_lahir_ibu);
            $ex->setCellValue('AL'.$counter, $row->pendidikan_ibu);
            $ex->setCellValue('AM'.$counter, $row->pekerjaan_id_ibu);
            $ex->setCellValue('AN'.$counter, $row->penghasilan_ibu);
            $ex->setCellValue('AO'.$counter, $row->nama_wali);
            $ex->setCellValue('AP'.$counter, $row->tgl_lahir_wali);
            $ex->setCellValue('AQ'.$counter, $row->pendidikan_wali);
            $ex->setCellValue('AR'.$counter, $row->pekerjaan_wali);
            $ex->setCellValue('AS'.$counter, $row->penghasilan_wali);
            $ex->setCellValue('AT'.$counter, $row->kode_prodi);
            $ex->setCellValue('AU'.$counter, $row->jenis_pembiayaan);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("Anwar-kun | asprogram.com")
            ->setLastModifiedBy("Anwar-kun")
            ->setTitle("Export PHPExcel Test Document")
            ->setSubject("Export PHPExcel Test Document")
            ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("PHPExcel");
        $objPHPExcel->getActiveSheet()->setTitle('Data Mahasiswa');

        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Export Mahasiswa '. date('Ymd') .'.xlsx"');

        $objWriter->save('php://output');
    }


    function post()
    {
        akses_admin();
        if(isset($_POST['submit']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nim', 'Nim Mahasiswa', 'required|is_unique[student_mahasiswa.nim]|max_length[15]|numeric');
            $this->form_validation->set_rules('nama', 'Nama Mahasiswa', 'required|max_length[35]');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|max_length[35]');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            if ($this->form_validation->run())
            {
                // pribadi
                $nama               =   $this->input->post('nama');
                $nim                =   $this->input->post('nim');
                $alamat             =   $this->input->post('alamat');
                $konsentrasi        =   $this->input->post('konsentrasi');
                $tahun              =   $this->input->post('tahun_angkatan');
                $tempat_lahir       =   $this->input->post('tempat_lahir');
                $tgl_lahir          =   $this->input->post('tanggal_lahir');
                $agama              =   $this->input->post('agama');
                $gender             =   $this->input->post('gender');
                $angkatan           =   $this->input->post('tahun_angkatan');
                // orang tua
                $nama_ayah          =   $this->input->post('nama_ayah');
                $nama_ibu           =   $this->input->post('nama_ibu');
                $pekerjaan_ayah     =   $this->input->post('pekerjan_ayah');
                $pekerjaan_ibu      =   $this->input->post('pekerjaan_ibu');
                $alamat_ayah        =   $this->input->post('alamat_ayah');
                $alamat_ibu         =   $this->input->post('alamat_ibu');
                $penghsln_ayah      =   $this->input->post('penghasilan_ayah');
                $penghsln_ibu       =   $this->input->post('penghasilan_ibu');
                $no_hp_ortu         =   $this->input->post('no_hp_ortu');

                // sekolah
                $sekolah_nama       =   $this->input->post('sekolah_nama');
                $sekolah_telpon     =   $this->input->post('sekolah_telpon');
                $sekolah_alamat     =   $this->input->post('sekolah_alamat');
                $sekolah_jurus      =   $this->input->post('sekolah_jurusan');
                $sekolah_tahun      =   $this->input->post('sekolah_tahun');
                // kampus
                $kampus_nama        =   $this->input->post('kampus_nama');
                $kampus_telpon      =   $this->input->post('kampus_telpon');
                $kampus_alamat      =   $this->input->post('kampus_alamat');
                $kampus_jurus       =   $this->input->post('kampus_jurusan');
                $kampus_tahun       =   $this->input->post('kampus_tahun');
                // instansi
                $instansi_nama      =   $this->input->post('instansi_nama');
                $instansi_telpon    =   $this->input->post('instansi_telpon');
                $instansi_alamat    =   $this->input->post('instansi_alamat');
                $instansi_mulai     =   $this->input->post('instansi_mulai');
                $instansi_sampai    =   $this->input->post('instansi_sampai');
                // institusi
                $institusi_nama     =   $this->input->post('institusi_nama');
                $institusi_telpon   =   $this->input->post('institusi_telpon');
                $institusi_alamat   =   $this->input->post('institusi_alamat');

                $dosen_pa           =   $this->input->post('dosen_pa');

                $instansi           =   array(  'instansi_nama'=>$instansi_nama,
                                                'instansi_telpon'=>$instansi_telpon,
                                                'instansi_alamat'=>$instansi_alamat,
                                                'instansi_mulai'=>$instansi_mulai,
                                                'instansi_sampai'=>$instansi_sampai);
                $institusi          =   array(  'institusi_nama'=>$institusi_nama,
                                                'institusi_telpon'=>$institusi_telpon,
                                                'institusi_alamat'=>$institusi_alamat);
                //$angkatan           = getField('student_angkatan', 'angkatan_id', 'aktif', 'y');
                $pribadi            =   array(  'nama'=>$nama,
                                                'semester_aktif'=>0,
                                                'agama_id'=>$agama,
                                                'gender'=>$gender,
                                                'tempat_lahir'=>$tempat_lahir,
                                                'tanggal_lahir'=>$tgl_lahir,
                                                'nim'=>$nim,
                                                'konsentrasi_id'=>$konsentrasi,
                                                'alamat'=>$alamat,
                                                'angkatan_id'=> $angkatan,
                                                'dosen_pa'=> $dosen_pa);

                $sekolah            =   array(  'sekolah_nama'=>$sekolah_nama,
                                                'sekolah_telpon'=>$sekolah_telpon,
                                                'sekolah_alamat'=>$sekolah_alamat,
                                                'sekolah_tahun_lulus'=>$sekolah_tahun,
                                                'sekolah_jurusan'=>$sekolah_jurus);
                $kampus             =   array(  'kampus_nama'=>$kampus_nama,
                                                'kampus_telpon'=>$kampus_telpon,
                                                'kampus_alamat'=>$kampus_alamat,
                                                'kampus_tahun_lulus'=>$kampus_tahun,
                                                'kampus_jurusan'=>$kampus_jurus);

                $orangtua           =   array(  'nama_ayah'=>$nama_ayah,
                                                'nama_ibu'=>$nama_ibu,
                                                'pekerjaan_id_ayah'=>$pekerjaan_ayah,
                                                'pekerjaan_id_ibu'=>$pekerjaan_ibu,
                                                'alamat_ayah'=>$alamat_ayah,
                                                'no_hp_ortu'=>$no_hp_ortu,
                                                'alamat_ibu'=>$alamat_ibu,
                                                'penghasilan_ayah'=>$penghsln_ayah,
                                                'penghasilan_ibu'=>$penghsln_ibu);
                $data               =array_merge($orangtua,$kampus,$sekolah,$pribadi,$instansi,$institusi);
                $this->db->insert($this->tables,$data);
                $id             = getField('student_mahasiswa', 'mahasiswa_id', 'nim', $nim);
                $konsentrasi_id = getField('akademik_konsentrasi', 'konsentrasi_id', 'konsentrasi_id', $konsentrasi);
                $account        = array('username'=>$nim,'password'=>  hash_string($nim),'keterangan'=>$id,'level'=>4, 'konsentrasi_id'=>$konsentrasi_id);
                $this->db->insert('app_users',$account);
                $this->session->set_flashdata('pesan', "<div class='alert alert-success'>Data $nama Sudah Tersimpan </div>");
                redirect('mahasiswa');
            }
            else
            {
                $data['title']=  $this->title;
                $data['desc']="";
                $this->template->load('template', $this->folder.'/post',$data);
            }

        }
        else
        {
            $data['title']=  $this->title;
            $data['desc']="";
            $this->template->load('template', $this->folder.'/post',$data);
        }
    }

    function edit()
    {
        akses_admin();
        if(isset($_POST['submit']))
        {

            $this->load->library('form_validation');
            $nim = $this->input->post('nim');
            $nim_old = $this->input->post('nim_old');
            $callback           = "";
            if($nim !== $nim_old){
                $callback = "|is_unique[student_mahasiswa.nim]";
            }
            else{
                $callback  = "";
            }

            $this->form_validation->set_rules('nim', 'Nim Mahasiswa', 'required'.$callback);
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            if ($this->form_validation->run())
            {
                $id     = $this->input->post('id');
                            // pribadi
                $nama               =   $this->input->post('nama');
                // $nim                =   $this->input->post('nim');
                $alamat             =   $this->input->post('alamat');
                $konsentrasi        =   $this->input->post('konsentrasi');
                $tahun              =   $this->input->post('tahun_angkatan');
                $tempat_lahir       =   $this->input->post('tempat_lahir');
                $tgl_lahir          =   $this->input->post('tanggal_lahir');
                $agama              =   $this->input->post('agama');
                $gender             =   $this->input->post('gender');
                // orang tua
                $nama_ayah          =   $this->input->post('nama_ayah');
                $nama_ibu           =   $this->input->post('nama_ibu');
                $pekerjaan_ayah     =   $this->input->post('pekerjan_ayah');
                $pekerjaan_ibu      =   $this->input->post('pekerjaan_ibu');
                $alamat_ayah        =   $this->input->post('alamat_ayah');
                $alamat_ibu         =   $this->input->post('alamat_ibu');
                $penghsln_ayah      =   $this->input->post('penghasilan_ayah');
                $penghsln_ibu       =   $this->input->post('penghasilan_ibu');
                $no_hp_ortu         =   $this->input->post('no_hp_ortu');

                // sekolah
                $sekolah_nama       =   $this->input->post('sekolah_nama');
                $sekolah_telpon     =   $this->input->post('sekolah_telpon');
                $sekolah_alamat     =   $this->input->post('sekolah_alamat');
                $sekolah_jurus      =   $this->input->post('sekolah_jurusan');
                $sekolah_tahun      =   $this->input->post('sekolah_tahun');
                // kampus
                $kampus_nama        =   $this->input->post('kampus_nama');
                $kampus_telpon      =   $this->input->post('kampus_telpon');
                $kampus_alamat      =   $this->input->post('kampus_alamat');
                $kampus_jurus       =   $this->input->post('kampus_jurusan');
                $kampus_tahun       =   $this->input->post('kampus_tahun');
                // instansi
                $instansi_nama      =   $this->input->post('instansi_nama');
                $instansi_telpon    =   $this->input->post('instansi_telpon');
                $instansi_alamat    =   $this->input->post('instansi_alamat');
                $instansi_mulai     =   $this->input->post('instansi_mulai');
                $instansi_sampai    =   $this->input->post('instansi_sampai');
                // institusi
                $institusi_nama     =   $this->input->post('institusi_nama');
                $institusi_telpon   =   $this->input->post('institusi_telpon');
                $institusi_alamat   =   $this->input->post('institusi_alamat');

                $dosen_pa           =   $this->input->post('dosen_pa');
                $status_mhs         =   $this->input->post('status_mhs');

                if ($status_mhs=='') {
                  $status_mhs = Null;
                }

                $instansi           =   array(  'instansi_nama'=>$instansi_nama,
                                                'instansi_telpon'=>$instansi_telpon,
                                                'instansi_alamat'=>$instansi_alamat,
                                                'instansi_mulai'=>$instansi_mulai,
                                                'instansi_sampai'=>$instansi_sampai);
                $institusi          =   array(  'institusi_nama'=>$institusi_nama,
                                                'institusi_telpon'=>$institusi_telpon,
                                                'institusi_alamat'=>$institusi_alamat);

                $pribadi            =   array(  'nama'=>$nama,
                                                'agama_id'=>$agama,
                                                'gender'=>$gender,
                                                'tempat_lahir'=>$tempat_lahir,
                                                'tanggal_lahir'=>$tgl_lahir,
                                                'nim'=>$nim,
                                                'konsentrasi_id'=>$konsentrasi,
                                                'alamat'=>$alamat,
                                                'dosen_pa'=>$dosen_pa,
                                                'status_mhs'=>$status_mhs
                                                );

                $sekolah            =   array(  'sekolah_nama'=>$sekolah_nama,
                                                'sekolah_telpon'=>$sekolah_telpon,
                                                'sekolah_alamat'=>$sekolah_alamat,
                                                'sekolah_tahun_lulus'=>$sekolah_tahun,
                                                'sekolah_jurusan'=>$sekolah_jurus);

                $kampus             =   array(  'kampus_nama'=>$sekolah_nama,
                                                'kampus_telpon'=>$sekolah_telpon,
                                                'kampus_alamat'=>$sekolah_alamat,
                                                'kampus_tahun_lulus'=>$sekolah_tahun,
                                                'kampus_jurusan'=>$sekolah_jurus);

                $orangtua           =   array(  'nama_ayah'=>$nama_ayah,
                                                'nama_ibu'=>$nama_ibu,
                                                'pekerjaan_id_ayah'=>$pekerjaan_ayah,
                                                'pekerjaan_id_ibu'=>$pekerjaan_ibu,
                                                'alamat_ayah'=>$alamat_ayah,
                                                'alamat_ibu'=>$alamat_ibu,
                                                'no_hp_ortu'=>$no_hp_ortu,
                                                'penghasilan_ayah'=>$penghsln_ayah,
                    'penghasilan_ibu'=>$penghsln_ibu);
                $data               =array_merge($orangtua,$kampus,$sekolah,$pribadi,$instansi,$institusi);
                $this->Mcrud->update($this->tables,$data, $this->pk,$id);
                $this->session->set_flashdata('pesan', "<div class='alert alert-success'>Data $nama Berhasil Diedit</div>");
                redirect($this->uri->segment(1));
            }
            else
            {
                $data['title']=  $this->title;
                $data['desc']="";
                $id          =  $this->uri->segment(3);
                $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
                $this->template->load('template', $this->folder.'/edit',$data);
            }
        }
        else
        {
            $data['title']=  $this->title;
            $data['desc']="";
            $id          =  $this->uri->segment(3);
            $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
            $this->template->load('template', $this->folder.'/edit',$data);
        }
    }
    function delete()
    {
        akses_admin();
        $id     =  $_GET['id'];
        $this->Mcrud->delete($this->tables,  $this->pk,  $id);
        $this->Mcrud->delete('app_users',    'keterangan',  $id);

    }


    function tampilkankonsentrasi()
    {
        $prodi  =   $_GET['prodi'];
        $data   = $this->db->get_where('akademik_konsentrasi',array('prodi_id'=>$prodi))->result();
        foreach ($data as $r)
        {
            echo "<option value='$r->konsentrasi_id'>".  strtoupper($r->nama_konsentrasi)."</option>";
        }
    }


    function tampilkanmahasiswa($kelulusan="")
    {
        $level = $this->session->userdata('level');
        $konsentrasi    =   $_GET['konsentrasi'];
        $tahun_angkatan =   $_GET['tahun_angkatan'];
        if ($kelulusan!='') {
          $this->db->where('status_mhs',"lulus");
        }else {
          // $this->db->where('status_mhs','aktif');
        }
        $data           =   $this->db->get_where('student_mahasiswa',array('konsentrasi_id'=>$konsentrasi,'angkatan_id'=>$tahun_angkatan))->result();
        // log_r($this->db->last_query());
        echo "<tr class='alert-info'><th width='5'>No</th><th width='70'>Nim</th><th>Nama</th>
            <th>Status</th>";
            if ($level=='1' or $level=='2') {
              echo "
              <th width='150'>Operasi</th></tr>";
            }
        if (!empty($data))
        {
            $no=1;
            foreach ($data as $r)
            {
                // $gender=$r->gender==1?'Laki-Laki':'Perempuan';
                $gender=$r->gender;
                echo "<tr id='hide$r->mahasiswa_id'>
                    <td align='center'>".$no++."</td>
                    <td>".  strtoupper($r->nim)."</td>";
                    // <td>".anchor(strtoupper($r->nama), strtoupper($r->nama), array('class' => 'text-primary')) ."</td>
                    ?>
                    <td>
                    <a href="<?php echo base_url().'cetak/kartu_mhs/'.$r->mahasiswa_id;?>" data-toggle="tooltip" data-placement='bottom' title="Cetak Kartu Mahasiswa" target="_blank">
                      <?php echo strtoupper($r->nama); ?>
                    </a>
                    </td>
                    <?php echo "
                    
                    <td>".  ucwords($r->status_mhs)."</td>";
                    ?>
                    <?php if ($level== 1 OR $level==2): ?>
                    <td class='text-center'>
                      <div class="btn-group">
                         <a href="<?php echo base_url().'cetak/kartu_mhs/'.$r->mahasiswa_id;?>" data-toggle="tooltip" data-placement='bottom' title="Cetak Kartu Mahasiswa" class="btn btn-sm btn-info" target="_blank"><span class="fa fa-credit-card"></span></a>
                         <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->mahasiswa_id;?>" data-toggle="tooltip" data-placement='bottom' title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                         <a href='javascript:void(0)' onclick='hapus(<?php echo $r->mahasiswa_id  ?>)' data-toggle='tooltip' data-placement='bottom' title='Delete' class='btn btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></a>
                      </div>
                    </td>
                    <?php endif ?>
                <?php
                echo "</tr>";

                //
            }
        }
        else{
            echo "<td colspan='6' rowspan='' align='center'>Data Tidak Ditemukan</td>";
        }
    }

}
