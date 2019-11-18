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
        padding: 4px;
    }
    h2{
        text-align: left;
        margin-bottom: 10px;
        margin-top: 15px;
    }
    .potong
    {
        page-break-after:always;
    }
</style>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>

<body onload="window.print()"></body>

<h3 style="border: 1px solid #000;padding: 10px; text-align: center;">JADWAL KULIAH <BR> TAHUN AKADEMIK <?php echo date('Y')-'1'.'/'.date('Y') ?></h3>
<table width="100%;">
    <tr>
        <td rowspan="3">
          <img src="<?php echo base_url()?>assets/images/logo.gif" width="100" style="float: left;margin-right: 10px;">
            <h2>AKADEMI KEBIDANAN  <br> KELUARGA BUNDA JAMBI</h2>
            Kampus : Talang Bakung, Jambi Sel., Kota Jambi, Jambi 36138  <br>
            Telp / Fax (0434) 2621672 E.Mail : email : info@akbidkeluargabunda.ac.id
        </td>
        <td style="font-weight: bold; width:10%;">Program Studi</td><td style="font-weight: bold">: <?php echo $prodi;?></td>
    </tr>
    <tr style="font-weight: bold"><td>Konsentrasi</td><td>: <?php echo $konsentrasi;?></td></tr>
    <tr style="font-weight: bold"><td>Semester</td><td> : <?php echo $semester;?></td></tr>
</table>

<br>
<table border="1" cellspacing="0" style="border: 1px solid #000; border-collapse: collapse;">
    <tr style="background-color: yellow;"><th>NO</th>
    <?php
    for($i=1;$i<=7;$i++)
    {
        echo "<th width=160>".  strtoupper($hari[$i])."</th>";
    }
    ?>
    </tr>
    <?php
    for($i=1;$i<=5;$i++)
    {
        echo "<tr><td align='center'>$i</td>";
        for($h=1;$h<=7;$h++)
        {
            echo "<td style='text-align: center'>".  chek_jadwal_kuliah($konsen, $h, $tahun,$semester,$i-1)."</td>";
            // echo "<td style='text-align: center'> k".$konsen." h".$h." t".$tahun." s".$semester." i".$i."</td>";
        }
        echo"</tr>";
    }
    ?>
</table>

<table style="font-weight: bold;">
    <tr><td valign="top">Ket</td> <td valign="top" width="1">:</td> <td>1 SKS adalah 1 jam =  50 menit</td></tr>
    <tr><td valign="top">Catatan</td> <td valign="top" width="1">:</td> <td>Pergantian Jadwal Kuliah baik Dosen maupun Jurusan harap menghubungi bag. Akademik</td></tr>
</table>

<table style="font-weight: bold; width: 100%; text-align: center;">
    <tr>
        <td width="500">Mengetahui<br>Pembantu Direktur I<br>Bidang Akademik</td>
        <td>Kota Jambi, <?php echo $this->M_users->tgl_id(date('d-m-Y')); ?><br>Ka. Jurusan<br>Sekretaris Jurusan</td>
    </tr>
    <tr>
        <td height="100">
          <?php
          $this->db->join('app_dosen','app_dosen.dosen_id=app_kepala_bagian.dosen_id');
          $cek_data1 = $this->db->get_where('app_kepala_bagian', array('nama_kepala_bagian'=>'Pembantu Direktur I Bidang Akademik'));
          if ($cek_data1->num_rows()!=0) {
            echo ucwords($cek_data1->row()->nama_lengkap);
          }
          ?>
        </td>
        <td>
          <?php
          $this->db->join('app_dosen','app_dosen.dosen_id=app_kepala_bagian.dosen_id');
          $cek_data2 = $this->db->get_where('app_kepala_bagian', array('nama_kepala_bagian'=>'Ka. Jurusan Sekretaris Jurusan'));
          if ($cek_data2->num_rows()!=0) {
            echo ucwords($cek_data2->row()->nama_lengkap);
          }
          ?>
        </td>
    </tr>
</table>
