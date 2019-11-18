 <div class="profile clearfix">
  <div class="profile_pic">
    <?php if ($this->session->userdata('id_users') == '') {?>
      <!-- <img class = img-circle src="<?php echo base_url('images/user.png') ?>" alt="..." class="profile_img"  style="height:80px;width:85px;margin-top: 10px;margin-left: 15px;"> -->
      <img class = img-circle src="<?php echo base_url('images/user.png') ?>" alt="..." class="profile_img"  style="height:80px;width:85px;margin-top: 10px;margin-left: 15px;">
    <?php } else {
      $id_users = $this->session->userdata('id_users');
      $cek_data = $this->db->get_where('app_users',"id_users='$id_users'")->row();
      $foto = $this->M_users->cek_filename($cek_data->foto);
      ?>
      <img class = img-circle src="<?php echo base_url($foto) ?>" alt="..." class="profile_img"  style="height:80px;width:85px;margin-top: 10px;margin-left: 15px;">
    <?php } ?>

  </div>
  <div class="profile_info">
    <span style="margin-left: 15px;">Selamat Datang</span>
       <h2 style="margin-left: 15px;"><?php echo strtoupper($this->session->userdata('username'));?></h2><br>
  </div>

  <!-- <div style="float: left;margin-left: 10px;color: #ccc;">
  	<span>Anda Login Sebagai </span><?php echo strtoupper($this->session->userdata('prodi_id')); ?></small>
  </div> -->
</div>
<!--class = img-circle -->
