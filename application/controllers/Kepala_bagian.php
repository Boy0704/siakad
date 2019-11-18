<?php
class Kepala_bagian extends MY_Controller{

    var $folder =   "kepala_bagian";
    var $tables =   "app_kepala_bagian";
    var $pk     =   "kepala_bagian_id";
    var $title  =   "Kepala Bagian";

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('level')!=1) {
            redirect('');
        }
    }

    function index()
    {
                      $this->db->order_by('nama_kepala_bagian','ASC');
    $data['record'] = $this->db->get($this->tables)->result();
    $data['title']  = $this->title;
	   $this->template->load('template', $this->folder.'/view',$data);
    }

    function post()
    {
        if(isset($_POST['submit']))
        {
          date_default_timezone_set('Asia/Jakarta');
					$tgl = date('Y-m-d H:i:s');
            $nama     = $this->input->post('nama_kepala_bagian');
            $dosen_id = $this->input->post('dosen_id');
            if ($this->db->get_where($this->tables, array('nama_kepala_bagian'=>$nama))->num_rows()!=0) {
              $this->session->set_flashdata('message', '<div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <strong><i class="fa fa-close"></i> Gagal!</strong> Nama Kepala Bagian <b>'.$nama.'</b> sudah ada.
                      </div>');
              redirect($this->uri->segment(1)."/post");
            }
            $data   =   array('nama_kepala_bagian'=>$nama,'dosen_id'=>$dosen_id,'tgl_kepala_bagian'=>$tgl);
            $this->db->insert($this->tables,$data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><i class="fa fa-check"></i> Sukses!</strong> Data berhasil ditambah.
                    </div>');
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
            $nama     = $this->input->post('nama_kepala_bagian');
            $dosen_id = $this->input->post('dosen_id');
            $id       = $this->input->post('id');
            $nama_old = $this->db->get_where($this->tables, array('kepala_bagian_id'=>$id))->row()->nama_kepala_bagian;
            if ($this->db->get_where($this->tables, array('nama_kepala_bagian'=>$nama,'nama_kepala_bagian!='=>$nama_old))->num_rows()!=0) {
              $this->session->set_flashdata('message', '<div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <strong><i class="fa fa-close"></i> Gagal!</strong> Nama Kepala Bagian <b>'.$nama.'</b> sudah ada.
                      </div>');
              redirect($this->uri->segment(1)."/edit/$id");
            }
            $data   =   array('nama_kepala_bagian'=>$nama,'dosen_id'=>$dosen_id);
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            $this->session->set_flashdata('message', '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><i class="fa fa-check"></i> Sukses!</strong> Data berhasil ditambah.
                    </div>');
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

}
