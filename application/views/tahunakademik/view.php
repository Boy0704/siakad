<?php
echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-primary btn-sm'))
?>
<table id="datatable" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th width="7">No</th>
            <th>Tahun Akademik</th>
            <th>Keterangan</th>
            <th>Batas Registrasi</th>
            <th>Status</th>
            <th width="80"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        $i=1;
        foreach ($record as $r)
        {
        ?>
        
        <tr id="<?php echo 'hide'.$r->$pk; ?>">
          <td><?php echo $i;?></td>
            <td><?php echo strtoupper($r->keterangan);?></td>
            <td>SEMESTER <?php echo substr($r->keterangan,4,1)==1?'GANJIL':'GENAP';?></td>
            <td><?php echo tgl_indo($r->batas_registrasi);?></td>
            <td align="center">
            <?php if($r->status=='y'): ?>
    <span class="label label-success"><?php echo $r->status=='y'?'OPEN':'CLOSED'?></span>
                <?php else: ?>
    <span class="label label-danger"><?php echo $r->status=='y'?'OPEN':'CLOSED'?></span>
            <?php endif ?>
            </td>
            <td class="text-center">
                <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->tahun_akademik_id;?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="javascript:void(0)" onclick="hapus(<?php echo $r->$pk; ?>)" data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
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
              url:"<?php echo base_url();?>tahunakademik/delete",
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
