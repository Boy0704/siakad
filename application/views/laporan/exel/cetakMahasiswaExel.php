<?php
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-type: application/octet-stream");
    header ("Content-Disposition: attachment; filename=cetak-laporan-Mahasiswa.xls");
?>
<link href="<?php echo base_url() ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    table,th,td{
        border-collapse: collapse;
        padding: 15px;
        margin: 10px;
        color: black;
    }
</style>
<div style="text-align: center;">
  <span style="font-size: 20px;margin-left: 50px;"><b>DATA MAHASISWA FAKULTAS ILMU KOMPUTER</b></span><br>
  <span style="font-size: 20px;margin-left: 50px;"><b>UNIVERSITAS INDONESIA TIMUR</b></span>
</div>
<br>
<?php
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
echo "Dicetak Pada Hari/Tanggal : ".$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");?>
<br><br>
  <table border="1">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nim</th>
                          <th>Nama</th>
                          <th>Angk.</th>
                          <th>Smster</th>
                          <th>J.Kelamin</th>
                          <th>Agama</th>
                          <th>Tempt Lahir</th>
                          <th>Tgl Lahir</th>
                         
                        </tr>
                      </thead>
                       <?php
                       $no=1;
                        
                            foreach ($data as $row) {
                              ?>

                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row->nim; ?></td>
                                <td><?php echo strtoupper($row->nama) ?></td>
                                <td><?php echo $row->name_angkatan?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->jk; ?></td>
                                <td><?php echo strtoupper($row->agama) ?></td>
                                <td><?php echo $row->tempat_lahir ?></td>
                                <td><?php echo $row->tanggal_lahir ?></td>
                               
                            </tr>
                              <?php
                            }

                        ?>
                        <tr>
                          <td colspan="5" align="center" style="padding: 10px;">Total Jumlah Mahasiswa</td>
                          <td colspan="4" align="center"><?php echo $jumlah_mahasiswa; ?></td>
                        </tr>
                    
                    </table>
<?php 
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
echo "Makassar, ".$hari[date("w")].", ".date("j")." ".$bulan[date("n")]." ".date("Y");

 ?>
<BR></br><br><br>
  TASRIN ADIPUTRA