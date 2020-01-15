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

    public function cetak_pembayaran($value='')
    {
        if ($value == 'all') {
            $this->load->view('bayar_dinamis/cetak_all');
        } else {
            $this->load->view('bayar_dinamis/cetak');
        }
    }

    public function simpan_pembayaran()
    {
        $this->db->insert('bayar_dinamis', $_POST);
        $this->session->set_flashdata('message', alert_biasa('Pembayaran berhasil','success'));
        redirect('bayar_dinamis/index/'.$_POST['nim'],'refresh');
    }

    function pregistrasi($nim)
    {
        $id_ms      =   get_data('student_mahasiswa','nim',$nim,'mahasiswa_id');
        // $nim = get_data('student_mahasiswa','mahasiswa_id',$id_ms,'nim');

        // get batas registrasi tahun akademik yang aktif
        $thun_admk  = $this->db->get_where('akademik_tahun_akademik',array('status'=>'y'))->row_array();
        //cek tahun akademik skrg
        $thn_akademik = $thun_admk['keterangan'];

        $thun_admk  = $thun_admk['batas_registrasi'];
        if(substr(waktu(),0,10)>$thun_admk)
        {
            $this->session->set_flashdata('message', alert_biasa('Batas Waktu Registrasi sudah lewat','success'));
            redirect('bayar_dinamis/index/'.$nim,'refresh');
        }
        else{
            
        $sql        =   $this->db->query("select nim,semester_aktif from student_mahasiswa where mahasiswa_id='$id_ms'")->row_array();
        $semester   =   cek_semester($nim,$thn_akademik);


        $data       =   array( 'nim'=>$sql['nim'],
                                'tahun_akademik_id'=>  get_tahun_ajaran_aktif('tahun_akademik_id'),
                                'semester'=>$semester,
                                'tanggal_registrasi'=>  waktu());
        $this->db->insert('akademik_registrasi',$data);
        $this->Mcrud->update('student_mahasiswa',array('semester_aktif'=>$semester), 'nim',$sql['nim']);
        // insert krs automatic
        $r=  $this->db->query("select semester_aktif,konsentrasi_id from student_mahasiswa where mahasiswa_id='$id_ms'")->row_array();
        $sms_aktf   =   $r['semester_aktif'];
        $konsentrasi=   $r['konsentrasi_id'];
        // load jadwal kuliah
        $jadwal="   SELECT jk.jadwal_id
                    FROM makul_matakuliah as mm, akademik_jadwal_kuliah as jk
                    WHERE jk.makul_id=mm.makul_id and mm.semester=$sms_aktf";
        $jadwal =  $this->db->query($jadwal)->result();
        if ($semester == 1) {
        
            foreach ($jadwal as $j)
            {
                $this->db->insert('akademik_krs',array('nim'=>$sql['nim'],'jadwal_id'=>$j->jadwal_id,'semester'=>$semester));
                // insert to khs
                $id_krs= $this->db->get_where('akademik_krs',array('nim'=>$sql['nim'],'jadwal_id'=>$j->jadwal_id))->row_array();
                $this->db->insert('akademik_khs',array('krs_id'=>$id_krs['krs_id'],'mutu'=>0,'confirm'=>'2'));
            }
        }
        $this->session->set_flashdata('message', alert_biasa('Registrasi berhasil ','success'));
        redirect('bayar_dinamis/index/'.$nim,'refresh');
        }
        
    }

    function hapus_registrasi($id,$nim)
    {
        $chekid = $this->db->get_where('akademik_registrasi',array('registrasi_id'=>$id));
        if($chekid>0)
        {
            $this->Mcrud->delete('akademik_registrasi',  'registrasi_id',  $id);
        }
        redirect('bayar_dinamis/index/'.$nim,'refresh');
    }

    public function hapus($id,$nim)
    {
        $this->db->where('id_bayar_dinamis', $id);
        $this->db->delete('bayar_dinamis');
        $this->session->set_flashdata('message', alert_biasa('Pembayaran berhasil dihapus','success'));
        redirect('bayar_dinamis/index/'.$nim,'refresh');
    }
    


}