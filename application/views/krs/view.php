
 <?php
$level = $this->session->userdata('level');
if ($level == 1 or $level==2 or $level==3): ?>
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
  $("#list").change(function(){
      loaddata();
  });
});

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

<script>
$(document).ready(function(){
  $("#input").click(function(){
      loadtablemapel();
  });
});
</script>

<script type="text/javascript">
function loadmahasiswa()
{
    var konsentrasi=$("#konsentrasi").val();
    var tahun_angkatan=$("#tahun_angkatan").val();
    $.ajax({
    url:"<?php echo base_url();?>krs/tampilkanmahasiswa",
    data:"konsentrasi=" + konsentrasi + "&tahun_angkatan=" + tahun_angkatan ,
    success: function(html)
       {
          $("#list").html(html);
          loaddata();
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
function loaddata(mahasiswa_id)
{
  var mahasiswa_id=$("#list").val();
  $.ajax({
	url:"<?php echo base_url();?>krs/loaddata",
	data:"id_mahasiswa=" + mahasiswa_id ,
	success: function(html)
	{
          $("#daftarkrs").html(html);
	}
	});
}


function loadtablemapel(id)
{
    var konsentrasi=$("#konsentrasi").val();
    $.ajax({
  	url:"<?php echo base_url();?>krs/loadmapel",
  	data:"konsentrasi=" + konsentrasi +"&mahasiswa_id="+id,
  	success: function(html)
  	{
              $("#daftarkrs").html(html);
  	}
	});
}


function ambil(jadwal_id,mahasiswa_id)
{
  $.ajax({
	url:"<?php echo base_url();?>krs/post",
	data:"jadwal_id=" + jadwal_id+"&mahasiswa_id="+mahasiswa_id ,
	success: function(html)
	{
      // $('#ambil').html(html.sks);
      $("#hide"+jadwal_id).hide(300);
	}
	});

}

function hapus(krs_id){

    swal({
      title: 'Yakin.. Data Akan dihapus?',
      text: "jika Mengklik yes data anda akan dihapus secara permanen!",
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
              url:"<?php echo base_url();?>krs/delete",
              data:"krs_id=" + krs_id ,
              success: function(html)
              {
                swal("Deleted","Data Berhasil Di Hapus.", "success");
                $("#krshide"+krs_id).hide(300);
                loaddata();
                // $('#my-grid').DataTable().ajax.reload( null, false );
              }
          });
       }else {
          swal("Anda Membatalkan! :)","", "info");
        }
    });


  }

  function krs_export()
  {
    var prodi          = $("#prodi").val();
    var konsentrasi    = $("#konsentrasi").val();
    var tahun_angkatan = $("#tahun_angkatan").val();
    var list           = $("#list").val();
    // var url = prodi+konsentrasi+tahun_angkatan+list;
    if (prodi=='') { prodi=0;}
    if (konsentrasi=='') { konsentrasi=0;}
    if (list=='') { list=0;}
    if (tahun_angkatan=='') { tahun_angkatan=0;}

    var url = "export/"+prodi+"/"+konsentrasi+"/"+tahun_angkatan+"/"+list;
    window.open(url, '_blank');
    // alert(url);
  }

</script>
<?php
if($level==1)
{
    $param="";
}
else
{
    $param=array('prodi_id'=>$this->session->userdata('keterangan'));
}
?>
<div class="row">
  <div class="col-sm-12">
    <!-- <a href="krs/form_import" class="btn btn-primary" >Import KRS</a>
    <a href="javascript:void(0);" onclick="krs_export()" class="btn btn-primary">Export KRS</a> -->
  </div>

    <div class="col-sm-3">
    <table class="table table-bordered">
    <tr>
      <td>Jurusan<?php echo buatcombo('prodi', 'akademik_prodi', '', 'nama_prodi', 'prodi_id', $param, array('id'=>'prodi'))?>

      </td>
    </tr>
    <tr><td>Prodi<?php echo combodumy('konsentrasi', 'konsentrasi')?></td></tr>
    <tr>
      <td>Tahun Angkatan
        <?php echo buatcombo('tahun_angkatan', 'student_angkatan', '', 'keterangan', 'angkatan_id', '', array('id'=>'tahun_angkatan'))?>
      </td>
    </tr>
    <tr>
      <td>
        <select id="list" name="example-select" class="form-control select2"></select>
      </td>
    </tr>
    </table>
  </div>


  <div class="col-sm-9">
      <div id="daftarkrs"></div>
  </div>
</div>
<?php else: ?>

 <?php endif ?>
