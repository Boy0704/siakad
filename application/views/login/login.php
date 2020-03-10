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
                                  <div class="form-group" style="display: none;">
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
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#myCarousel" data-slide-to="1"></li>
                          <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                    
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                          <div class="item active">
                            <img src="images/slide/g1.png" alt="Los Angeles" style="width:100%; height: 400px;">
                          </div>
                    
                          <div class="item">
                            <img src="images/slide/g2.png" alt="Chicago" style="width:100%; height: 400px;">
                          </div>
                        
                          <div class="item">
                            <img src="images/slide/g3.png" alt="New york" style="width:100%; height: 400px;">
                          </div>
                        </div>
                    
                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                          <span class="glyphicon glyphicon-chevron-right"></span>
                          <span class="sr-only">Next</span>
                        </a>
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
