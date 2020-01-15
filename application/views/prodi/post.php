<?php
echo form_open_multipart($this->uri->segment(1).'/post');
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Entry Record</h3>
  </div>
  <div class="panel-body">
<table class="table table-bordered">
   
    <tr>
    <td width="150">Nama Prodi</td><td>
        <?php echo inputan('text', 'nama','col-sm-4','Nama prodi ..', 1, '','');?>
    </td>
    </tr>
    <tr>
    <td width="150">Ketua</td><td>
        <?php //echo inputan('text', 'ketua','col-sm-4','Ketua ..', 0, '','');?>
        <select name="ketua" class="form_control select2">
            <?php 
            foreach ($this->db->get('app_dosen')->result() as $rw) {
             ?>
            <option value="<?php echo $rw->nama_lengkap ?>"><?php echo $rw->nama_lengkap ?></option>
            <?php } ?>
        </select>
    </td>
    </tr>
    <tr>
    <td width="150">No Izin</td><td>
        <?php echo inputan('text', 'izin','col-sm-4','No Izin ..', 0, '','');?>
    </td>
    </tr>
    <tr>
         <td></td><td colspan="2"> 
            <input type="submit" name="submit" value="simpan" class="btn btn-danger  btn-sm">
            <?php echo anchor($this->uri->segment(1),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
        </td></tr>
    
</table>
  </div></div>
</form>