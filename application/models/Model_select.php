<?php

Class Model_select extends CI_Model
{

function __construct(){

parent::__construct();

}


function provinsi(){


$this->db->order_by('id','ASC');
$provinces= $this->db->get('tahun_angkatan');


return $provinces->result_array();


}


function kabupaten($provId){

// $kabupaten="<option value='0'>--pilih--</pilih>";

$this->db->order_by('name','asc');
$kab= $this->db->get_where('semester',array('angkatan_id'=>$provId));

foreach ($kab->result_array() as $data ){
$kabupaten.= "<option value='$data[id]'>$data[name]</option>";
}

return $kabupaten;

}

function kecamatan($kabId){
// $kecamatan="<option value='0'>--pilih--</pilih>";

$this->db->order_by('name','ASC');
$kec= $this->db->get_where('districts',array('regency_id'=>$kabId));

foreach ($kec->result_array() as $data ){
$kecamatan.= "<option value='$data[id]'>$data[name]</option>";
}

return $kecamatan;
}

function kelurahan($kecId){
// $kelurahan="<option value='0'>--pilih--</pilih>";

$this->db->order_by('name','ASC');
$kel= $this->db->get_where('villages',array('district_id'=>$kecId));

foreach ($kel->result_array() as $data ){
$kelurahan.= "<option value='$data[id]'>$data[name]</option>";
}

return $kelurahan;
}


}