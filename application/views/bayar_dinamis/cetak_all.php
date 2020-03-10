<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Pembayaran UKT SEMUA MHS.xls");
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Cetak PembayarAN UKT</title>
</head>
<body>
	<center>
		<h2>DAFTAR UANG KULIAH TUNGGAL</h2>
		<h2>STAIN SULTAN ABDURRAHMAN KEPULAUAN RIAU</h2>
	</center>
	

	<table border="1">
		<tr>
			<td>No.</td>
			<td>Nama Mahasiswa</td>
			<td>Nim</td>
			<td>Prodi</td>
			<td>Semester</td>
			<td>UKT/Semester</td>
			<td>Keterangan</td>
			<td>Status Mahasiswa</td>
		</tr>
		<?php 
		$no = 1;
		$this->db->where('status_mhs', 'Aktif');
		foreach ($this->db->get('student_mahasiswa')->result() as $rw) {
		 ?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $rw->nama; ?></td>
			<td><?php echo $rw->nim; ?></td>
			<td><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$rw->konsentrasi_id,'nama_konsentrasi'); ?></td>
			<td><?php echo get_data('bayar_dinamis','nim',$rw->nim,'semester'); ?></td>
			<td><?php echo get_data('bayar_dinamis','nim',$rw->nim,'jumlah_bayar'); ?></td>
			<td>
				<?php 
				$cek = $this->db->get_where('bayar_dinamis', array('nim'=>$rw->nim));
				if ($cek->num_rows() > 0) {
					echo "Lunas";
				} else {
					echo "Belum Lunas";
				}
				 ?>
			</td>
			<td><?php echo $rw->keterangan; ?></td>
		</tr>
	<?php $no++; } ?>
	</table>


</body>
</html>