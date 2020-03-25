<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
	function mainmenu(id,level) {
		$.ajax({
			url: '<?php echo base_url() ?>mainmenu/cek_mainmenu/'+id+'/'+level,
			type: 'GET',
			dataType: 'JSON',
			beforeSend: function() {
					swal({ title: "Mohon tunggu!", text: "", type: "info", showConfirmButton: false, allowEscapeKey: false });
				},
		})
		.done(function(a) {
			console.log("success");
			console.log(a.berhasil);
			// window.location.reload();
			swal.close();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}

	function submenu(id,level) {
		$.ajax({
			url: '<?php echo base_url() ?>mainmenu/cek_submenu/'+id+'/'+level,
			type: 'GET',
			dataType: 'JSON',
			beforeSend: function() {
					swal({ title: "Mohon tunggu!", text: "", type: "info", showConfirmButton: false, allowEscapeKey: false });
				},
		})
		.done(function(a) {
			console.log("success");
			console.log(a.berhasil);
			// window.location.reload();
			swal.close();
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
	<div class="col-md-6">
		<div class="panel panel-info">
		  <div class="panel-heading">Level</div>
		  <div class="panel-body">
		  	<div class="form-group">
		  		<form action="">
				<label>Pilih Level</label>
				<select name="level" id="level" class="form-control">
					<option value="">--Pilih Level--</option>
					<?php foreach ($this->db->get('level')->result() as $rw): ?>
						<option value="<?php echo $rw->id_level ?>"><?php echo $rw->level ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-group" style="text-align: right;">
				<button type="submit" class="btn btn-primary">Kirim</button>
				</form>
			</div>
		  </div>
		</div>
				
	</div>
	
</div>
		<?php 
		$level = '';
		if (isset($_GET['level'])) {
			$level = $_GET['level'];

		 ?>
<div class="row">
	<div class="col-md-12">
		
		<div class="panel panel-info">
		  <div class="panel-heading">Role Menu <b><?php echo get_data('level','id_level',$level,'level') ?></b></div>
		  <div class="panel-body">
		  	<?php 
		  	$this->db->where('level', $level);
			$main_menu = $this->db->get_where('mainmenu');
			$checked = '';
			foreach ($main_menu->result() as $rw) {
				if ($rw->level == $level && $rw->aktif =='y') {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				?>
				<input type="checkbox" name="mainmenu" id="mainmenu_<?php echo $rw->id_mainmenu ?>" value="<?php echo $rw->id_mainmenu ?>" onclick="mainmenu(<?php echo $rw->id_mainmenu.','.$level ?>)" <?php echo $checked ?>> <?php echo strtoupper($rw->nama_mainmenu) ?> <br>
				<?php
				//submenu
				$this->db->where('level', $level);
				$submenu = $this->db->get_where('submenu', array('id_mainmenu'=>$rw->id_mainmenu));
				if ($submenu->num_rows() > 0) {
					foreach ($submenu->result() as $menu) {
						if ($menu->level == $level && $menu->aktif =='y') {
							$checked = 'checked';
						} else {
							$checked = '';
						}
						?>
						<div style="margin-left: 30px;">
							<input type="checkbox" name="submenu" id="submenu_<?php echo $menu->id_submenu ?>" value="<?php echo $menu->id_submenu ?>" onclick="submenu(<?php echo $menu->id_submenu.','.$level ?>)" <?php echo $checked ?>> <?php echo strtoupper($menu->nama_submenu) ?>
						</div>
						<?php
					}
				} else {

				}
				
			}
			 ?>
		  </div>
		</div>
				
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		
		<div class="panel panel-info">
		  <div class="panel-heading">Menu <b>Lainnya</b></div>
		  <div class="panel-body">
		  	<?php 
		  	$this->db->where('level !=', $level);
		  	$this->db->group_by('link');
			$main_menu = $this->db->get_where('mainmenu');
			$checked = '';
			foreach ($main_menu->result() as $rw) {
				if ($rw->level == $level && $rw->aktif =='y') {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				?>
				<input type="checkbox" name="mainmenu" id="mainmenu_<?php echo $rw->id_mainmenu ?>" value="<?php echo $rw->id_mainmenu ?>" onclick="mainmenu(<?php echo $rw->id_mainmenu.','.$level ?>)" <?php echo $checked ?>> <?php echo strtoupper($rw->nama_mainmenu) ?> <br>
				<?php
				//submenu
				$this->db->where('level !=', $level);
				$this->db->group_by('link');
				$submenu = $this->db->get_where('submenu', array('id_mainmenu'=>$rw->id_mainmenu));
				if ($submenu->num_rows() > 0) {
					foreach ($submenu->result() as $menu) {
						if ($menu->level == $level && $menu->aktif =='y') {
							$checked = 'checked';
						} else {
							$checked = '';
						}
						?>
						<div style="margin-left: 30px;">
							<input type="checkbox" name="submenu" id="submenu_<?php echo $menu->id_submenu ?>" value="<?php echo $menu->id_submenu ?>" <?php echo $checked ?>> <?php echo strtoupper($menu->nama_submenu) ?>
						</div>
						<?php
					}
				} else {

				}
				
			}
			 ?>
		  </div>
		</div>
		<?php } ?>
		
	</div>
</div>
