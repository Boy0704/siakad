<?php
$level =$this->session->userdata('level');
if ($level == 1 OR $level ==2) {
    echo anchor($this->uri->segment(1).'/post','<span class="fa fa-plus"></span> Tambah Data',array('class'=>'btn btn-primary btn-sm'));
}
?>

<?php if ($level == 1 or $level==2 or $level==6): ?>
<div class="col-sm-12 row">
<table id="datatable" class="table table-striped table-bordered table-hover nowrap">
    <thead>
        <tr>
            <th>No</th>
            <th>NIDN</th>
            <th>NIP</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Handphone</th>
            <th>Jurusan</th>
             <?php if ($level == 1 OR $level==2): ?>
            <th>Opsi</th>
            <?php endif ?>
        </tr>
    </thead>
    <tbody>

        <?php
        $i=1;
        foreach ($record as $r)
        {
        ?>

        <?php echo "<tr id='hide$r->dosen_id'>"; ?>
            <td align="center"><?php echo $i++;?></td>
            <td><?php cetak(strtoupper($r->nidn));?></a></td>
            <td><?php cetak(strtoupper($r->nip));?></a></td>
            <td><?php cetak(strtoupper($r->nama_lengkap));?></td>
            <td><?php cetak($r->email);?></td>
            <td><?php echo $r->hp;?></td>
            <td><?php cetak(strtoupper($r->nama_konsentrasi));?></td>
            <?php if ($level == 1 OR $level==2): ?>
                 <td class="text-center">
                <div class="btn-group">
                    <a href="<?php echo base_url().''.$this->uri->segment(1).'/edit/'.$r->dosen_id;?>" data-toggle="tooltip" title="Edit"  class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="#" onclick="hapus(<?php echo $r->dosen_id ?>)" data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </td>
            <?php endif ?>

        </tr>
        <?php } ?>


    </tbody>
</table>
</div>
<!-- END Datatables -->
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script>
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
              url:"<?php echo base_url();?>dosen/delete",
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
<?php else: ?>
<div class="row">
    <div class="col-lg-12">

        <legend><code><?php echo ucwords('jika data anda ada yang salah/keliru segera menghadap pada bagian akademik'); ?></code></legend>
        <div class="row">
           <div class="col-lg-3">
              <div class="list-group">
              <span class="list-group-item">
              <?php if (!empty($record->foto)): ?>
                <img src="<?php echo base_url('uploads/'.$record->foto) ?>" alt="" style="width: 200px;height: 230px;">
                <?php else: ?>
                <img src="<?php echo base_url('images/user.png') ?>" alt="" style="width: 200px;height: 230px;">
                <?php endif ?>
              </span>
              </div>
            </div>

           <div class="col-md-8">
             <table id="example" class="table" >
             <tr>
                <td>
                  <div style="color:black;" class="col-md-9">
                                <span class="col-md-3" for="name">Nip</span>
                                <span class=" col-md-2 ">:</span>
                                <div class="col-md-6">
                                <span><?php echo $record->nip; ?></span><br>
                                </div>
                  </div>
               </td>
              </tr>
                 <tr>
                <td>
                   <div style="color:black;" class="col-md-9">
                                <span class="control-span col-md-3 " for="name">Nama</span>
                                <span class=" col-md-2 ">:</span>
                                <div class="col-md-6">
                                <span><?php echo strtoupper($record->nama_lengkap); ?></span>
                                </div>
                  </div> </td>
              </tr>
              <tr>
                <td>
                   <div style="color:black;" class="col-md-9">
                                <span class="control-span col-md-3 " for="name">No.Telp</span>
                                <span class=" col-md-2 ">:</span>
                                <div class="col-md-6">
                                <span><?php echo strtoupper($record->hp); ?></span>
                                </div>
                  </div> </td>
              </tr>
              <tr>
                <td>
                   <div style="color:black;" class="col-md-9">
                                <span class="control-span col-md-3 " for="name">Email</span>
                                <span class=" col-md-2 ">:</span>
                                <div class="col-md-6">
                                <span><?php echo strtoupper($record->email); ?></span>
                                </div>
                  </div> </td>
              </tr>
               <tr>
                <td>
                   <div style="color:black;" class="col-md-9">
                                <span class="control-span col-md-3 " for="name">Nama Prodi</span>
                                <span class=" col-md-2 ">:</span>
                                <div class="col-md-6">
                                <span><?php echo strtoupper($record->nama_prodi); ?></span>
                                </div>
                  </div> </td>
              </tr>


                <tr>
                    <td>
                      <div class="row">
                          <div class="text-right">
                            <a class="btn btn-warning" href="<?php echo base_url(); ?>"><i class="fa fa-arrow-left"></i> Kembali</a><br/>
                          </div>
                      </div>
                    </td>
                </tr>
              </table>
            </div>

        </div>

    </div>




    </div>

<?php endif ?>
