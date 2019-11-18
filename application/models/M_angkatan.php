<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_angkatan extends CI_Model {

	var $table  =   "tahun_angkatan";

	public function getAllangkatan()
	{
		$query = $this->db->where(['angkatan_id'=>'1'])
							  ->get($this->table);
			if ($query->num_rows() > 0) {
				return $query->row()->angkatan_id;
			}
	}

	function getAngkatan()
	{
		$this->db->order_by('name_angkatan','ASC');
		$angkatan= $this->db->get('tahun_angkatan');
		return $angkatan->result();

	}
	public function cetakkelas($kelas_id)
	{
	
	echo anchor('laporan/cetakJadwalPerkelas/'.$kelas_id, ' Cetak Jadwal Kelas',['class'=>'fa fa-print btn-lg btn btn-default','target'=>'new']);

	}
	
	public function m_cetakkelas($kelas_id)
	{
		$sql="SELECT a.id_jadwal,d.nama_hari, a.jam_mulai, a.jam_selesai, kelas.nama_kelas, b.nama_matkul, c.nama,e.name_angkatan 
			FROM jadwal_kuliah a
			JOIN matkul b ON a.matkul_id = b.matkul_id
			JOIN dosen c ON a.dosen_id = c.dosen_id
			JOIN hari d ON a.hari_id = d.hari_id
			JOIN tahun_angkatan e On a.angkatan_id = e.angkatan_id
			INNER JOIN kelas ON a.kelas_id = kelas.kelas_id WHERE a.kelas_id = $kelas_id ORDER BY nama_hari DESC";
        $query = $this->db->query($sql);
        return $query->result();
	}
	
	
	function jadwal_select($kelas_id)
	{
		
	 ?>
	  <table id="datatable" class="table table-bordered table-hover"> 
	  <thead>
                        <tr>
                          <th>No</th>
                          <th>Hari</th>
                          <th>Waktu</th>
                          <th>Kelas</th>
                          <th>Matakuliah</th>
                          <th>Dosen</th>
                          <?php if ($this->session->userdata('user_role_id') == 'admin') {
                                      ?>
                          <th>Opsi</th>
                          <?php } ?>
                        </tr>
       </thead>
      <?php
      		$no = 1;
      		// $kelas_id = 0;
    		$sql="SELECT jadwal_kuliah.id_jadwal,hari.nama_hari, jadwal_kuliah.jam_mulai, jadwal_kuliah.jam_selesai, kelas.nama_kelas, matkul.nama_matkul, dosen.nama
					FROM jadwal_kuliah
					JOIN matkul ON jadwal_kuliah.matkul_id = matkul.matkul_id
					JOIN dosen ON jadwal_kuliah.dosen_id = dosen.dosen_id
					JOIN hari ON jadwal_kuliah.hari_id = hari.hari_id
					iNNER JOIN kelas ON jadwal_kuliah.kelas_id = kelas.kelas_id WHERE jadwal_kuliah.kelas_id = $kelas_id ORDER BY nama_hari DESC";
        $data1 =  $this->db->query($sql)->result();
      if (!empty($data1)) {
			foreach ($data1 as $row ){ ?>
				
				<tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo strtoupper($row->nama_hari) ?></td>
                    <td><?php echo strtoupper($row->jam_mulai).' - '.($row->jam_selesai);?></td>
                    <td><?php echo strtoupper($row->nama_kelas); ?></td>
                    <td><?php echo strtoupper($row->nama_matkul) ?></td>
                    <td colspan=""><?php echo strtoupper($row->nama) ?></td>
                    <?php if ($this->session->userdata('user_role_id') == 'admin') { ?>
                    <td><center>
                        <a class="btn btn-sm btn-primary" data-placement="bottom" data-toggle="tooltip" title="Edit JadwalKuliah" href="<?php echo base_url("JadwalKuliah/Editjadwal/{$row->id_jadwal}") ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        </a>

                        <a onclick="return confirm ('Yakin Jadwal kuliah <?php echo $row->nama_matkul;?> Ingin Di Hapus.?');" class="btn btn-sm btn-danger tooltips" data-placement="bottom" data-toggle="tooltip" title="Hapus JadwalKuliah" href="<?php echo base_url('jadwalKuliah/C_deleteJadwal/'.$row->id_jadwal) ?>"><span class="glyphicon glyphicon-trash"></a>
                        </center></td>
                    <?php } ?>

                </tr>
        	<?php
								
		}

	}
	else
    {
      	echo "<td colspan='7'>Data kosong</td>";
    }

	
	echo"</table>";
	

	}

	function kelas($angkatan_id){


	$this->db->order_by('nama_kelas','asc');
	$sem= $this->db->get_where('kelas',array('angkatan_id'=>$angkatan_id));
	echo "<option value=''>Pilih Kelas</option>";
	foreach ($sem->result_array() as $data ){
		if ($data){
			$kelas .=   "<option value=".$data['kelas_id'].">".strtoupper($data['nama_kelas'])."</option>";
		}
	
	}
	return $kelas;

	}

	function dosen($dosen_id){


	$this->db->order_by('nama_matkul','asc');
	$matkul= $this->db->get_where('matkul',array('dosen_id'=>$dosen_id));
	
	foreach ($matkul->result_array() as $data ){
		if ($data){
			$tampil .=   "<option value=".$data['matkul_id'].">".strtoupper($data['nama_matkul'])."</option>";
		}
	
	}
	return $tampil;

	}

	function semester($angkatan_id)
	{

	// $kabupaten="<option value='0'>--pilih--</pilih>";

		$this->db->order_by('name','asc');
		$sem= $this->db->get_where('semester',array('angkatan_id'=>$angkatan_id));

		foreach ($sem->result_array() as $data )
		{
			$semester.= "<option value=".$data['semester_id'].">".$data['name']."</option>";
		}
		return $semester;

	}

	public function dataAngkatan()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('name_angkatan', 'ASC');
		$query = $this->db->get();
		return $query;
	}
	public function addAngkatan($data)
	{
		$this->db->insert($this->table, $data);
		return true;
	}

	public function deleteAngkatan($id)
	{
		$this->db->where('angkatan_id', $id)
				 ->delete($this->table);
		return true;
	}

}

/* End of file m_angkatan.php */
/* Location: ./application/models/m_angkatan.php */