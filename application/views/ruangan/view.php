<?php
echo anchor($this->uri->segment(1).'/post',"<i class='fa fa-plus'></i> Tambah Data",array('class'=>'btn btn-primary   btn-sm','title'=>'Tambah Data'))
?>
<a href="<?php echo base_url() ?>feeder/import_kelas_feeder" class="btn btn-info">Import Kelas Feeder</a>
      
<table id="datatable" class="table table-striped table-bordered table-hover nowrap">
    <thead>
        <tr>
            <th width="7">No</th>
            <th>Nama Ruangan</th>
            <th width="200">Kapasitas</th>
            <th width="200">Nama Gedung</th>
            <th>Keterangan</th>
            <th width="90"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        $i=1;
        foreach ($record as $r)
        {
         echo "<tr id='hide".$r->$pk."'>";
        ?>
            <td align="center"><?php echo $i;?></td>
            <td><?php echo strtoupper($r->nama_ruangan);?></td>
            <td><?php echo $r->kapasitas;?> Orang</td>
            <td><?php echo strtoupper($r->nama_gedung);?></td>
            <td><?php echo strtoupper($r->keterangan);?></td>
            <td align="center">
                <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->$pk;?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="javascript:void(0)" onclick="hapus(<?php echo $r->$pk ?>)"  data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </td>
        </tr>
        <?php $i++;}?>
        
        
    </tbody>
</table>
<!-- END Datatables -->
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
              url:"<?php echo base_url();?>ruangan/delete",
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