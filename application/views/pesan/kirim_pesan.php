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
                <li class="active"><i class='fa fa-folder'></i> Mengirim Pesan</li>
            </ol>
        </div>
        </div>
           
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  

                  <div class="x_content">
                 
                    <form action="<?php echo base_url('pesan/sendmsg') ?>" method="post" id="mahasiswa_add" class="form-horizontal form-label-left" novalidate>
                    
                      <p>Input data anda yang benar sesuai biodata asli anda <code>"biodata asli"</code>
                      </p>
                      
                       <table class="table table-bordered">
                      <tr class="success"><th colspan="2">Create Mahasiswa</th></tr>
                      
                      <tr>
                       <td width="200">
                        <label class="control-label col-md-3" for="name">No Telepon <span class="required"></span>
                        </label>
                        </td>
                      <td>
                      <div class="item form-group">
                        <div class="col-md-6">
                            <?php echo form_input(['name' => 'mobile' ,
                              'class' => 'form-control',
                              'type'=>'tel',
                              'placeholder' => 'mobile',
                              'data-validate-length-range'=>'8,20',
                              'required' => 'required',
                              'value' => set_value('mobile')
                              ]);
                           ?>
                            <div class="col-md-6">
                         <?php echo form_error('mobile','<div class="text-danger">','</div>'); ?>
                       </div>
                        </div>
                      </div>
                      </td>
                      </tr>
                    
                         <tr>
                       <td align="center">
                        <label class="control-label col-md-4" for="name">message <span class="required"></span>
                        </label>
                        </td>
                      <td>
                      <div class="item form-group">
                        <div class="col-md-6">
                            <?php echo form_textarea(['name' => 'message' ,
                              'class' => 'form-control',
                              'placeholder' => 'message',
                              'maxlength' => '100',
                              'required' => 'required',
                              'value' => set_value('message')
                              ]);
                           ?>
                            <div class="col-md-6">
                         <?php echo form_error('message','<div class="text-danger">','</div>'); ?>
                       </div>
                        </div>
                      </div>
                      </td>
                      </tr>
                                          
                    
                       
                       <tr><td colspan="2">
                          <div class="form-group">
                        <div class=" col-md-offset-3">
                          <!-- <button type="reset" class="btn btn-default"> <span class="fa fa-undo"></span> Cancel</button> -->
                          <button id="send" type="submit" class="btn btn-primary"> <span class="fa fa-send"> </span> Kirim</button>
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

    <?php require_once('template/footer/validation.php');  ?> 

    <script>
      $(document).ready(function(){
         $('#send').submit(function(e){
            e.preventDefault();
            alert('alalal');
            // var me = $this;
            // $.ajax({
            //     url:me.attr('action'),
            //     type :'post',
            //     data : me.serialize(),
            //     datatype:'json',
            //     success:function(response){

            //     }
            // });
         });
      });
    </script>
     
   