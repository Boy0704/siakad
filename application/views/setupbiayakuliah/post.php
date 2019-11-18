<script src="<?php echo base_url();?>assets/js/1.8.2.min.js"></script>  
<script>
 
  $( document ).ready(function() {
      loaddata();
  });
  </script>
 
  <script type="text/javascript">
$(document).ready(function(){
  $("#konsentrasi").change(function(){
      loaddata();
      
  });
});
</script>
  
 <script type="text/javascript">
 
 function simpan(id)
 {
     var jumlah=$("#jumlah"+id).val();
     $.ajax({
        url:"<?php echo base_url();?>setupbiayakuliah/simpan",
        data:"jumlah=" + jumlah + "&id=" + id  ,
                success: function(html)
                {
                    //loaddata();
                }
            });
 }
 
 function loaddata()
 {
     var konsentrasi=$("#konsentrasi").val();
     $.ajax({
        url:"<?php echo base_url();?>setupbiayakuliah/loadform",
        data:"konsentrasi=" + konsentrasi  ,
                success: function(html)
                {
                    $("#table").html(html);
                }
            });
 }
 </script>
 
 
<div class="col-sm-3">
    <table class="table table-bordered">
        <tr class="alert-info"><th>Pilih Konsentrasi</th></tr>
        <tr><td><input  type="text" value="<?php echo $tahun_ajrn['keterangan'];?>" class="form-control" disabled=""></td></tr>
        <tr><td>
            <div class="col-sm-13">
                <select id="konsentrasi" class="form-control">
                <?php
                foreach ($konsentrasi as $k)
                {
                    echo "<option value='$k->konsentrasi_id'>".strtoupper($k->nama_konsentrasi)."</option>";
                }
                ?>
            </select>
            </div>
            </td></tr>
        <tr><td><?php echo anchor('setupbiayakuliah','Kembali',array('class'=>'btn btn-primary'))?></td></tr>
    </table>
</div>

<div class="col-md-9">
    <table class="table table-bordered" id="table"></table>
</div>