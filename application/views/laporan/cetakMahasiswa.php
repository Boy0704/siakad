<body onload="window.print()">
    
</body>
<style>
    .table  th,td{
      text-align: center;
      padding: 5px;
    }
</style>
<table border="1" style=" border-collapse: collapse;width: 100%;">
  <tr>
    <td width="10%" rowspan="2"><img style="width: 80px; height:80px;" src="<?php echo base_url() ?>images/logo/logouit.gif" alt="" ></td>
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>DATA MAHASISWA</b></td>
  </tr>
  <tr>
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>STAIN KEPRI SULTAN ABDURAHMAN</b></td>
  </tr>
</table>
<br>
<?php
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
echo "Dicetak Pada Hari/Tanggal : ".$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");?>
<br><br>
  <table border="1" style=" border-collapse: collapse;width: 100%;">
                      <thead>
                        <tr class="table">
                          <th>No</th>
                          <th>Nim</th>
                          <th>Nama</th>
                          <th>Angk.</th>
                          <th>Smster</th>
                          <th>J.Kelamin</th>
                          <th>Agama</th>
                          <th>Tempt Lahir</th>
                          <th>Tgl Lahir</th>
                          <th>Foto</th>
                        </tr>
                      </thead>
                       <?php
                       $no=1;
                        
                            foreach ($data as $row) {
                              ?>

                            <tr class="table">
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row->nim; ?></td>
                                <td><?php echo strtoupper($row->nama) ?></td>
                                <td><?php echo $row->name_angkatan?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->jk; ?></td>
                                <td><?php echo strtoupper($row->agama) ?></td>
                                <td><?php echo $row->tempat_lahir ?></td>
                                <td><?php echo $row->tanggal_lahir ?></td>
                                <td>
                               <?php if (!empty($row->foto)): ?>
                                 <div class="list-group">
                                 <span href="" class="list-group-item">
                                    <img src="<?php echo base_url('uploads/'.$row->foto); ?>" style="height:100px;width:110px;">
                                  </span>
                                </div>
                                 <?php else: ?>
                                      <img src="<?php echo base_url('images/user.png'); ?>" style="height:100px;width:110px;">
                               <?php endif ?>
                               </td>
                            </tr>
                            
                  
                              <?php
                            }
                          
                        ?>
                         <tr>
                          <td colspan="5" align="center" style="padding: 10px;">Total Jumlah Mahasiswa</td>
                          <td colspan="5" align="center"><?php echo $jumlah_mahasiswa; ?></td>
                        </tr>
                    
                    </table>
<?php 
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
echo "Makassar, ".$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");

 ?>
<BR></br><br><br>
  NOT SET