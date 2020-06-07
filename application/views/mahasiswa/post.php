<script src="<?php echo base_url()?>assets/js/jquery.min.js"> </script>

<script>
$(document).ready(function(){
          loadjurusan();
  });
</script>

<script type="text/javascript">
function loadjurusan()
{
     var prodi=$("#prodi").val();
      $.ajax({
	url:"<?php echo base_url();?>mahasiswa/tampilkankonsentrasi",
	data:"prodi=" + prodi ,
	success: function(html)
	{
            $("#konsentrasi").html(html);
             var konsentrasi=$("#konsentrasi").val();
	}
	});
}
</script>
<script>
$(document).ready(function(){
  $("#prodi").change(function(){

        loadjurusan();
  });
});
</script>
<?php
echo form_open_multipart($this->uri->segment(1).'/post');
if($this->session->userdata('level')==1 or $this->session->userdata('level')==6)
{
    $param="";
}
else
{
    $param=array('prodi_id'=>$this->session->userdata('keterangan'));
}
?>
 <div class="row">
          <div class="col-md-12 clearfix">
              <ul id="example-tabs" class="nav nav-tabs" data-toggle="tabs">
                  <li class="active"><a href="#biodata">Biodata</a></li>
                  <!-- <li><a href="#orangtua">Orangtua</a></li>
                  <li><a href="#sekolah">Sekolah/ Perguruan tinggi Asal</a></li>
                  <li><a href="#institusi">Institusi Yang Mnegusulkan/ Tempat Kerja</a></li>
                  <li><a href="#pa">Pembimbing Akademik</a></li> -->
              </ul>

              <div class="tab-content">
                  <div class="tab-pane active" id="biodata">
                      <table class="table table-bordered">
                          <tr class="alert-info"><th colspan="2">BIODATA</th></tr>
                          <tr><td width="150">NPM, Nama</td>
                              <td>
                                   <?php echo inputan('text', 'nim','col-sm-2','Nim ..', 0,'','');
                                    ?>


                                    <?php echo inputan('text', 'nama','col-sm-10','Nama ..', 0, '','');?>
                                     <div class="col-md-6">
                                      <?php echo form_error('nim','<div class="text-danger">','</div>'); ?>
                                    </div>
                                     <div class="col-md-6">
                                      <?php echo form_error('nama','<div class="text-danger">','</div>'); ?>
                                    </div>
                              </td>
                          </tr>
                          <tr><td>Tahun Agkatan</td><td>
                                  <?php echo buatcombo('tahun_angkatan','student_angkatan','col-sm-2','keterangan','angkatan_id','',''); ?>
                              </td></tr>
                          <tr style="display: none;"><td>Gender, Agama</td>
                              <td>
                                  <div class="col-md-2">
                                  <?php  echo form_dropdown('gender',array('1'=>'Laki Laki','2'=>'Perempuan'),'',"class='form-control'");?>
                                  </div>
                                   <?php echo buatcombo('agama','app_agama','col-sm-2','keterangan','agama_id','',''); ?></td></tr>
                          <tr style="display: none;"><td>Tempat, Tanggal Lahir</td>
                              <td>
                                  <?php echo inputan('text', 'tempat_lahir','col-sm-6','Tempat Lahir ..', 0, '','');?>
                                  <?php echo inputan('text', 'tanggal_lahir','col-sm-2','Tanggal Lahir ..', 0, '',array('id'=>'datepicker'));?>
                                   <div class="col-md-6">
                                      <?php echo form_error('tempat_lahir','<div class="text-danger">','</div>'); ?>
                                    </div>
                                    <div class="col-md-6">
                                      <?php echo form_error('tanggal_lahir','<div class="text-danger">','</div>'); ?>
                                    </div>
                              </td></tr>
                         <tr><td>Jurusan, Prodi</td>
                             <td>
                                 <div class="col-sm-6">
                                    <?php echo buatcombo('prodi', 'akademik_prodi', '', 'nama_prodi', 'prodi_id', $param, array('id'=>'prodi'))?>
                                 </div>
                              <div class="col-sm-6">
                                       <?php echo combodumy('konsentrasi', 'konsentrasi')?>
                              </div>
                              </td>
                          </tr>
                          <tr style="display: none;"><td>Alamat</td><td>
                            <div class="col-sm-12">
                               <?php echo textarea('alamat', '', 'col-sm-02', 2, '');?>
                            </div>
                          </td></tr>
                          <tr>
                            <td  width="150">PILIH DOSEN PA</td><td>
                                  <select name="dosen_pa" class="form-control select2" required="">
                                    <option value="">--Pilih--</option>
                                    <?php 
                                    foreach ($this->db->get('app_dosen')->result() as $rw) {
                                     ?>
                                    <option value="<?php echo $rw->dosen_id; ?>"><?php echo $rw->nidn.' - '.$rw->nama_lengkap ?></option>
                                    <?php } ?>
                                </select>
                                </td>

                          </tr>
                          <tr><td>Keterangan Mahasiswa</td><td>
                            <div class="col-sm-12">
                               <div class='col-sm-02'>
                                 <select name="keterangan_mhs" class="form-control" required="">
                                   <option value="">-- Pilih -- </option>
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
                          </td></tr>
                      </table>

                  </div>




                  <div class="tab-pane" id="orangtua">
                      <table class="table table-bordered">
                          <tr class="alert-info"><th colspan="2">ORANG TUA</th></tr>
                          <tr><td width="150">Nama Ayah, Ibu</td>
                              <td>
                                  <?php echo inputan('text', 'nama_ayah','col-sm-6','Nama Ayah ..', 0, '','');?>
                                  <?php echo inputan('text', 'nama_ibu','col-sm-6','Nama Ibu ..', 0, '','');?>
                              </td></tr>
                          <tr><td>Pekerjaan Ayah, Ibu</td>
                              <td>
                                  <?php echo buatcombo('pekerjan_ayah','app_pekerjaan','col-sm-4','keterangan','pekerjaan_id','',''); ?>
                                  <?php echo buatcombo('pekerjaan_ibu','app_pekerjaan','col-sm-4','keterangan','pekerjaan_id','',''); ?>
                              </td></tr>
                          <tr><td>Alamat Ayah, Ibu</td>
                              <td>
                                  <?php echo textarea('alamat_ayah', '', 'col-sm-6', 2, '')?>
                                  <?php echo textarea('alamat_ibu', '', 'col-sm-6', 2, '')?>
                              </td></tr>
                          <tr><td>Penghasilan Ayah, Ibu</td>
                              <td>
                                  <?php
                                  $penghasilan=array(0=>'Satu Juta s/d dua juta',2=>'Dua Juta s/d Tiga Juta',3=>'Tiga Juta Lebih')
                                  ?>

                                  <div class="col-sm-6">
                                      <?php echo form_dropdown('penghasilan_ayah',$penghasilan,'',"class='form-control'");?>
                                  </div>
                                  <div class="col-sm-6">
                                      <?php echo form_dropdown('penghasilan_ibu',$penghasilan,'',"class='form-control'");?>
                                  </div>
                              </td></tr>
                          <tr><td>No HP Orang Tua</td>
                              <td>
                                  <?php echo inputan('text', 'no_hp_ortu','col-sm-3','No Hp Orang Tua ..', 0, '','');?>
                              </td></tr>
                      </table>
                  </div>



                  <div class="tab-pane" id="sekolah">
                      <table class="table table-bordered">
                          <tr class="alert-info"><th colspan="2">Data Sekolah Asal</th></tr>
                          <tr><td  width="150">Nama Sekolah</td><td>
                                  <?php echo inputan('text', 'sekolah_nama','col-sm-7','Nama Sekolah ..', 0, '','');?>
                              </td></tr>
                           <tr><td>No Telpon</td><td>
                                   <?php echo inputan('text', 'sekolah_telpon','col-sm-5','Telpon Sekolah ..', 0, '','');?>
                               </td></tr>
                            <tr><td>Jurusan/ Tahun Lulus</td><td>
                                    <?php echo inputan('text', 'sekolah_jurusan','col-sm-9','Jurusan ..', 0, '','');?>
                                  <?php echo inputan('text', 'sekolah_tahun','col-sm-3','Lulus ..', 0, '','');?>
                                </td></tr>
                             <tr><td>Alamat</td><td><?php echo textarea('sekolah_alamat', '', 'col-sm-02', 0, '')?></td></tr>
                           <tr class="alert-info"><th colspan="2">Data Perguruan Tinggi Asal</th></tr>
                          <tr><td>Nama Kampus</td><td>
                                  <?php echo inputan('text', 'kampus_nama','col-sm-7','Nama Kampus ..', 0, '','');?>

                              </td></tr>
                           <tr><td>No Telpon</td><td><?php echo inputan('text', 'kampus_telpon','col-sm-5','Telpon Kampus ..', 0, '','');?></td></tr>
                            <tr><td>Jurusan/ Tahun Lulus</td><td>
                                    <?php echo inputan('text', 'kampus_jurusan','col-sm-9','Jurusan ..', 0, '','');?>
                        <?php echo inputan('text', 'kampus_tahun','col-sm-3','Lulus ..', 0, '','');?>
                                </td></tr>
                             <tr><td>Alamat</td><td>
                                     <?php echo textarea('kampus_alamat', '', 'col-sm-02', 0, '')?>
                                 </td></tr>
                      </table>
                  </div>


                  <div class="tab-pane" id="institusi">
                      <table class="table table-bordered">
                          <tr class="alert-info"><th colspan="2">INSTITUSI YANG MENGUSULKAN</th></tr>
                          <tr><td  width="150">Nama Institusi</td><td>
                                  <?php echo inputan('text', 'institusi_nama','col-sm-8','Nama Instansi ..', 0, '','');?>
                              </td></tr>
                          <tr><td>Telpon</td><td>
                                  <?php echo inputan('text', 'institusi_telpon','col-sm-4','Telpon ..', 0, '','');?>
                              </td></tr>
                          <tr><td>Alamat</td><td>
                                  <?php echo textarea('institusi_alamat', '', 'col-sm-02', 0, '')?>
                              </td></tr>
                          <tr class="alert-info"><th colspan="2">TEMPAT KERJA</th></tr>
                          <tr><td>Nama Institusi</td><td>
                                  <?php echo inputan('text', 'instansi_nama','col-sm-8','Nama Instansi ..', 0, '','');?>
                              </td></tr>
                          <tr><td>Telpon</td><td>
                                  <?php echo inputan('text', 'instansi_telpon','col-sm-4','Telpon ..', 0, '','');?>
                              </td></tr>
                          <tr><td>Alamat</td>
                              <td>
                                  <?php echo textarea('instansi_alamat', '', 'col-sm-02', 0, '')?>

                              </td></tr>
                          <tr><td>Mulai Selesai</td><td>
                                  <?php echo inputan('text', 'instansi_mulai','col-sm-3','Mulai ..', 0, '','');?>
                                  <?php echo inputan('text', 'instansi_sampai','col-sm-3','Sampai ..', 0, '','');?>
                              </td></tr>
                      </table>
                  </div>

                  <div class="tab-pane" id="pa">
                      <table class="table table-bordered">
                          <tr class="alert-info"><th colspan="2">DOSEN PEMBIMBING AKADEMIK (PA)</th></tr>
                          <tr><td  width="150">PILIH DOSEN PA</td><td>
                            <?php echo buatcombo('dosen_pa','app_dosen','col-sm-6','nama_lengkap','dosen_id','',''); ?>
                          </td></tr>
                          <tr>
                      </table>
                  </div>

            <input type="submit" name="submit" value="simpan" class="btn btn-primary  btn-sm ">
                    <?php echo anchor($this->uri->segment(1),'kembali',array('class'=>'btn btn-danger btn-sm'));?>
          </form>

              </div>
          </div>

          </div>
