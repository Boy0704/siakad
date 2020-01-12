<body onload="window.print()">

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

<?php $this->load->view('kop'); ?>

<h3 align="center">KARTU HASIL STUDI</h3><br>

<table border="0" style="border-collapse: collapse;width: 100%;">
    <tr>
    <td style="width: 100px;">Nama</td><td align="left">: <?php echo strtoupper($profile['nama'])?></td>
    <?php $kode = $profile['nim']; ?>
    <td width="20" rowspan="4" align="right"><img src="<?php echo base_url('laporan/barcode/'.$kode) ?>" alt=""></td>
    </tr>
    <tr><td style="width: 100px;">Nim / Semester</td><td>: <?php echo strtoupper($profile['nim']). " / " . $this->uri->segment(4) ?></td></tr>
    <tr><td style="width: 100px;">Jurusan</td><td>: <?php echo strtoupper($profile['nama_prodi'])?></td></tr>
    <tr><td style="width: 100px;">Prodi</td><td>: <?php echo strtoupper($profile['nama_konsentrasi'])?></td></tr>
</table>
<br>
<table border="1" style="border-collapse: collapse;width: 100%;">

    <tr>
        <th width="10">NO</th>
        <th>KODE</th>
        <th>MATA KULIAH</th>
        <th>SKS</th>
        <!-- <th>NILAI</th> -->
        <th>MUTU</th>
        <th>NM</th>
        <th>GRADE</th>
    </tr>
    <?php
    $nim = $this->uri->segment(3);
    $semester = $this->uri->segment(4);
    $no =1 ;
    $sks = 0;
    foreach ($this->db->get_where('v_khs', array('nim'=>$nim, 'semester'=>$semester))->result() as $r) {
        ?>
            <tr>
                <td align="center"><?php echo $no++; ?></td>
                <td align="center" width="60"><?php echo strtoupper($r->kode_makul) ?></td>
                <td style="padding-left: 10px;"><?php echo strtoupper($r->nama_makul) ?></td>
                <td align="center" width="40"><?php echo $r->sks ?></td>
                <!-- <td align="center" width="40"><?php echo $r->nilai ?></td> -->
                <td align="center" width="40"><?php echo $r->mutu ?></td>
                <td align="center" width="40"><?php echo $r->mutu*$r->sks ?></td>
                <td align="center" width="40"><?php echo $r->grade ?></td>
            </tr>
        <?php
        $sks = $sks+$r->sks;
    }

    ?>
    <tr>
        <td align="center" colspan="3"><b>Total SKS</b></td>
        <td align="left" colspan="4"><b><?php echo  $sks;?></b></td>
    </tr>
    <tr>
        <td align="center" colspan="3"><b>Index Prestasi (IP)</b></td>
        <td align="left" colspan="4"><b><?php echo number_format(ip($nim,$semester),2);?></b></td>
    </tr>
</table>

<br><br>
<table style="width: 100%;">
    <tr>
        <td align="right" colspan="3" style="padding-right: 20px; padding-bottom: 15px;">Bintan, <?php echo tgl_indo(substr(waktu(), 0, 10)) ?></td>
    </tr>
    <tr>
        <td style="padding-bottom: 60px;" align="center">Diketahui Oleh <br> Wakil Ketua I</td>
        <td style="padding-bottom: 60px;" align="center">Ketua Jurusan <br><?php echo strtoupper($profile['nama_prodi'])?></td>
    </tr>
    <tr>
           
        <td align="center"><u>ARIS BINTANIA, M.Ag</u> <br>NIDN. 2023077501</td>
        <td align="center"><u>Drs. H. RUNTONI, M.Pd</u> <br>NIDN. 2112126701</td>
    </tr>

</table>
