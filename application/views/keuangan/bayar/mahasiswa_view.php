<table class='table table-bordered'>
             <?php
                    $id   = $this->session->userdata('keterangan');
                    $thn  =  get_tahun_ajaran_aktif('tahun_akademik_id');
                    $semester_aktif =  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $id);
                    $mhs  = "SELECT sm.nim,sm.nama,sm.semester_aktif,ap.nama_prodi,ak.nama_konsentrasi
                                FROM student_mahasiswa as sm,akademik_konsentrasi as ak,akademik_prodi as ap
                                WHERE ap.prodi_id=ak.prodi_id and sm.konsentrasi_id=ak.konsentrasi_id and sm.mahasiswa_id=$id";
                    $d    = $this->db->query($mhs)->row();
                    $nim  =  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $id);
                    $krs  =   "SELECT ak.krs_id,mm.kode_makul,mm.nama_makul,mm.sks,ad.nama_lengkap
                                FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak,app_dosen as ad
                                WHERE mm.makul_id=jk.makul_id and ad.dosen_id=jk.dosen_id and jk.jadwal_id=ak.jadwal_id and jk.tahun_akademik_id='$thn' and ak.nim='$nim' and ak.semester='".$d->semester_aktif."'";
                    $data =  $this->db->query($krs);

                ?>
            <tr class="alert-info"><th colspan="5">Tabel Mahasiswa</th></tr>
            <tr>
                <td width='150'>NAMA</td><td><?php echo strtoupper($d->nama); ?></td>
                <td width=100>NIM</td><td><?php echo strtoupper($d->nim)?></td><td rowspan='2' width='70'><img width='50' src=<?php echo base_url()."assets/images/avatar.png"?> ></td>
            </tr>
            <tr>
                <td>Prodi / Konsentrasi</td><td><?php echo strtoupper($d->nama_prodi.' / '.$d->nama_konsentrasi); ?></td>
                <td>SEMESTER</td><td><?php echo $d->semester_aktif; ?> </td>
            </tr>
        </table>
<?php
if($statuss!="kosong"){
?>
<table class="table table-bordered">
    <tr class="alert-info"><th colspan="7">Riwayat Transaksi Pembayaran Anda</th></tr>
    <tr><th width="10">No</th>
        <th width="240">Jenis Pembayaran</th>
        <th width="180">Harus Dibayar</th>
        <th width="180">Sudah Dibayar</th>
        <th width="60">Sisa</th>
        <th width="120">Persentase %</th>
        <th>Keterangan</th></tr>
<?php
    // tahun akademik ketika masuk
    $tahun_akademik_id=  getField('student_mahasiswa', 'angkatan_id', 'nim', $nim);
    // konsentrasi
    $konsentrasi_id=getField('student_mahasiswa', 'konsentrasi_id', 'nim', $nim);
    $no=1;
    foreach ($jenis_bayar as $jb)
    {
        $jumlah_bayar   =(int) get_biaya_kuliah($tahun_akademik_id, $jb->jenis_bayar_id, $konsentrasi_id, 'jumlah');
        $sudah_bayar    = (int)get_biaya_sudah_bayar($nim, $jb->jenis_bayar_id);
        $sisa           = $jumlah_bayar-$sudah_bayar;
        $ket           = $sisa<=0?'Lunas':'Tunggakan '.rp($sisa);
        echo "<tr align='center'><td>$no</td>
            <td>".  strtoupper($jb->keterangan)."</td>
            <td>".rp($jumlah_bayar)."</td>
            <td>".rp($sudah_bayar)."</td>
            <td>".rp($sisa)."</td>
            <td>".  get_persentase_pembayaran($jumlah_bayar, $sudah_bayar)." %</td>";
            if ($sisa<=0) {
                echo "<td><span class='label label-success'>".$ket."</span></td>";
            }
            else{
                echo "<td><span class='label label-warning'>".$ket."</span></td>"; 
            }
        echo "</tr>";
        $no++;
    }
    // get semester aktif
    $smt_aktif = getField('student_mahasiswa', 'semester_aktif', 'nim', $nim);
    // looping semester
    for($i=1;$i<=$smt_aktif;$i++)
    {
        $spp            =   (int) get_biaya_kuliah($tahun_akademik_id, 3, $konsentrasi_id, 'jumlah');
        $spp_udah_bayar =   (int)get_semester_sudah_bayar($nim, $i);
        $sisa           =   $spp-$spp_udah_bayar;
        $keterangan           =   $sisa<=0?'Lunas':'Tunggakan '.$sisa;
        echo "<tr align='center'><td>$no</td>
            <td>BPP SEMESTER $i</td>
            <td>".rp($spp)."</td>
            <td>".rp($spp_udah_bayar)."</td>
            <td>$sisa</td>
            <td>".  rp(get_persentase_pembayaran($spp, $spp_udah_bayar))." %</td>";
            if ($sisa<=0) {
                echo "<td><span class='label label-success'>".$keterangan."</span></td>";
            }
            else{
                echo "<td><span class='label label-warning'>".$keterangan."</span></td>"; 
            }
        echo "</tr>";
        $no++;
    }
?>

</table>

<table class="table table-bordered">
    <tr class="alert-info"><th colspan="7">Riwayat Transaksi Detail</th></tr>
    <tr><th width="10">No</th>
        <th width="500">Jenis Pembayaran</th>
        <th width="120">Tanggal</th>
        <th width="160">Jumlah</th>
    <?php
    $i=1;
    
    foreach ($transaksi as $r)
    {
        $smt=$r->jenis_bayar_id==3?$r->semester:'';
        echo "<tr>
            <td align='center'>$i</td>
            <td>".  strtoupper($r->keterangan)." $smt</td>
            <td>".  tgl_indo($r->tanggal)."</td>
            <td>Rp .".rp((int)$r->jumlah)."</td>
            <td>".  strtoupper($r->nama)."</td>
            </tr>";
        $i++;
    }
    ?> 
</table>


<?php
}
else
{
?>

<?php } ?>