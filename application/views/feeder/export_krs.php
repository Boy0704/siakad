<?php 
if ($_GET) {
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Export_Krs_Feeder.xls");
 ?>

<table border="1">
	<tr>
		<td style="background-color: red">NIM</td>
		<td>NAMA</td>
		<td style="background-color: red">SEMESTER</td>
		<td style="background-color: red">KODE MK</td>
		<td>MATA KULIAH</td>
		<td style="background-color: red">KELAS</td>
		<td style="background-color: red">KODE PRODI</td>
	</tr>
	<?php 
	$tahun_akademik = $this->input->get('thn_akademik');
	$nim = $this->input->get('nim');

	if ($nim !='') {
		$this->db->where('nim', $nim);
	}
	$this->db->where('tahun_akademik_id', $tahun_akademik);
	$this->db->order_by('nim', 'desc');
	foreach ($this->db->get('v_krs')->result() as $rw) {
	 ?>
	<tr>
		<td><?php echo $rw->nim ?></td>
		<td><?php echo get_data('student_mahasiswa','nim',$rw->nim,'nama') ?></td>
		<td><?php echo get_data('akademik_tahun_akademik','tahun_akademik_id',$rw->tahun_akademik_id,'keterangan') ?></td>
		<td><?php echo $rw->kode_makul; ?></td>
		<td><?php echo $rw->nama_makul ?></td>
		<td><?php echo $rw->ruangan_id ?></td>
		<td><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$rw->konsentrasi_id,'kode_prodi') ?></td>
		
	</tr>
	<?php } ?>
</table>

<?php } ?>