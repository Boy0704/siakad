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
<h3 align="center">DAFTAR HADIR PERKULIAHAN MAHASISWA/I</h3>
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
        <th rowspan="2" width="10">NO</th>
        <th rowspan="2">Nama Mahasiswa</th>
        <th rowspan="2">Nim</th>
        <th colspan="16">Pertemuan</th>
        
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
        <th>8</th>
        <th>9</th>
        <th>10</th>
        <th>11</th>
        <th>12</th>
        <th>13</th>
        <th>14</th>
        <th>15</th>
        <th>16</th>
    </tr>
    <?php 
    $data = $this->db->query($sql);
    $no=1;
    foreach ($data->result() as $rw) {
     ?>
    <tr>
        <td><?php echo $no ?></td>
        <td><?php echo $rw->nama ?></td>
        <td><?php echo $rw->nim ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php $no++; } ?>
</table>

