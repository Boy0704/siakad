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
				<td>Periode</td>
				<td>Total Tagihan</td>
				<td>Start Date</td>
				<td>End Date</td>
				<td>Aksi</td>
			</tr>
			<?php if ($_GET): 
				$prodi = $this->input->get('prodi');
				?>
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Tambah Tagihan</button>

			  <!-- Modal -->
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
			
			<?php 
	        	$keuangan = $this->load->database('keuangan', TRUE);
				$sql = $keuangan->get_where('tagihan', array('kode_prodi'=>$prodi));
				foreach ($sql->result() as $rw) {
			 ?>
			<tr>
				<td><?php echo $rw->nim; ?></td>
				<td><?php echo $rw->nama; ?></td>
				<td><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$rw->konsentrasi_id,'nama_konsentrasi'); ?></td>
				<td>
					<a href="<?php echo base_url() ?>keuangan_hth/edit_tagihan/<?php echo $rw->id_record_tagihan ?>" class="btn btn-sm btn-info">Edit</a>
				</td>
			</tr>
			<?php } ?>

			<?php endif ?>
		</table>
	</div>
</div>