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
                <li><i class='fa fa-cube'></i> <?php echo anchor($this->uri->segment(1),$title);?></li>
                <li class="active"><i class='fa fa-folder'></i> Create Kelas</li>
            </ol>
        </div>
        </div>
           
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 

                  <div class="x_content">
                 
                    <form action="<?php echo base_url('kelas/insertKelas') ?>" method="post" class="form-horizontal form-label-left" novalidate>
                    
                      
                     <table class="table">
                      <tr class="success"><th colspan="2">Create Kelas</th></tr>
                      <tr>
                       <td width="100">
                        <label class="control-label col-md-3" for="name">Angkatan <span class="required"></span>
                        </label>
                        </td>
                      <td>
                      <div class="item form-group">
                         <div class="col-md-4">
                            <select id='angkatan' name='angkatan' class='form-control select2_single' required>
                             <option value='' disabled selected>Pilih Angkatan</option>
                             <?php
                              foreach ($angkatan as $d) {  
                              echo "<option value='".$d->angkatan_id."'>".$d->name_angkatan."</option>";
                              }
                              ?>
                            </select>
                            <div class="col-md-12 row">
                         <?php echo form_error('angkatan','<div class="text-danger">','</div>'); ?>
                       </div>
                        </div>
                      </div>
                      </td>
                      </tr>
                      <tr>
                       <td width="100">
                        <label class="control-label col-md-3" for="name">Kelas <span class="required"></span>
                        </label>
                        </td>
                      <td>
                      <div class="item form-group">
                        <div class="col-md-6">
                            <?php echo form_input(['name' => 'kelas',
                              'id'=>'tags_1',
                              'class' => 'form-control',
                              'placeholder' => 'Nama Kelas',
                              'maxlength' => '100',
                              'required' => 'required',
                              'value' => set_value('nama_kelas')
                              ]);
                           ?>
                            <div class="col-md-6 row">
                         <?php echo form_error('kelas','<div class="text-danger">','</div>'); ?>
                       </div>
                        </div>
                      </div>
                      </td>
                      </tr>

                      <!-- <tr>
                       <td width="200">
                        <label class="control-label col-md-3" for="name">auto komplete <span class="required"></span>
                        </label>
                        </td>
                      <td>
                      <div class="item form-group">
                        <div class="col-md-12">
                          <div id="tags"></div>
                          <input type="text" id="" class="form-control">
                          <input type="hidden" name="skills" id="skills">
                        </div>
                      </div>
                      </td>
                      </tr> -->
                      
                    
                       <tr><td colspan="2">
                          <div class="form-group">
                        <div class=" col-md-offset-3">
                          <button type="reset" class="btn btn-default"> <span class="fa fa-undo"></span> Cancel</button>
                          <button id="send" type="submit" class="btn btn-primary"> <span class="fa fa-save"></span> Save</button>
                        </div>
                      </div>
                       </td></tr>

                      </table>
                      

                    </form>

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

    <?php require_once('template/footer/footer.php'); ?>
    
    
    <?php require_once('template/footer/form_input_footer.php');  ?> 
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ?>template/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>Input_Tag-master/style.css">
<script src="<?php echo base_url() ?>Input_Tag-master/input_tag.js"></script>  -->
    <!-- Switchery -->
    <script>
       $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
        $("input").val()
      });
    </script>

    <!-- <script>

var dataTags = [];
       $.post("<?php echo base_url();?>Chart/getdata",
      function(data){
        var obj = JSON.parse(data);
        dataTags = [];
        $.each(obj, function(i,item){
          dataTags.push(item.name_angkatan);
        });
      
     dataTags = new Array('s');

      
  });
 
</script>
 -->