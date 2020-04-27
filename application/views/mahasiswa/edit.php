<script src="<?php echo base_url()?>assets/js/jquery.min.js">
</script>
<script>
$(document).ready(function(){
  $("#prodi").change(function(){
      var prodi=$("#prodi").val();
      $.ajax({
	url:"<?php echo base_url();?>mahasiswa/tampilkankonsentrasi",
	data:"prodi=" + prodi ,
	success: function(html)
	{
            $("#konsentrasi").html(html);

	}
	});


  });
});
</script>

<?php
echo form_open_multipart($this->uri->segment(1).'/edit_mhs/');
echo "<input type='hidden' name='id' value='$r[mahasiswa_id]'>";
echo form_hidden('nim_old', $r['nim']);
if($this->session->userdata('level')==1)
{
    $param="";
}
else
{
    $param=array('prodi_id'=>$this->session->userdata('keterangan'));
}

$disable = '';
if ($this->session->userdata('level') == 4) {
    $disable = 'readonly';
}

?>
<table class="table table-bordered">
    <tr class="alert-info"><th colspan="2">BIODATA PRIBADI</th><th colspan="2">BIODATA ORANG TUA</th></tr>
    <tr><td width="150">NPM /NAMA</td><td WIDTH="450">
        <?php echo inputan('text', 'nim','col-sm-4','Nim ..', 1, $r['nim'],'',$disable);?>
        <div class="col-md-6 row">
        <?php echo form_error('nim','<div class="text-danger">','</div>'); ?>
      </div>
         <?php echo inputan('text', 'nama','col-sm-8','Nama ..', 1, $r['nama'],'','');?></td>

        <td width="150">Nama Ayah, Ibu</td><td>
            <?php echo inputan('text', 'nama_ayah','col-sm-6','Nama Ayah ..', 0, $r['nama_ayah'],'');?>
            <?php echo inputan('text', 'nama_ibu','col-sm-6','Nama Ibu ..', 0, $r['nama_ibu'],'');?>
        </td>
    </tr>
    <tr>
        <td width="050">Jenis Kelamin, Agama</td>
        <td>
            <div class="col-md-4">
                <?php
                echo form_dropdown('gender',array('1'=>'Laki Laki','2'=>'Perempuan'),$r['gender'],"class='form-control'");
                ?>
            </div>
            <?php echo editcombo('agama','app_agama','col-sm-4','keterangan','agama_id','','',$r['agama_id']); ?>
        </td>
        <td>Pekerjaan Ayah ,Ibu</td>
        <td>
            <?php echo editcombo('pekerjan_ayah','app_pekerjaan','col-sm-6','keterangan','pekerjaan_id','','',$r['pekerjaan_id_ayah']); ?>
            <?php echo editcombo('pekerjaan_ibu','app_pekerjaan','col-sm-6','keterangan','pekerjaan_id','','',$r['pekerjaan_id_ibu']); ?>
        </td>
    </tr>
    <tr>
    <td width="050">Tempat ,Tanggal Lahir</td><td>
       <?php echo inputan('text', 'tempat_lahir','col-sm-8','Tempat Lahir ..', 0, $r['tempat_lahir'],'');?>
        <?php echo inputan('text', 'tanggal_lahir','col-sm-4','Tanggal Lahir ..', 0, $r['tanggal_lahir'],array('id'=>'datepicker'));?>
    </td>
    <td>Alamat Ayah, Ibu</td>
    <td><?php echo textarea('alamat_ayah', '', 'col-sm-6', 2, $r['alamat_ayah'])?>
        <?php echo textarea('alamat_ibu', '', 'col-sm-6', 2, $r['alamat_ibu'])?>
    </td>
    </tr>
    <tr>
    <td width="050">Jurusan / Prodi</td><td>
        <div class="col-sm-6">
            <?php
            $prodi=  getField('akademik_konsentrasi', 'prodi_id', 'konsentrasi_id', $r['konsentrasi_id'])
            ?>
        <?php //echo get_data('akademik_prodi','prodi_id',$prodi,'nama_prodi'); //buatcombo('prodi', 'akademik_prodi', '', 'nama_prodi', 'prodi_id', $param, array('id'=>'prodi'),'',$disable) ?>
          <?php if ($this->session->userdata('level') =='1'): ?>
            <select name="" class="form-control" >
            <option value="<?php echo $prodi ?>"><?php echo get_data('akademik_prodi','prodi_id',$prodi,'nama_prodi'); ?></option>

            <?php foreach ($this->db->get('akademik_prodi')->result() as $key => $value): ?>
              <option value="<?php echo $value->prodi_id ?>"><?php echo $value->nama_prodi ?></option>
            <?php endforeach ?>

          </select>
          <?php endif ?>

          <?php if ($this->session->userdata('level') == '4'): ?>
            <?php echo get_data('akademik_prodi','prodi_id',$prodi,'nama_prodi'); ?>
          <?php endif ?>
        </div>
            <div class="col-sm-6">
              <!-- <input type="hidden" name="konsentrasi" value="<?php echo $r['konsentrasi_id'] ?>"> -->
         <?php echo //get_data('akademik_konsentrasi','konsentrasi_id',$r['konsentrasi_id'],'nama_konsentrasi');//editcombo('konsentrasi', 'akademik_konsentrasi', '', 'nama_konsentrasi', 'konsentrasi_id', array('prodi_id'=>$prodi), array('id'=>'konsentrasi'),$r['konsentrasi_id'],'',$disable) ?>

         <?php if ($this->session->userdata('level') =='1'): ?>
           <select name="konsentrasi" class="form-control" >
            <option value="<?php echo $r['konsentrasi_id'] ?>"><?php echo get_data('akademik_konsentrasi','konsentrasi_id',$r['konsentrasi_id'],'nama_konsentrasi'); ?></option>

            <?php foreach ($this->db->get('akademik_konsentrasi')->result() as $key => $value): ?>
              <option value="<?php echo $value->konsentrasi_id ?>"><?php echo $value->nama_konsentrasi ?></option>
            <?php endforeach ?>

          </select>
         <?php endif ?>

         <?php if ($this->session->userdata('level') == '4'): ?>
           <?php echo get_data('akademik_konsentrasi','konsentrasi_id',$r['konsentrasi_id'],'nama_konsentrasi'); ?>
         <?php endif ?>
          

            </div>
    </td>
    <td>Penghasilan Ayah, Ibu</td>
    <td>
        <?php
        $penghasilan=array(0=>'Satu Juta s/d dua juta',2=>'Dua Juta s/d Tiga Juta',3=>'Tiga Juta Lebih')
        ?>

        <div class="col-sm-6">
            <?php echo form_dropdown('penghasilan_ayah',$penghasilan,$r['penghasilan_ayah'],"class='form-control'");?>
        </div>
        <div class="col-sm-6">
            <?php echo form_dropdown('penghasilan_ibu',$penghasilan,$r['penghasilan_ibu'],"class='form-control'");?>
        </div>

    </td>

    </tr>


    <tr>
    <td width="050">Alamat</td><td>
        <?php echo textarea('alamat', '', 'col-sm-02', 2, $r['alamat']);?>
    </td>

    <td>No Hp Ortu</td><td>
        <?php echo inputan('text', 'no_hp_ortu','col-sm-7','No Hp Orang Tua ..', 0, $r['no_hp_ortu'],'');?>
    </td>
    </tr>
    <?php 
    if ($this->session->userdata('level') == 1) {
        ?>
    <tr>
        <td>Keterangan Mahasiswa</td><td>
        <div class="col-sm-12">
           <div class='col-sm-02'>
             <select name="keterangan_mhs" class="form-control" required="">
               <option value="<?php echo $r['keterangan'] ?>"><?php echo $r['keterangan'] ?></option>
               <option value="mahasiswa aktif">mahasiswa aktif</option>
               <option value="cuti resmi">cuti resmi</option>
               <option value="cuti tanpa keterangan">cuti tanpa keterangan</option>
               <option value="mahasiswa baru">mahasiswa baru</option>
               <option value="meninggal dunia">meninggal dunia</option>
               <option value="drop out">drop out</option>
               <option value="mengundurkan diri">mengundurkan diri</option>
               <option value="mutasi keluar perguruan tinggi">mutasi keluar perguruan tinggi</option>
             </select>
           </div>                            
         </div>
      </td>
      <td>
        Semester Saat ini
      </td>
      <td>
        <input type="text" name="semester_aktif" class="form-control" value="<?php echo $r['semester_aktif'] ?>">
      </td>
    </tr>
    <?php 
    }
        ?>
    <tr class="alert-info"><th colspan="2">Data Sekolah Asal</th><th colspan="2">Data Perguruan Tinggi Asal ( Khusus Mahasiswa Pindahan)</th></tr>
    <tr>
        <td>Nama Sekolah, Telpon</td>
        <td>
             <?php echo inputan('text', 'sekolah_nama','col-sm-7','Nama Sekolah ..', 0, $r['sekolah_nama'],'');?>
            <?php echo inputan('text', 'sekolah_telpon','col-sm-5','Telpon Sekolah ..', 0, $r['sekolah_telpon'],'');?>
        </td>
        <td>Nama Kampus, Telpon</td>
        <td>
             <?php echo inputan('text', 'kampus_nama','col-sm-7','Nama Kampus ..', 0, $r['kampus_nama'],'');?>
            <?php echo inputan('text', 'kampus_telpon','col-sm-5','Telpon Kampus ..', 0, $r['kampus_telpon'],'');?>
        </td>
    </tr>
    <tr>
    <tr>
        <td>Alamat</td><td><?php echo textarea('sekolah_alamat', '', 'col-sm-02', 0, $r['sekolah_alamat'])?></td>
        <td>Alamat</td><td><?php echo textarea('kampus_alamat', '', 'col-sm-02', 0, $r['kampus_alamat'])?></td>
    </tr>
    <tr>
        <td>Jurusan/ Tahun Lulus</td>
        <td>
            <?php echo inputan('text', 'sekolah_jurusan','col-sm-9','Jurusan ..', 0, $r['sekolah_jurusan'],'');?>
            <?php echo inputan('text', 'sekolah_tahun','col-sm-3','Lulus ..', 0, $r['sekolah_tahun_lulus'],'');?></td>
        <td>Jurusan/ Tahun Lulus</td>
        <td>
            <?php echo inputan('text', 'kampus_jurusan','col-sm-9','Jurusan ..', 0, $r['kampus_jurusan'],'');?>
            <?php echo inputan('text', 'kampus_tahun','col-sm-3','Lulus ..', 0, $r['kampus_tahun_lulus'],'');?></td>
    </tr>
    <tr class="alert-info"><th colspan="2">INSTITUSI YANG MENGUSULKAN</th><th colspan="2">TEMPAT KERJA</th></tr>
    <tr>
        <td>Nama Institusi/ Telpon</td>
        <td>
           <?php echo inputan('text', 'institusi_nama','col-sm-8','Nama Institusi ..', 0, $r['institusi_nama'],'');?>
            <?php echo inputan('text', 'institusi_telpon','col-sm-4','Telpon ..', 0, $r['institusi_telpon'],'');?>
        </td>
                <td>Nama Instansi/ Telpon</td>
        <td>
           <?php echo inputan('text', 'instansi_nama','col-sm-8','Nama Instansi ..', 0, $r['instansi_nama'],'');?>
            <?php echo inputan('text', 'instansi_telpon','col-sm-4','Telpon ..', 0, $r['instansi_telpon'],'');?>
        </td>
    </tr>
    <tr><td>Alamat</td>
        <td><?php echo textarea('institusi_alamat', '', 'col-sm-02', 0, $r['institusi_alamat'])?></td>
        <td>Alamat/ Mulai Bekerja</td>
        <td>
            <?php echo textarea('instansi_alamat', '', 'col-sm-6', 2, $r['instansi_alamat'])?>
            <?php echo inputan('text', 'instansi_mulai','col-sm-3','Mulai ..', 0, $r['instansi_mulai'],'');?>
            <?php echo inputan('text', 'instansi_sampai','col-sm-3','Sampai ..', 0, $r['instansi_sampai'],'');?>
        </td>
    </tr>
    <tr class="alert-info">
      <th colspan="2">DOSEN PEMBIMBING AKADEMIK (PA)</th>
      <th colspan="2">STATUS MAHASISWA</th>
    </tr>
    <?php 
    if ($this->session->userdata('level') == 1) {
        ?>
        <tr>
      <td colspan="2">
        <?php echo editcombo('dosen_pa','app_dosen','col-sm-12','nama_lengkap','dosen_id','','',$r['dosen_pa']);?>
      </td>
      <?php
      $status = array('Aktif'=>'AKTIF','lulus'=>'LULUS', 'non-aktif'=>'NON-AKTIF');
      $class  = "class='form-control' id='status'"; ?>
      <td colspan="2">
        <?php echo form_dropdown('status_mhs',$status,$r['status_mhs'],$class);?>
      </td>
    </tr>
    <?php
    }
     ?>
    <tr>
         <td></td><td colspan="4">
            <div style="float:right;">
              <input type="submit" name="submit" value="simpan" class="btn btn-danger  btn-sm">
              <?php echo anchor(base_url(),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
            </div>
        </td></tr>
        
    

</table>
</form>
