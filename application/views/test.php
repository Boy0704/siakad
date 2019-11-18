<?php 
  // echo "
  //       <table class='table table-bordered'>
  //        <tr>
  //       <td colspan=6>
  //       <button onclick='loadtablemapel($id)' class='btn btn-primary btn-sm'><i class='fa fa-shopping-cart'></i> Input KRS</button> ";
  //       echo anchor('cetak/cetakkrs/'.$d['nim'].'/'.$semester_aktif,'<i class="fa fa-print"></i> Cetak KRS',array('class'=>'btn btn-default btn-sm','target'=>'_blank'));
  //       echo anchor('cetak/kum/'.$d['nim'].'/'.$semester_aktif,'<i class="fa fa-print"></i> Cetak KUM',array('class'=>'btn btn-default btn-sm','target'=>'_blank'));
  //       echo "
  //       </tr>
  //       <tr>
  //           <td width='150'>NAMA</td><td>".  strtoupper($d['nama'])."</td>
  //           <td width=100>NIM</td><td>".  strtoupper($d['nim'])."</td><td rowspan='2' width='70'><img src='".  base_url()."assets/images/avatar.png' width='50'></td>
  //       </tr>
  //       <tr>
  //           <td>Prodi / Konsentrasi</td><td>".  strtoupper($d['nama_prodi'].' / '.$d['nama_konsentrasi'])."</td>
  //           <td>SEMESTER</td><td>".$d['semester_aktif']."</td>
  //       </tr>
  //       </table>
        
  //       <table class='table table-bordered' id='daftarkrs'>
  //       <tr class='alert-info'><th width='5'>No</th>
  //       <th width='80'>KODE</th>
  //       <th>NAMA MATAKULIAH</th>
  //       <th width=10>SKS</th>
  //       <th>DOSEN PENGAPU</th>
  //       <th width='10'>Hapus</th></tr>";
  //       $sks=0;
  //       if($data->num_rows()<1)
  //       {
  //           echo "<tr><td colspan=6 align='center' class='warning'>DATA KRS TIDAK DITEMUKAN</td></tr>";
  //       }
  //       else
  //       {
  //           $no=1;
            
  //           foreach ($data->result() as $r)
  //           {
  //               echo "<tr id='krshide$r->krs_id'>
  //                   <td align='center'>$no</td>
  //                   <td align='center'>".  strtoupper($r->kode_makul)."</td>
  //                   <td>".  strtoupper($r->nama_makul)."</td>
  //                   <td align='center'>".  $r->sks."</td>
  //                   <td>".  strtoupper($r->nama_lengkap)."</td>
  //                   <td align='center'><a href='javascript:void(0)' class='btn btn-sm btn-danger fa fa-trash-o' title='Batal Ambil Matakuliah' onclick='hapus($r->krs_id)'></a></td>
  //                   </tr>";
  //               $no++;
  //               $sks=$sks+$r->sks;
  //           }
  //       }
  //   if ($sks>24) {
  //       echo "<script>swal('Info','Maksimal Pengambilan KRS Adalah 24 SKS, silahkan dikurangi KRS nya!!','info')</script>";
  //   }
  //   echo"<tr><td colspan='3' align='right'>Total SKS</td><td align='center'>$sks</td><td colspan=2></td></tr>
    
  //       </table>";

