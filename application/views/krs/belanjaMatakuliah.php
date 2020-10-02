<?php 
$tahun_akademik_aktif = get_tahun_ajaran_aktif('tahun_akademik_id');
$cek = $this->db->get_where('akademik_registrasi', array('tahun_akademik_id'=>$tahun_akademik_aktif,'nim'=>$this->session->userdata('username')));
if ($cek->num_rows() == 0) {
    $this->session->set_flashdata('message',alert_biasa(" Kamu belum terigistrasi di tahun akademik ini ",'error'));
    redirect('krs','refresh');
    // exit();
}
 ?>

<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script>
function ambil(jadwal_id,mahasiswa_id,sisa_ruang)
{
    if (sisa_ruang == 0 || sisa_ruang < 0) {
        alert("INFO: RUANGAN SUDAH PENUH !!");
    } else {
        $.ajax({
        url:"<?php echo base_url();?>krs/post",
        data:"jadwal_id=" + jadwal_id+"&mahasiswa_id="+mahasiswa_id,
      dataType: "JSON",
        success: function(data)
        {
            if (data.status=='0') {
              alert("INFO: SKS Lebih Dari "+data.max_sks+" SKS !!");
              location.reload();
            } else if (data.status=='01') {
                alert("Ada eror system, silahkan ulangi lagi");
              location.reload();
            }else {
              $("#hide"+jadwal_id).hide(300);
            }
        }
        });
    }
  

}
</script>

<div class="row">
	<div class="col-md-12">
		<table class='table table-bordered'>
            <tr class='alert-info'><th colspan=8>DAFTAR MATAKULIAH</th><th colspan=3><a href="<?php echo base_url('krs'); ?>" class="btn btn-primary"><i class="fa fa-mail-reply-all"></i> Kembali</a></th></tr>
            <tr class='alert-info'><th width=10>No</th><th width=20>Kode</th>
                <th>Nama Matakuliah</th>
                <th>Dosen</th>
                <th width=60>SKS</th>
                <th width=60>HARI</th>
                <th width=60>RUANG</th>
                <th width=60>WAKTU</th>
                <th width=60>KUOTA KELAS</th>
                <th width=60>SISA</th>
                <th>Ambil</th>
            </tr>
            <?php
                if ($this->session->userdata('konsentrasi_id')) {
                    echo "";
                }
                else
                {
                    echo"<tr>
                            <td colspan='11' style='text-align:center;font-size:18px;'><i class='fa fa-info' style='font-size:60px;'></i><br>OPS DATA TIDAK DITEMUKAN</td>
                        </tr>";
                }

            $thn            =  get_tahun_ajaran_aktif('tahun_akademik_id');
            $ket_thn = substr(get_data('akademik_tahun_akademik','tahun_akademik_id',$thn,'keterangan'), 4);
            $mahasiswa_id = $this->session->userdata('keterangan');
            $nim=  getField('student_mahasiswa', 'nim', 'mahasiswa_id', $mahasiswa_id);
            $semester_aktif=  getField('student_mahasiswa', 'semester_aktif', 'mahasiswa_id', $mahasiswa_id);
            $max_sks = $this->Import_mhs->cek_sks_old($nim,$semester_aktif);
            $krs            =   "SELECT sum(mm.sks) as sks
                                FROM makul_matakuliah as mm,akademik_jadwal_kuliah as jk,akademik_krs as ak WHERE jk.makul_id=mm.makul_id and jk.jadwal_id=ak.jadwal_id and ak.nim=$nim";

            $data           =  $this->db->query($krs)->result();
            // print_r($data->sks);
            $sksbatas = 0;
            foreach ($data as $r)
            {
               $sksbatas = $r->sks;
            }

            $kon = $this->session->userdata('konsentrasi_id');
            $data=  $this->db->get_where('akademik_konsentrasi',array('konsentrasi_id'=>$kon))->row_array();
        	$jmlSemester=$data['jml_semester'];
            for($i=1;$i<=$jmlSemester;$i++)
            {
                if ($ket_thn == '1' and $i%2==1) {
                    echo"<tr class='warning'><td colspan=10>Semester $i</td></tr>";
                    $query = "SELECT jk.hari_id, jk.makul_id, mm.kode_makul,mm.sks,mm.jam,mm.nama_makul,mm.sks,jk.jadwal_id,ds.nama_lengkap,jk.ruangan_id FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ds WHERE mm.makul_id=jk.makul_id and jk.konsentrasi_id=$kon and mm.semester=$i and tahun_akademik_id='$thn' and ds.dosen_id=jk.dosen_id and jk.jadwal_id not in(select jadwal_id from akademik_krs where nim='$nim' and semester = '$i')";
                    $makul = $this->db->query($query)->result();
                }else{
                    echo"<tr class='warning'><td colspan=10>Semester $i</td></tr>";
                    $query = "SELECT jk.hari_id, jk.makul_id, mm.kode_makul,mm.sks,mm.jam,mm.nama_makul,mm.sks,jk.jadwal_id,ds.nama_lengkap,jk.ruangan_id FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ds WHERE mm.makul_id=jk.makul_id and jk.konsentrasi_id=$kon and mm.semester=$i and tahun_akademik_id='$thn' and ds.dosen_id=jk.dosen_id and jk.jadwal_id not in(select jadwal_id from akademik_krs where nim='$nim' and semester = '$i')";
                    $makul = $this->db->query($query)->result();
                    // log_r($this->db->last_query());
                }

                // echo"<tr class='warning'><td colspan=10>Semester $i</td></tr>";
                //     $query = "SELECT jk.makul_id, mm.kode_makul,mm.sks,mm.jam,mm.nama_makul,mm.sks,jk.jadwal_id,ds.nama_lengkap,jk.ruangan_id FROM akademik_jadwal_kuliah as jk, makul_matakuliah as mm, app_dosen as ds WHERE mm.makul_id=jk.makul_id and mm.konsentrasi_id=$kon and mm.semester=$i and tahun_akademik_id='$thn' and ds.dosen_id=jk.dosen_id and jk.jadwal_id not in(select jadwal_id from akademik_krs where nim='$nim')";
                //     $makul = $this->db->query($query)->result();
                
                $no=1;


                foreach ($makul as $m)
                {
                    echo"<tr id='hide$m->jadwal_id'><td>$no</td>
                        <td>".  strtoupper($m->kode_makul)."</td>
                        <td>".  strtoupper($m->nama_makul)."</td>
                        <td>".  strtoupper($m->nama_lengkap)."</td>
                        <td>$m->sks SKS</td>
                        <td>".  strtoupper(get_data('app_hari','hari_id',$m->hari_id,'hari'))."</td>
                        <td>".  strtoupper(get_data('app_ruangan','ruangan_id',$m->ruangan_id,'nama_ruangan'))."</td>
                        <td>".  get_data('akademik_jadwal_kuliah','jadwal_id',$m->jadwal_id,'jam_mulai')." - ".get_data('akademik_jadwal_kuliah','jadwal_id',$m->jadwal_id,'jam_selesai')."</td>
                        <td>".  strtoupper(get_data('akademik_jadwal_kuliah','jadwal_id',$m->jadwal_id,'kuota'))."</td>
                        <td>".  strtoupper(cek_sisa_kuota($m->jadwal_id))."</td>
                        ";
                        // if ($sksbatas>=$max_sks) {
                        //      echo "<td width='10' id='ambil' align='center'><span class='btn btn-sm btn-primary disabled' title='SKS MAKSIMUM'>Ambil</span></td>";
                        // }
                        // else{
                        //      echo "<td width='10' id='ambil' align='center'><span class='btn btn-sm btn-primary' onclick='ambil($m->jadwal_id,$mahasiswa_id)' title='Ambil Matakuliah'>Ambil</span></td>";
                        // }
                        $sisa_ruang = cek_sisa_kuota($m->jadwal_id);
                        echo "<td width='10' id='ambil' align='center'><span class='btn btn-sm btn-primary' onclick='ambil($m->jadwal_id,$mahasiswa_id,$sisa_ruang)' title='Ambil Matakuliah'>Ambil</span></td>";
                        echo "</tr>";
                    $no++;
                }

            }
        ?>
        </table>
	</div>
</div>
