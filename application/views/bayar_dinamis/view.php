<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript"><?php echo $this->session->userdata('message') ?></script>

<div class="row">
	<form action="<?php echo base_url() ?>bayar_dinamis/cari" method="POST">
	<div class="col-md-3">
		<input type="text" name="nim" id="nim" class="form-control">
	</div>
	<div class="col-md-3">
		<button id="cari" class="btn btn-primary">CARI</button>
	</div>
	</form>
</div>


<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<tr>
				<td width="100px;">Nim</td>
				<td>
					<span id="nim_hasil">
						<?php echo get_data('student_mahasiswa','nim',$nim,'nim'); ?>
					</span>
				</td>
			</tr>
			<tr>
				<td width="100px;">Nama</td>
				<td>
					<span id="nama">
						<?php echo get_data('student_mahasiswa','nim',$nim,'nama'); ?>
					</span>
				</td>
			</tr>
			<tr>
				<td width="100px;">Prodi</td>
				<td>
					<span id="prodi">
						<?php 
						$konsentrasi_id = get_data('student_mahasiswa','nim',$nim,'konsentrasi_id');
						echo get_data('akademik_konsentrasi','konsentrasi_id',$konsentrasi_id,'nama_konsentrasi');
						 ?>
					</span>
				</td>
			</tr>
		</table>
	</div>

	<form action="<?php echo base_url() ?>bayar_dinamis/simpan_pembayaran" method="POST">
	<div class="col-md-2">
		<select name="id_jenis_bayar_dinamis" class="form-control">
			<?php 
			foreach ($this->db->get('jenis_bayar_dinamis')->result() as $rw) {
			 ?>
			<option value="<?php echo $rw->id_jenis_bayar_dinamis ?>"><?php echo $rw->jenis_bayar_dinamis ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-2">
		<input type="text" name="nim" class="form-control" value="<?php echo $nim ?>" readonly>
	</div>
	<div class="col-md-2">
		<input type="text" name="semester" class="form-control" placeholder="semester">
	</div>
	<div class="col-md-2">
		<input type="number" name="jumlah_bayar" class="form-control" placeholder="jumlah bayar">
	</div>
	<div class="col-md-2">
		<button class="btn btn-info">SIMPAN</button>
	</div>

	</form>
	<br>

	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Jenis Pembayaran</th>
					<th>Jumlah</th>
					<th>Semester</th>
					<th width="100px;">Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$this->db->order_by('semester', 'asc');
				foreach ($this->db->get_where('bayar_dinamis', array('nim'=>$nim))->result() as $d) {
				 ?>
				<tr>
					<td><?php echo get_data('jenis_bayar_dinamis','id_jenis_bayar_dinamis',$d->id_jenis_bayar_dinamis,'jenis_bayar_dinamis') ?></td>
					<td><?php echo number_format($d->jumlah_bayar) ?></td>
					<td><?php echo $d->semester ?></td>
					<td>
						<a onclick="javasciprt: return confirm('Yakin akan menghapus pembayaran ini ?')" href="<?php echo base_url() ?>bayar_dinamis/hapus/<?php echo $d->id_bayar_dinamis.'/'.$nim ?>" class="btn btn-danger btn-sm">HAPUS</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

</div>