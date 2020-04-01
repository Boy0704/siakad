<div class="row">
    <div class="col-md-12">
         <table class="table table-bordered">
           <?php foreach ($tahun_akademik as $t) { ?>
            <tr class='alert-info'><th colspan="8">Jadwal Kuliah</th></tr>
            <tr>
                <th width="200">Tahun Akademik</th>
                <td><?php echo get_tahun_ajaran_aktif('keterangan'); ?> </td>      
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>SEMESTER <?php echo substr($t->keterangan,4,1)==1?'GANJIL':'GENAP';?></td>      
            </tr>

            <?php
           } 
           ?>
        </table>
        <table class='table table-bordered' id='jadwal'>
           
            <tr class='alert-info'><th width=7>No</th>
                <th width=120>Hari</th>
                <th>Kode</th>
                <th>Matakuliah</th>
                <th width=5>SKS</th>
                <th width=115>Ruang</th>
                <th  width=154>Jam</th>
                <th>Dosen</th>
            </tr>
        <?php  

        $i=1;
        $kon = $this->session->userdata('konsentrasi_id');
        $sql="SELECT jk.*,mm.jam,mm.nama_makul,mm.kode_makul,mm.sks,mm.semester,jk.jam_mulai,jk.jam_selesai,ah.hari,ar.nama_ruangan,ad.nama_lengkap FROM akademik_jadwal_kuliah as jk,makul_matakuliah as mm, app_hari as ah, app_ruangan as ar, app_dosen as ad WHERE mm.makul_id=jk.makul_id and jk.hari_id=ah.hari_id and jk.ruangan_id=ar.ruangan_id and jk.dosen_id=ad.dosen_id and jk.tahun_akademik_id=$thn and jk.konsentrasi_id=$kon and jk.semester=$semester";
            $data=  $this->db->query($sql)->result();
            $class="class='form-control'";
            if (empty($data) || $semester == '') 
            {
                 echo" <td colspan='8' style='text-align:center;font-size:18px;'><i class='fa fa-info' style='font-size:60px;'></i><br>OPS DATA TIDAK DITEMUKAN</td>";
            }
            else{
               

                foreach ($data as $r)
                {
                echo    "<tr>
                            <td align='center'>$i</td>
                            <td>".  strtoupper($r->hari)."</td>
                            <td>".  strtoupper($r->kode_makul)."</td>
                            <td>".  strtoupper($r->nama_makul)."</td>
                            <td align='center'>".$r->sks."</td>
                            <td>".  strtoupper($r->nama_ruangan)."</td>
                            <td align='center'>".  strtoupper($r->jam_mulai)." - " .$r->jam_selesai."</td>
                            <td align='center'>".  strtoupper($r->nama_lengkap)."</td>
                        </tr>";
                    $i++;
                }    
            }
            
        ?>
        </table>
    </div>
</div>