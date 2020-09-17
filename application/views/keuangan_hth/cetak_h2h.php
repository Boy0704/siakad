<?php if ($_GET['aksi'] == 'cetak'): ?>
	<?php
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=Rekap Pembayaran Host2Host.xls");
		?>
	<h2>REKAP PEMBAYARAN HOST TO HOST</h2>
	<table class="table table-bordered" border="1">
			<thead>
			<tr class="alert-success">
				<td>Label</td>
				<td>No Pembayaran</td>
				<td>Nim</td>
				<td>Nama</td>
				<td>Prodi</td>
				<td>Kode Periode</td>
				<td>Periode</td>
				<td>Total Tagihan</td>
				<td>Start Date</td>
				<td>End Date</td>
				<td>Status Bayar</td>
			</tr>
			</thead>
			<tbody>
			<?php 
				$prodi = $this->input->get('prodi');
				$nim = $this->input->get('nim');
				$tahun = $this->input->get('tahun');
				?>
			<!-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Tambah Tagihan</button> -->

			  <!-- Modal -->
			  
			
			<?php 
	        	$keuangan = $this->load->database('keuangan', TRUE);
	        	if ($prodi !== '') {
	        		$keuangan->where('kode_prodi', $prodi);
	        	}
	        	if ($nim !== '') {
	        		$keuangan->where('nomor_induk', $nim);
	        	}
	        	$keuangan->like('waktu_berlaku', $tahun, 'after');
	        	$keuangan->order_by('id', 'desc');
				$sql = $keuangan->get('tagihan');
				foreach ($sql->result() as $rw) {
					if ($rw->kode_prodi == '') {
						// update
						$this->db->select('ak.kode_prodi, ak.nama_konsentrasi');
						$this->db->from('student_mahasiswa sm');
						$this->db->join('akademik_konsentrasi ak', 'sm.konsentrasi_id = ak.konsentrasi_id', 'inner');
						$this->db->where('sm.nim', $rw->nomor_induk);
						$cek = $this->db->get();
						if ($cek->num_rows() > 0) {
							$dt = $cek->row();
							$keuangan->where('id_record_tagihan', $rw->id_record_tagihan);
							$keuangan->update('tagihan', array(
								'kode_prodi' => $dt->kode_prodi,
								'nama_prodi' => $dt->nama_konsentrasi
							));
						}

					}
			 ?>
			
			<tr>
				<td><?php echo $keuangan->get_where('detil_tagihan', array('id_record_tagihan'=>$rw->id_record_tagihan))->row()->label_jenis_biaya; ?></td>
				<td><?php echo $rw->nomor_pembayaran; ?></td>
				<td><?php echo $rw->nomor_induk; ?></td>
				<td><?php echo $rw->nama; ?></td>
				<td><?php echo $rw->nama_prodi ?></td>
				<td><?php echo $rw->kode_periode; ?></td>
				<td><?php echo $rw->nama_periode; ?></td>
				<td><?php echo $rw->total_nilai_tagihan; ?></td>
				<td><?php echo $rw->waktu_berlaku; ?></td>
				<td><?php echo $rw->waktu_berakhir; ?></td>
				<td>
					<!-- <a href="<?php echo base_url() ?>keuangan_hth/edit_tagihan/<?php echo $rw->id_record_tagihan ?>" class="btn btn-sm btn-info">Edit</a> -->
					<?php 
					$cek_bayar = $keuangan->get_where('pembayaran', array('id_record_tagihan'=>$rw->id_record_tagihan));
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
<?php endif ?>