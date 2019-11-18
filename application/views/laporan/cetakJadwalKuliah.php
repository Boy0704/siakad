<?php
/*siapkan sebuah fungsi
paramater pertama adalah pemisah antara kalimat
biasanya pemisah antar kalimat adalah ". ", "? ", "! "
parameter kedua adalah paragrap yang akan dirubah menjadi format sentence case
*/
function ubah_huruf_awal($pemisah, $paragrap) {
//pisahkan $paragraf berdasarkan $pemisah dengan fungsi explode
$pisahkalimat=explode($pemisah, $paragrap);
$kalimatbaru = array();

//looping dalam array
foreach ($pisahkalimat as $kalimat) {
//jadikan awal huruf masing2 array menjadi huruf besar dengan fungsi ucfirst
$kalimatawalhurufbesar=ucfirst(strtolower($kalimat));
$kalimatbaru[] = $kalimatawalhurufbesar;
}

//kalo udah gabungin lagi dengan fungsi implode
$textgood = implode($pemisah, $kalimatbaru);
return $textgood;
}

?>
<body onload="window.print()">

</body>

<link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .table th{
      text-align: center;
      padding: 10px;
    }
    .table td{
      /*text-align: center;*/
      padding: 10px;
    }
</style>
<table border="1" style=" border-collapse: collapse;width: 100%;">
  <tr>
    <td width="10%" rowspan="2"><img style="width: 80px; height:80px;" src="<?php echo base_url() ?>images/logo/logouit.gif" alt="" ></td>
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>DATA DOSEN FAKULTAS ILMU KOMPUTER</b></td>
  </tr>
  <tr>
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>UNIVERSITAS INDONESIA TIMUR</b></td>
  </tr>
</table>
<br>
<?php
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
echo "Dicetak Pada Hari/Tanggal : ".$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");
?>
<br><br>
 <table border="1" style=" border-collapse: collapse;width: 100%;">
                      <thead>
                        <tr class="table">
                          <th>No</th>
                          <th>Hari</th>
                          <th>Waktu</th>
                          <th>Kelas</th>
                          <th>Matakuliah</th>
                          <th>Dosen</th>
                         
                        </tr>
                      </thead>
                       <?php
                       $no=1;

                            foreach ($data as $row) {
                              ?>
                  
                    
                            <tr class="table">
                               <td style="text-align: center;"><?php echo $no++; ?></td>
                               <td style="text-align: center;"><?php echo ucfirst(strtolower($row->nama_hari)) ?></td>
                               <td style="text-align: center;"><?php echo strtoupper($row->jam_mulai).' - '.($row->jam_selesai);?></td>
                               <?php if ($row->angkatan_id == "1") { ?>
                                  <td style="text-align: center;">
                                      <span class="label label-success">
                                          <?php echo strtoupper($row->nama_kelas); ?>
                                      </span>
                                  </td>
                               <?php }elseif ($row->angkatan_id == "2") { ?>
                                     <td style="text-align: center;">
                                      <span class="label label-info">
                                          <?php echo strtoupper($row->nama_kelas); ?>
                                      </span>
                                  </td>
                               
                               <?php }elseif ($row->angkatan_id == "3") { ?>
                                     <td style="text-align: center;">
                                      <span class="label label-primary">
                                          <?php echo strtoupper($row->nama_kelas); ?>
                                      </span>
                                  </td>
                               
                               <?php }elseif ($row->angkatan_id == "4") { ?>
                                     <td style="text-align: center;">
                                      <span class="label label-warning">
                                          <?php echo strtoupper($row->nama_kelas); ?>
                                      </span>
                                  </td>
                              
                               <?php } else { ?>
                                     
                                      <td ><?php echo strtoupper($row->nama_kelas) ?></td>
                                  
                               <?php } ?>
                               
                                 
                               
                               
                               <td ><?php echo ucwords($row->nama_matkul) ?></td>
                               <td ><?php echo ucwords(ubah_huruf_awal(",",$row->nama))?></td>

                            </tr>
                            
                  
                              <?php
                            }
                         
                        ?>
                    
                    </table><br>
<table style="float: left;">
    <tr><td>Catatan</td><td>: Pergantian Jadwal Kuliah harap menghubungi bag. Akademik</td></tr>
</table>
<?php 
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
 echo '<div style="float:right;margin-top:25px;margin-right:120px;">'
 .'Makassar, '.$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");
 echo '</div>';
 echo '<table style="clear:both;margin:0 auto;">
 <tr><td>Mengetahui</td></tr>
 </table>';
echo '<br>';
echo '<table style="margin:0 auto;">
    <tr><td width="500">Bidang Akademik<br><br></td><td>Ketua Program Studi<br><br></td></tr>'.
    '<tr><td height="100">( Syahrul Syawal, S.Pd.,MT )</td><td>( Bahrun Herdanial B, S.Kom, M.M )</td></tr>
</table>';

 ?>