<?php 
if ($_GET) {
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Export_Mahasiswa_Feeder.xls");
 ?>

<table border="1">
	<tr>
		<td style="background-color: red">NIM</td>
		<td style="background-color: red">NAMA</td>
		<td style="background-color: red">TEMPAT LAHIR</td>
		<td style="background-color: red">TANGGAL LAHIR</td>
		<td style="background-color: red">JENIS KELAMIN</td>
		<td style="background-color: red">NIK</td>
		<td style="background-color: red">AGAMA</td>
		<td>NISN</td>
		<td>JALUR PENDAFTARAN</td>
		<td>NPWP</td>
		<td style="background-color: red">KEWARGANEGARAAN</td>
		<td style="background-color: red">JENIS PENDAFTARAN</td>
		<td style="background-color: red">TANGGAL MASUK KULIAH</td>
		<td style="background-color: red">MULAI SEMESTER</td>
		<td>JALAN</td>
		<td>RT</td>
		<td>RW</td>
		<td>NAMA DUSUN</td>
		<td style="background-color: red">KELURAHAN</td>
		<td style="background-color: red">KECAMATAN</td>
		<td>KODE POS</td>
		<td>JENIS TINGGAL</td>
		<td>ALAT TRANSPORTASI</td>
		<td>TELP RUMAH</td>
		<td>NO HP</td>
		<td>EMAIL</td>
		<td style="background-color: red">TERIMA KPS</td>
		<td>NO KPS</td>
		<td>NIK AYAH</td>
		<td>NAMA AYAH</td>
		<td>TGL LAHIR AYAH</td>
		<td>PENDIDIKAN AYAH</td>
		<td>PEKERJAAN AYAH</td>
		<td>PENGHASILAN AYAH</td>
		<td>NIK IBU </td>
		<td style="background-color: red">NAMA IBU</td>
		<td>TGL LAHIR IBU</td>
		<td>PENDIDIKAN IBU</td>
		<td>PEKERJAAN IBU</td>
		<td>PENGHASILAN IBU</td>
		<td>NAMA WALI</td>
		<td>TANGGAL LAHIR WALI</td>
		<td>PENDIDIKAN WALI</td>
		<td>PEKERJAAN WALI</td>
		<td>PENGHASILAN WALI</td>
		<td style="background-color: red">KODE PRODI</td>
		<td>JENIS PEMBIAYAAN</td>
		<td>JUMLAH BIAYA MASUK</td>
	</tr>
	<?php 
	$tahun_angkatan = $this->input->get('thn_angkatan');
	$keterangan_mhs = $this->input->get('keterangan_mhs');
	$nim = $this->input->get('nim');

	if ($nim !='') {
		$this->db->where('nim', $nim);
	}
	
	if ($keterangan_mhs != '') {
		$this->db->where('keterangan', $keterangan_mhs);
	}
	$this->db->where('angkatan_id', $tahun_angkatan);
	foreach ($this->db->get('student_mahasiswa')->result() as $rw) {
	 ?>
	<tr>
		<td><?php echo $rw->nim ?></td>
		<td><?php echo $rw->nama ?></td>
		<td><?php echo $rw->tempat_lahir ?></td>
		<td><?php echo $rw->tanggal_lahir ?></td>
		<td><?php echo ($rw->gender == 1) ? 'L' : 'P'; ?></td>
		<td><?php echo $rw->nik ?></td>
		<td><?php echo $rw->agama_id ?></td>
		<td><?php echo $rw->nis ?></td>
		<td></td>
		<td></td>
		<td>ID</td>
		<td><?php echo $rw->jenis_pendaftaran ?></td>
		<td><?php echo substr($rw->date_create, 0,10) ?></td>
		<td><?php echo get_tahun_ajaran_aktif('keterangan'); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo $rw->kelurahan ?></td>
		<td>999999</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>0</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo $rw->nama_ibu ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$rw->konsentrasi_id,'kode_prodi') ?></td>
		<td></td>
		<td></td>
	</tr>
	<?php } ?>
</table>

<?php } ?>