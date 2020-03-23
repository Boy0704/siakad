<script src="<?php echo base_url()?>assets/js/jquery.min.js">
</script>

<script>
$(document).ready(function(){
          loadjurusan();
          tampilkan_semester();

  });
</script>
<script>
  $(document).ready(function(){
  $("#list").change(function(){
      loaddata();
  });
});
    $(document).ready(function(){
  $("#list").change(function(){
      tampilkan_semester();
  });
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
  $("#semester").change(function(){
      var mahasiswa=$("#list").val();
      var semester=$("#semester").val();
      loaddata(mahasiswa,semester);
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
    url:"<?php echo base_url();?>khs/tampilkanmahasiswa",
    data:"konsentrasi=" + konsentrasi + "&tahun_angkatan=" + tahun_angkatan ,
    success: function(html)
       {
          $("#list").html(html);
          // loaddata();
          tampilkan_semester();
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
function loaddata(mahasiswa_id,semester)
{
   var mahasiswa_id=$("#list").val();
  // var semester=$("#semester").val();
        $.ajax({
	url:"<?php echo base_url();?>khs/loaddata",
	data:"id_mahasiswa=" + mahasiswa_id+"&semester="+semester ,
	success: function(html)
	{
            //tampilkan_semester(mahasiswa_id);
            $("#daftarkrs").html(html);
	}
	});
}

function print(id)
{
    alert('do print');
}
function tampilkan_semester(id)
{
  var id=$("#list").val();
    $.ajax({
	url:"<?php echo base_url();?>khs/semester_mhs",
	data:"id_mahasiswa=" + id ,
	success: function(html)
	{
            $("#semester").html(html);
            var semester=$("#semester").val();
            loaddata(semester);
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
            $("#hide"+jadwal_id).hide(300);
	}
	});

}

function ambilkrs(krs_id)
{
        var mahasiswa=$("#list").val();
        var semester=$("#semester").val();
        $.ajax({
        url:"<?php echo base_url();?>khs/konfirm",
        data:"krs_id=" + khs_id ,
        success: function(html)
        {
            loaddata(mahasiswa,semester);
        }
        });
}


function konfirm(khs_id)
{
        var mahasiswa=$("#list").val();
        var semester=$("#semester").val();
        $.ajax({
      	url:"<?php echo base_url();?>khs/konfirm",
      	data:"khs_id=" + khs_id ,
      	success: function(html)
      	{
            loaddata(mahasiswa,semester);
      	}
      	});
}

function khs_export()
{
  var prodi          = $("#prodi").val();
  var konsentrasi    = $("#konsentrasi").val();
  var tahun_angkatan = $("#tahun_angkatan").val();
  var list           = $("#list").val();
  var semester       = $("#semester").val();
  // var url = prodi+konsentrasi+tahun_angkatan+list;
  if (prodi=='') { prodi=0;}
  if (konsentrasi=='') { konsentrasi=0;}
  if (list=='') { list=0;}
  if (tahun_angkatan=='') { tahun_angkatan=0;}
  if (semester=='') { semester=0;}

  var url = "khs/export/"+prodi+"/"+konsentrasi+"/"+tahun_angkatan+"/"+list+"/"+semester;
  window.open(url, '_blank');
  // alert(url);
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
  <div class="col-sm-12">
    <?php if ($this->session->userdata('level')!='6'): ?>
    <!-- <a href="khs/form_import" class="btn btn-primary" >Import KHS</a>
    <?php endif; ?>
    <a href="javascript:void(0);" onclick="khs_export()" class="btn btn-primary">Export KHS</a> -->
    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#example-modal2">Input KRS Manual</a>
    <a id="btn_import" class="btn btn-primary">Import KHS EXCEL</a>
    <a href="<?php echo base_url() ?>feeder/import_khs_feeder" target="_blank" class="btn btn-primary">Import Feeder KHS</a>
    
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
                <div class="col-md-14">
                    <select class="form-control select2" id="tahun_angkatan">
                      <?php
                      foreach ($tahun_angkatan as $ta) {
                          echo "<option value='$ta->angkatan_id'>$ta->keterangan</option>";
                      }
                      ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
          <td>
              <select id="list" name="example-select" class="form-control select2" ></select>
          </td>
        </tr>
        <tr><td><?php echo combodumy('semester', 'semester')?></td></tr>
      </table>
  </div>

  <div class="col-sm-9">
      <div id="daftarkrs"></div>
  </div>



<form action="<?php echo base_url() ?>khs/simpan_krs_manual" method="post">
    <div id="example-modal2" class="modal">
        <!-- Modal Dialog -->
        <div class="modal-dialog">
            <!-- Modal Content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4>Form Manual KRS</h4>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered">
                    <tr>
                        <td>Nim/Nama</td>
                        <td>
                          <select name="nim_mhs" class="form-control select2" id="nim_mhs" style="width: 100%" required="">
                              <option value="">--pilih nim/nama--</option>
                              <?php 
                              foreach ($this->db->get('student_mahasiswa')->result() as $mhs) {
                               ?>
                              <option value="<?php echo $mhs->nim ?>"><?php echo $mhs->nim.' '.$mhs->nama ?></option>
                              <?php } ?>
                          </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>
                            <select name="semester" class="form-control select2" id="semester_matkul" style="width: 100%" required="">
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

                        <!-- <select name="jadwal_id" class="form-control select2" id="jadwal_id" style="width: 100%" required="">
                            <option value="0">--Pilih KD/MK--</option>
                            <?php 
                            $sql = $this->db->query("
                              SELECT ajk.jadwal_id, mm.nama_makul, mm.kode_makul FROM akademik_jadwal_kuliah as ajk,
                              makul_matakuliah as mm 
                              where ajk.makul_id=mm.makul_id
                              ");
                            foreach ($sql->result() as $mkl) {
                             ?>
                            <option value="<?php echo $mkl->jadwal_id ?>"><?php echo $mkl->kode_makul.' '.$mkl->nama_makul ?></option>
                            <?php } ?>
                        </select> -->

                        <select name="jadwal_id" class="form-control select2" style="width: 100%">
                          <option value="0">--Pilih KD/MK--</option>
                          <?php
                          $sql = $this->db->query("
                              SELECT ajk.jadwal_id, mm.nama_makul, mm.kode_makul, mm.semester FROM akademik_jadwal_kuliah as ajk,
                              makul_matakuliah as mm 
                              where ajk.makul_id=mm.makul_id ORDER BY semester ASC
                              ");
                          $currSemester = "";
                          $endLabel = FALSE;
                          foreach($sql->result_array() as $item) :
                              if ($item['semester'] != $currSemester)
                              {
                                  if ($endLabel)
                                  {
                                      // echo ending label here
                                      echo '</optgroup>';
                                  }
                                  // echo label...
                                  echo '<optgroup label="Semester ' . $item['semester'] . '">';
                                  $currSemester = $item['semester'];
                                  $endLabel = true;
                              }
                          ?>
                          <option value="<?php echo $item['jadwal_id']?>" <?php if($this->input->get_post('jadwal_id') == $item['jadwal_id']) echo 'selected' ?>><?php echo $item['kode_makul'].' '.$item['nama_makul']?></option>
                          <?php
                          if ($endLabel)
                          {
                              // echo ending label here
                              echo '</optgroup>';
                          }
                          endforeach;
                          ?>
                      </select>

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


</div>

<script type="text/javascript">
  $(document).ready(function() {
    
    $('#btn_import').click(function(event) {
    
      window.open('<?php echo base_url() ?>manual/import_khs/', '_blank', 'location=yes,height=570,width=800,scrollbars=yes,status=yes');
    });

  });
</script>
