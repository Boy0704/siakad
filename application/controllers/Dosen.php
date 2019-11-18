<?php

class dosen extends MY_Controller{

    var $folder =   "dosen";
    var $tables =   "app_dosen";
    var $pk     =   "dosen_id";
    var $title  =   "Data Dosen";

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('level')==4) {
            redirect('mahasiswa');
        }
    }

    function index()
    {
        $level = $this->session->userdata('level');
        if ($level==1 OR $level==2 OR $level==6)
        {
            if($level==2)
            {
                $sess=$this->session->userdata('keterangan');
                $param="and ap.prodi_id='$sess'";
            }
            else
            {
                $param="";
            }
            $sql    =   "SELECT ad.hp,ad.email,ad.dosen_id,ad.nama_lengkap,ad.nidn,ad.nip,ap.nama_prodi
                        FROM app_dosen as ad,akademik_prodi as ap
                        WHERE ad.prodi_id=ap.prodi_id and dosen_id not in('0') $param";
            $data['title']=  $this->title;
            $data['desc']="";
            $data['record']=  $this->db->query($sql)->result();
            $this->template->load('template', $this->folder.'/view',$data);
        }
        else
        {
            $data['title']=  strtoupper($this->session->userdata('username'));
            $ses = $this->session->userdata('keterangan');
            $get="SELECT ad.hp,ad.email,ad.dosen_id,ad.nama_lengkap,ad.nidn,ad.nip,ap.nama_prodi
                        FROM app_dosen as ad,akademik_prodi as ap
                        WHERE ad.dosen_id=$ses";
            $data['record'] = $this->db->query($get)->row();
            $this->template->load('template', $this->folder.'/view',$data);
        }
    }


    function post()
    {
        akses_admin();
        if(isset($_POST['submit']))
        {
            $nama           =   $this->input->post('nama');
            $nidn           =   $this->input->post('nidn');
            $nip            =   $this->input->post('nip');
            $tempat_lahir   =   $this->input->post('tempat_lahir');
            $tanggal_lahir  =   $this->input->post('tanggal_lahir');
            $gender         =   $this->input->post('gender');
            $agama          =   $this->input->post('agama');
            $kawin          =   $this->input->post('kawin');
            $alamat         =   $this->input->post('alamat');
            $hp             =   $this->input->post('hp');
            $email          =   $this->input->post('email');
            $prodi_id       =   $this->input->post('prodi_id');
            $data           =   array(  'nama_lengkap'=>$nama,
                                        'nidn'=>$nidn,
                                        'nip'=>$nip,
                                        'tempat_lahir'=>$tempat_lahir,
                                        'tanggal_lahir'=>$tanggal_lahir,
                                        'gender'=>$gender,
                                        'agama_id'=>$agama,
                                        'status_kawin'=>$kawin,
                                        'alamat'=>$alamat,'hp'=>$hp,
                                        'email'=>$email,
                                        'prodi_id'=>$prodi_id,
                                        'prodi_id'=> $this->session->userdata('keterangan'));
            $username       =   $this->input->post('username');
            $password       =   $this->input->post('password');
            $this->db->insert($this->tables,$data);
            $id             = getField('app_dosen', 'dosen_id', 'nama_lengkap', $nama);
            $account        = array('username'=>$username,'password'=>  hash_string($password),'keterangan'=>$id,'level'=>3);
            $this->db->insert('app_users',$account);
            redirect($this->uri->segment(1));
        }
        else
        {
            $data['title']=  $this->title;
            $data['desc']="Input Dosen";
            $this->template->load('template', $this->folder.'/post',$data);
        }
    }
    function edit()
    {
        akses_admin();
        if(isset($_POST['submit']))
        {
            $id     = $this->input->post('id');
            $nama           =   $this->input->post('nama');
            $nidn           =   $this->input->post('nidn');
            $nip            =   $this->input->post('nip');
            $tempat_lahir   =   $this->input->post('tempat_lahir');
            $tanggal_lahir  =   $this->input->post('tanggal_lahir');
            $gender         =   $this->input->post('gender');
            $agama          =   $this->input->post('agama');
            $kawin          =   $this->input->post('kawin');
            $alamat         =   $this->input->post('alamat');
            $hp             =   $this->input->post('hp');
            $email          =   $this->input->post('email');
            $prodi_id       =   $this->input->post('prodi_id');
            $data           =   array(  'nama_lengkap'=>$nama,
                                        'nidn'=>$nidn,
                                        'nip'=>$nip,
                                        'tempat_lahir'=>$tempat_lahir,
                                        'tanggal_lahir'=>$tanggal_lahir,
                                        'gender'=>$gender,
                                        'agama_id'=>$agama,
                                        'status_kawin'=>$kawin,
                                        'alamat'=>$alamat,'hp'=>$hp,
                                        'email'=>$email,
                                        'prodi_id'=>$prodi_id);
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            redirect($this->uri->segment(1));
        }
        else
        {
            $data['title']=  $this->title;
            $data['desc']="Edit Dosen";
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
        $this->Mcrud->delete('app_users',  'keterangan_id',  $id);

    }

}
