<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    loaddata_khs();
});
function loaddata_khs()
{
   var s1 = $("#sel_semester1").val();
   var s2 = $("#sel_semester2").val();
   var v_cetak = $("#v_cetak");
   v_cetak.show();
   if (s1 > s2) {
     $("#semester").html('-');
     v_cetak.hide();
   }else if (s1 == s2) {
     $("#semester").html(s1);
   }else {
     $("#semester").html(s1+' - '+s2);
   }
   $.ajax({
    url:"<?php echo base_url();?>khs/loaddata_khs",
    data:"id_mahasiswa=<?php echo $d['mahasiswa_id']; ?>&semester=<?php echo $d['semester_aktif']; ?>&s1="+s1+"&s2="+s2,
    beforeSend:function()
    {
       $("#v_khs").html("Memuat data KHS . . .");
    },
    success: function(html)
    {
       $("#v_khs").html(html);
    }
  });
}

function khs_cetak()
{
  var s1 = $("#sel_semester1").val();
  var s2 = $("#sel_semester2").val();

  var url = "<?php echo base_url();?>khs/cetak_khs/<?php echo $d['mahasiswa_id']; ?>/<?php echo $d['semester_aktif']; ?>/"+s1+"/"+s2;
  window.open(url, '_blank');
  // alert(url);
}
</script>

<?php
$id       =  $this->session->userdata('keterangan');
$semester =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
?>
<div class="row">
  <div class="col-sm-12">
      <table class='table table-bordered'>
         <tr>
            <td colspan=5>
              <label class="col-md-1" style="margin-top:10px;">SEMESTER</label>
              <div class="col-md-1">
                <select class="form-control" id="sel_semester1" onchange="loaddata_khs()">
                  <?php
                  for ($i=1; $i <=8 ; $i++) {?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <label class="col-md-1" style="margin-top:10px;">SAMPAI</label>
              <div class="col-md-1">
                <select class="form-control" id="sel_semester2" onchange="loaddata_khs()">
                  <?php
                  for ($i=1; $i <=8 ; $i++) {?>
                    <option value="<?php echo $i; ?>" <?php if($i==$semester){echo "selected";} ?>><?php echo $i; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>

              <a href="javascript:void(0);" onclick="khs_cetak()" class="btn btn-primary" id="v_cetak" style="float:right"><i class="fa fa-print"></i> Cetak KHS</a>

            </tr>
        <tr>
            <td width='150'>NAMA</td><td><?php echo strtoupper($d['nama']); ?></td>
            <td width=100>NIM</td><td><?php echo strtoupper($d['nim']);?></td>
            <td rowspan='2' width='70'><img src=<?php echo base_url()."assets/images/avatar.png" ?> width='50'></td>
        </tr>
        <tr>
            <td>Jurusan, Prodi</td><td><?php echo strtoupper($d['nama_prodi'].' / '.$d['nama_konsentrasi']); ?></td>
            <td>Semester</td><td> <label id="semester">-</label> </td>
        </tr>
        </table>

        <div id="v_khs"></div>

  </div>
