<?php
$level = $this->session->userdata('level');
if ($level == 1 or $level==2) { ?>
<script src="<?php echo base_url();?>assets/js/1.8.2.min.js"></script>
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
echo form_open_multipart($this->uri->segment(1).'/post');
if ($level == 1) {
  $level2=array(1=>'Admin',2=>'Pihak Jurusan',3=>'Dosen', 4=>'Mahasiswa', 5=>'Bendahara', 6=>'Pimpinan');
}
elseif ($level==2) {
  $level2=array(2=>'Pihak Jurusan',3=>'Dosen', 4=>'Mahasiswa', 5=>'Bendahara', 6=>'Pimpinan');
}


if($level==1)
{
    $param="";
}
else
{
    $param=array('prodi_id'=>$this->session->userdata('level'));
}

$class      ="class='form-control' id='level'";
?>
 <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Entry Record</h3>
  </div>
  <div class="panel-body">
<table class="table table-bordered">

    <tr>
    <td width="150">username</td><td>
        <?php echo inputan('text', 'username','col-sm-4','Username ..', 1, '','');?>
    </td>
    </tr>
    <tr>
        <tr>
    <td width="150">Password</td><td>
        <?php echo inputan('password', 'password','col-sm-3','Password ..', 1, '','');?>
    </td>
    </tr>
    <tr>
    <td width="150">Level</td><td>
        <div class="col-sm-3">
        <select name="level" class='form-control' id='level'>
          <?php foreach ($this->db->get('level')->result() as $key => $value): ?>
              <option value="<?php echo $value->id_level ?>"><?php echo $value->level ?></option>
          <?php endforeach ?>
          
        </select>
        </div>

        <?php echo buatcombo('prodi', 'akademik_prodi', 'col-sm-3', 'nama_prodi', 'prodi_id', $param, array('id'=>'jurusan'))?>

    </td>
    </tr>
    <tr>
         <td></td><td colspan="2">
          <div class="col-sm-3">
           <input type="submit" name="submit" value="Simpan" class="btn btn-primary btn-sm">
            <?php echo anchor($this->uri->segment(1),'Kembali',array('class'=>'btn btn-default btn-sm'));?>
          </div>
        </td></tr>

</table>
  </div></div>
</form>
<?php
}
?>
