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
            redirect(base_url());
        }
        elseif ($level==4) {
            redirect(base_url());
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