<!-- <body onload="window.print()"> -->
<body >
<!-- <a target="_blank" href="cetak/cetak_absen_kosong/" class="btn btn-primary">Cetak Absen</a> -->
</body>
<style type="text/css">
    body
    {
        font-family: sans-serif;
        font-size: 14px;
    }
    th{
        padding: 5px;
        font-weight: bold;
        font-size: 12px;
    }
    td{
        font-size: 12px;
        padding: 3px;
    }
    h2{
        text-align: left;
        margin-bottom: 13px;
    }
    .potong
    {
        page-break-after:always;
    }
</style>

<?php //$this->load->view('kop'); ?>
<?php 
    $profile = $d->row_array();
 ?>
<h3 align="center">DAFTAR HADIR DOSEN DAN BATAS KULIAH</h3>
<h3 align="center">SEMESTER GENAP TA. 2019/2020</h3><br>

<table border="0" style="border-collapse: collapse;width: 100%;">
    <tr>
        <td style="width: 100px;">Nama</td><td align="left">: <?php echo strtoupper($profile['nama_lengkap'])?></td>
        <td style="width: 100px;">Prodi</td><td align="left">: <?php echo get_data('akademik_konsentrasi','konsentrasi_id',$profile['konsentrasi_id'],'nama_konsentrasi') ?></td>
    </tr>

    <tr>
        <td style="width: 100px;">Mata Kuliah</td><td align="left">: <?php echo strtoupper($profile['nama_makul'])?></td>
        <td style="width: 100px;">Jumlah SKS</td><td align="left">: <?php echo $profile['sks'] ?></td>
    </tr>
    <tr>
        <td style="width: 100px;">Kode MK</td><td align="left">: <?php echo strtoupper($profile['kode_makul'])?></td>
        <td style="width: 100px;">Semester</td><td align="left">: <?php echo $profile['semester'] ?></td>
    </tr>

    
</table>
<br>
<table border="1" style="border-collapse: collapse;width: 100%;">

    <tr>
        <th  width="10">NO</th>
        <th >Tanggal</th>
        <th >Materi</th>
        <th >Metode</th>
        
        <th width="100" height="50">Tanda Tangan</th>
    </tr>
    
    <?php 
    for ($i=1; $i < 17 ; $i++) { 
     ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php } ?>
</table>

