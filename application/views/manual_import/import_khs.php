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
				<label>Import KHS</label>
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
								<th>NIM</th>
								<th>NILAI</th>
								<th>SEMESTER</th>
								<th>GRADE</th>
								<th>MUTU</th>
								<th>KODE MK</th>
								<th>DOSEN PENGAMPU</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$style_kdmk="";
						$style_nim="";
						$style_kddosen="";
						$no= 1;
						// log_r($sheet);
						//skip untuk header
						unset($sheet[1]);
						foreach ($sheet as $rw) {
						//cek kode MK apakah sudah ada di jadwal kuliah
						$makul_id = get_data('makul_matakuliah','kode_makul',$rw['F'],'makul_id');
						$cek_jadwal_mk = $this->db->get_where('akademik_jadwal_kuliah', array('makul_id'=>$makul_id));
						if ($cek_jadwal_mk->num_rows() == 0) {
							$style_kdmk = 'style="background-color: red;"';
						}

						//cek nim
						$cek_nim = $this->db->get_where('student_mahasiswa', array('nim'=>$rw['A']));
						if ($cek_nim->num_rows() == 0) {
							$style_nim = 'style="background-color: red;"';
						}

						//cek nidn dosen
						$cek_nidn = $this->db->get_where('app_dosen', array('nidn'=>$rw['G']));
						if ($cek_nidn->num_rows() == 0) {
							$style_kddosen = 'style="background-color: red;"';
						}

						 ?>
						
							<tr>
								<td><?php echo $no; ?></td>
								<td <?php echo $style_nim ?> ><?php echo $rw['A']; ?></td>
								<td><?php echo $rw['B']; ?></td>
								<td><?php echo $rw['C']; ?></td>
								<td><?php echo $rw['D']; ?></td>
								<td><?php echo $rw['E']; ?></td>
								<td <?php echo $style_kdmk ?> ><?php echo $rw['F']; ?></td>
								<td <?php echo $style_kddosen ?> ><?php echo $rw['G']; ?></td>
							</tr>

						<?php $no++; } ?>
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
				url: '<?php echo base_url() ?>manual/aksi_import_khs',
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
				swal("Berhasil Import Data KHS!", "You clicked the button!", "success");
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

