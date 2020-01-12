<?php
/**
 * Description of mcrud
 * class ini digunakan untuk melakukan manipulasi  data sederhana
 * dengan parameter yang dikirim dari controller.
 * @author nuris akbar
 */
class Mcrud extends CI_Model{

   public function __construct() { parent::__construct(); }
    // Menampilkan data dari sebuah tabel dengan pagination.
    public function getList($tables,$limit,$page,$by,$sort){
        $this->db->order_by($by,$sort);
        $this->db->limit($limit,$page);
        return $this->db->get($tables);
    }

    // menampilkan semua data dari sebuah tabel.
    public function getAll($tables,$nama=''){
      if ($nama=='tahun_angkatan') {
        $this->db->order_by("keterangan",'DESC');
      }
        return $this->db->get($tables);
    }

    // menghitun jumlah record dari sebuah tabel.
    public function countAll($tables){
        return $this->db->get($tables)->num_rows();
    }

    // menghitun jumlah record dari sebuah query.
    public function countQuery($query){
        return $this->db->get($query)->num_rows();
    }

    //enampilkan satu record brdasarkan parameter.
    public function kondisi($tables,$where)
    {
        $this->db->where($where);
        return $this->db->get($tables);
    }
    //menampilkan satu record brdasarkan parameter.
    public  function getByID($tables,$pk,$id){
        $this->db->where($pk,$id);
        return $this->db->get($tables);
    }

    // Menampilkan data dari sebuah query dengan pagination.
    public function queryList($query,$limit,$page){

        return $this->db->query($query." limit ".$page.",".$limit."");
    }

    public function queryBiasa($query,$by,$sort){
       // $this->db->order_by($by,$sort);
        return $this->db->query($query);
    }
    // memasukan data ke database.
    public function insert($tables,$data){
        $this->db->insert($tables,$data);
    }

    // update data kedalalam sebuah tabel
    public function update($tables,$data,$pk,$id){
        $this->db->where($pk,$id);
        $this->db->update($tables,$data);
    }

    // menghapus data dari sebuah tabel
    public function delete($tables,$pk,$id){
        $this->db->where($pk,$id);
        $this->db->delete($tables);
    }

    function login($username,$password)
    {
       return $this->db->get_where('users',array('username'=>$username,'password'=>$password));
    }

    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename,$lokasi_file,$type_file){
        $this->load->library('upload'); // Load librari upload
        
        $config['upload_path'] = $lokasi_file;
        $config['allowed_types'] = $type_file;
        $config['max_size'] = '10000';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;
    
        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

}

?>
