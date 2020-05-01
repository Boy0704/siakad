<div class="row">
	<div class="col-md-12">
		<div class="row">
			<form action="">
			<div class="col-md-3">
				<input type="text" name="nim" class="form-control" placeholder="Masukkan Nim">
			</div>
			<div class="col-md-3">
				<button class="btn btn-primary">Cari</button>
			</div>
			</form>
		</div>
		
	</div>
	<div class="col-md-12" style="margin-top: 20px;">
		<table class="table table-bordered">
			<tr class="alert-success">
				<td>Nim</td>
				<td>Nama</td>
				<td>Prodi</td>
				<td>Aksi</td>
			</tr>
			<?php 
			if ($_GET) {
				$nim = $this->input->get('nim');
				$sql = $this->db->get_where('student_mahasiswa', array('nim'=>$nim));
				if ($sql->num_rows() == 0) {
					// log_r('disni');
					?>
					<script type="text/javascript">
						alert('Nim tidak di temukan !');
						window.location='<?php echo base_url() ?>mahasiswa/cari_mahasiswa'
					</script>
					<?php

				}
				$data = $sql->row();
			 ?>
			<tr>
				<td><?php echo $data->nim; ?></td>
				<td><?php echo $data->nama; ?></td>
				<td><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$data->konsentrasi_id,'nama_konsentrasi'); ?></td>
				<td>
					<a href="<?php echo base_url() ?>mahasiswa/edit_mhs/<?php echo $data->mahasiswa_id ?>" class="btn btn-sm btn-info">Edit</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>