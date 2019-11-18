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
        if($id==1)
        {
            return "Admin";
        }
        elseif($id==2)
        {
            return "Jurusan";
        }
        elseif($id==3)
        {
            return 'Dosen';
        }
        elseif($id==5)
        {
            return 'Bendahara';
        }
        elseif($id==6)
        {
            return 'Pimpinan';
        }
        else
        {
            return "Mahasiswa";
        }

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
