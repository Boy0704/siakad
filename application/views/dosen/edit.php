
<?php
if ($this->session->userdata('level') == '1') {
  echo form_open(base_url().'dosen/edit');
} else {
  echo form_open(base_url().'users/edit_dosen');
}
echo "<input type='hidden' name='id' value='$r[dosen_id]'>";
$gender=array(''=>'- Pilih -',1=>'Laki Laki',2=>'Perempuan');
$kawin=array(''=>'- Pilih -',1=>'Kawin',2=>'Belum Kawin');
$class="class='form-control' ";
?>
 <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Record</h3>
  </div>
  <div class="panel-body">
<table class="table table-bordered">
    <tr>
    <td width="150">Nama Lengkap</td><td>
        <?php echo inputan('text', 'nama','col-sm-4','Nama Lengkap ..', 1, $r['nama_lengkap'],'');?>
    </td>
    </tr>

            <tr>
    <td width="150">NIDN ,NIP</td><td>
        <?php echo inputan('text', 'nidn','col-sm-3','NIDN ..', 1, $r['nidn'],'');?>
         <?php echo inputan('text', 'nip','col-sm-4','NIP ..', 1, $r['nip'],'');?>
    </td>
    </tr>
     <tr>
    <td width="150">Tempat ,Tanggal Lahir</td><td>
        <?php echo inputan('text', 'tempat_lahir','col-sm-4','Tempat Lahir ..', 0, $r['tempat_lahir'],'');?>
        <?php echo inputan('text', 'tanggal_lahir','col-sm-2','Tanggal Lahir ..', 0, $r['tanggal_lahir'],array('id'=>'datepicker'));?>
    </td>
    </tr>

            <tr>
            <td width="180">Jenis Kelamin</td><td>
                <div class="col-sm-3">
                        <?php echo form_dropdown('gender',$gender,$r['gender'],$class)?>
                 </div>
            </td>
            </tr>

        <tr>
    <td width="150">Agama ,Status Kawin</td><td>
        <?php echo editcombo('agama','app_agama','col-sm-2','keterangan','agama_id','','',$r['agama_id'],0); ?>
         <div class="col-sm-2">
                        <?php echo form_dropdown('kawin',$kawin,$r['status_kawin'],$class)?>
                 </div>
    </td>
    </tr>

            <tr>
    <td width="150">Alamat</td><td>
        <?php echo textarea('alamat', '', 'col-sm-5', 2, $r['alamat']);?>
    </td>
    </tr>
        <tr>
    <td width="150">No Hp ,Email</td><td>
        <?php echo inputan('text', 'hp','col-sm-2','No HP ..', 0, $r['hp'],'');?>
         <?php echo inputan('email', 'email','col-sm-4','Email ..', 0, $r['email'],'');?>
    </td>
    </tr>
   <tr>
      <td width="150">Prodi</td><td>
          <!-- <?php echo editcombo('prodi_id', 'akademik_prodi', 'col-md-6', 'nama_prodi', 'prodi_id', '','',$r['prodi_id'],1)?> -->
          <?php //echo buatcombo('konsentrasi_id', 'akademik_konsentrasi', 'col-md-6', 'nama_konsentrasi', 'konsentrasi_id', '', '',1)?> 
          <select name="konsentrasi_id" class="form-control">
            <option value="<?php echo $r['konsentrasi_id'] ?>"><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$r['konsentrasi_id'],'nama_konsentrasi') ?></option>
            <?php 
            foreach ($this->db->get('akademik_konsentrasi')->result() as $rw) {
             ?>
             <option value="<?php echo $rw->konsentrasi_id ?>"><?php echo $rw->nama_konsentrasi ?></option>
           <?php } ?>
          </select>
      </td>
    </tr>

      <tr>
         <td></td><td colspan="2">
          <div class="col-sm-3">
            <input type="submit" name="submit" value="Simpan" class="btn btn-primary  btn-sm">
            <?php echo anchor(base_url(),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
          </div>
        </td></tr>

</table>
  </div>
</form>
