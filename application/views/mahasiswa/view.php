<?php $level = $this->session->userdata('level'); ?>
<?php if ($level == 1 or $level==2 or $level==3 OR $level==5 OR $level==6): ?>

<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
          loadjurusan();
  });
</script>

<script>
$(document).ready(function(){
  $("#prodi").change(function(){
      loadjurusan()
  });
});
</script>

<script>
$(document).ready(function(){
  $("#konsentrasi").change(function(){
      loadmahasiswa();
  });
});
</script>

<script>
$(document).ready(function(){
  $("#tahun_angkatan").change(function(){
      loadjurusan()
  });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#status").change(function(){
      loadmahasiswa();
  });
});
function loadmahasiswa()
{
    var konsentrasi=$("#konsentrasi").val();
    var tahun_angkatan=$("#tahun_angkatan").val();
    var status=$("#status").val();
    $.ajax({
    url:"<?php echo base_url();?>mahasiswa/tampilkanmahasiswa/"+status,
    data:"konsentrasi=" + konsentrasi + "&tahun_angkatan=" + tahun_angkatan,
    beforeSend: function() {
        $("#mahasiswa").html('<h1><b>Proses</b> menampilkan data . . .</h1>');
    },
    success: function(html)
       {
          $("#mahasiswa").html(html);
       }
       });
}
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
            loadmahasiswa();

	}
	});
}
</script>


<script type="text/javascript">
function hapus(id){

    swal({
      title: 'Yakin.. Ingin mengapus ini?',
      text: "jika Mengklik yes maka data akan dihapus secara permanen dan tidak dapat diurungkan!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!',
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
          $.ajax({
              url:"<?php echo base_url();?>mahasiswa/delete",
              data:"id=" + id ,
              success: function(html)
              {
                swal("Deleted","Data Berhasil Di Hapus.", "success");
                $("#hide"+id).hide(300);
                loadmahasiswa();
              }
          });
       }else {
          swal("Anda Membatalkan! :)", "","info");
        }
    });


  }

  function mhs_export()
  {
    var prodi          = $("#prodi").val();
    var konsentrasi    = $("#konsentrasi").val();
    var tahun_angkatan = $("#tahun_angkatan").val();
    // var url = prodi+konsentrasi+tahun_angkatan;
    if (prodi=='') { prodi=0;}
    if (konsentrasi=='') { konsentrasi=0;}
    if (tahun_angkatan=='') { tahun_angkatan=0;}

    var url = "<?php echo base_url()?>mahasiswa/export/"+prodi+"/"+konsentrasi+"/"+tahun_angkatan;
    window.open(url, '_blank');
    // alert(url);
  }
</script>
<?php
$level = $this->session->userdata('level');
if($level == 1 or $level == 6 or $level == 5)
{
    $param="";
}
else
{
    $param=array('prodi_id'=>$this->session->userdata('konsentrasi_id'));
}
?>
<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
<div class="col-sm-12">
  <?php if ($level==1 OR $level==2): ?>
    <!-- <a href="mahasiswa/form_import" class="btn btn-primary" >Import Mahasiswa</a> -->
  <?php endif; ?>
  <!-- <a href="javascript:void(0);" onclick="mhs_export()" class="btn btn-primary">Export Mahasiswa</a> -->
  <a href="<?php echo base_url('feeder/import_mhs') ?>" class="btn btn-primary">Import Mahasiswa Feeder </a>
</div>



<div class="col-sm-12">
<?php
$status=array(''=>'AKTIF','lulus'=>'LULUS','non-aktif'=>'NON-AKTIF');
$class      ="class='form-control' id='status'"; ?>
    <table class="table table-bordered">
    <tr>
      <td>
        Jurusan<?php echo buatcombo('prodi', 'akademik_prodi', '', 'nama_prodi', 'prodi_id', $param, array('id'=>'prodi'))?>
      </td>
      <td>Prodi<?php echo combodumy('konsentrasi', 'konsentrasi')?></td>
      <td>
        Tahun Angkatan<?php echo buatcombo('tahun_angkatan', 'student_angkatan', '', 'keterangan', 'angkatan_id', '', array('id'=>'tahun_angkatan'))?>
      </td>
      <td>
        Status<?php echo form_dropdown('status',$status,'',$class);?>
      </td>
    </tr>
    <?php if ($level==1 OR $level==2): ?>
     <tr><td colspan="4"><?php echo anchor('mahasiswa/post','<span class="fa fa-plus"></span> Input Data',array('class'=>'btn btn-primary btn-sm'));?> <?php //echo anchor('','Cetak Data',array('class'=>'btn btn-primary  btn-sm'));?> 
     <a href="<?php echo base_url() ?>mahasiswa/cari_mahasiswa" class="btn btn-sm btn-primary">Cari Mahasiswa</a>
   </td>
      
     </tr>
    <?php endif; ?>
</table>
</div>

<div class="col-sm-12">
    <div id="mahasiswa">
      
    </div>
  <!-- <div id="datatable"></div> -->
</div>
<?php else: ?>
  <div class="row" style="background-color: white;">
          <div class="col-lg-12">

              <legend><code><?php echo ucwords('jika data anda ada yang salah/keliru segera menghadap pada bagian akademik'); ?></code></legend>
              <div class="row">
                 <div class="col-lg-3">
                    <div class="list-group">
                    <span class="list-group-item">
                    <?php if ($this->session->userdata('id_users') == ''): ?>
                      <!-- <img src="<?php echo base_url('uploads/'.$record->foto) ?>" alt="" style="width: 200px;height: 230px;"> -->
                      <img class = img-circle src="<?php echo base_url('images/user.png') ?>" alt="..." class="profile_img"  style="height:80px;width:85px;margin-top: 10px;margin-left: 15px;">
                      <?php else:
                        $id_users = $this->session->userdata('id_users');
                        $cek_data = $this->db->get_where('app_users',"id_users='$id_users'")->row();
                        $foto = $this->M_users->cek_filename($cek_data->foto);?>
                      <img src="<?php echo base_url($foto) ?>" alt="" style="width: 200px;height: 230px;">
                      <?php endif ?>
                    </span>
                    </div>
                  </div>

                 <div class="col-md-8">
                   <table id="example" class="table" >
                   <tr>
                      <td>
                        <div style="color:black;" class="col-md-9">
                                      <span class="col-md-2" for="name">Nim</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo $record->nim; ?></span><br>
                                      </div>
                        </div>
                     </td>
                    </tr>
                       <tr>
                      <td>
                         <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Nama</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo strtoupper($record->nama); ?></span>
                                      </div>
                        </div> </td>
                    </tr>
                    <tr>
                      <td>
                          <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Angkatan</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo $record->nama_angkatan; ?></span>
                                      </div>
                        </div> </td>
                    </tr>
                    <tr>
                      <td>
                        <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Semester</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php if($record->semester_aktif==0){echo "-";}else{ echo $record->semester_aktif;} ?></span>
                                      </div>
                        </div> </td>
                    </tr> <tr>
                      <td>
                        <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Jenis Kelamin</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo $record->gender==1?"Laki-laki":"Perempuan"; ?></span>
                                      </div>
                        </div> </td>
                    </tr> <tr>
                      <td>
                         <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Agama</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo $record->agama; ?></span>
                                      </div>
                        </div> </td>
                    </tr> <tr>
                      <td>
                         <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Tempat Lahir</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo $record->tempat_lahir; ?></span>
                                      </div>
                        </div> </td>
                    </tr> <tr>
                      <td>
                         <div style="color:black;" class="col-md-9">
                                      <span class="control-span col-md-2 " for="name">Tgl Lahir</span>
                                      <span class=" col-md-2 ">:</span>
                                      <div class="col-md-8">
                                      <span><?php echo $record->tanggal_lahir; ?></span>
                                      </div>
                        </div>  </td>
                    </tr>
                    </table>
                  </div>

              </div>

          </div>




          </div>

<?php endif ?>
