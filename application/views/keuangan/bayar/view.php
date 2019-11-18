<script src="<?php echo base_url();?>assets/js/1.8.2.min.js"></script>
  <script>
  $( document ).ready(function() { 
      hidesemster();
  });
</script>

  <script type="text/javascript">
$(document).ready(function(){
  $("#jenis_pembayaran").change(function(){
       hidesemster();
  });
});
</script>

<script type="text/javascript">
function hidesemster()
{
     var jenis_pembayaran=$("#jenis_pembayaran").val();
        if(jenis_pembayaran==3)
            {
                $("#semester").show()
            }
            else
            {
                 $("#semester").hide()
            }
}
</script>
<?php
$status=array(0=>'Lunas',1=>'Pembayaran Ke 1',2=>'Pembayaran Ke 2',3=>'Pembayaran Ke 3',4=>'Pembayaran Ke 4');
?>
<?php
echo form_open('keuangan/pembayaran');
?>
<table class="table table-bordered">
    <tr  class="alert-info"><th colspan="3">Data Mahasiswa </th></tr>
    <tr><td width="150">NIM Mahasiswa</td><td> <?php echo inputan('text', 'nim','col-sm-6','Masukan Nim ..', 1, '','');?> <input type="submit" value="OK" name="submit" class="btn btn-primary"> <?php echo anchor('keuangan/reset','Reset',array('class'=>'btn btn-primary'));?></td>
        <td wisth="90" align="center" rowspan="3"><img src="<?php echo base_url()?>assets/images/noprofile.gif" width="85"></td>
    </tr>
    <tr><td>Nama</td><td>  : <?php echo $statuss=="kosong"?"":strtoupper($profile['nama'])?></td></tr>
    <tr><td>Prodi / Konsentrasi</td><td> : <?php echo $statuss=="kosong"?"":strtoupper($profile['nama_konsentrasi'].' / '.$profile['nama_prodi'])?></td></tr>
 
</table>
</form>

<?php
echo form_open('keuangan/pembayaran');
?>
    <table class="table table-bordered">
        <tr  class="alert-info"><th colspan="2">Form Transaksi</th></tr>
        <tr><td width="150">Jenis Pembayaran</td><td>
            <?php echo buatcombo('jenis','keuangan_jenis_bayar','col-sm-3','keterangan','jenis_bayar_id','',array('id'=>'jenis_pembayaran')); ?>
                <div class="col-md-3">
                    <select name="semester" id="semester" class="form-control">
                        <?php 
                        for($sms=1;$sms<=8;$sms++)
                        {
                            echo "<option VALUE='$sms'>SEMESTER $sms</option>";
                        }
                        ?>
                    </select>
                </div>
            </td></tr>
       
        <tr><td>Jumlah Bayar</td><td><?php echo inputan('text', 'jumlah','col-sm-3','Jumlah ..', 1, '','');?> <input type="submit" name="submit2" value="Simpan" class="btn btn-primary"></td></tr>
    </table>
</form>
<?php
if($statuss!="kosong"){
?>
<table class="table table-bordered">
    <tr class="alert-info"><th colspan="7">Riwayat Transaksi</th></tr>
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
    <tr><td colspan="7"><?php echo anchor('keuangan/cetakpersonal','<span class="fa fa-print"></span> Cetak Data',array('class'=>'btn btn-primary','target'=>'new'))?></td></tr>
</table>

<table class="table table-bordered">
    <tr class="alert-info"><th colspan="7">Riwayat Transaksi Detail</th></tr>
    <tr><th width="10">No</th>
        <th width="500">Jenis Pembayaran</th>
        <th width="120">Tanggal</th>
        <th width="160">Jumlah</th>
        <th width="200">Petugas</th><th width="10">Operasi</th></tr>
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
            <td align='center'>".anchor('keuangan/delete/'.$r->pembayara_detail_id,'<i class="btn btn-danger fa fa-trash-o"></i>',array('title'=>'Hapus Catatan', 'data-placement'=>'bottom', 'data-toggle'=>'tooltip'))."</td></tr>";
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
