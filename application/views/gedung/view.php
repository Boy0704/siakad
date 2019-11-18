<!-- END Breadcumbs -->
<?php
echo anchor($this->uri->segment(1).'/post',"<i class='fa fa-building-o'></i> New Record",array('class'=>'btn btn-primary  btn-sm','title'=>'Tambah Data'))
?>                    
<table id="datatable" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="7">No</th>
            <th>Nama Gedung</th>
            <th>Opsi</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        $no=1;
        foreach ($record as $r)
        {
            
            echo "<tr id='hide".$r->$pk."'>";
            ?>
            
                <td align="center"><?php echo $no++?></td>
                <td><?php echo strtoupper($r->nama_gedung)?></td>
                <td class="text-center">
                <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->$pk;?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="javascript:void(0)" onclick="hapus(<?php echo $r->$pk ?>)"  data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </td>
                </tr>
        <?php
        }
        ?>

    </tbody>
</table>
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script>
    function hapus(id){
    
    swal({
      title: 'Yakin.. Ingin Dilanjutkan?',
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
              url:"<?php echo base_url();?>gedung/delete",
              data:"id=" + id ,
              success: function(html)
              {
                swal("Deleted","Data Berhasil Di Hapus.", "success");
                $("#hide"+id).hide(300);   
                // $('#my-grid').DataTable().ajax.reload( null, false );
              }
          });
       }else {
          swal("Anda Membatalkan! :)", "","info");
        }
    });

    
  }
</script>