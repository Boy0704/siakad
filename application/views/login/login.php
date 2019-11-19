<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php require_once('template/halaman_login/header/header.php'); ?>
<body>
   <?php require_once('template/halaman_login/navbar/navbar.php'); ?>
    <!-- LOGO HEADER END-->
   <?php require_once('template/halaman_login/menu/menu.php'); ?>
    <!-- MENU SECTION END-->

        <div class="container content-wrapper">
           <div class="row">
              <div class="col-md-12" style="margin-top: -30px;margin-bottom: -20px;">
                  <h4 class="page-head-line">SELAMAT DATANG DI SIAKAD STAIN KEPULAUAN RIAU</h4>
              </div>
            </div>
            <div class="row">
                 <div class="col-md-4">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h4 align="center">Login Sistem</h4>
                        </div>
                        <div class="panel-body">
                             <form action="" method="post" accept-charset="utf-8" class="form-veritikal">
                                <?php if ($error = $this->session->flashdata('login_response')): ?>
                                      <div class="row">
                                        <div class="form-group">
                                          <div class="col-sm-12">
                                              <div class="alert alert-danger" role="alert">
                                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <span class="sr-only">Error:</span>
                                                <?php echo $error; ?>
                                              </div>

                                          </div>

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="_username" class="form-control" id="exampleInputEmail1" placeholder="Username" autocomplete="off" autofocus/>
                                    <div class="row">
                                         <div class="col-md-12">
                                        <?php echo form_error('_username','<div class="text-danger">','</div>'); ?>
                                    </div>
                                    </div>

                                    <label>Password</label>
                                    <input type="password" name="_password" class="form-control" id="password-2"  placeholder="Password" />
                                    <div class="row">
                                         <div class="col-md-12">
                                        <?php echo form_error('_password','<div class="text-danger">','</div>'); ?>
                                    </div>
                                    </div>

                                  </div>
                                  <div class="form-group">
                                    <?php echo $image; ?><br>
                                    <label>Kode Aman</label>
                                    <input type="text" name="_kode_aman" class="form-control" autocomplete="off" placeholder="Kode Aman" />

                                  </div>
                                   <div class="form-group">
                                    <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
                                  </div>
                            </form>
                        </div>
                            </div>
                        </div>
                <div class="col-md-8">
                                            <br>
                    <div class="alert alert-info">
                      <?php
                      //echo ucwords("<p style='text-align: justify;'>Masukkan Username dan Password anda yang benar untuk masuk di Halaman sistem, anda akan di alihkan di halaman sistem jika validasi telah berhasil.</p>");
                       ?>
                      


                    </div>
                </div>

            </div>
        </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; <?php echo date('Y') ?> SIAKAD Versi 1.0
                </div>

            </div>
        </div>
    </footer>
   <script src="<?php echo base_url() ?>template/assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="<?php echo base_url() ?>template/assets/js/bootstrap.js"></script>
</body>
</html>
  <script src="<?php echo base_url() ?>template/vendors/dist/hideShowPassword.min.js"></script>

<script>
  $('#password-2').hidePassword('focus', {
    toggle: { className: 'my-toggle' }
  });
</script>
