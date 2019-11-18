<!DOCTYPE html>
<html xmlns="http://www.w6.org/1999/xhtml">
<?php require_once('template/halaman_login/header/header.php'); ?>
<body>
   <?php require_once('template/halaman_login/navbar/navbar.php'); ?>
    <!-- LOGO HEADER END-->
   <?php require_once('template/halaman_login/menu/menu.php'); ?>
    <!-- MENU SECTION END-->
   
        <div class="container content-wrapper">
             <div class="row">
              <div class="col-md-12" style="margin-top: -30px;margin-bottom: -20px;">
                  <h4 class="page-head-line">TENTANG APLIKASI</h4>
              </div>
            </div>
            <div class="row">
                 <div class="col-md-12 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tentang Aplikasi 
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Tentang</a>
                                </li>
                                <li class=""><a href="#profile" data-toggle="tab">Profile</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home">
                                    <h4>Tentang Aplikasi</h4>
                                    <p style="text-align: justify;">Aplikasi SIAKAD Ini adalah aplikasi yang di rancang sebagai pengolahan data akademik mahasiswa, akademik dosen, jurusan dan lain-lain. Aplikasi yang saya rancang ini tentu masih banyak kekurangan, dengan kekurangan tersebut maka Untuk kepentingan pengembangan aplikasi agar lebih baik dan lebih bermanfaat kedepannya. Saya mengharapkan ada kritik dan saran yang bersifat membangun untuk kemajuan aplikasi ini.. Anda bisa memberikan kritik dan saran di :<br> <strong style="float: right;">Terima kasih salam develop</strong></p>
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <table class="table">
                                                <tr>
                                                    <td><i class="fa fa-facebook"></i> Facebook</td><td>:</td><td> Tasrin Adiputra</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-facebook"></i> Hal. Facebook</td><td>:</td><td>facebook.com/tasrinteknik</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-whatsapp"></i> Wa</td><td>:</td><td> 082325507930</td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fa fa-instagram"></i> Instagram</td><td>:</td><td>@tasrinadiputra</td>
                                                </tr>
                                            </table>
                                    </div>
                                    </div>
                                   
                                   
                                </div>
                                <div class="tab-pane fade" id="profile">
                                    <h4>Profile Author</h4>
                                     <div class="row">
                                         <div class="col-sm-12">
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama</td>
                                <td><i class="fa fa-user"> Tasrin Adiputra</td>
                                <td rowspan="7" style="height: 200px;width: 450px;">
                                      <div class="profile_img">
                                        <div id="crop-avatar">
                                          <!-- Current avatar -->
                                          <img class="img-responsive avatar-view" src="<?php echo base_url() ?>template/halaman_login/images/tasrin.jpg" alt="Avatar" title="Change the avatar">
                                        </div>
                                       </div>
                                </td>
                                </tr>
                                <tr>
                                    <td width="250">Alamat</td>
                                    <td width="550"><i class="fa fa-map-marker user-profile-icon"></i>  Makassar, Indonesia
                                  </td>
                                </tr>
                                <tr>
                                    <td>Situs</td>
                                    <td> <i class="fa fa-external-link user-profile-icon"></i>
                                    <a href="http://webnyait.blogspot.com/" target="_blank">webnyait.blogspot.com</a></td>
                                </tr>
                                 <tr>
                                    <td>Software</td>
                                   <td><i class="fa fa-briefcase user-profile-icon"></i> Software Engineer</td>
                                </tr>
                                    </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <!-- CONTENT-WRAPPER SECTION END-->
   <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; <?php echo date('Y') ?> SIAKA Versi 1.0 | Created By Tasrin Adiputra | By : <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap</a>
                </div>

            </div>
        </div>
    </footer>
    <script src="<?php echo base_url() ?>template/assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="<?php echo base_url() ?>template/assets/js/bootstrap.js"></script>
</body>
</html>
