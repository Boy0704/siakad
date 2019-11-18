
<?php
$level = $this->session->userdata('level');
if(!$level)
{
    redirect('login');
}
?>
<?php require_once('template/datatables/datatables_header.php') ?>
<?php require_once('template/menu/menu_left.php') ?>
<?php require_once('template/menu/menu_left_footer.php') ?>
<?php require_once('template/menu/menu_header.php') ?>
<style type="text/css">
  th{
    text-align: center;
  }
</style>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                          <h2 style="font-weight: normal;"><?php echo ucwords($title);?></h2>
                          <!-- <hr>  <br> -->
                          <?php
                          $level =  $this->session->userdata('level');
                          if ( $level==1 OR $level == 2  OR $level == 6 ): ?>
                          <div class="push">
                              <ol class="breadcrumb">
                                  <li><i class='fa fa-home'></i> <a href="javascript:void(0)">Home</a></li>
                                  <li><?php echo anchor($this->uri->segment(1),$title);?></li>
                                  <li class="active">Data</li>
                              </ol>
                          </div>
                           <?php else: ?>

                          <?php endif ?>
                            <?php
                            echo $this->session->flashdata('pesan');
                            echo $contents; ?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/select2/select2.full.min.js"></script>
    
   <?php require_once('template/datatables/datatables_footer.php') ?>
    <?php require_once('template/alert/sweet_alert.php') ?>
    <script src="<?php echo base_url()?>uadmin/js/vendor/bootstrap.min.js"></script>
    <!-- <script src="<?php echo base_url()?>uadmin/js/plugins.js"></script> -->
    <!-- <script src="<?php echo base_url()?>uadmin/js/main.js"></script> -->
    <script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/ui/jquery.ui.core.js"></script> -->
    <!-- <script src="<?php echo base_url();?>assets/ui/jquery.ui.widget.js"></script> -->
    <script src="<?php echo base_url();?>assets/ui/jquery.ui.datepicker.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/themes/base/jquery.ui.all.css">
<script>
$(document).ready(function(){
          $(".alert").fadeIn('fast').show().delay(3000).fadeOut('fast');
  });
</script>


<script>
    $(function() {
        $( "#datepicker" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

                $( "#datepicker1" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

                $( "#datepicker2" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });
                $( "#datepicker3" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

                $( "#datepicker4" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

                $( "#datepicker5" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

                $( "#datepicker6" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

                $( "#datepicker7" ).datepicker({
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                changeYear: true
                });

    });
    </script>


        <!-- Javascript code only for this page -->
        <script>
            $(function() {
                /* Initialize Datatables */
                $('#example-datatables').dataTable({"aoColumnDefs": [{"bSortable": false, "aTargets": [0]}]});
                $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');

            });



        </script>
  </body>
</html>
