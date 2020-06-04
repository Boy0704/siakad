<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script>
function hapus(krs_id){

    swal({
      title: 'Batalkan Belanja Matakuliah Ini',
      text: "jika Mengklik yes data anda akan dihapus secara permanen!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!',
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
        var url = "<?php echo base_url('krs/lihat'); ?>";
        if (isConfirm) {
          $.ajax({
              url:"<?php echo base_url();?>krs/delete",
              data:"krs_id=" + krs_id ,
              success: function(html)
              {
                swal("Deleted","Data Berhasil Di Hapus.", "success");
                jumlah_sks();
                $("#krshide"+krs_id).hide(300);
                // loaddata();
                // window.location.href = url;
                // $('#my-grid').DataTable().ajax.reload( null, false );
              }
          });
       }else {
          swal("Dibatalkan! :)","", "info");
        }
    });


  }

function loadtablemapel(id)
{
    var konsentrasi=$("#konsentrasi").val();
    $.ajax({
    url:"<?php echo base_url();?>krs/loadmapel",
    data:"konsentrasi=" + konsentrasi +"&mahasiswa_id="+id,
    success: function(html)
    {
            $("#my-grid").html(html);
    }
    });
}

jumlah_sks();
function jumlah_sks()
{
    $.ajax({
    url:"<?php echo base_url();?>krs/jumlah_sks",
    data:"oke=sip",
    success: function(html)
    {
        $("#jumlah_sks").html(html);
    }
    });
}
</script>

<div class="row">
  <div class="col-sm-12">
        <table class='table table-bordered'>
             <?php
                    $id   = $this->session->userdata('keterangan');
                    $d    = $this->db->query($mhs)->row();
                    $nim  =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
                    $krs  =   "SELECT ak.krs_id,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,jk.hari_id,jk.jam_mulai,jk.jam_selesai
                                FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                                WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and jk.tahun_akademik_id='$thn' and ak.nim='$nim' and ak.semester='".$d->semester_aktif."'";
                    $data =  $this->db->query($krs);
                    // log_r($this->db->last_query());

                ?>
            <?php
                if ($d->semester_aktif !=0) {
                    ?>
            <tr>
                <td colspan=6>

                     <a href="<?php echo base_url('krs/belanjaMatakuliah') ?>" class="btn btn-primary btn-sm"><i class='fa fa-shopping-cart'></i> Input KRS</a>
                    <?php  echo anchor('cetak/cetakkrs/'.$d->nim.'/'.$semester_aktif,'<i class="fa fa-print"></i> Cetak KRS',array('class'=>'btn btn-default btn-sm','target'=>'_blank'));
                    ?>

                </td>
            </tr>
                    <?php
                }
            ?>
            <tr>
                <td width='150'>NAMA</td><td><?php echo strtoupper($d->nama); ?></td>
                <td width=100>NIM</td><td><?php echo strtoupper($d->nim)?></td><td rowspan='2' width='70'><img width='50' src=<?php echo base_url()."assets/images/avatar.png"?> ></td>
            </tr>
            <tr>
                <td>Jurusan / Prodi</td><td><?php echo strtoupper($d->nama_prodi.' / '.$d->nama_konsentrasi); ?></td>
                <td>SEMESTER</td><td><?php echo $d->semester_aktif; ?> </td>
            </tr>
        </table>
        <?php
        $max_sks = $this->Import_mhs->cek_sks_old($d->nim,$d->semester_aktif);
        ?>
        <table id="my-grid" class='table table-bordered'>
            <tr class='alert-info'><th width='5'>No</th>
                <th width='80'>KODE</th>
                <th>NAMA MATAKULIAH</th>
                <th width=10>SKS</th>
                <th width=20>HARI</th>
                <th width=20>JAM</th>
                <th>DOSEN PENGAPU</th>
                <th width='10'>Hapus</th>
            </tr>
            <?php

                $sks=0;
                if($data->num_rows()<1)
                {
                    echo "<tr><td colspan=6 align='center' class='warning'>DATA KRS TIDAK DITEMUKAN</td></tr>";
                }
                else
                {
                    $no=1;

                    foreach ($data->result() as $r)
                    {
                        echo "<tr id='krshide$r->krs_id'>
                            <td align='center'>$no</td>
                            <td align='center'>".  strtoupper($r->kode_makul)."</td>
                            <td>".  strtoupper($r->nama_makul)."</td>
                            <td align='center'>".  $r->sks."</td>
                            <td align='center'>".  get_data('app_hari','hari_id',$r->hari_id,'hari') ."</td>
                            <td align='center'>". $r->jam_mulai." - ".$r->jam_selesai ."</td>
                             <td>".  strtoupper($r->nama_lengkap)."</td>
                            <td align='center'><a href='javascript:void(0)' class='btn btn-sm btn-danger fa fa-trash-o' title='Batal Ambil Matakuliah' onclick='hapus($r->krs_id)'></a></td>
                            </tr>";
                        $no++;
                        $sks=$sks+$r->sks;
                    }
                }
            if ($sks>$max_sks) { ?>
                <script>
                    alert("INFO: SKS Lebih Dari <?php echo "$max_sks"; ?> SKS !! Silahkan Di kurangi");
                </script>
            <?php
            }?>
            <tr><td colspan='3' align='right'>Total SKS</td><td align='center'><?php //if($sks>$max_sks){echo $sks;}else{echo "<b id='jumlah_sks'></b>";} ?><b id='jumlah_sks'></b></td><td colspan=4></td></tr>

        </table>

  </div>
</div>
