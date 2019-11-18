<div id="sidebar-menu" class="main_menu_side hidden-print main_menu ">
  <div class="menu_section">
    <ul class="nav side-menu">
    <?php if ($this->session->userdata('level')==1): ?>
    	<li><a href="<?php echo base_url('login') ?>"><i class="fa fa-home"></i> Home </a></li>
    <?php endif ?>
    <?php
       echo menu_help('nama_mainmenu', 'nama_submenu', 'mainmenu', 'submenu', 'sub_menu', 'icon');
    ?>
    <?php if ($this->session->userdata('level')==4):
      $mhs_id = $this->db->get_where('student_mahasiswa', "nim=".$this->session->userdata('username'))->row()->mahasiswa_id;?>
    	<li><a href="<?php echo base_url('cetak/kartu_mhs/'.$mhs_id); ?>" target="_blank"><i class="fa fa-credit-card"></i> Cetak Kartu Mahasiswa </a></li>
    <?php endif ?>
  </ul>
  </div>
</div>
