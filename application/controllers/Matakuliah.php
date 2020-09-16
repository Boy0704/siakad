<?php
class matakuliah extends MY_Controller{

    var $folder =   "matakuliah";
    var $tables =   "makul_matakuliah";
    var $pk     =   "makul_id";
    var $title  =   "Mata Kuliah";

    function __construct() {
        parent::__construct();
    }

    function index()
    {
        $query="SELECT mm.makul_id,mm.kode_makul,mm.nama_makul,mk.kode_kelompok,mm.sks
                FROM makul_matakuliah as mm,makul_kelompok as mk
                WHERE mk.kelompok_id=mm.kelompok_id";
        $data['title']  = $this->title;
        $data['desc']    =   "";
        $data['makul']=  $this->db->query($query)->result();
        $data['prodi']=  $this->db->get('akademik_prodi')->result();
	    $this->template->load('template', $this->folder.'/view',$data);
    }


    function tampilkonsentrasi()
    {

        $prodi=$_GET['prodi'];
        $data=  $this->db->get_where('akademik_konsentrasi',array('prodi_id'=>$prodi))->result();
        foreach ($data as $r)
        {
            echo "<option value='$r->konsentrasi_id'>".  strtoupper($r->nama_konsentrasi)."</option>";
        }
    }


    function tampilsemester()
    {
        $konsentrasi=$_GET['konsentrasi'];
        // get semester
        $r=  $this->db->get_where('akademik_konsentrasi',array('konsentrasi_id'=>$konsentrasi))->row_array();
        for($i=1;$i<=$r['jml_semester'];$i++)
        {
            echo "<option value='$i'>SEMESTER $i</option>";
        }
        echo "<option value='0'>SEMUA SEMESTER</option>";
    }

    function jadwalkuliah()
    {
        $query="SELECT mm.makul_id,mm.kode_makul,mm.nama_makul,mk.kode_kelompok,mm.sks
                FROM makul_matakuliah as mm,makul_kelompok as mk
                WHERE mk.kelompok_id=mm.kelompok_id";
        $data['makul']=  $this->db->query($query)->result();
        $data['prodi']=  $this->db->get('akademik_prodi')->result();
	$this->template->load('template', $this->folder.'/jadwalkuliah',$data);
    }


    function post()
    {
        if(isset($_POST['submit']))
        {
            $nama   =   $this->input->post('nama');
            $kode   =   $this->input->post('kode');
            $sks    =   $this->input->post('sks');
            $jam    =   $this->input->post('jam');
            $semeste=   $this->input->post('semester');
            $konsen =   $this->input->post('konsentrasi');
            $kelomp =   $this->input->post('kelompok');
            $data   =   array(  'kode_makul'=>$kode,
                                'semester'=>$semeste,
                                'nama_makul'=>$nama,
                                'sks'=>$sks,
                                'jam'=>$jam,
                                'konsentrasi_id'=>$konsen,
                                'kelompok_id'=>$kelomp
                            );
            $this->db->insert($this->tables,$data);
            $pesan="<div class='alert alert-success'>Matakuliah $nama Sudah Disimpan Kedatabase !!</div>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('matakuliah/post');
        }
        else
        {
            $data['title']  = $this->title;
            $data['desc']    =   "";
            $this->template->load('template', $this->folder.'/post',$data);
        }
    }
    function edit()
    {
        if(isset($_POST['submit']))
        {
            $id     =   $this->input->post('id');
            $nama   =   $this->input->post('nama');
            $kode   =   $this->input->post('kode');
            $sks    =   $this->input->post('sks');
            $jam    =   $this->input->post('jam');
            $semeste=   $this->input->post('semester');
            $konsen =   $this->input->post('konsentrasi');
            $kelomp =   $this->input->post('kelompok');
            $data   =   array(  'kode_makul'=>$kode,
                                'semester'=>$semeste,
                                'nama_makul'=>$nama,
                                'sks'=>$sks,
                                'jam'=>$jam,
                                'konsentrasi_id'=>$konsen,
                                'kelompok_id'=>$kelomp
                            );
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            $pesan="<div class='alert alert-success'>Matakuliah $nama Sudah diubah Kedatabase !!</div>";
            $this->session->set_flashdata('pesan', $pesan);
            redirect('matakuliah/edit/'.$id);
        }
        else
        {
            $data['title']  = $this->title;
            $data['desc']    =   "Edit Matakuliah";
            $id          =  $this->uri->segment(3);
            $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
            $this->template->load('template', $this->folder.'/edit',$data);
        }
    }
    function delete()
    {
        $id     =  $_GET['id'];
        $this->Mcrud->delete('makul_matakuliah',  'makul_id',  $id);
    }

    function ubahstatus()
    {
        $id=$_GET['id'];
        // chek status terakhir
        $statuslama=  getField('makul_matakuliah', 'aktif', 'makul_id', $id);
        // simpan status
        $statusbaru=  $statuslama=='y'?'n':'y';
        // ubah status
        $this->Mcrud->update($this->tables,array('aktif'=>$statusbaru), $this->pk,$id);
    }




    function tampilmakul()
    {
        $konsentrasi    =   $_GET['konsentrasi'];
        $semester       =   $_GET['semester'];
        $level          = $this->session->userdata('level');
        // apabila request semua semester
        echo '<a href="'.base_url().'feeder/import_mk/'.$konsentrasi.'" class="btn btn-info">Export MK Feeder</a> <br>';
        if($semester==0)
        {
            
            echo"<table class='table table-bordered'>
            <tr class='alert-info'>
                <th width=10>No</th>
                <th width=20>Kode</th>
                <th>Nama Matakuliah</th>
                <th width=60>SKS</th>
                <th width=60>Waktu</th>";
                if ($level == '1' OR $level == '2' OR $level == '3' OR $level == '6') {
                  echo "<th colspan=3>Operasi</th>";
                }
            echo "
            </tr>";
            // dapatkan jumlah semester dari kosentrasi yang diminta
            $data=  $this->db->get_where('akademik_konsentrasi',array('konsentrasi_id'=>$konsentrasi))->row_array();
            $jmlSemester=$data['jml_semester'];
            for($i=1;$i<=$jmlSemester;$i++)
            {
                echo"<tr class='warning'><td colspan=9>Semester $i</td></tr>";
                $query          =   "SELECT mm.jam,mm.aktif,mm.makul_id,mm.kode_makul,mm.nama_makul,mk.kode_kelompok,mm.sks
                                    FROM makul_matakuliah as mm,makul_kelompok as mk
                                    WHERE mk.kelompok_id=mm.kelompok_id and mm.konsentrasi_id='$konsentrasi' and mm.semester='$i' order by mm.kode_makul asc";
                $makul          = $this->db->query($query)->result();
                $no=1;
                foreach ($makul as $m)
                {
                     // <td>".  strtoupper($m->kode_kelompok)."</td>
                    echo "<tr id='hide$m->makul_id'>
                        <td align='center'>".$no++."</td>
                        <td>".  strtoupper($m->kode_makul)."</td>
                        <td>".  strtoupper($m->nama_makul)."</td>
                        <td>$m->sks SKS</td>
                        <td>$m->jam JAM</td>";
                      if ($level == '1' OR $level == '2' OR $level == '3' OR $level == '6') {
                        echo "
                        <td align='center'>
                        <div class='btn-group'>
                       ";
                        if($m->aktif=='y')
                        {
                            echo"<i class='btn btn-sm btn-info fa fa-eye' title='Non Aktfikan' onclick='ubahstatus($m->makul_id)'></i>";
                        }
                        else
                        {
                            echo"<i class='btn btn-sm btn-info fa fa-eye-slash' title='Aktifkan' onclick='ubahstatus($m->makul_id)'></i>";
                        }
                        echo
                            "<i class='btn btn-sm btn-primary fa fa-edit' title='Edit' onclick='edit($m->makul_id)'></i>
                            <i class='btn btn-sm btn-danger fa fa-trash-o' title='Hapus'  onclick='hapus($m->makul_id)'></i>
                          </div></td>";
                        }
                        echo "
                        </tr>";
                }

            }
            echo "<table>";
        }
        else
        {
        $query          =   "SELECT mm.jam,mm.aktif,mm.makul_id,mm.kode_makul,mm.nama_makul,mk.kode_kelompok,mm.sks
                            FROM makul_matakuliah as mm,makul_kelompok as mk
                            WHERE mk.kelompok_id=mm.kelompok_id and mm.konsentrasi_id='$konsentrasi' and mm.semester='$semester' order by mm.kode_makul asc";
        $makul          =   $this->db->query($query)->result();
            echo"<table class='table table-bordered'>
            <tr class='alert-info'>
                <th width=10>No</th>
                <th width=20>Kode</th>
                <th>Nama Matakuliah</th>
                <th width=60>SKS</th>
                <th width=60>Waktu</th>";
                if ($level<='3') {
                  echo "<th colspan=3>Operasi</th>";
                }
            echo "
            </tr>";
            $no=1;
            if (!empty($makul))
            {
                foreach ($makul as $m)
                {
                    // <td>".  strtoupper($m->kode_kelompok)."</td>
                    echo "<tr id='hide$m->makul_id'>
                        <td>".$no++."</td>
                        <td>".  strtoupper($m->kode_makul)."</td>
                        <td>".  strtoupper($m->nama_makul)."</td>
                        <td>$m->sks SKS</td>
                        <td>$m->jam JAM</td>";
                      if ($level<='3') {
                        echo "
                       <td align='center'>
                        <div class='btn-group'>
                       ";
                        if($m->aktif=='y')
                        {
                            echo"<i class='btn btn-sm btn-info fa fa-eye' title='Non Aktfikan' onclick='ubahstatus($m->makul_id)'></i>";
                        }
                        else
                        {
                            echo"<i class='btn btn-sm btn-info fa fa-eye-slash' title='Aktifkan' onclick='ubahstatus($m->makul_id)'></i>";
                        }
                        echo
                            "<i class='btn btn-sm btn-primary fa fa-edit' title='Edit' onclick='edit($m->makul_id)'></i>
                            <i class='btn btn-sm btn-danger fa fa-trash-o' title='Hapus'  onclick='hapus($m->makul_id)'></i>
                          </div></td>";
                        }
                        echo "
                        </tr>";
                }
            }
            else{
                 echo"<tr align='center'><td colspan=9>Data Tidak Ditemukan</td></tr>";
            }


            echo "<table>";
        }
    }


}
