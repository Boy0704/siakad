<?php
$level =$this->session->userdata('level');
if ($level == 1 OR $level ==2) {
    echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-primary btn-sm'));
}

?>
  <table id="datatable" class="table table-striped table-bordered table-hover">
      <thead>
          <tr>
              
              <th width="7" align="center">No</th>
              <th>Username</th>
              <th width="80">Level</th>
              <th width="150">Last Login</th>
              <th width="150">Jam Out</th>
              <th>Keterangan</th>
              <th width="150">Status</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          
          <?php
          $i=1;
          foreach ($record as $r)
          {
          ?>
          
          <?php echo "<tr id='hide$r->id_users'>"; ?>
              <td align="center"><?php echo $i;?></td>
              <td><?php cetak(strtoupper($r->username));?></a></td>
              <td>
                  <?php
                  if($r->level==1)
                  {
                      cetak("Admin");
                  }
                  elseif($r->level==2)
                  {
                      cetak("Jurusan");
                  }
                  elseif($r->level==3)
                  {
                      cetak("Dosen");
                  }
                  elseif($r->level==4)
                  {
                      cetak("Mahasiswa");
                  }
                  ?>
              </td>
              <td><?php cetak(tgl_indo($r->last_login));?></td>
              <td><?php cetak($r->jam_out);?></td>
              <td><?php cetak(strtoupper(users_keterangan($r->level, $r->keterangan)))?></td>
              <td align="center">
              <?php $status = $r->status == 1? "<span class='label label-success'>Online</span>":"<span class='label label-danger'>Offline</span>"; 
                echo $status;
              ?>
              </td>
              <td width="80" class="text-center">
                  <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->id_users;?>" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit" class="disabled"></i></a>
                      
                    <?php 
                    if ($r->level == 1 && $r->level == 3) {
                      echo ""; 
                    }
                    if($r->level != 1 && $r->level != 3 ){ ?>
                      <a href="javascript:void(0)" onclick="hapus(<?php cetak($r->id_users) ?>)" data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
        
                    <?php
                    }
                    ?>
                  </div>
              </td>
          </tr>
          <?php $i++;}?>
          
          
      </tbody>
  </table>
  <!-- END Datatables -->
  <script>
    function hapus(id){
    
    swal({
      title: 'Yakin Ingin Menghapus ini?',
      text: "jika Mengklik yes data akan terhapus secara permanen dan tidak dapat diurungkan!!!",
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
              url:"<?php echo base_url();?>users/delete",
              data:"id=" + id ,
              success: function(html)
              {
                swal("Deleted","Data Berhasil Di Hapus.", "success");
                $("#hide"+id).hide(300);   
                // $('#datatable').DataTable().ajax.reload( null, false );
              }
          });
       }else {
          swal("Anda Membatalkan! :)","", "info");
        }
    });

    
  }
</script>