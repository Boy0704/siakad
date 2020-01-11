<?php
class Bayar_dinamis extends MY_Controller{
    
    var $folder =   "bayar_dinamis";
    var $title  =   "Pembayaran Dinamis";
    function __construct() {
        parent::__construct();
    }
    
    function index($nim=null)
    {
        $data['title']  = $this->title;
        $data['nim']  = $nim;
    	$this->template->load('template', $this->folder.'/view',$data);
    }

    public function cari()
    {
        $nim = $this->input->post('nim');
        $cari = $this->db->get_where('student_mahasiswa', array('nim'=>$nim));
        if ($cari->num_rows() == 0) {
            $this->session->set_flashdata('message', alert_biasa('Nim tidak ditemukan','danger'));
            redirect('bayar_dinamis/index/'.$nim,'refresh');
        } else {
            redirect('bayar_dinamis/index/'.$nim,'refresh');
        }
    }

    public function simpan_pembayaran()
    {
        $this->db->insert('bayar_dinamis', $_POST);
        $this->session->set_flashdata('message', alert_biasa('Pembayaran berhasil','success'));
        redirect('bayar_dinamis/index/'.$_POST['nim'],'refresh');
    }

    public function hapus($id,$nim)
    {
        $this->db->where('id_bayar_dinamis', $id);
        $this->db->delete('bayar_dinamis');
        $this->session->set_flashdata('message', alert_biasa('Pembayaran berhasil dihapus','success'));
        redirect('bayar_dinamis/index/'.$nim,'refresh');
    }
    


}