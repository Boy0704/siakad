<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>
	<div class="container">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label>Import Matakuliah</label>
				<input type="file" name="file" class="form-control">
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="preview" value="Preview" >
				<input type="hidden" name="filename" value="<?php echo $filename ?>" id="filename">
				<a id="import" class="btn btn-info">IMPORT DATA</a>
			</div>
		</form>

		<div id="preview">
			<?php 
			if (isset($_POST['preview'])) {
				if(isset($upload_error)){ // Jika proses upload gagal
					echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
					die; // stop skrip
				}

				?>

				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Kode Mk</th>
								<th>Nama MK</th>
								<th>SKS</th>
								<th>Semester</th>
								<th>Kode Prodi</th>
								<th>Kelompok MK</th>
								<th> - </th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$style = '';
						$no= 1;
						$kosong = 0;
						// log_r($sheet);
						//skip untuk header
						unset($sheet[1]);
						foreach ($sheet as $rw) {

						$cek_mk = $this->db->get_where('makul_matakuliah', array('kode_makul'=>$rw['A'],'konsentrasi_id'=>get_data('akademik_konsentrasi','kode_prodi',$rw['E'],'konsentrasi_id')));
						if ($cek_mk->num_rows() == 0) {
							$style = 'style="background-color: red;"';
							$kosong++; 
						}else {
							$style = '';
						}
						 ?>
						
							<tr>
								<td><?php echo $no; ?></td>
								<td <?php echo $style; ?> ><?php echo $rw['A']; ?></td>
								<td><?php echo $rw['B']; ?></td>
								<td><?php echo $rw['C']; ?></td>
								<td><?php echo $rw['D']; ?></td>
								<td><?php echo $rw['E']; ?></td>
								<td><?php echo $rw['F']; ?></td>
								<td><?php 
								// $d = $cek_mk->row();
								echo get_data('akademik_konsentrasi','kode_prodi',$rw['E'],'konsentrasi_id');
								 ?></td>
							</tr>

						<?php $no++; } ?>
							<tr>
								<td>Jumlah Kosong</td>
								<td colspan="7"><?php echo $kosong ?></td>
							</tr>
						</tbody>
					</table>
				</div>


				<?php

			}

			 ?>
		</div>

		


	</div>


<script type="text/javascript">
	$(document).ready(function() {
		
		$('#import').click(function(event) {
						
			var filename = $('#filename').val();
			$.ajax({
				url: '<?php echo base_url() ?>manual/aksi_import_mk',
				type: 'POST',
				dataType: 'html',
				data: {filename: filename},
				beforeSend: function() {
					swal("Silahkan tunggu!", {
					  button: false,
					  icon: 'info'
					});
				},
			})
			.done(function(data) {
				console.log("success");
				swal("Berhasil Import Data Matakuliah!", "You clicked the button!", "success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});



	});
</script>
</body>
</html>

