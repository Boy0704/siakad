<?php
echo form_open($this->uri->segment(1).'/edit');
echo "<input type='hidden' name='id' value='$r[nilai_id]'>";
?>



<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Record</h3>
  </div>
  <div class="panel-body">
   <table class="table table-bordered">
   
    <tr>
    <td width="150">Grade</td><td>
        <?php echo inputan('text', 'grade','col-sm-4','Grade ..', 1, $r['grade'],'');?>
    </td>
    </tr>
       <tr>
    <td width="150">Dari ,Sampai</td><td>
        <?php echo inputan('text', 'dari','col-sm-3','Example 7.9 ..', 1, $r['dari'],'');?> 
         <?php echo inputan('text', 'sampai','col-sm-3','Example 6.0', 1, $r['sampai'],'');?>
    </td>
    </tr>

    <tr>
    <td width="150">Grade</td><td>
        <?php echo inputan('number', 'grade','col-sm-4','Mutu ..', 1, $r['mutu'],'');?>
    </td>
    </tr>

   <tr>
    <td width="150">Keterangan</td><td>
        <?php echo inputan('text', 'keterangan','col-sm-14','Keterangan ..', 1, $r['keterangan'],'');?>
    </td>
    </tr>
    <tr>
         <td></td><td colspan="2"> 
            <input type="submit" name="submit" value="simpan" class="btn btn-danger  btn-sm">
            <?php echo anchor($this->uri->segment(1),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
        </td></tr>
    
</table>
  </div>
</div>
</form>