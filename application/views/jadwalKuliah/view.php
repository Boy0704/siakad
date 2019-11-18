<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<?php $level = $this->session->userdata('level'); ?>
<script>
$(document).ready(function(){
    loadkonsentrasi();
    loadkonsentrasi2();
    //tampilmakul();
});
</script>

<!-- <script>
$(document).ready(function(){
  $("#tahun_akademik_id").change(function(){
      tampilmakul();
  });
});
</script> -->

<script>
// 	$(document).on('keydown', 'body', function(e){
//         var charCode = ( e.which ) ? e.which : event.keyCode;

//         if(charCode == 13) //enter
//         {
//             alert("berhasil");
//         }
        
//     });
// </script>

<script>
$(document).ready(function(){
  $("#konsentrasi").change(function(){
      loadsemester();
  });
});
</script>

<script>
$(document).ready(function(){
  $("#prodi").change(function(){
      loadkonsentrasi();
  });
});
</script>

<script>
$(document).ready(function(){
  $("#prodi2").change(function(){
      loadkonsentrasi2()
  });
});
</script>


<script>
$(document).ready(function(){
  $("#semester").change(function(){
      tampilmakul();
  });
});
</script>

<script>
    $(document).ready(function(){
        $("#semester_matkul").change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>index.php/jadwalkuliah/get_matkul_manual",
                method : "POST",
                data : {id: id},
                success: function(data){
                    $('#matkul_manual').html(data);
                    //alert(data);
                }
            });
        });
    });
</script>

<script type="text/javascript">
function loadkonsentrasi()
{
    var prodi=$("#prodi").val();
    $.ajax({
    url:"<?php echo base_url();?>matakuliah/tampilkonsentrasi",
    data:"prodi=" + prodi ,
    success: function(html)
    {
       $("#konsentrasi").html(html);
       loadsemester();
    }
          });
}
function loadkonsentrasi2()
{
    var prodi=$("#prodi2").val();
    $.ajax({
    url:"<?php echo base_url();?>matakuliah/tampilkonsentrasi",
    data:"prodi=" + prodi ,
    success: function(html)
    {
       $("#konsentrasi2").html(html);

    }
          });
}

<?php if ($level!='6') {?>
function simpanhari(id)
{
    var nilaihari=$("#hariid"+id).val();
    var nilaijam=$("#jamid"+id).val();
    var nilairuang=$("#ruangid"+id).val();
    $.ajax({
    url:"<?php echo base_url();?>jadwalkuliah/simpanhari",
    data:"id=" + id +"&nilaihari="+nilaihari+"&nilai_jam="+nilaijam+"&nilai_ruang="+nilairuang  ,
    beforeSend: function() {
        $("#pesan").html('<h1><b>Proses</b> menyimpan data . . .</h1>');
    },
    success: function(html)
    {
      $("#pesan").html('');
        // loadkonsentrasi();
         $("#hasil").html(html);
    }
          });
}

function simpanruang(id)
{
     var nilairuang=$("#ruangid"+id).val();
     var nilaijam=$("#jamid"+id).val();
     var nilaihari=$("#hariid"+id).val();
    $.ajax({
    url:"<?php echo base_url();?>jadwalkuliah/simpanruang",
    data:"id=" + id +"&nilai_ruang="+nilairuang+"&nilai_jam="+nilaijam+"&nilaihari="+nilaihari ,
    beforeSend: function() {
        $("#pesan").html('<h1><b>Proses</b> menyimpan data . . .</h1>');
    },
    success: function(html)
    {
      $("#pesan").html('');
         // loadkonsentrasi();
         $("#hasil").html(html);
    }
          });
}

function simpandosen(id,field,id_n)
{
    var nilaidosen=$("#"+id_n+id).val();
    $.ajax({
    url:"<?php echo base_url();?>jadwalkuliah/simpandosen",
    data:"id=" + id +"&nilai_dosen="+nilaidosen +"&field="+field ,
    beforeSend: function() {
        $("#pesan").html('<h1><b>Proses</b> menyimpan data . . .</h1>');
    },
    success: function(html)
    {
      $("#pesan").html('');
         $("#hasil").html(html);
    }
          });
}



function simpanjam(id)
{
     var nilaijam=$("#jamid"+id).val();
     var nilairuang=$("#ruangid"+id).val();
     var nilaihari=$("#hariid"+id).val();
     var jumlah=nilaijam.length;
     //alert("1 :"+id+" 2 :"+nilaijam+" 3 :"+nilairuang+" 4 :"+nilaihari+" 5 :"+jumlah)
     if(jumlah==5)
     {
        $.ajax({
              url:"<?php echo base_url();?>jadwalkuliah/simpanjam",
              data:"id=" + id +"&nilai_ruang="+nilairuang+"&nilai_jam="+nilaijam+"&nilaihari="+nilaihari ,
              beforeSend: function() {
                  $("#pesan").html('<h1><b>Proses</b> menyimpan data . . .</h1>');
              },
              success: function(html)
              {
                $("#pesan").html('');
                // loadkonsentrasi();
                tampilmakul();
                $("#hasil").html(html);
              }
        });
     }
}
<?php } ?>

function loadsemester()
{
    var konsentrasi_id=$("#konsentrasi").val();
    $.ajax({
    url:"<?php echo base_url();?>matakuliah/tampilsemester",
    data:"konsentrasi=" + konsentrasi_id ,
    success: function(html)
    {
        $("#semester").html(html);
        tampilmakul();
    }
          });
}

function tampilmakul()
{
    var konsentrasi     =$("#konsentrasi").val();
    var semester        =$("#semester").val();
    // var tahun_akademik  =$("#tahun_akademik_id").val();

    $.ajax({
    url:"<?php echo base_url();?>jadwalkuliah/tampiljadwal",
    data:"konsentrasi=" + konsentrasi +"&semester="+semester,
    // +"&tahun_akademik="+tahun_akademik ,
    beforeSend: function() {
        $("#jadwal").html('<h1><b>Proses</b> menampilkan data . . .</h1>');
    },
    success: function(html)
    {
       $("#jadwal").html(html);

    }
          });

}
</script>
<?php
if($this->session->userdata('level')==1 or $this->session->userdata('level') == 6)
{
    $param="";
}
else
{
    $param=array('prodi_id'=>$this->session->userdata('keterangan'));
}
?>
<div class="row">
    <div class="col-md-12">
    <form action="jadwalkuliah/cetak" method="post" target="_blank">
      <table class="table table-bordered">
      <tr>
        <!-- <td>
          Tahun Akademik <?php echo buatcombo('tahun_akademik', 'akademik_tahun_akademik', '', 'keterangan', 'tahun_akademik_id', '', array('id'=>'tahun_akademik_id'))?>
        </td> -->
        <td>
          Program Studi <?php echo buatcombo('prodi', 'akademik_prodi', '', 'nama_prodi', 'prodi_id', $param, array('id'=>'prodi'))?>
        </td>
        <td>
          Konsentrasi <?php echo combodumy('konsentrasi', 'konsentrasi')?>
        </td>
        <td>
          Semester <?php echo combodumy('semester', 'semester')?>
        </td>
      </tr>
      <tr>
        <td colspan="4">
        <?php if ($level!="6"): ?>
          <?php //echo anchor('#example-modal','<span class="fa fa-circle-o-notch"></span> Autosetup',array('class'=>'btn btn-primary btn-sm','data-toggle'=>'modal'));?>
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#example-modal"><span class="fa fa-circle-o-notch"></span> Autosetup</button>
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#example-modal2"><span class="fa fa-plus"></span> Manual Jadwal kuliah</button>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-print"></span> Cetak Data</button>
      <?php //echo anchor('matakuliah/#','<span class="glyphicon glyphicon-print"></span> Cetak Data',array('class'=>'btn btn-primary  btn-sm'));?>
        </td>
      </tr>
      </table>
      <div id="pesan"></div>
        <div id="pesan_manual"> 
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        </div>
      <div id="hasil"></div>

      </form>
    </div>
    <div class="col-md-12">

    </div>
    <div class="col-md-12">
        <div id="pesan"></div>
        <div id="jadwal"></div>
    </div>
</div>



<?php
echo form_open('jadwalkuliah/autosetup');
?>
        <!-- Modal itself -->
        <div id="example-modal" class="modal">
            <!-- Modal Dialog -->
            <div class="modal-dialog">
                <!-- Modal Content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4>Autosetup Jadwal Kuliah</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr><td width="180">Tahun Akademik </td><td><?php echo buatcombo('tahun_akademik', 'akademik_tahun_akademik', '', 'keterangan', 'tahun_akademik_id', '', array('id'=>'tahun_akademik_id'))?></td></tr>

                            <tr><td>Program Studi </td><td><?php echo buatcombo('prodi', 'akademik_prodi', '', 'nama_prodi', 'prodi_id', $param, array('id'=>'prodi2'))?></td></tr>
                            <tr><td>Konsentrasi </td><td><?php echo combodumy('konsentrasi', 'konsentrasi2')?></td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button class="btn btn-danger">Mulai Proses Autosetup</button>
                    </div>
                </div>
                <!-- END Modal Content -->
            </div>
            <!-- END Modal Dialog -->
        </div>
        <!-- END Modal itself -->
 </form>

<form action="<?php echo base_url() ?>jadwalkuliah/simpan_jadwalkuliah_manual" method="post">
    <div id="example-modal2" class="modal">
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4>Form Manual Jadwal Kuliah</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                    <tr>
                        <td>Konsentrasi</td>
                        <td>
                        <?php echo buatcombo('konsentrasi', 'akademik_konsentrasi', '', 'nama_konsentrasi', 'konsentrasi_id', $param, array('id'=>'konsentrasi_manual'))?>
                        </td>
                    </tr>
                        <tr>
                            <td>Semester</td>
                            <td>
                                <select name="semester" class="form-control" id="semester_matkul">
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Matakuliah</td>
                            <td>
                            <select name="matkul_manual" class="form-control select2_multiple" id="matkul_manual">
                                    <option value="0">--Pilih--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Hari</td>
                            <td>
                            <?php echo buatcombo('hari', 'app_hari', '', 'hari', 'hari_id', '', array('id'=>'hari_manual'))?>
                            </td>
                        </tr>
                        <tr>
                            <td>Ruangan</td>
                            <td>
                            <?php echo buatcombo('ruangan', 'app_ruangan', '', 'nama_ruangan', 'ruangan_id', '', array('id'=>'ruangan_manual'))?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jam Mulai</td>
                            <td>
                                <input type="time" name="jam_mulai" id="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Jam Selesai</td>
                            <td>
                                <input type="time" name="jam_selesai" id="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Dosen 1</td>
                            <td>
                            <?php echo buatcombo('dosen1', 'app_dosen', '', 'nama_lengkap', 'dosen_id', '', array('id'=>'dosen1_manual'))?>
                            </td>
                        </tr>
                        <tr>
                            <td>Dosen 2</td>
                            <td>
                            <?php echo buatcombo('dosen2', 'app_dosen', '', 'nama_lengkap', 'dosen_id', '', array('id'=>'dosen2_manual'))?>
                            </td>
                        </tr>
                        <tr>
                            <td>Dosen 3</td>
                            <td>
                            <?php echo buatcombo('dosen3', 'app_dosen', '', 'nama_lengkap', 'dosen_id', '', array('id'=>'dosen3_manual'))?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-danger">Simpan</button>
                </div>
            </div>
            <!-- END Modal Content -->
        </div>
        <!-- END Modal Dialog -->
    </div>
</form>


 <!--
 <table class="table table-borderedb">
     <tr><th>Matakuliah</th><th>Jam Mulai</th><th>Jumlah Jam</th><th>Jam selesai</th></tr>
     <tr><td>Pemograman Web</td>
         <td><?php echo inputan('text', 'nama_ayah','col-sm-6','Nama Ayah ..', 0, '','');?></td>
         <td>4</td>
         <td><?php echo inputan('text', 'nama_ayah','col-sm-6','Nama Ayah ..', 0, '','');?></td></tr>
 </table>END Modal itself -->
