<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak KHS</title>
    <base href="<?php echo base_url();?>"/>
  	<link rel="icon" type="image/png" href="assets/favicon.png"/>
    <style>
    table {
        border-collapse: collapse;
    }

    th, td {
      padding: 2px;
    }

    th {
        color: #222;
    }
    </style>
    <!-- <style type="text/css" media="print">
      @page { size: landscape; }
    </style> -->
  </head>
  <body>

<?php
$s1 = $semester;
$s2 = $semester2;
if ($s1 > $s2) {
  $v_semester = '-';
}else if ($s1 == $s2) {
  $v_semester = $s1;
}else {
  $v_semester = "$s1 - $s2";
}
?>

<?php $this->load->view('kop'); ?>

<h3 align="center">KARTU HASIL STUDI</h3><br>

    <table border="0" width="100%">
      <tr>
          <td width='130'>NAMA</td><td width='1'>:</td><td><?php echo strtoupper($d['nama']); ?></td>
          <td width=70>NIM</td><td width='1'>:</td><td><?php echo strtoupper($d['nim']);?></td>
          <td rowspan='3' width='70'><img src=<?php echo $_SERVER["DOCUMENT_ROOT"]."assets/images/avatar.png" ?> width='50'></td>
      </tr>
      <tr>
          <td>Jurusan, Prodi</td><td width='1'>:</td><td><?php echo strtoupper($d['nama_prodi'].' / '.$d['nama_konsentrasi']); ?></td>
          <td>Semester</td><td width='1'>:</td><td> <?php echo $v_semester; ?> </td>
      </tr>
      </table>
      <br>
        <table border='1' width="100%">
                <tr class='alert-info'>
                    <th>No</th>
                    <th>KODE MP</th>
                    <th>NAMA MATAKULIAH</th>
                    <th>DOSEN PENGAPU</th>
                    <th>SKS</th>
                    <th>Grade</>
                    <th>Mutu</th>
                    <th>Jumlah</th>
                </tr>
                <?php
                error_reporting(0);
                $no=1;
                $sks=0;
                $mutu = 0;
                $total = 0;

                if($semester==0)
                {
                    // foreach semester dari semester aktif
                    for($smt=1;$smt<=$d['semester_aktif'];$smt++)
                    {
                        echo "<tr class='warning'><th colspan='11'>SEMESTER $smt</th></tr>";
                        $krs  = "SELECT kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.confirm,kh.khs_id,kh.kehadiran,kh.tugas
                                    FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                                    app_dosen as ad,akademik_khs as kh
                                    WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                                    and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$smt' and kh.confirm='1'";
                        $data           =  $this->db->query($krs);
                        if($data->num_rows()<1)
                        {
                            echo "<tr><td align='center' colspan='11'>Data Tidak Ditemukan</td></tr>";
                        }
                        else
                        {
                            $no=1;
                            $sks=0;
                            $total = 0;
                            foreach ($data->result() as $r)
                            {

                                $hasilkali = $r->sks * $r->mutu;
                                echo "<tr id='krshide$r->khs_id'>
                                    <td align='center'>$no</td>
                                    <td>".  strtoupper($r->kode_makul)."</td>
                                    <td>".  strtoupper($r->nama_makul)."</td>
                                    <td>".  strtoupper($r->nama_lengkap)."</td>
                                    <td align='center'>".  $r->sks."</td>
                                    <td align='center'>".$r->grade."</td>
                                    <td align='center'>$r->mutu</td>
                                    <td align='center'>$hasilkali</td>
                                    ";

                                    echo "
                                    </tr>";
                                $no++;
                                $sks=$sks+$r->sks;
                            }
                            // $krs  =   "SELECT avg(kh.mutu) as mutu
                            //         FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                            //         app_dosen as ad,akademik_khs as kh
                            //         WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                            //         and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$smt' and kh.confirm='1' GROUP BY kh.krs_id";
                            // $sqlipk           =  $this->db->query($krs)->result();
                            // foreach ($sqlipk as $r) {
                            //      $ipk = number_format($r->mutu, 2);
                            //    }

                            $ipk = number_format($total/$sks, 2);

                               //simpan nilai index prestasi

                                //cek ip
                                $cekip = cek_ip($nim, $smt);
                                if ($cekip == 0 ) {
                                    $this->db->insert('akademik_ip', array('nim'=>$nim, 'semester'=>$smt,'ip'=>$ipk));
                                    // $ipk = get_ipk($nim);
                                    $this->db->where('nim', $nim);
                                    $this->db->update('student_mahasiswa', array('ipk'=>number_format($ipk, 2)));
                                } else{
                                    // $ipk = get_ipk($nim);
                                    $this->db->where('nim', $nim);
                                    $this->db->update('student_mahasiswa', array('ipk'=>number_format($ipk, 2)));
                                }
                            echo"<tr>
                            <td colspan='5' align='right'>Total SKS</td>
                            <td align='center'>$sks</td>
                            <td colspan='2' align='left'>IP = ".$ipk."</td>
                            <td colspan='4'></td>
                            </tr>
                    <tr>
                    <td colspan=11>".anchor('cetak/cetakkhs/'.$smt.'/'.$id,'<i class="fa fa-print"></i> Cetak KHS',array('title'=>$this->title,'class'=>'btn btn-primary btn-sm', 'target'=>'_blank'))."

                    ".anchor('','<i class="fa fa-bar-chart-o"></i> Grafik',array('Title'=>'Lihat Grafik','class'=>'btn btn-primary btn-sm'))."
                    </td></tr>";
                        }
                    }
                    // end foreach
                }
                else
                {
                    $krs       =   "SELECT kh.grade,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap,kh.mutu,kh.confirm,kh.khs_id,kh.tugas,kh.kehadiran
                                    FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                                    app_dosen as ad,akademik_khs as kh
                                    WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                                    and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester>='$semester' and ak.semester<='$semester2' and kh.confirm='1' GROUP BY kh.krs_id";

                    $data      =  $this->db->query($krs);

                    if($data->num_rows()<1)
                    {
                        echo "<tr class='warning' align='center'><td colspan=11>DATA KHS TIDAK DITEMUKAN</td></tr>";
                    }
                    else
                    {

                        foreach ($data->result() as $r)
                        {
                          $level = $this->session->userdata('level');
                            $hasilkali = $r->sks * $r->mutu;
                            $total    += $r->sks * $r->mutu;
                            $mutu      = $mutu + $r->mutu;
                            echo "<tr id='krshide$r->khs_id'>
                                <td align='center'>$no</td>
                                <td>".  strtoupper($r->kode_makul)."</td>
                                <td>".  strtoupper($r->nama_makul)."</td>
                                <td>".  strtoupper($r->nama_lengkap)."</td>
                                <td align='center'>".  $r->sks."</td>
                                <td align='center'>".$r->grade."</td>
                                <td align='center'>$r->mutu</td>
                                <td align='center'>$hasilkali</td>
                                ";
                               echo  "
                                </tr>";
                            $no++;
                            $sks=$sks+$r->sks;
                        }
                    }
                     // $krs  =   "SELECT avg(kh.mutu) as mutu
                     //                FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,
                     //                app_dosen as ad,akademik_khs as kh
                     //                WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id
                     //                and ak.nim='$nim' and kh.krs_id=ak.krs_id and ak.semester='$semester' and kh.confirm='1' GROUP BY kh.krs_id";
                     //        $sqlipk           =  $this->db->query($krs)->result();
                     //          foreach ($sqlipk as $r) {
                     //             $ipk = number_format($r->mutu, 2);
                     //           }

                     $ipk = number_format($total/$sks, 2);

                               //simpan nilai index prestasi

                                //cek ip
                                $cekip = cek_ip($nim, $semester);
                                if ($cekip == 0 ) {
                                    $this->db->insert('akademik_ip', array('nim'=>$nim, 'semester'=>$semester,'ip'=>$ipk));
                                    // $ipk = get_ipk($nim);
                                    $this->db->where('nim', $nim);
                                    $this->db->update('student_mahasiswa', array('ipk'=>number_format($ipk, 2)));
                                } else{
                                    // $ipk = get_ipk($nim);
                                    $this->db->where('nim', $nim);
                                    $this->db->update('student_mahasiswa', array('ipk'=>number_format($ipk, 2)));
                                }

                echo"<tr style='font-weight:bold;'>
                        <td colspan='4' align='center'>Total</td>
                        <td align='center'>$sks</td>
                        <td></td>
                        <td align='center'>".$mutu."</td>
                        <td align='center'>".$total."</td>
                        </tr>
                        <tr>
                            <td align='center' colspan='8' style='font-size:13px;font-family:arial;letter-spacing:0.6px;'><b>Index Predikat Kumulatif (IPK) = ".$ipk."</b></td>
                        </tr>
                   </table>";
                }
                ?>
</body>
</html>
