<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap_PMB.xls");
?>
	<h2>REKAP PESERTA PMB <?php echo $tahun ?></h2>
	<table class="table table-bordered" border="1">
			<thead>
			<tr class="alert-success">
				<td>Nisn</td>
				<td>Nama Lengkap</td>
				<td>No HP</td>
				<td>Kota</td>
				<td>Status Bayar</td>
			</tr>
			</thead>
			<tbody>
			<?php 
			$keuangan = $this->load->database('keuangan', TRUE);
				foreach ($query->result() as $rw) {
			 ?>
			
			<tr>
				<td><?php echo $rw->nisn ?></td>
				<td><?php echo strtoupper($rw->nama) ?></td>
				<td><?php echo strtoupper($rw->kota) ?></td>
				<td><?php echo strtoupper($rw->selular) ?></td>
				<td>
					<?php 
					$keuangan->like('nomor_pembayaran', $rw->nisn, 'after');
					$cek_bayar = $keuangan->get('pembayaran');
					if ($cek_bayar->num_rows() > 0) {
						echo '<span class="label label-success">TERBAYAR</span>';
					} else {
						echo '<span class="label label-danger">BELUM DIBAYAR</span>';
					}
					 ?>
					
				</td>

			</tr>
			<?php } ?>
			</tbody>
		</table>