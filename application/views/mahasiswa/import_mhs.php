<script>
  $(document).ready(function(){
    // Sembunyikan alert validasi kosong
    $("#kosong").hide();
  });
  </script>

<form action="<?php echo base_url() ?>mahasiswa/form_import" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Hanya File .xlsx</label>
              <input type="file" name="file" class="form-control">
            </div>
            <input type="submit" name="preview" value="Preview" class="btn btn-primary">
          </form>

          <?php
          if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
            if(isset($upload_error)){ // Jika proses upload gagal
              echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
              die; // stop skrip
            }
            
            // Buat sebuah tag form untuk proses import data ke database
            echo "<form method='post' action='".base_url("mahasiswa/aksi_import")."'>";
            
            // Buat sebuah div untuk alert validasi kosong
            echo "<div style='color: red; display: none;' id='kosong'>
            Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
            </div>";
            
            
            echo "<table class='table table-bordered'>
            <tr>
              <th colspan='7'>Preview Data</th>
            </tr>
            <tr>
              <th>Nim</th>
              <th>Nama</th>
              <th>Tempat Lahir</th>
              <th>Tanggal Lahir</th>
              <th>Jenis Kelamin</th>
              <th>Nik</th>
              <th>Agama</th>
            </tr>";
            
            $numrow = 1;
            $kosong = 0;
            
            // Lakukan perulangan dari data yang ada di excel
            // $sheet adalah variabel yang dikirim dari controller
            foreach($sheet as $row){ 
              // Ambil data pada excel sesuai Kolom
              $nim = $row['A']; // Ambil data NIS
              $nama = $row['B']; // Ambil data nama
              $tempat_lahir = $row['C']; // Ambil data jenis kelamin
              $tgl_lahir = $row['D']; // Ambil data alamat
              $jenis_kelamin = $row['E']; // Ambil data alamat
              $nik = $row['F']; // Ambil data alamat
              $agama = $row['G']; // Ambil data alamat
              
              // Cek jika semua data tidak diisi
              if(empty($nim) && empty($nama) && empty($tempat_lahir) && empty($tgl_lahir) && empty($jenis_kelamin) && empty($nik) && empty($agama))
                continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
              
              // Cek $numrow apakah lebih dari 1
              // Artinya karena baris pertama adalah nama-nama kolom
              // Jadi dilewat saja, tidak usah diimport
              if($numrow > 1){
                // Validasi apakah semua data telah diisi
                $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                $tempatl_td = ( ! empty($tempat_lahir))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                $tgll_td = ( ! empty($tgl_lahir))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                $jk_td = ( ! empty($jenis_kelamin))? "" : " style='background: #E07171;'"; 
                $nik_td = ( ! empty($nik))? "" : " style='background: #E07171;'"; 
                $agama_td = ( ! empty($agama))? "" : " style='background: #E07171;'"; 
                
                // Jika salah satu data ada yang kosong
                if(empty($nim) or empty($nama) or empty($tempat_lahir) or empty($tgl_lahir) or empty($jenis_kelamin) or empty($nik) or empty($agama)){
                  $kosong++; // Tambah 1 variabel $kosong
                }
                
                echo "<tr>";
                echo "<td".$nim_td.">".$nim."</td>";
                echo "<td".$nama_td.">".$nama."</td>";
                echo "<td".$tempatl_td.">".$tempat_lahir."</td>";
                echo "<td".$tgll_td.">".$tgl_lahir."</td>";
                echo "<td".$jk_td.">".$jenis_kelamin."</td>";
                echo "<td".$nik_td.">".$nik."</td>";
                echo "<td".$agama_td.">".$agama."</td>";
                echo "</tr>";
              }
              
              $numrow++; // Tambah 1 setiap kali looping
            }
            
            echo "</table>";
            
            // Cek apakah variabel kosong lebih dari 1
            // Jika lebih dari 1, berarti ada data yang masih kosong
            if($kosong > 1){
            ?>  
              <script>
              $(document).ready(function(){
                // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                $("#jumlah_kosong").html('<?php echo $kosong; ?>');
                
                $("#kosong").show(); // Munculkan alert validasi kosong
              });
              </script>
            <?php
            }else{ // Jika semua data sudah diisi
              echo "<hr>";
              
              // Buat sebuah tombol untuk mengimport data ke database
              echo "<button type='submit' name='import' class='btn btn-primary'>Import</button>";
              echo "<a href='".base_url("index.php/mahasiswa")."' class='btn btn-primary'>Cancel</a>";
            }
            
            echo "</form>";
          }
          ?>