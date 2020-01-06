<?php
  $level = $this->session->userdata('level');
  if (!$level == 3) {
    echo "<script>alert('anda tidak punya akses dihalaman ini')</script>";
    redirect(base_url());
  }
?>

 <script src="<?php echo base_url()?>assets/js/jquery.min.js">
</script>
<script>
$(document).ready(function(){
          loadmahasiswa();
  });

  function simpan(id)
  {
      var nilai=$("#ambil"+id).val();
      $.ajax({
      url:"<?php echo base_url();?>khs/simpan_nilai",
      data:"id=" + id+"&nilai="+nilai ,
      success: function(html)
       {
           loadmahasiswa();
           //alert(id);
       }
       });
  }

  function simpangrade(id)
  {
      var nilai=$("#ambilgrade"+id).val();
      $.ajax({
      url:"<?php echo base_url();?>khs/simpan_grade",
      data:"id=" + id+"&nilai="+nilai ,
      success: function(html)
       {
           loadmahasiswa();
           //alert(id);
       }
       });
  }


  function simpankehadiran(id)
  {
      var nilai=$("#ambilkehadiran"+id).val();
      $.ajax({
      url:"<?php echo base_url();?>khs/simpan_kehadiran",
      data:"id=" + id+"&nilai="+nilai ,
      success: function(html)
       {
           loadmahasiswa();
           //alert(id);
       }
       });
  }

  function simpantugas(id)
  {
      var nilai=$("#ambiltugas"+id).val();
      $.ajax({
      url:"<?php echo base_url();?>khs/simpan_tugas",
      data:"id=" + id+"&nilai="+nilai ,
      success: function(html)
       {
           loadmahasiswa();
           //alert(id);
       }
       });
  }

  function simpannilai(id)
  {
      var nilai=$("#ambilnilai"+id).val();
      $.ajax({
      url:"<?php echo base_url();?>khs/simpan_nilai_akhir",
      data:"id=" + id+"&nilai="+nilai ,
 		  dataType: "JSON",
      beforeSend:function()
 		 {
 				$("#pesan").html("Loading...");
 		 },
      success: function(data)
       {
           // loadmahasiswa();
           //alert(id);
           $("#mutu_"+data.id).html(data.mutu);
           $("#grade_"+data.id).html(data.grade);
           $("#pesan").html("");
           swal("Nilai Behasil disimpan !", "ok!", "success");
       }
     });
  }

  function loadmahasiswa()
  {
      var jadwal_id=$("#jadwal").val();
      $.ajax({
      url:"<?php echo base_url();?>khs/form_berinilai",
      data:"jadwal_id=" + jadwal_id ,
      success: function(html)
       {
          $("#mahasiswa").html(html);
       }
       });
  }
</script>
<script>
$(document).ready(function(){
  $("#jadwal").change(function(){
      loadmahasiswa();
  });
});
</script>
<div class="row">
    <div class="col-md-3">
      <table class="table table-bordered">
          <tr class="alert-info"><th>Kelas Ajar</th></tr>
          <tr><th>Tahun Akademik <?php echo get_tahun_ajaran_aktif('keterangan')?></th></tr>
          <td>
              <div class="col-md-14">
                  <select id="jadwal" class="form-control">
                      <?php
                      foreach ($kelas as $k)
                      {
                          echo "<option value='$k->jadwal_id'>".  strtoupper($k->nama_makul)."</option>";
                      }
                      ?>
                  </select>
              </div>
          </td>
      </table>
      <div id="pesan"></div>
      <div id="hasil"></div>
  </div>
  <div class="col-md-9">
      <div id="mahasiswa"></div>
  </div>
</div>
