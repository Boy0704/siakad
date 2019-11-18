<?php
$level = $this->session->userdata('level');
echo anchor($this->uri->segment(1).'/post',"<i class='fa fa-plus'></i> New Record",array('class'=>'btn btn-primary  btn-sm','title'=>'Tambah Data'))
?>                    
<table id="datatable" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="7">No</th>
            <th>Grade</th>
            <th>Dari</th>
            <th>Sampai</th>
            <th>Mutu</th>
            <th>Keterangan</th>
            <th width="90"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no=1;
        foreach ($record as $r)
        {
            echo "<tr id='hide".$r->$pk."'>
                <td align='center'>$no</td>
                <td width='20'>".  strtoupper($r->grade)."</td>
                <td width='20'>$r->dari</td>
                <td width='20'>$r->sampai</td>
                <td width='20'>$r->mutu</td>
                <td>".strtoupper($r->keterangan)."</td>
                <td align='center'>";
                 ?>
                    <?php if ($level== 1 OR $level==2): ?>
                        <div class="btn-group">
                        <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->$pk;?>" data-toggle="tooltip" data-placement='bottom' title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                       <a href='javascript:void(0)' onclick='hapus(<?php echo $r->$pk  ?>)' data-toggle='tooltip' data-placement='bottom' title='Delete' class='btn btn-sm btn-danger'><span class='glyphicon glyphicon-trash'></span></a>
                    </div>
                    <?php endif ?>
                <?php
                echo "</td>
                </tr>";
            $no++;
        }
        ?>

    </tbody>
</table>
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
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
              url:"<?php echo base_url();?>grade/delete",
              data:"id=" + id ,
              success: function(html)
              {
                swal("Deleted","Data Berhasil Di Hapus.", "success");
                $("#hide"+id).hide(300);   
                // loadmahasiswa();
              }
          });
       }else {
          swal("Anda Membatalkan! :)", "","info");
        }
    });

    
  }

</script>