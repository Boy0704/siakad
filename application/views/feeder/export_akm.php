<?php 
if ($_GET) {
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Export_akm_Feeder.xls");
 ?>

<table border="1">
	<tr>
		<td style="background-color: red">NIM</td>
		<td>NAMA</td>
		<td style="background-color: red">SEMESTER</td>
		<td style="background-color: red">SKS</td>
		<td style="background-color: red">IP SEMESTER</td>
		<td style="background-color: red">SKS KUMULATIF</td>
		<td style="background-color: red">IP KUMULATIF</td>
		<td style="background-color: red">STATUS</td>
		<td style="background-color: red">KODE PRODI</td>
		<td>BIAYA MATAKULIAH</td>
		
	</tr>
	<?php 
	$tahun_akademik = $this->input->get('thn_akademik');
	$nim = $this->input->get('nim');

	if ($nim !='') {
		$this->db->where('nim', $nim);
	}
	$this->db->where('tahun_akademik_id', $tahun_akademik);
	$this->db->group_by('nim');
	$this->db->order_by('nim', 'desc');
	foreach ($this->db->get('v_khs')->result() as $rw) {
	 ?>
	<tr>
		<td><?php echo $rw->nim ?></td>
		<td><?php echo get_data('student_mahasiswa','nim',$rw->nim,'nama') ?></td>
		<td><?php echo get_data('akademik_tahun_akademik','tahun_akademik_id',$rw->tahun_akademik_id,'keterangan') ?></td>
		<td><?php echo akm_sks($rw->nim,$rw->tahun_akademik_id) ?></td>
		<td><?php echo floatval(akm_ip($rw->nim,$rw->tahun_akademik_id)) ?></td>
		<td><?php echo all_sks($rw->nim) ?></td>
		<td><?php echo floatval(ipk($rw->nim)) ?></td>
		<td><?php 
			$status = get_data('student_mahasiswa','nim',$rw->nim,'keterangan');
			if ($status == 'mahasiswa aktif' or $status == 'mahasiswa baru' ) {
				echo  'A';
			} elseif ($status == 'cuti resmi' or $status='cuti tanpa keterangan') {
				echo 'C';
			} elseif($status == 'meninggal dunia' or $status == 'drop out' or $status == 'mengundurkan diri' or $status == 'mutasi keluar perguruan tinggi') {
			} else {
				echo '';
			} 


			 ?></td>
		<td><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$rw->konsentrasi_id,'kode_prodi') ?></td>
		<td></td>
		
	</tr>
	<?php } ?>
</table>

<?php } ?>