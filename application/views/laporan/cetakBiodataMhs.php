<link href="<?php echo base_url() ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- <body onload="window.print()">
    
</body> -->

<table border="1" width="100%" height="50">
  <tr>
    <td width="8%" rowspan="2"><img style="padding: 8px; width: 95px; height:80px;" src="<?php echo base_url() ?>images/logo/logouit.gif" alt="" ></td>
    <td width="92%" height="25" style="font-size: 25px; text-align: center;"><b>BIODATA MAHASISWA </b></td>
  </tr>
  <tr>
    <td width="90%" height="25" style="font-size: 25px; text-align: center;"><b>FAKULTAS ILMU KOMPUTER</b></td>
  </tr>
</table>
<br>

<br>
   <table id="example" class="table">
                                <tr>
                                <td width="150">Nim</td>
                                <td>:</td>
                                <td><?php echo $record->nim; ?></td>
                                <td rowspan="10" style="height: 150px;width: 250px;">
                                      <div class="profile_img">
                                        <div id="crop-avatar">
                                          <!-- Current avatar -->
                                          <?php if (!empty($record->foto)) { ?>
                                            <img class="img-responsive avatar-view" src="<?php echo base_url('uploads/'.$record->foto); ?>" alt="Avatar" title="Change the avatar">
                                         <?php }else{ ?>
                                            <img class="img-responsive avatar-view" src="<?php echo base_url('images/user.png'); ?>" alt="Avatar" title="Change the avatar">
                                           <?php } ?>
                                          
                                        </div>
                                       </div>
                                </td>
                                </tr>
                                <tr>
                                    <td width="150">Nama</td>
                                    <td width="50">:</td>
                                    <td width="550"></i> <?php echo ucwords($record->nama); ?>
                                  </td>
                                </tr>
                                <tr>
                                    <td>Angkatan</td>
                                     <td width="50">:</td>
                                      <?php foreach ($angkatan as $k) {

                                          if ($k->angkatan_id == $record->angkatan_id) {
                                              echo "<td>".$k->name_angkatan."</td>";
                                          }

                                        } ?> 

                                </tr>
                                 <tr>
                                    <td>Semester</td>
                                     <td width="50">:</td>
                                     <?php foreach ($semester as $s) {
                                        if ($s->semester_id == $record->semester_id) {
                                          echo '<td>'.$s->name.'</td>';
                                        }
                                      } 
                                    ?>
                                                            
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td width="50">:</td>
                                   <td><i class="fa fa-map-marker"></i> <?php echo ucwords($record->alamat); ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis kelamin</td>
                                   <td width="50">:</td>
                                    <?php if ($record->jk == "Laki-Laki"): ?>
                              
                                      <td><i class="fa fa-male"></i> <?php echo ucwords($record->jk) ?>
                                      </td>
                                      <?php else: ?>
                                      <td><i class="fa fa-female"></i> <?php echo ucwords($record->jk) ?></td>

                                     <?php endif ?>
                                </tr>
                                   
                                    
                                </tr>
                                <tr>
                                    <td>Agama</td>
                                    <td width="50">:</td>
                                   <td><i class=""></i> <?php echo ucwords($record->agama); ?></td>
                                </tr>
                                <tr>
                                    <td>tempat lahir</td>
                                    <td width="50">:</td>
                                   <td><i class=""></i> <?php echo ucwords($record->tempat_lahir); ?></td>
                                </tr>
                                 <tr>
                                    <td>tempat lahir</td>
                                    <td width="50">:</td>
                                   <td><i class=""></i> <?php echo $record->tanggal_lahir; ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td width="50">:</td>
                                   <td><i class=""></i> <?php echo ucwords($record->status); ?></td>
                                </tr>
                                 <tr>
                                    <td>Barcode</td>
                                    <td width="50">:</td>
                                   <td>
                                     <?php $kode = $record->nim ?>
<img src="<?php echo site_url();?>/Laporan/generate/<?php echo $kode;?>">
                                   </td>
                                </tr>
                                              
   </table>
<table style="float: left;">
    <tr><td>Catatan</td><td>: Biodata ini di cetak untuk keperluan akademik mahasiswa</td></tr>
</table>

<?php 

$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
 echo '<div style="float:right;margin-top:25px;margin-right:120px;">'
 .'Makassar, '.$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");
 echo '</div>';
echo '<br>';
echo '<table style="margin:50 auto;">
    <tr><td width="500"><br><br></td><td>Mahasiswa<br><br></td></tr>'.
    '<tr><td height="100"></td><td><u>'.strtoupper($record->nama).'</u></td></tr>
</table>';


 ?>