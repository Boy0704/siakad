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
<link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- <body onload="window.print()">

</body> -->
<style>
   .table th{
    padding: 10px;
    text-align: center;
   }
    .table td{
    padding: 10px;
   }
</style>

<table border="1" width="100%">
  <tr>
    <td width="10%" rowspan="2"><img style="padding: 8px; width: 120px; height:110px;" src="<?php echo base_url() ?>images/logo/logouit.gif" alt="" ></td>
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>JADWAL KULIAH TAHUN AJARAN <?php echo  date('Y') - "1"."/". date('Y'); ?></b></td>
  </tr>
  <tr>
    <td width="90%" height="30" style="font-size: 25px; text-align: center;"><b>FAKULTAS ILMU KEBIDANAN</b></td>
  </tr>
</table>
<table border="0">

<?php 

    foreach ($data as $row) 
            { 
              $definisi[] = $row;
            } ?>
           <br>
           <tr>
            <td width="10%" style="font-size: 15px;padding-bottom: 5px;"><b>ANGKATAN</b></td>
            <td style="text-align: center;">:</td>
            <?php if (!empty($row->name_angkatan)): ?>
               <td style="font-size: 15px;"><span><?php echo strtoupper($row->name_angkatan); ?></span></td>
              <?php else: ?>
                <td>-</td>
            <?php endif ?>
           
          </tr>
          <tr>
            <td style="font-size: 15px;padding-bottom: 10px;"><b>KELAS</b></td>
            <td style="text-align: center;">:</td>
            <?php if (!empty($row->nama_kelas)): ?>
              <td style="font-size: 15px;"><span><?php echo strtoupper($row->nama_kelas) ?></span></td>
            <?php else: ?>
              <td>-</td>
            <?php endif ?>
              
          </tr>

          <?php
    

?>

</table>

    <table border="1" style="border-collapse: collapse;width: 100%;"> 
    <thead>
                         <tr class="table">
                          <th>No</th>
                          <th>Hari</th>
                          <th>Waktu</th>
                          <th>Matakuliah</th>
                          <th>Dosen</th>
                        </tr>
       </thead>
      <?php
      $no = 1;
      if (isset($data)){
        foreach ($data as $row) 
          {  ?>

             <tr class="table">
                    <td align="center"><?php echo $no++; ?></td>
                    <td align="center"><?php echo strtoupper($row->nama_hari) ?></td>
                    <td align="center"><?php echo strtoupper($row->jam_mulai).' - '.($row->jam_selesai);?></td>
                    <td ><?php echo ucwords($row->nama_matkul) ?></td>
                    <td ><?php echo ucwords(ubah_huruf_awal(",", $row->nama))?></td>

              </tr>
          <?php
          } 

        }
          ?>
      
</table>
<table style="float: left;"><br>
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