<?php
echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-primary btn-sm'))
?>
<table id="datatable" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th class="cell-small text-center hidden-xs hidden-sm">Nomor</th>
            <th>Nama Submenu</th>
            <th class="hidden-xs hidden-sm hidden-md"> Nama Mainmenu</th>
            <th>Level</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        
        <?php
        $i=1;
        foreach ($record as $r)
        {
        ?>
        
        <tr>
            <td width="100" class="text-center">
                <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->id_submenu;?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" onclick="hapus(<?php echo $r->id_submenu ?>)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                    <?php
                    if($r->aktif=='y')
                    {
                        // disabled
                        $link="/status/n/";
                        $icon="<span class='fa fa-eye-slash'></span>";
                        $title="Jangan Aktifkan";   
                    }
                    else
                    {
                        $link="/status/y/";
                        $icon="<span class='fa fa-eye'></span>";
                        $title="Aktifkan";
                    }
                    ?>
                    <a href="<?php echo base_url().''.$this->uri->segment(1).$link.$r->id_submenu;?>" data-toggle="tooltip" title="<?php echo $title;?>" class="btn btn-xs btn-info"><?php echo $icon;?></a>
                </div>
            </td>
            <td class="text-center hidden-xs hidden-sm"><?php echo $i;?></td>
            <td><?php echo anchor($r->link,strtoupper($r->nama_submenu));?></a></td>
            <td><?php echo strtoupper($r->nama_submenu);?></td>
            <td></td>
            <td align="center">
                <?php
                $status = $r->aktif=='y'?'Aktif':'Tidak';
                if ($r->aktif == 'y') 
                {
                    echo "<span class='label label-success'>".$status."</span>";
                } 
                else
                {
                    echo "<span class='label label-danger'>".$status."</span>";
                }

                ?>
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
              url:"<?php echo base_url();?>submenu/delete",
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