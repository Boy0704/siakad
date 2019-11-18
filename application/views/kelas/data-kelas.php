       
       <?php require_once('template/datatables/datatables_header.php') ?>

         <?php require_once('template/menu/menu_foto_admin.php') ?>

            <!-- sidebar menu -->
      <?php require_once('template/menu/menu_left.php') ?>

            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
  <?php require_once('template/menu/menu_left_footer.php') ?>

        <!-- top navigation -->
      <?php require_once('template/menu/menu_header.php') ?>
      <style>
        th{
          text-align: center;
        }
      
      </style>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row"> 
            <div class="push">
                <ol class="breadcrumb">
                    <li><i class='fa fa-home'></i> <a href="javascript:void(0)">Home</a></li>
                    <li><i class='fa fa-cube'></i> <?php echo anchor($this->uri->segment(1),$title);?></li>
                    <li class="active"><i class='fa fa-table'></i> Data</li>
                </ol>
            </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
             
           
              <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $title; ?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                        <?php if ($response = $this->session->flashdata('kelas_add')): ?>
                            <div class="row">
                              <div class="col-lg-12" align="center">
                              <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <span class="sr-only">success:</span>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $response; ?>
                              </div>
                              </div>
                            </div>
                        <?php else: ?>
                            
                        <?php endif; ?>

                         <?php if ($response = $this->session->flashdata('kelas_edit')): ?>
                            <div class="row">
                              <div class="col-lg-12" align="center">
                                <div class="alert alert-dismissible alert-success">
                               <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <?php echo $response; ?>
                              </div>
                              </div>
                            </div>
                        <?php else: ?>
                            
                        <?php endif; ?>

                         <?php if ($response = $this->session->flashdata('kelas_delete')): ?>
                            <div class="row">
                              <div class="col-lg-12" align="center">
                              <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">success:</span>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $response; ?>
                              </div>
                              </div>
                            </div>
                        <?php else: ?>
                            
                        <?php endif; ?> 
                    <?php echo anchor('kelas/createKelas', ' Tambah Data',['class'=>'fa fa-plus btn-lg btn btn-primary']); ?>
                    <table id="datatable" class="table table-bordered table-hover nowrap">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kelas</th>
                          <th>Opsi</th>
                        </tr>
                      </thead>
                       <?php
                       $no=1;
                          if ($kelas->num_rows() > 0 ) {
                            foreach ($kelas->result() as $row) {
                              ?>
                  
                    
                            <tr>
                               <td align="center"><?php echo $no++; ?></td>
                               <td align="center"><?php echo strtoupper($row->nama_kelas); ?></td>
                             
                              <td><center>
                              <a class="btn btn-sm btn-primary" data-placement="bottom" data-toggle="tooltip" title="Edit Angkatan" href="<?php echo base_url("angkatan/angkatanEdit/{$row->angkatan_id}") ?>">
                              <span class="glyphicon glyphicon-edit"></span>
                              </a>

                               <a onclick="return confirm ('Yakin Data <?php echo $row->nama_kelas;?> Ingin Di Hapus.?');" class="btn btn-sm btn-danger tooltips" data-placement="bottom" data-toggle="tooltip" title="Hapus Angkatan" href="<?php echo base_url('angkatan/deleteAngkatan/'.$row->angkatan_id) ?>"><span class="glyphicon glyphicon-trash"></a>
                                </center></td>

                            </tr>
                            
                  
                              <?php
                            }
                          }
                        ?>
                    
                    </table>
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
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-3.2.1.min.js') ?>"></script>

   <?php require_once('template/datatables/datatables_footer.php') ?>  
