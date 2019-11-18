<?php
class jenisbayar extends MY_Controller{
    
    var $folder =   "jenisbayar";
    var $tables =   "keuangan_jenis_bayar";
    var $pk     =   "jenis_bayar_id";
    var $title  =   "Jenis Pembayaran";
    function __construct() {
        parent::__construct();
    }
    
    function index()
    {
        $data['record'] = $this->db->get($this->tables)->result();
        $data['title']  = $this->title;
    	$this->template->load('template', $this->folder.'/view',$data);
    }
    function post()
    {
        if(isset($_POST['submit']))
        {
            $jenis  =   $this->input->post('jenis');
            $this->db->insert($this->tables,array('keterangan'=>$jenis));
            $jns_byr=   $this->db->get_where('keuangan_jenis_bayar',array('keterangan'=>$jenis))->row_array();
            $thn_ajr= getField('student_angkatan', 'angkatan_id', 'aktif', 'y');
            // foreach konsentrasi
            $konsen =   $this->db->get('akademik_konsentrasi')->result();
            foreach ($konsen as $k)
            {
                $data   =   array(  'angkatan_id'=>$thn_ajr,
                                    'jumlah'=>0,
                                    'jenis_bayar_id'=>$jns_byr['jenis_bayar_id'],
                                    'konsentrasi_id'=>$k->konsentrasi_id);
                $this->db->insert('keuangan_biaya_kuliah',$data);
            }
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
            $jenis  = $this->input->post('jenis');
            $id     = $this->input->post('id');
            $data   = array('keterangan'=>$jenis);
            $this->Mcrud->update($this->tables,$data, $this->pk,$id);
            redirect($this->uri->segment(1));
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
        $id     =  $this->uri->segment(3);
        $chekid = $this->db->get_where($this->tables,array($this->pk=>$id));
        if($chekid>0)
        {
            $this->Mcrud->delete($this->tables,  $this->pk,  $this->uri->segment(3));
        }
        redirect($this->uri->segment(1));
    }
}