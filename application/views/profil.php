<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"></h3>
  </div>
  <div class="panel-body">

    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
    <?php
echo form_open_multipart($this->uri->segment(1));
?>
<table class="table table-bordered">

    <tr>
      <td width="150">Upload Foto</td><td>
          <?php echo inputan('file', 'foto','col-sm-6','Foto ..', '', '','');?>
          <i style="color:red;font-size:10px;">*tidak wajib diisi. <br> *Format: .jpg, .png | *Max. Size: 3 MB</i>
      </td>
    </tr>
    <tr>
      <td width="150">Password</td><td>
          <?php echo inputan('password', 'password','col-sm-6','Ubah Password ...', '', '','');?>
          <i style="color:red;font-size:10px;">*tidak wajib diisi.</i>
      </td>
    </tr>
    <tr>
      <td width="150">Ulangi Password</td><td>
          <?php echo inputan('password', 'password2','col-sm-6','Ulangi Password ...', '', '','');?>
          <i style="color:red;font-size:10px;">*tidak wajib diisi jika <b>Ubah password tidak diisi</b>.</i>
      </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2">
            <input type="submit" name="submit" value="simpan" class="btn btn-danger">
        </td>
    </tr>
</table>

  </div></div>
</form>
