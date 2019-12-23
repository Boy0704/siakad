<!-- <body onload="window.print()">
    
</body> -->
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
        padding: 8px;
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
<table border="1" style="border-collapse: collapse;width: 100%;">
    <tr>
       <td width="10" rowspan="2" align="center"><img src="<?php echo base_url('images/logo/logouit.png') ?>" alt=""></td>
       <td style="text-align: center;font-size: 20px; font-weight: arial;">LAPORAN KEUANGAN</td>
    </tr>
    <tr>
        <td style="text-align: center;font-size: 20px; font-weight: arial;">STAIN KEPRI SULTAN ABDURAHMAN</td>
    </tr>
</table>
<table>
<br>
    <tr>
        <td width="100">NIM</td>
        <td width="1000">: <?php echo strtoupper($biodata['nim'])?></td>
        <?php $kode = $biodata['nim']; ?>
       <td width="100" rowspan="3" align="right"><img src="<?php echo base_url('laporan/barcode/'.$kode) ?>" alt=""></td>
    </tr>
     <tr>
        <td>NAMA</td>
        <td>: <?php echo strtoupper($biodata['nama'])?></td>
    </tr>
    <tr>
        <td>KONSENTRASI</td>
        <td>: <?php echo strtoupper($biodata['nama_konsentrasi'])?></td>
    </tr>
</table>
<br>
<table border="1" style="border-collapse: collapse;width: 100%;">
   
    <tr>
        <th width="10">No</th>
        <th>Jenis Pembayaran</th>
        <th>Jumlah Bayar</th>
        <th>Sudah Bayar</th>
        <th>Keterangan</th>
    </tr>
        
    <?php
    // tahun akademik ketika masuk
    $tahun_akademik_id=  getField('student_mahasiswa', 'angkatan_id', 'nim', $biodata['nim']);
    // konsentrasi
    $konsentrasi_id=getField('student_mahasiswa', 'konsentrasi_id', 'nim', $biodata['nim']);
    $no=1;
    $sisa_total=0;
        foreach ($jenis_bayar as $jb)
        {
            $jumlah_bayar   =(int) get_biaya_kuliah($tahun_akademik_id, $jb->jenis_bayar_id, $konsentrasi_id, 'jumlah');
            $sudah_bayar    = (int)get_biaya_sudah_bayar($biodata['nim'], $jb->jenis_bayar_id);
            $sisa           = $jumlah_bayar-$sudah_bayar;
            $ket           = $sisa<=0?'Lunas':'Tunggakan '.rp($sisa);
            echo "<tr>
                <td align='center'>$no</td>
                <td>".  strtoupper($jb->keterangan)."</td>
                <td>".rp($jumlah_bayar)."</td>
                <td>".rp($sudah_bayar)."</td>
                <td>".$ket."</td>
                </tr>";
            $no++;
            $sisa_total=$sisa_total+$sisa;
        }
        // looping semester
        for($i=1;$i<=$semester;$i++)
        {
            $spp            =   (int) get_biaya_kuliah($tahun_akademik_id, 3, $konsentrasi_id, 'jumlah');
            $spp_udah_bayar =   (int)get_semester_sudah_bayar($biodata['nim'], $i);
            $sisa           =   $spp-$spp_udah_bayar;
            $keterangan           =   $sisa<=0?'Lunas':'Tunggakan '.$sisa;
            echo "<tr>
                <td align='center'>$no</td>
                <td>BPP SEMESTER $i</td>
                <td>".rp($spp)."</td>
                <td>".rp($spp_udah_bayar)."</td>
                <td>".$keterangan."</td>";
            $sisa_total=$sisa_total+$sisa;
            $no++;
        }
    ?>
    <tr>
        <td colspan="4" align="center"><b>Total Yang Belum Dibayar</b></td>
        <td><b>Sisa  = <?php echo  rp($sisa_total);?></b></td>
    </tr>
</table>

<br><br>
<table border="0" style="float: right;">
    <tr>
        <td><span style=" font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 13px;">
            Makassar, <?php echo tgl_indo(substr(waktu(), 0, 10)); ?>
            <br>bagian keuangan
        </span>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 50px;text-align:center;">
            <span style=" font-family: Arial, Helvetica, sans-serif;font-weight: bold;">
            <?php echo strtoupper($this->session->userdata('username')); ?></td>
        </span>
    </tr>
</table>
