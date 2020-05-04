<!-- <script src="<?php echo base_url();?>assets/js/1.8.2.min.js"></script>
<script>
  $( document ).ready(function() {
    $( "#jurusan" ).hide();
  });
  </script>
  <script>
$(document).ready(function(){
    $("#level").change(function(){
        var level = $("#level").val();  
        if(level==2)
            {
                 $( "#jurusan" ).show();
            }
            else
            {
                   $( "#jurusan" ).hide();  
            }
  });
});
</script>
<?php
echo form_open($this->uri->segment(1).'/edit');
echo "<input type='hidden' name='id' value='$r[id_users]'>";
$level=array(1=>'Admin',2=>'Pihak Jurusan',3=>'Dosen');
$class      ="class='form-control' id='level'";
?>
 <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Record</h3>
  </div>
  <div class="panel-body">
<table class="table table-bordered">
  
    <tr>
    <td width="150">username</td><td>
        <?php echo inputan('text', 'username','col-sm-4','Username ..', 1, $r['username'],'');?>
        <input type="hidden" name="username_lama" value="<?php echo $r['username'] ?>">
    </td>
    </tr>
    <tr>
        <tr>
    <td width="150">Password</td><td>
        <div class='col-sm-3'><input type='password' name='password' placeholder='Password ..' class='form-control' value=''  ></div>
    </td>
    </tr>
    
    <tr>
         <td></td><td colspan="2"> 
            <input type="submit" name="submit" value="simpan" class="btn btn-danger  btn-sm">
            <?php echo anchor($this->uri->segment(1),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
        </td></tr>
    
</table>
  </div></div>
</form> -->
<h3>Edit Data User</h3>
<form action="<?php echo base_url() ?>users/edit_user_new/<?php echo $this->uri->segment(3) ?>" method="POST">
  <div class="form-group">
    <label>Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo $r['username'] ?>">
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control">
    <input type="hidden" name="pass_lama" value="<?php echo $r['password'] ?>">
    <p>*) <b style="color: red">Kosongkan password jika tidak diubah</b></p>
  </div>
  <div class="form-group">
    <label>Level</label>
    <select name="level" class="form-control">
      <option value="<?php echo $r['level'] ?>"><?php echo get_data('level','id_level',$r['level'],'level') ?></option>
      <?php foreach ($this->db->get('level')->result() as $rw): ?>
        <option value="<?php echo $rw->id_level ?>"><?php echo $rw->level ?></option>
      <?php endforeach ?>
    </select>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-success">Ubah</button>
  </div>
</form>