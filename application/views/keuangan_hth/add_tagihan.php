<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

	function editEndDate(nomor_pembayaran) {
		// var nomor_pembayaran = $(this).attr("data-no");
		var waktu_berakhir = $("#waktu_berakhir"+nomor_pembayaran).val();
		$.ajax({
			url: 'Keuangan_hth/edit_tagihan',
			type: 'POST',
			dataType: 'html',
			data: {nomor_pembayaran: nomor_pembayaran, waktu_berakhir: waktu_berakhir},
		})
		.done(function() {
			console.log("success");
			// window.location.reload();
			alert("berhasil di edit !");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}


	function editTotalTagihan(nomor_pembayaran) {
		// alert(nomor_pembayaran);
		// var nomor_pembayaran = $(this).attr("data-no");
		var total_nilai_tagihan = $("#total_nilai_tagihan"+nomor_pembayaran).val();
		// alert(total_nilai_tagihan);
		$.ajax({
			url: 'Keuangan_hth/edit_tot_tagihan',
			type: 'POST',
			dataType: 'html',
			data: {nomor_pembayaran: nomor_pembayaran, total_nilai_tagihan: total_nilai_tagihan},
		})
		.done(function() {
			console.log("success");
			// window.location.reload();
			alert("berhasil di edit !");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}


		
</script>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<form action="">
			<div class="col-md-3">
				<select name="prodi" class="form-control">
					<option value="">Pilih Prodi</option>
					<?php foreach ($this->db->get('akademik_konsentrasi')->result() as $key => $value): ?>
						<option value="<?php echo $value->kode_prodi ?>"><?php echo $value->nama_konsentrasi ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-md-2">
				<input type="text" name="nim" class="form-control" placeholder="Masukkan Nim">
			</div>
			<div class="col-md-2">
				<input type="text" name="tahun" class="form-control" placeholder="EX: 2019" required>
			</div>
			<div class="col-md-1">
				<button class="btn btn-primary">Cari</button>
			</div>

			<div class="col-md-3">
				<a class="btn btn-info" data-toggle="modal" data-target="#modalImport">Import Tagihan</a>

				
			</div>
			</form>
		</div>


		
	</div>
	<div class="col-md-12" style="margin-top: 20px;" >
		<p>
			<a href="<?php echo $this->uri->segment(1)."/cetak_h2h?&prodi=".$_GET['prodi']."&nim=".$_GET['nim']."&tahun=".$_GET['tahun']."&aksi=cetak" ?>" class="btn btn-info">Cetak</a>
		</p>
		<div class="table-responsive">
		<table class="table table-bordered" id="datatable">
			<thead>
			<tr class="alert-success">
				<td>No Pembayaran</td>
				<td>Nim</td>
				<td>Nama</td>
				<td>Prodi</td>
				<td>Kode Periode</td>
				<td>Periode</td>
				<td width="250">Total Tagihan</td>
				<td>Start Date</td>
				<td width="250">End Date</td>
				<td>Status Bayar</td>
			</tr>
			</thead>
			<tbody>
			<?php if ($_GET): 
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
			 ?>
			
			<tr>
				<td><?php echo $rw->nomor_pembayaran; ?></td>
				<td><?php echo $rw->nomor_induk; ?></td>
				<td><?php echo $rw->nama; ?></td>
				<td><?php echo $rw->nama_prodi ?></td>
				<td><?php echo $rw->kode_periode; ?></td>
				<td><?php echo $rw->nama_periode; ?></td>
				<td>
					<div class="input-group mb-3">
						<input type="text" name="total_nilai_tagihan" value="<?php echo $rw->total_nilai_tagihan; ?>" id="total_nilai_tagihan<?php echo $rw->nomor_pembayaran ?>" class="form-control" paria-describedby="basic-addon2">
					  <div class="input-group-append">
					    <button class="btn btn-outline-secondary editTotTagihan" data-no="<?php echo $rw->nomor_pembayaran ?>" onclick="editTotalTagihan(<?php echo $rw->nomor_pembayaran ?>)" type="button"><i class="fa fa-edit"></i></button>
					  </div>
					</div>
				</td>
				<td><?php echo $rw->waktu_berlaku; ?></td>
				<td>
					<div class="input-group mb-3">
						<input type="text" name="waktu_berakhir" value="<?php echo $rw->waktu_berakhir; ?>" id="waktu_berakhir<?php echo $rw->nomor_pembayaran ?>" class="form-control" paria-describedby="basic-addon2">
					  <div class="input-group-append">
					    <button class="btn btn-outline-secondary editEndDate" data-no="<?php echo $rw->nomor_pembayaran ?>" onclick="editEndDate(<?php echo $rw->nomor_pembayaran ?>)" type="button" ><i class="fa fa-edit"></i></button>
					  </div>
					</div>
				</td>
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

			<?php endif ?>
			</tbody>
		</table>
		</div>
	</div>
</div>



<!-- Modal -->
<div id="modalImport" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Tagihan H2H</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('keuangan_hth/import_tagihan') ?>" method="POST" enctype="multipart/form-data">
        	<div class="form-group">
        		
        		<a href="excel/import_tagihan.xlsx"><label>Download Template</label></a>
        	</div>
        	<div class="form-group">
        		<label>Upload Excel</label>
        		<input type="file" name="file_excel" class="form-control">
        	</div>
        	<div class="form-group">
        		<button type="submit" class="btn btn-info">Upload</button>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog">
			    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Form Tagihan</h4>
			        </div>
			        <div class="modal-body">
			          <form action="keuangan_hth/simpan_tagihan/<?php echo $prodi ?>" method="POST">
			          	<div class="form-group">
			          		<label>Nim</label>
			          		<select name="nim" class="form-control select2">
			          			<option value="">Pilih Nim</option>
			          			<?php foreach ($this->db->get('student_mahasiswa')->result() as $n): ?>
			          				<option value="<?php echo $n->nim ?>"><?php echo $n->nim.' - '.$n->nama ?></option>
			          			<?php endforeach ?>
			          		</select>
			          	</div>
			          	<div class="form-group">
			          		<label>Nama</label>
			          		<input type="text" name="nama" readonly="" class="form-control">
			          	</div>
			          	<div class="form-group">
			          		<label>Semester</label>
			          		<input type="text" name="semester" readonly="" class="form-control">
			          	</div>
			          	<div class="form-group">
			          		<label>Periode</label>
			          		<input type="text" name="periode" readonly="" class="form-control">
			          	</div>
			          	<div class="form-group">
			          		<label>Total Tagihan UKT</label>
			          		<input type="text" name="semester" class="form-control">
			          	</div>
			          </form>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>

