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
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>DATA DOSEN </b></td>
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
                          <th>Nip</th>
                          <th>Nama</th>
                          <th>Jenis Kelamin</th>
                          <th>Alamat</th>
                          <th>Agama</th>
                          <th>No.Telp</th>
                          <th>Temp.Lahir</th>
                          <th>Tgl.Lahir</th>
                          
                        </tr>
                      </thead>
                       <?php
                       $no=1;
                            if ($data->num_rows() > 0) {
                            foreach ($data->result() as $row) {
                              ?>
                  
                    
                            <tr class="table">
                               <td><?php echo $no++; ?></td>
                               <td><?php echo strtoupper($row->nip) ?></td>
                               <td><?php echo strtoupper($row->nama);?></td>
                               <td><?php echo strtoupper($row->jk); ?></td>
                               <td><?php echo $row->alamat ?></td>
                               <td><?php echo strtoupper($row->agama) ?></td>
                               <td><?php echo strtoupper($row->no_hp) ?></td>
                               <td><?php echo strtoupper($row->tempat_lahir) ?></td>
                               <td><?php echo strtoupper($row->tgl_lahir) ?></td>
                            </tr>
                            
                  
                              <?php
                            }
                          }
                        ?>
                    
                    </table>
<table style="float: left;">
    <tr><td>Catatan</td><td>: Pergantian Jadwal Kuliah harap menghubungi bag. Akademik</td></tr>
</table>
<?php 
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
 echo '<div style="float:right;margin-top:40px;margin-right:120px;">'
 .'Makassar, '.$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");
 echo '</div>';
 echo '<table style="clear:both;margin:0 auto;">
 <tr><td>Mengetahui</td></tr>
 </table>';
echo '<br><br>';
echo '<table style="margin:0 auto;">
    <tr><td width="500">Bidang Akademik<br><br><br></td><td>Ketua Program Studi<br><br><br></td></tr><br>'.
    '<tr><td height="100"><u>Syahrul Syawal, S.Pd.,MT</u></td><td><u>NOT SET</u></td></tr>
</table>';

echo '<br><br>';


 ?>