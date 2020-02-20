<?php
class jadwalkuliah extends MY_Controller
{
    var $folder =   "jadwalKuliah";
    var $tables =   "akademik_jadwal_kuliah";
    var $pk     =   "jadwal_id";
    var $title  =   "Jadwal Kuliah";

    function __construct() {
        parent::__construct();
    }

    function index()
    {
        //akses_admin();
        $level = $this->session->userdata('level');
        if ($level == 1 OR $level == 2 OR $level == 6) {
            $data['title']=  $this->title;
            $data['desc']="";
            $this->template->load('template', $this->folder.'/view',$data);
        }
        else{
            $this->load->view('404/404');
        }


    }

    function tampiljadwal()
    {
        $konsentrasi    =   $_GET['konsentrasi'];
        // $tahun_akademik =   $_GET['tahun_akademik'];
        $semester       =   $_GET['semester'];
        $level = $this->session->userdata('level');

        if ($level=='6') {
          $disabled = "disabled";
        }else {
          $disabled = "";
        }

        echo "<table class='table table-bordered' id='jadwal'>
        <tr class='alert-info'>
        <th width=7>#</th>
        <th width=7>No</th>
        
        <th width=120>Hari</th>
        <th>Kode</th>
        <th>Matakuliah</th>
        <th width=5>SKS</th>
        <th width=150>Ruang</th>
        <th  width=150>Jam</th>
        <th  width=150>Kuota SKS</th>
        <th  width=150>Kuota Terisi</th>
        <th>Dosen</th>
        <th>Dosen 2</th>
        <th>Dosen 3</th>
        ";
        $i=1;

        if($semester==0)
        {
            // looping semester
            $smt=  getField('akademik_konsentrasi', 'jml_semester', 'konsentrasi_id', $konsentrasi);
            for($j=1;$j<=$smt;$j++)
            {
                echo"<tr class='warning'><th colspan=10>SEMESTER $j</th></tr>";
                $sql="  SELECT jk.*,mm.jam,mm.nama_makul,mm.kode_makul,mm.sks,mm.semester,jk.jam_mulai,jk.jam_selesai
                FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm
                WHERE mm.makul_id=jk.makul_id and jk.konsentrasi_id=$konsentrasi and jk.semester=$j";
                // and jk.tahun_akademik_id=$tahun_akademik

                $data=  $this->db->query($sql)->result();
                $class="class='form-control'";
                foreach ($data as $r)
                {
                    echo "<tr>
                    <td align='center'>
                        <a href='".base_url()."' onclick='return confirm('yakin hapus ?')'>
                            <i class='fa fa-trash'></i>
                        </a>
                    </td>
                    ";
                    echo "<td align='center'>$i</td>
                         
                        <td>";
                        cetak(editcombo('hari','app_hari','col-sm-14','hari','hari_id','',array('onchange'=>'simpanhari('.$r->jadwal_id.')','id'=>'hariid'.$r->jadwal_id),$r->hari_id));
                        echo "</td>
                        <td>".  strtoupper($r->kode_makul)."</td>
                        <td>".  strtoupper($r->nama_makul)."</td>
                        <td align='center'>$r->sks</td>
                        <td>";
                        cetak(editcombo('ruang','app_ruangan','col-sm-14','nama_ruangan','ruangan_id','',array('onchange'=>'simpanruang('.$r->jadwal_id.')','id'=>'ruangid'.$r->jadwal_id),$r->ruangan_id));
                        echo"</td>
                        <td>";
                        echo inputan('text', '', 'col-sm-12', '', 1, $r->jam_mulai, array('onKeyup'=>'simpanjam('.$r->jadwal_id.')','id'=>'jamid'.$r->jadwal_id));
                        echo inputan('text','', 'col-sm-12', '', 1, $r->jam_selesai, array('disabled'=>'disabled'));
                        //echo editcombo('waktu_kuliah','akademik_waktu_kuliah','col-sm-13','keterangan','waktu_id','',array('onchange'=>'simpanjam('.$r->jadwal_id.')','id'=>'jamid'.$r->jadwal_id),$r->waktu_id);
                        echo"</td>

                        <td>";
                        echo inputan('text', '', 'col-sm-9', '', 1, $r->kuota, array('onKeyup'=>'simpankuota('.$r->jadwal_id.')','id'=>'kuotaid'.$r->jadwal_id));
                        echo"</td>

                        <td>";
                        echo cek_kuota_terisi($r->jadwal_id);
                        echo"</td>

                        <td>";
                        echo editcombo('dosen','app_dosen','col-sm-13','nama_lengkap','dosen_id','',array('onchange'=>'simpandosen('.$r->jadwal_id.',"dosen_id","dosenid")','id'=>'dosenid'.$r->jadwal_id),$r->dosen_id);
                        echo"</td>
                        <td>";
                        echo editcombo('dosen2','app_dosen','col-sm-13','nama_lengkap','dosen_id','',array('onchange'=>'simpandosen('.$r->jadwal_id.',"dosen_id2","dosenid2")','id'=>'dosenid2'.$r->jadwal_id),$r->dosen_id2);
                        echo"</td>
                        <td>";
                        echo editcombo('dosen3','app_dosen','col-sm-13','nama_lengkap','dosen_id','',array('onchange'=>'simpandosen('.$r->jadwal_id.',"dosen_id3","dosenid3")','id'=>'dosenid3'.$r->jadwal_id),$r->dosen_id3);
                        echo"</td>

                            </tr>";
                    $i++;
                }
            }
        }
        else
        {
            $sql="SELECT jk.*,mm.jam,mm.nama_makul,mm.kode_makul,mm.sks,mm.semester,jk.jam_mulai,jk.jam_selesai
                FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm
                WHERE mm.makul_id=jk.makul_id and jk.konsentrasi_id=$konsentrasi and jk.semester=$semester";
                // and jk.tahun_akademik_id=$tahun_akademik

                $data=  $this->db->query($sql)->result();
                $class="class='form-control'";
                if (!empty($data))
                {
                    foreach ($data as $r)
                    {

                        echo "<tr>
                            <td align='center'>
                                <a href='".base_url()."jadwalkuliah/hapus_jadwal/".$r->jadwal_id."' onclick=\"return confirm('yakin hapus ?')\">
                                    <i class='fa fa-trash'></i>
                                </a>
                            </td>
                            ";
                        echo "
                            <td align='center'>$i</td>
                            <td>";
                            $app_hari = $this->db->get_where('app_hari',"hari_id='$r->hari_id'")->row();
                            if ($disabled=="disabled") {
                              if ($app_hari=='') {
                                echo "-";
                              }else {
                                echo strtoupper($app_hari->hari);
                              }
                            }else {
                              echo editcombo('hari','app_hari','col-sm-14','hari','hari_id','',array('onchange'=>'simpanhari('.$r->jadwal_id.')','id'=>'hariid'.$r->jadwal_id),$r->hari_id);
                            }
                            echo"</td>
                            <td>".  strtoupper($r->kode_makul)."</td>
                            <td>".  strtoupper($r->nama_makul)."</td>
                            <td align='center'>$r->sks</td>
                            <td>";
                            $app_ruangan = $this->db->get_where('app_ruangan',"ruangan_id='$r->ruangan_id'")->row();
                            if ($disabled=="disabled") {
                              if ($app_ruangan=='') {
                                echo "-";
                              }else {
                                echo strtoupper($app_ruangan->nama_ruangan);
                              }
                            }else {
                              echo editcombo('ruang','app_ruangan','col-sm-14','nama_ruangan','ruangan_id','',array('onchange'=>'simpanruang('.$r->jadwal_id.')','id'=>'ruangid'.$r->jadwal_id),$r->ruangan_id);
                            }
                            echo"</td>
                            <td align='center'>";
                            if ($disabled=="disabled") {
                              echo "$r->jam_mulai - $r->jam_selesai";
                            }else {
                              echo inputan('text', '', 'col-sm-12', '', 1, $r->jam_mulai, array('onKeyup'=>'simpanjam('.$r->jadwal_id.')','id'=>'jamid'.$r->jadwal_id));
                              echo inputan('text','', 'col-sm-12', '', 1, $r->jam_selesai, array('disabled'=>'disabled'));
                              //echo editcombo('waktu_kuliah','akademik_waktu_kuliah','col-sm-13','keterangan','waktu_id','',array('onchange'=>'simpanjam('.$r->jadwal_id.')','id'=>'jamid'.$r->jadwal_id),$r->waktu_id);
                            }
                            echo"</td>

                             <td>";
                            echo inputan('text', '', 'col-sm-9', '', 1, $r->kuota, array('onKeyup'=>'simpankuota('.$r->jadwal_id.')','id'=>'kuotaid'.$r->jadwal_id));
                            echo"</td>

                            <td>";
                            echo cek_kuota_terisi($r->jadwal_id);
                            echo"</td>

                            <td>";
                            $app_dosen = $this->db->get_where('app_dosen', array('dosen_id'=>$r->dosen_id))->row();
                            if ($disabled=="disabled") {
                              if ($app_dosen=='') {
                                echo "-";
                              }else {
                                echo strtoupper($app_dosen->nama_lengkap);
                              }
                            }else {
                              echo editcombo('dosen','app_dosen','col-sm-13','nama_lengkap','dosen_id','',array('onchange'=>'simpandosen('.$r->jadwal_id.',"dosen_id","dosenid")','id'=>'dosenid'.$r->jadwal_id),$r->dosen_id);
                            }
                            echo"</td>
                            <td>";
                            $app_dosen2 = $this->db->get_where('app_dosen', array('dosen_id'=>$r->dosen_id2))->row();
                            if ($disabled=="disabled") {
                              if ($app_dosen2=='') {
                                echo "-";
                              }else {
                                echo strtoupper($app_dosen2->nama_lengkap);
                              }
                            }else {
                              echo editcombo('dosen2','app_dosen','col-sm-13','nama_lengkap','dosen_id','',array('onchange'=>'simpandosen('.$r->jadwal_id.',"dosen_id2","dosenid2")','id'=>'dosenid2'.$r->jadwal_id),$r->dosen_id2);
                            }
                            echo"</td>
                            <td>";
                            $app_dosen3 = $this->db->get_where('app_dosen', array('dosen_id'=>$r->dosen_id3))->row();
                            if ($disabled=="disabled") {
                              if ($app_dosen3=='') {
                                echo "-";
                              }else {
                                echo strtoupper($app_dosen3->nama_lengkap);
                              }
                            }else {
                              echo editcombo('dosen3','app_dosen','col-sm-13','nama_lengkap','dosen_id','',array('onchange'=>'simpandosen('.$r->jadwal_id.',"dosen_id3","dosenid3")','id'=>'dosenid3'.$r->jadwal_id),$r->dosen_id3);
                            }
                            echo"</td>
                                </tr>";
                        $i++;
                    }
                }
                else{
                    echo"<tr align='center'><td colspan=10>Data Tidak Ditemukan</td></tr>";
                }

        }
        echo"</table>";
    }

    function simpanhari()
    {
        $id         =   $_GET['id'];
        $nilaihari  =   $_GET['nilaihari'];
        $nilaijam   =   $_GET['nilai_jam'];
        $nilairuang =   $_GET['nilai_ruang'];
        $get_jam    =   $this->db->query("SELECT mm.jam,jk.ruangan_id,jk.hari_id,jk.jadwal_id
                        FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm
                        WHERE mm.makul_id=jk.makul_id and jk.jadwal_id=$id")->row_array();
        $chek=  $this->chek_ruangan($nilairuang, $nilaihari, $nilaijam);
        if($chek==1)
        {
             $this->Mcrud->update($this->tables,array('hari_id'=>$nilaihari), $this->pk,$id);
             echo "<div class='alert alert-success'>Jadwal Berhasil Diperbaharui <i class='fa fa-check'></i> </div>";
        }
        else
        {
            echo "<div class='alert alert-danger'>Jadwal Gagal Diperbaharui <i class='fa fa-remove'></i> </div>";
        }
        echo " <script>
         $(document).ready(function(){
              $('.alert').fadeIn('fast').show().delay(3000).fadeOut('fast');
            });
         </script>";
    }

    function simpanruang()
    {
        $id         =   $_GET['id'];
        $nilaijam   =   $_GET['nilai_jam'];
        $nilaihari  =   $_GET['nilaihari'];
        $nilairuang =   $_GET['nilai_ruang'];
        $get_jam    =   $this->db->query("SELECT mm.jam,jk.ruangan_id,jk.hari_id,jk.jadwal_id
                        FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm
                        WHERE mm.makul_id=jk.makul_id and jk.jadwal_id=$id")->row_array();
        //$chek=  $this->chek_ruangan($nilairuang, $nilaihari, $nilaijam);
        if($nilairuang)
        {

            $this->Mcrud->update($this->tables,array('ruangan_id'=>$nilairuang), $this->pk,$id);
             echo "<div class='alert alert-success'>Jadwal Berhasil Diperbaharui <i class='fa fa-check'></i> </div>";
        }
        else
        {
            echo "<div class='alert alert-danger'>Jadwal Gagal Diperbaharui <i class='fa fa-remove'></i> </div>";
        }
        echo " <script>
         $(document).ready(function(){
              $('.alert').fadeIn('fast').show().delay(3000).fadeOut('fast');
            });
         </script>";
    }

    function simpandosen()
    {
        $id         =   $_GET['id'];
        $nilaidosen =   $_GET['nilai_dosen'];
        $field      =   $_GET['field'];
        $this->Mcrud->update($this->tables,array($field=>$nilaidosen), $this->pk,$id);
        echo "<div class='alert alert-success'>Jadwal Berhasil Diperbaharui <i class='fa fa-check'></i> </div>";
        echo " <script>
         $(document).ready(function(){
              $('.alert').fadeIn('fast').show().delay(3000).fadeOut('fast');
            });
         </script>";
    }


    function chek_ruangan($ruangan_id,$hari_id,$jam)
    {
        $query="SELECT jadwal_id,timediff(jam_selesai,'$jam') as selisih
                FROM akademik_jadwal_kuliah
                WHERE hari_id='$hari_id' and ruangan_id='$ruangan_id'";

        $chek=$this->db->query($query)->num_rows();
        if($chek==0)
        {
            return 1;
        }
        else
        {
            $r      =   $this->db->query($query)->row_array();
            $jam    =   substr($r['selisih'],0,2);
            $menit  =   substr($r['selisih'],3,2);
            if($menit>0 or $jam>0)
            {
                // tidak
                return 0;
            }
            else
            {
                return 1;
            }
        }
    }
    function simpanjam()
    {
        $id         =   $_GET['id'];
        $nilaijam   =   $_GET['nilai_jam'];
        $nilaihari  =   $_GET['nilaihari'];
        $nilairuang =   $_GET['nilai_ruang'];
        $get_jam    =   $this->db->query("SELECT mm.jam,jk.ruangan_id,jk.hari_id,jk.jadwal_id
                        FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm
                        WHERE mm.makul_id=jk.makul_id and jk.jadwal_id=$id")->row_array();
        //$chek=  $this->chek_ruangan($nilairuang, $nilaihari, $nilaijam);

        if($get_jam)
        {
            // save
            $jam_selesai=  $this->get_jam_selesai_kuliah($nilaijam.':00', ($get_jam['jam']*50));
            $this->Mcrud->update($this->tables,array('jam_mulai'=>$nilaijam,'jam_selesai'=>$jam_selesai), $this->pk,$id);
            echo "<div class='alert alert-success'>Jadwal Berhasil Diperbaharui <i class='fa fa-check'></i> </div>";
        }
        else
        {
             echo "<div class='alert alert-danger'>Jadwal Gagal Diperbaharui <i class='fa fa-info'></i> </div>";
        }
        echo " <script>
         $(document).ready(function(){
              $('.alert').fadeIn('fast').show().delay(12000).fadeOut('fast');
            });
         </script>";
    }

    function simpankuota()
    {
        $id         =   $_GET['id'];
        $kuota   =   $_GET['kuota'];
        // log_r($_GET);
        //$chek=  $this->chek_ruangan($nilairuang, $nilaihari, $nilaijam);

        if($kuota > 0)
        {
            // save
            $this->Mcrud->update($this->tables,array('kuota'=>$kuota), $this->pk,$id);
            echo "<div class='alert alert-success'>Jadwal Berhasil Diperbaharui <i class='fa fa-check'></i> </div>";
        }
        else
        {
             echo "<div class='alert alert-danger'>Jadwal Gagal Diperbaharui <i class='fa fa-info'></i> </div>";
        }
        echo " <script>
         $(document).ready(function(){
              $('.alert').fadeIn('fast').show().delay(12000).fadeOut('fast');
            });
         </script>";
    }

    function autosetup()
    {
        $tahun_akademik_id  =   $this->input->post('tahun_akademik');
        $tahun_akd          =   getField('akademik_tahun_akademik', 'keterangan', 'tahun_akademik_id', $tahun_akademik_id);
        $tahun_akd=  substr($tahun_akd, 4,1);
        $prodi              =   $this->input->post('prodi');
        $konsentrasi        =   $this->input->post('konsentrasi');
        // get semester
        $semester           =   getField('akademik_konsentrasi', 'jml_semester', 'konsentrasi_id', $konsentrasi);
        // looping semester

        if($tahun_akd==1)
        {
            $sms=array(1,3,5,7);
        }
        else
        {
            $sms=array(2,4,6,8);
        }
        //for($i=1;$i<=$semester;$i++)
        for($i=0;($i<=count($sms)-1);$i++)
        {
            $smstr=$sms[$i];
            // ambil makul_id dari makul_matakuliah
            $makul      =   $this->db->get_where('makul_matakuliah',array('semester'=>$smstr,'konsentrasi_id'=>$konsentrasi,'aktif'=>'y'))->result();
            foreach ($makul as $makul)
            {
                $makul_id   =   $makul->makul_id;
                // chek udah ada belum
                $param      =   array('tahun_akademik_id'=>  $tahun_akademik_id,
                                       'konsentrasi_id'=>$konsentrasi,
                                       'makul_id'=>$makul_id);
                $chek       =  $this->db->get_where('akademik_jadwal_kuliah',$param)->num_rows();
                if($chek<1)
                {
                    $data       =   array(  'tahun_akademik_id'=>  $tahun_akademik_id, //get_tahun_akademik(),
                                            'konsentrasi_id'=>$konsentrasi,
                                            'makul_id'=>$makul_id,
                                            'hari_id'=>0,
                                            'semester'=>$i,
                                            'waktu_id'=>0,
                                            'ruangan_id'=>0,
                                             'semester'=>$smstr,
                                            'dosen_id'=>0);
                    $this->db->insert('akademik_jadwal_kuliah',$data);
                } else {
                    echo "Jadwal Sudah ADA !!";
                }
            }
        }
        redirect('jadwalkuliah');
    }

    public function FunctionName()
    {
        echo $this->session->userdata('keterangan');
    }

    public function mahasiswa()
    {
        $id  =  $this->session->userdata('keterangan');
        $data['thn']        = get_tahun_ajaran_aktif('tahun_akademik_id');
        $data['semester']   =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
        $data['tahun_akademik']=  $this->db->query('SELECT * FROM akademik_tahun_akademik where status="y"')->result();
        $data['title']="Jadwal Kuliah";
        $this->template->load('template', $this->folder.'/jadwalmahasiswa',$data);
    }

    function jadwalngajar()
    {
        $dosen  =  $this->session->userdata('keterangan');
        $thn    = get_tahun_ajaran_aktif('tahun_akademik_id');

        $query="SELECT ak.jenjang,ak.nama_konsentrasi,ar.nama_ruangan,mm.sks,mm.nama_makul,mm.kode_makul,ah.hari,aj.jam_mulai,aj.jam_selesai
                FROM akademik_jadwal_kuliah as aj,app_ruangan as ar,akademik_konsentrasi as ak,makul_matakuliah as mm,app_hari as ah
                WHERE ar.ruangan_id=aj.ruangan_id and ak.konsentrasi_id=aj.konsentrasi_id and mm.makul_id=aj.makul_id and ah.hari_id=aj.hari_id and aj.dosen_id=$dosen and aj.tahun_akademik_id";
        $data['jadwal']=  $this->db->query($query)->result();
        $data['title']="Jadwal Mengajar";
        $data['dosen']=$dosen;
        $this->template->load('template', $this->folder.'/jadwalngajar',$data);
    }


            function get_jam($menit)
        {
            for($i=0;$i<=7;$i++)
            {
                if(($i*60)>$menit)
                {
                    return $i-1;
                    exit();
                }
            }
        }


        function get_menit($menit)
        {
            $jam=  $this->get_jam($menit);
            return $menit-$jam*60;
        }

        function get_nol($nilai)
        {
            if($nilai>9)
            {
                return $nilai;
            }
            else
            {
                return "0$nilai";
            }
        }

        function get_jam_selesai_kuliah($jam_mulai,$waktu_kuliah)
        {
            $jam=  $this->get_jam($waktu_kuliah);
            $menit=  $this->get_menit($waktu_kuliah);
            $dateString = "Tue, 13 Mar 2012 $jam_mulai";
            $date = new DateTime( $dateString );
            $nextHour   = (intval($date->format('H'))+$jam) % 24;
            $nextMinute = (intval($date->format('i'))+$menit) % 60;
            return $this->get_nol($nextHour).':'.$this->get_nol($nextMinute);
        }



        function cetak()
        {
            //$konsen             =  $this->uri->segment(3);
            //$semester           =  $this->uri->segment(4);
            //$tahun              =  $this->uri->segment(5);
            //$konsen             =  $this->uri->segment(3);
            $konsen             =  $this->input->post('konsentrasi');
            $semester           =  $this->input->post('semester');
            // $tahun              =  $this->input->post('tahun_akademik');
            $data['konsen']     =  $konsen;
            $data['semester']   =  $semester;
            $data['tahun']      =  '';
            $data['hari']       =  array('','senin','selasa','rabu','kamis','jumat','sabtu','minggu');
            $data['prodi']      =  strtoupper(getField('akademik_prodi', 'nama_prodi', 'prodi_id', getField('akademik_konsentrasi', 'prodi_id', 'konsentrasi_id', $konsen)));
            $data['konsentrasi']=  strtoupper(getField('akademik_konsentrasi', 'nama_konsentrasi', 'konsentrasi_id', $konsen));
            $this->load->view($this->folder.'/cetak',$data);

        }

        function get_matkul_manual(){
            $id=$this->input->post('id');
            $konsentrasi_id=$this->input->post('konsentrasi_id');
            $data=$this->db->get_where('makul_matakuliah', array('semester'=>$id,'konsentrasi_id'=>$konsentrasi_id))->result();
            foreach ($data as $row) {
                echo "<option value='$row->makul_id'> $row->makul_id $row->nama_makul </option>";
            }
        }

        function simpan_jadwalkuliah_manual()
        {
            $semester = $this->input->post('semester');
            $matkul_manual = $this->input->post('matkul_manual');
            $hari = $this->input->post('hari');
            $ruangan = $this->input->post('ruangan');
            $jam_mulai = $this->input->post('jam_mulai');
            $jam_selesai = $this->input->post('jam_selesai');
            $dosen1 = $this->input->post('dosen1');
            $dosen2 = $this->input->post('dosen2');
            $dosen3 = $this->input->post('dosen3');
            $konsentrasi = $this->input->post('konsentrasi');
            $tahun_akademik = get_tahun_akademik();

            $data = array(
                'tahun_akademik_id'=> $tahun_akademik,
                'konsentrasi_id'=> $konsentrasi,
                'makul_id'=> $matkul_manual,
                'hari_id'=> $hari,
                'ruangan_id'=> $ruangan,
                'dosen_id'=> $dosen1,
                'dosen_id2'=> $dosen2,
                'dosen_id3'=> $dosen3,
                'semester'=> $semester,
                'jam_mulai'=> $jam_mulai,
                'jam_selesai'=> $jam_selesai,
            );
            $simpan = $this->db->insert('akademik_jadwal_kuliah', $data);
            if ($simpan) {
                $message = '<div class="alert alert-success alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Data berhasil disimpan.
                        </div>';
                $this->session->set_flashdata('message', $message);
                redirect('jadwalkuliah','refresh');
            } else {
                $message = '<div class="alert alert-warning alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Gagal!</strong> Data gagal disimpan, ulangi lagi.
                        </div>';
                $this->session->set_flashdata('message', $message);
                redirect('jadwalkuliah','refresh');
            }
            
            
        }

        function hapus_jadwal($id)
        {
            $this->db->where('jadwal_id', $id);
            $this->db->delete('akademik_jadwal_kuliah');
            $message = '<div class="alert alert-danger alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>success!</strong> Data berhasil dihapus.
                        </div>';
            $this->session->set_flashdata('message', $message);
            redirect('jadwalkuliah','refresh');
        }

}
