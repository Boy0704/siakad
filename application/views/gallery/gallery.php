  <!-- template header link bootstrap dan javascript -->
  <?php require_once('template/header/header.php') ?>
    
            <!-- /menu profile quick info -->

<?php require_once('template/menu/menu_left.php') ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
<?php require_once('template/menu/menu_left_footer.php') ?>

        <!-- top navigation -->
<?php require_once('template/menu/menu_header.php') ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row"> 
            <div class="push">
                <ol class="breadcrumb">
                    <li><i class='fa fa-home'></i> <a href="javascript:void(0)">Home</a></li>
                    <li><i class='fa fa-image'></i> <?php echo anchor($this->uri->segment(1),$title);?></li>
                    <li class="active"><i class='fa fa-table'></i> Data</li>
                </ol>
            </div>
            </div>
      <!-- page content -->
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Foto Mahasiswa<small> gallery design </small></h2>
                  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="row">
                    
                    <?php foreach ($data as $row) { ?>
                      <div class="col-md-55">
                        <div class="thumbnail">
                          <div class="image view view-first">
                             <?php if (!empty($row->foto)): ?>
                            <img style="width: 100%; display: block;" src="<?php echo base_url('./uploads/'.$row->foto) ?>" alt="image" />
                            <?php else: ?>
                              <img style="width: 100%; display: block;" src="<?php echo base_url('images/user.png') ?>" alt="image" />
                            <?php endif ?>
                            <div class="mask">
                              <p><?php echo strtoupper($row->nama); ?></p>
                              <div class="tools tools-bottom">
                                <a href="#"><i class="fa fa-link"></i></a>
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a href="#"><i class="fa fa-times"></i></a>
                              </div>
                            </div>
                          </div>
                          <div class="caption">
                            <span><?php echo "Nim : ".strtoupper($row->nim)?></span><br>
                            <span><?php echo "Angkatan : ".strtoupper($row->name_angkatan); ?></span>
                          </div>
                        </div>
                      </div>

                      <?php } ?>
                      

                    </div>

                  </div>
                </div>
              </div>
            </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

   <?php require_once('template/footer/halaman-utama-admin.php') ?>
   <?php require_once('template/alert/sweet_alert.php') ?>
