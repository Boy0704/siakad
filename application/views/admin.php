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
         
         <!-- top tiles -->
      <div class="row">
           
          <div class="col-md-4">
              <div class="sm-st clearfix">
                  <span class="sm-st-icon st-red"><i class="fa fa-users"></i></span>
                  <div class="sm-st-info">
                  
                      <span><?php echo "$mahasiswa"; ?></span>
                      Total Jumlah Mahasiswa
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="sm-st clearfix">
                  <span class="sm-st-icon st-violet"><i class="fa fa-user"></i></span>
                  <div class="sm-st-info">
                  
                      <span><?php echo "$dosen"; ?></span>
                      Total Jumlah Dosen
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="sm-st clearfix">
                  <span class="sm-st-icon st-blue"><i class="fa fa-book"></i></span>
                  <div class="sm-st-info">
                  
                      <span><?php echo "$matkul"; ?></span>
                      Total Jumlah Matakuliah
                  </div>
              </div>
          </div>

      </div>
         
          <!-- /top tiles -->
          <!-- Main row -->
          <div class="row">
             <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Chart Mahasiswa<small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="lineChart"></canvas>
                  </div>
                </div>
              </div>  

             <div class="col-md-6">
                <!--chat start-->
                  <div class="x_panel">
                     <div class="x_title">
                          <h2>Pemberitahuan</h2>
                          <div class="clearfix"></div>
                      </div>
                                          
                      <div class="x_content" id="noti-box">
                          <?php
                            //periksa apakah datanya array atau hanya 0
                            if(is_array($makul_list)){
                              foreach ($makul_list as $data) { ?>
                                <div class="alert alert-block alert-danger" style="background-color: #ed5b17; border-color: transparent;>
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <strong><?php echo 'Matakuliah ' . strtoupper($data->nama_makul);?></strong>, Baru Ditambahkan Di Database
                                </div>
                                <?php 
                                }
                              }
                            ?>

                            <?php
                              //periksa apakah datanya array atau hanya 0
                              if(is_array($mahasiswa_list)){
                              foreach ($mahasiswa_list as $data) { ?>
                                <div class="alert alert-block alert-info">
                                    <button data-dismiss="alert" class="close close-sm" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <strong><?php echo 'Mahasiswa ' . strtoupper($data->nama);?></strong>, Baru Ditambahkan Di Database
                                </div>
                                <?php 
                                }

                              }
                            ?>

                            <?php
                              //periksa apakah datanya array ada atau hanya 0
                              if(is_array($dosen_list)){
                               foreach ($dosen_list as $data) {
                                
                              ?>
                                  <div class="alert alert-block alert-success">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="fa fa-times"></i>
                                      </button>
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                      <strong><?php echo 'Dosen ' . strtoupper($data->nama_lengkap);?></strong>, Baru Ditambahkan Di Database
                                  </div>
                                  <?php
                                   }
                                }
                              ?>

                            <?php
                             //periksa apakah datanya array ada atau hanya 0
                              if(is_array($users_list)){
                               foreach ($users_list as $data) {
                                
                              ?>
                                  <div class="alert alert-block alert-info" style="background-color: #45f442; border-color: transparent;">
                                      <button data-dismiss="alert" class="close close-sm" type="button">
                                          <i class="fa fa-times"></i>
                                      </button>
                                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                                      <strong><?php echo strtoupper($data->username).' Telah Ditambahkan Sebagai User '?></strong> Baru
                                  </div>
                                  <?php }
                                  }
                                  ?>            
                            </div>
                      </div>
                </div>


          </div>
              

            
          </div>
        </div>

        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Siakad Versi 1.0 
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <script src="<?php echo base_url() ?>template/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/nprogress/nprogress.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/Chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/echarts/dist/echarts.min.js"></script>
    <script src="<?php echo base_url() ?>template/build/js/custom.min.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/dist/sweetalert-dev.js"></script>
    <script src="<?php echo base_url() ?>template/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
   <?php require_once('template/alert/sweet_alert.php') ?>
   <?php require_once('template/chart/chart.php') ?>

    <!-- Chart.js -->
<script>
      Chart.defaults.global.legend = {
        enabled: false
      };
      // Line chart
      var paramNombres = [];
      var paramEdades = [];
      var ctx = document.getElementById("lineChart");
       $.post("<?php echo base_url();?>Chart/getPersonas",
      function(data){
        var obj = JSON.parse(data);
        paramNombres = [];
        paramEdades = [];
        $.each(obj, function(i,item){
          paramNombres.push(item.keterangan);
          paramEdades.push(item.jumlah);
        });
      
    
      var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: paramNombres,
          datasets: [{
            label: "Jumlah Mahasiswa",
            data: paramEdades,
            backgroundColor: "rgba(38, 185, 154, 0.31)",
            borderColor: "rgba(38, 185, 154, 0.7)",
            pointBorderColor: "rgba(38, 185, 154, 0.7)",
            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointBorderWidth: 1
            
          }]
        },

        // data: {
        //   labels: paramNombres,
        //   datasets: [{
        //     label: 'Jumlah Mahasiswa',
        //     backgroundColor: "#26B99A",
        //     data: paramEdades
        //   }
          // , {
          //   label: 'Jumlah Mahasiswa',
          //   backgroundColor: "#03586A",
          //   data: [41, 56, 25, 48, 72, 34, 12]
          // }
          // ]
        // },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }


      });
  });
</script>

     </body>
</html>