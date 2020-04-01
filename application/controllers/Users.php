<?php
class users extends MY_Controller{
    
    var $folder =   "users";
    var $tables =   "app_users";
    var $pk     =   "id_users";
    var $title  =   "Users";
    function __construct() {
        parent::__construct();
        $level = $this->session->userdata('level');
        if ($level==3) {
            $this->edit_dosen;
        }
        elseif ($level==4) {
            // redirect(base_url('user'));
        }
    }

    function edit()
    {
        if(isset($_POST['submit']))
        {
            $username  =   $this->input->post('username');
            $username_lama  =   $this->input->post('username_lama');
            $password  =   $this->input->post('password');
            $passhash  =   hash_string($password);
            $id     = $this->input->post('id');
            $data   =   array('username'=>$username,'password'=>$passhash);
            
            if($username == $username_lama){
                $this->Mcrud->update($this->tables,$data, $this->pk,$id);
                redirect($this->uri->segment(1));
            } else {
                $cekusername = $this->db->get_where('app_users', array('username'=>$username));
                if($cekusername->num_rows()>0){
                    ?>
                    <script type="text/javascript">
                        alert('username sudah ada');
                        window.location="<?php echo base_url('users') ?>";
                    </script>
                    <?php
                } else {
                    $this->Mcrud->update($this->tables,$data, $this->pk,$id);
                    redirect($this->uri->segment(1));
                }
            }
            
            
        }
        else
        {
            $data['title']=  $this->title;
            $id          =  $this->uri->segment(3);
            $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
            $this->template->load('template', $this->folder.'/edit',$data);
        }
    }

    function edit_mhs()
    {
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
                                                'alamat_ibu'=>$alamat_ibu,
                                                'no_hp_ortu'=>$no_hp_ortu,
                                                'penghasilan_ayah'=>$penghsln_ayah,
                    'penghasilan_ibu'=>$penghsln_ibu);
                $data               =array_merge($orangtua,$kampus,$sekolah,$pribadi,$instansi,$institusi);
                $this->Mcrud->update('student_mahasiswa',$data, 'mahasiswa_id',$id);
                $this->session->set_flashdata('pesan', "<div class='alert alert-success'>Data $nama Berhasil Diedit</div>");
                redirect($this->uri->segment(1).'/edit_mhs');
            }
            else
            {
                $data['title']=  $this->title;
                $data['desc']="";
                $id          =  $this->uri->segment(3);
                $data['r']   =  $this->Mcrud->getByID('student_mahasiswa',  'mahasiswa_id',$id)->row_array();
                $this->template->load('template', 'mahasiswa/edit',$data);
            }
        }
        else
        {
            $data['title']=  $this->title;
            $data['desc']="";
            $id          =  $this->session->userdata('keterangan');;
            $data['r']   =  $this->Mcrud->getByID('student_mahasiswa',  'mahasiswa_id',$id)->row_array();
            $this->template->load('template', 'mahasiswa/edit',$data);
        }
    }
    
    function index()
    {
        if($this->session->userdata('level')==2)
        {
            $sess=$this->session->userdata('keterangan');
            $param="WHERE ad.keterangan='$sess'";
        }
        else
        {
            $param="";
        }
        $sql    =   "SELECT * FROM app_users as ad $param";
        $data['title']=  $this->title;
        $data['desc']="";
        $data['record']=  $this->db->query($sql)->result();
        $this->template->load('template', $this->folder.'/view',$data);
    //  $data['title']=  $this->title;
    //  $data['record']=  $this->db->get($this->tables)->result();
	//  $this->template->load('template', $this->folder.'/view',$data);
    }
    
    function keterangan($id)
    {
        if($id=='')
        {
            return '';
        }
        else
        {
            return getField('akademik_prodi', 'nama_prodi', 'prodi_id', $id);
        }
    }
    
    function level($level)
    {
        if($level==1)
        {
            return 'admin';
        }
        elseif($level==2)
        {
            return 'pihak jurusan';
        }
        elseif($level==3)
        {
            return 'pegawai';
        }
        else
        {
            return 'mahasiswa';
        }
    }
    
    function post()
    {
        if(isset($_POST['submit']))
        {
            $username  =   $this->input->post('username');
            $password  =   $this->input->post('password');
            $passhash  =   hash_string($password);
            $level     =   $this->input->post('level');
            $prodi     =   $this->input->post('prodi');

            if($level==2)
            {
                 $data   =   array('username'   =>$username,
                                    'password'  =>$passhash,
                                    'level'     =>$level,
                                    'keterangan'=>$prodi
                                );
            }
            else
            {
                 $data   =   array('username'=>$username,'password'=>$passhash ,'level'=>$level);
            }
            $this->db->insert($this->tables,$data);
            redirect($this->uri->segment(1));
        }
        else
        {
            $data['title']=  $this->title;
            $this->template->load('template', $this->folder.'/post',$data);
        }
    }
    
    function edit_dosen()
    {
        
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
            $this->Mcrud->update('app_dosen',$data, 'dosen_id',$id);
            redirect($this->uri->segment(1).'/'.$this->uri->segment(2));
        }
        else
        {
            $data['title']=  $this->title;
            $data['desc']="Edit Dosen";
            $id          =  $this->session->userdata('keterangan');;
            $data['r']   =  $this->Mcrud->getByID('app_dosen',  'dosen_id',$id)->row_array();
            $this->template->load('template', 'dosen/edit',$data);
        }
    }

    function delete()
    {
        $id     =  $_GET['id'];
        $this->Mcrud->delete($this->tables,  $this->pk,  $id);
    }
    
    function profile()
    {
        $id=  $this->session->userdata('id_users');
        if(isset($_POST['submit']))
        {
            $username=  $this->input->post('username');
            $password=  $this->input->post('password');
            $passhash  =   hash_string($password);
            $data    =  array('username'=>$username,'password'=>$passhash);
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            redirect('users/profile');
        }
        else
        {
            $data['title']=  $this->title;
            $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
            $this->template->load('template', $this->folder.'/profile',$data);
        }
    }
    
    function account()
    {
        $id=  $this->session->userdata('keterangan');
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
            $data           =   array(  'nama_lengkap'=>$nama,
                                        'nidn'=>$nidn,
                                        'nip'=>$nip,
                                        'tempat_lahir'=>$tempat_lahir,
                                        'tanggal_lahir'=>$tanggal_lahir,
                                        'gender'=>$gender,
                                        'agama_id'=>$agama,
                                        'status_kawin'=>$kawin,
                                        'alamat'=>$alamat,'hp'=>$hp,
                                        'email'=>$email);
            $this->Mcrud->update('app_dosen',$data, 'dosen_id',$id);
            redirect('users/account');
        }
        else
        {
            $data['title']=  $this->title;
            $data['r']   =  $this->Mcrud->getByID('app_dosen',  'dosen_id',  $id)->row_array();
            $this->template->load('template', $this->folder.'/account',$data);
        }
    }
}