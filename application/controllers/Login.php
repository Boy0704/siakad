<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends MY_Controller
{
    var $title = "Login";
    
    function __construct() {
        parent::__construct();
        $this->load->helper(array('captcha','string'));
        header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header( "Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT" );
    }
    
    
    function index()
    {
        $this->userlogin();
    }
    
    function userlogin()
    {
        if(isset($_POST['submit']))
        {
            $username   =  $this->input->post('_username');
            $password   =  $this->input->post('_password');
            $this->form_validation->set_rules('_username', 'Username', 'required|max_length[20]');
            $this->form_validation->set_rules('_password', 'Password', 'required|min_length[3]|max_length[20]');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            if ($this->form_validation->run())
            {
                $capth        = strtoupper($this->input->post('_kode_aman'));
                $login=  $this->db->get_where('app_users',array('username'=>$username));
                if($login->num_rows()==1) //and $this->session->userdata('mycaptcha')==$capth)
                {
                    $r=  $login->row();
                    if(password_verify($password, $r->password))
                    {
                        $data=array('id_users'=>$r->id_users,
                                    'pembayaran_mahasiswa_nim'=>'emptyy',
                                    'level'=>$r->level,
                                    'sess_login_absen'=>  substr(waktu(), 0,10),
                                    'keterangan'=>$r->keterangan,
                                    'username'=>$username,
                                    'konsentrasi_id'=>get_data('student_mahasiswa','mahasiswa_id',$r->keterangan,'konsentrasi_id'),
                                    'prodi_id'=>$r->prodi_id
                                );
                        $this->session->set_userdata($data);
                        $this->Mcrud->update('app_users',array('last_login'=>  waktu(), 'jam_out'=>"Logged", 'status'=>'1'), 'username',$username);
                        // echo "<script>alert('$username anda berhasil login!!');</script>";
                         $level = $r->level;
                        if ($level==1) {
                          redirect("admin");
                        }elseif ($level==2 or $level==3 or $level==4) {
                          redirect("Mahasiswa");
                        }elseif ($level==5 OR $level==6) {
                          redirect("Profil");
                        }
                        redirect('');
                        
                        
                    }
                    else
                    {
                        
                        $this->session->set_flashdata('login_response', 'Pasword tidak valid!!');
                        redirect('login');
                        //echo $username.' '.$r->password.' INI ASLI : $2y$09$CuKzTS11Pd2eeIwlgIq2VuzYRN1JZ9QcwO/afP/nFLcoDsiFIUg6O';
                        // echo '<br>'.password_hash("12345",PASSWORD_BCRYPT, ['cost'=>9]);
                        // if (password_verify('1235', '$2y$09$.KF5V72xcTFt1v515Wu68uc1wrhOtdS5usmxO0bR6JWy5Gr7g/ZZu')) {
                        //     echo 'Password is valid!';
                        // } else {
                        //     echo 'Invalid password.';
                        // }
                        
                    }
                    
                }
                else
                {

                   $this->session->set_flashdata('login_response', 'Username atau kode aman tidak valid!!');
                   redirect('login');
                   //echo $username.' '.$this->session->userdata('mycaptcha').' '.$capth;
                }
                    
            }
            else
            {
                $vals = array
                (
                    'img_path'   => './captcha/',
                    'img_url'    => base_url().'captcha/',
                    'img_width'  => '100',
                    'img_height' => 35,
                    'word'  => strtoupper(random_string('alnum', 5)),
                    'border' => 0, 
                    // 'expiration' => 7200
                );
 
                // create captcha image
                $cap = create_captcha($vals);
     
                // store image html code in a variable
                $data['image'] = $cap['image'];
                $data['title'] =$this->title;
                // store the captcha word in a session
                $this->session->set_userdata('mycaptcha', $cap['word']);
                $this->load->view('login/login',$data);
            }
        }
        else
        {
            
             $vals = array(
                'img_path'	 => './captcha/',
                'img_url'	 => base_url().'captcha/',
                'img_width'	 => '100',
                'img_height' => 35,
                'word'	=> strtoupper(random_string('alnum', 5)),
                'border' => 0, 
                // 'expiration' => 7200
            );
 
            // create captcha image
            $cap = create_captcha($vals);
 
            // store image html code in a variable
            $data['image'] = $cap['image'];
            $data['title'] =$this->title;
            // store the captcha word in a session
            $this->session->set_userdata('mycaptcha', $cap['word']);
            $this->load->view('login/login',$data);
        }
    }

    function logout()
    {
        $level = $this->session->userdata('level');
        $jam = date("H:i:s");
        $sql = "UPDATE app_users SET status='0', jam_out='$jam' where level='$level'";
        $this->db->query($sql);        
        $this->keluar();
        
    }
    
    function keluar()
    {
        $this->Delete_cache();
        header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header( "Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT" );
        // helper_log("logout","Telah Keluar");
        $this->session->sess_destroy();
        $this->session->unset_userdata(array('level', 'username', 'prodi_id', 'keterangan'));
        redirect(base_url());
    }

    function Delete_cache($uri_string=null)
    {
        $CI =& get_instance();
        $path = $CI->config->item('cache_path');
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;

        $uri =  $CI->config->item('base_url').
                $CI->config->item('index_page').
                $uri_string;
        $cache_path .= hash_verify($uri);
        return unlink($cache_path);
    }
    
    function logoutpmb()
    {
        $this->session->sess_destroy();
        redirect('publik/loginpsb');
    }
}
