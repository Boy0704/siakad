<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Input Record</h3>
  </div>
  <div class="panel-body">

    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
    <?php
echo form_open_multipart($this->uri->segment(1).'/post');
?>
<table class="table table-bordered">

    <tr>
    <td width="150">Nama Kepala Bagian</td><td>
        <?php echo inputan('text', 'nama_kepala_bagian','col-sm-6','Nama Kepala Bagian ..', 1, '','');?>
    </td>
    </tr>
    <tr>
    <td width="150">Dosen</td><td>
        <!-- <div class="col-sm-3"> -->
          <?php echo buatcombo('dosen_id','app_dosen','col-sm-6','nama_lengkap','dosen_id','',''); ?>
        <!-- </div> -->
    </td>
    </tr>
    <tr>
        <td></td><td colspan="2">
            <input type="submit" name="submit" value="simpan" class="btn btn-danger">
             <?php
          echo anchor($this->uri->segment(1),'kembali',array('class'=>'btn btn-danger btn-sm'));
          ?>
        </td></tr>

</table>
  </div></div>
</form>
