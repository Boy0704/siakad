<?php
class gedung extends MY_Controller{
    
    var $folder =   "gedung";
    var $tables =   "app_gedung";
    var $pk     =   "gedung_id";
    var $title  =   "Daftar Gedung";
    
    function __construct() {
        parent::__construct();
    }
    
    function index()
    {
        $data['title']  = $this->title;
        $data['desc']    =   "";
        $data['pk']=  $this->pk;
        $data['record'] =  $this->db->get($this->tables)->result();
	$this->template->load('template', $this->folder.'/view',$data);
    }
    function post()
    {
        if(isset($_POST['submit']))
        {
            $nama   =   $this->input->post('nama');
            $data   =   array('nama_gedung'=>$nama);
            $this->db->insert($this->tables,$data);
            $this->session->set_flashdata('pesan', "<div class='alert alert-success'>Data $nama Berhasil Disimpan</div>");
            redirect($this->uri->segment(1));
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
            $id     = $this->input->post('id');
            $nama   =   $this->input->post('nama');
            $data   =   array('nama_gedung'=>$nama);
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            $this->session->set_flashdata('pesan', "<div class='alert alert-success'>Data $nama Berhasil Diedit</div>");
            redirect($this->uri->segment(1));
        }
        else
        {
            $data['title']  = $this->title;
            $data['desc']    =   "";
            $id          =  $this->uri->segment(3);
            $data['r']   =  $this->Mcrud->getByID($this->tables,  $this->pk,$id)->row_array();
            $this->template->load('template', $this->folder.'/edit',$data);
        }
    }
    function delete()
    {
        $id = $_GET['id'];
        $this->Mcrud->delete($this->tables, $this->pk, $id);
    }
}