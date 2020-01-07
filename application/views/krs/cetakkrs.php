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

<h3 align="center">KARTU RENCANA STUDI</h3><br>

<table border="0" style="border-collapse: collapse;width: 100%;">
    <tr>
    <td rowspan="4">
        <?php if ($this->session->userdata('id_users') == '') {?>
      <!-- <img class = img-circle src="<?php echo base_url('images/user.png') ?>" alt="..." class="profile_img"  style="height:80px;width:85px;margin-top: 10px;margin-left: 15px;"> -->
      <img class = img-circle src="<?php echo base_url('images/user.png') ?>" alt="..." class="profile_img"  style="height:80px;width:85px;margin-top: 10px;margin-left: 15px;">
    <?php } else {
      $id_users = $this->session->userdata('id_users');
      $cek_data = $this->db->get_where('app_users',"id_users='$id_users'")->row();
      $foto = $this->M_users->cek_filename($cek_data->foto);
      ?>
      <img src="<?php echo base_url($foto) ?>" alt="..." class="profile_img"  style="height:80px;width:85px;">
    <?php } ?>
    </td>
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
        <th width="10" rowspan="2">No</th>
        <th rowspan="2">KODE</th>
        <th rowspan="2">MATA KULIAH</th>
        <th rowspan="2">SKS</th>
        <th colspan="2">Paraf Pengawas Ujian</th>
    </tr>
    <tr>
        <th>UTS</th>
        <th>UAS</th>
    </tr>
    <?php
    $no =1 ;
    $sks = 0;
    foreach ($record2 as $r) {
        ?>
            <tr>
                <td align="center"><?php echo $no++; ?></td>
                <td align="center" width="60"><?php echo strtoupper($r->kode_makul) ?></td>
                <td style="padding-left: 10px;"><?php echo strtoupper($r->nama_makul) ?></td>
                <td align="center" width="40"><?php echo $r->sks ?></td>
                <td></td>
                <td></td>
            </tr>
        <?php
        $sks = $sks+$r->sks;
    }

    ?>
    <tr>
        <td align="center" colspan="3"><b>Total SKS</b></td>
        <td align="center"><b><?php echo  $sks;?></b></td>
        <td></td>
        <td></td>
    </tr>
</table>

<br><br>
<table style="width: 100%;">
    <tr>
        <td align="right" colspan="3" style="padding-right: 20px; padding-bottom: 15px;">Bintan, <?php echo tgl_indo(substr(waktu(), 0, 10)) ?></td>
    </tr>
    <tr>
        <td style="padding-bottom: 60px;" align="center">Penasehat Akademik</td>
        <td style="padding-bottom: 60px;" align="center">Mahasiswa</td>
    </tr>
    <tr>
        
        <td align="center"><?php echo $dosen_pa ?></td>
        <td align="center"><?php echo strtoupper($profile['nama']) ?></td>
    </tr>

</table>
