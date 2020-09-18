<?php
class mainmenu extends MY_Controller{

    var $folder =   "mainmenu";
    var $tables =   "mainmenu";
    var $pk     =   "id_mainmenu";
    var $title  =   "Main Menu";

    function __construct() {
        parent::__construct();
    }

    function index()
    {
    $data['record'] = $this->db->get('mainmenu')->result();
    $data['title']=  $this->title;
	$this->template->load('template', $this->folder.'/view',$data);
    }


    function level($id)
    {
        // if($id==1)
        // {
        //     return "Admin";
        // }
        // elseif($id==2)
        // {
        //     return "Jurusan";
        // }
        // elseif($id==3)
        // {
        //     return 'Dosen';
        // }
        // elseif($id==5)
        // {
        //     return 'Bendahara';
        // }
        // elseif($id==6)
        // {
        //     return 'Pimpinan';
        // }
        // else
        // {
        //     return "Mahasiswa";
        // }
         $l = get_data('level','id_level',$id,'level');
        return $l;

    }

    public function cek_mainmenu($id,$level)
    {
        $cek_mainmenu = $this->db->get_where('mainmenu',array('id_mainmenu'=>$id,'level'=>$level));
        $dt_mainmenu = $this->db->get_where('mainmenu',array('id_mainmenu'=>$id))->row();
        if ($cek_mainmenu->num_rows() > 0) {
            $mainmenu = $cek_mainmenu->row();
            if ($mainmenu->aktif == 'y') {
                $this->db->where('id_mainmenu', $id);
                $this->db->update('mainmenu', array('aktif'=>'t'));
            } else {
                $this->db->where('id_mainmenu', $id);
                $this->db->update('mainmenu', array('aktif'=>'y'));
            }
        } else {
            //insert
            $this->db->insert('mainmenu', array(
                'nama_mainmenu'=>$dt_mainmenu->nama_mainmenu,
                'icon'=>$dt_mainmenu->icon,
                'aktif'=>$dt_mainmenu->aktif,
                'link'=>$dt_mainmenu->link,
                'level'=>$level,
            ));
        }
        echo json_encode(array('berhasil'=>1));
    }

    public function cek_submenu($id,$level)
    {
        $cek_submenu = $this->db->get_where('submenu',array('id_submenu'=>$id,'level'=>$level));
        $dt_submenu = $this->db->get_where('submenu',array('id_submenu'=>$id))->row();
        if ($cek_submenu->num_rows() > 0) {
            $submenu = $cek_submenu->row();
            if ($submenu->aktif == 'y') {
                $this->db->where('id_submenu', $id);
                $this->db->update('submenu', array('aktif'=>'t'));
            } else {
                $this->db->where('id_submenu', $id);
                $this->db->update('submenu', array('aktif'=>'y'));
            }
        } else {
            //insert
            $this->db->insert('submenu', array(
                'nama_submenu'=>$dt_submenu->nama_submenu,
                'icon'=>$dt_submenu->icon,
                'aktif'=>$dt_submenu->aktif,
                'link'=>$dt_submenu->link,
                'level'=>$level,
            ));
        }
        echo json_encode(array('berhasil'=>1));
    }

    public function menu_role()
    {
        $data['title']=  $this->title;
        $this->template->load('template', 'setting_menu/menu_role',$data);
    }

    function post()
    {
        if(isset($_POST['submit']))
        {
            $nama   =   $this->input->post('nama');
            $link   =   $this->input->post('link');
            $icon   =   $this->input->post('icon');
            $level  =   $this->input->post('level');
            $data   =   array('nama_mainmenu'=>$nama,'icon'=>$icon,'link'=>$link,'aktif'=>'y','level'=>$level);
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
            $nama   =   $this->input->post('nama');
            $link   =   $this->input->post('link');
            $icon   =   $this->input->post('icon');
            $level  =   $this->input->post('level');
            $id     = $this->input->post('id');
            $data   =   array('nama_mainmenu'=>$nama,'icon'=>$icon,'link'=>$link,'level'=>$level);
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            redirect($this->uri->segment(1));
        }
        else
        {
            $id          =  $this->uri->segment(3);
            $data['title']=  $this->title;
            $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
            $this->template->load('template', $this->folder.'/edit',$data);
        }
    }
    function delete()
    {
        $id     =  $this->uri->segment(3);
        $chekid = $this->db->get_where($this->tables,array($this->pk=>$id));
         if($chekid->num_rows()>0)
        {
            $this->Mcrud->delete($this->tables,  $this->pk,  $this->uri->segment(3));
        }
        redirect($this->uri->segment(1));
    }

    function status()
    {
        $id     =  $this->uri->segment(4);
        $status =  $this->uri->segment(3);
        $this->Mcrud->update($this->tables,array('aktif'=>$status), $this->pk,$id);
        redirect($this->uri->segment(1));
    }
}
