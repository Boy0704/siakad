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
                      <li><i class='fa fa-users'></i> <?php echo anchor($this->uri->segment(1),$title);?></li>
                      <li class="active"><i class='fa fa-table'></i> Data</li>
                  </ol>
            </div>
          </div>

          </div>
         
          <!-- /top tiles -->
          <!-- Main row -->
          <div class="row">
             
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <!-- <div class="x_title">
                    <h2>Presentasi Mahasiswa Per Angkatan</h2>
                    <div class="clearfix"></div>
                  </div> -->
                  <div class="x_content">
                    <div id="mybarChart" style="height:225px;"></div>
                  </div>
                </div>
              </div>

               <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                 <!--  <div class="x_title">
                    <h2>Pie Area</h2>
                    <div class="clearfix"></div>
                  </div> -->
                  <div class="x_content">

                    <div id="piechart" style="height:225px;"></div>

                  </div>
                </div>
              </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    <div id="lineChart" style="height:225px;"></div>

                  </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    <div id="mybarChart1" style="height:225px;"></div>

                  </div>
                </div>
            </div>
            
             <input type="button" value="Go Faster" onclick="changeTemp(1)" />
            <input type="button" value="Slow down" onclick="changeTemp(-1)" />
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    <div id="gauge_div" style="height:225px;"></div>

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
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
  <script type="text/javascript" src="<?php echo base_url() ?>template/vendors/Chart.js/dist/loader2.js"></script> 
    <!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
   <?php require_once('template/footer/halaman-utama-admin.php') ?>
   <?php require_once('template/alert/sweet_alert.php') ?>
  <?php require_once('template/chart/chart.php') ?>
    <!-- Chart.js -->
   <!--  -->
     </body>
</html>

