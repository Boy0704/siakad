<?php
echo form_open($this->uri->segment(1).'/edit');
echo "<input type='hidden' name='id' value='$r[gedung_id]'>";
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Record</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
   
    <tr>
    <td width="150">Nama Gedung</td><td>
         <?php echo inputan('text', 'nama','col-sm-4','Agama ..', 1, $r['nama_gedung'],'');?>
    </td>
    </tr>
    <tr>
         <td></td><td colspan="2"> 
          <div class="col-md-3">
            <input type="submit" name="submit" value="simpan" class="btn btn-primary  btn-sm">
            <?php echo anchor($this->uri->segment(1),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
          </div>
        </td></tr>
    
</table>
  </div>
</div>
</form>