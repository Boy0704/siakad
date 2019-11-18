<script>
  $(document).ready(function(){
    // Sembunyikan alert validasi kosong
    $("#kosong").hide();
  });
  </script>

<form action="<?php echo base_url() ?>krs/form_import" method="post" enctype="multipart/form-data">
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
            echo "<form method='post' action='".base_url("krs/aksi_import")."'>";

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
              <th>Semester</th>
              <th>Kode Matakuliah</th>
              <th>Nama Mata Kuliah</th>
              <th>Kelas</th>
              <th>Kode Prodi</th>
            </tr>";

            $numrow = 1;
            $kosong = 0;

            // Lakukan perulangan dari data yang ada di excel
            // $sheet adalah variabel yang dikirim dari controller
            foreach($sheet as $row){
              // Ambil data pada excel sesuai Kolom
              $nim = $row['A'];
              $nama = $row['B'];
              $semester = $row['C'];
              $kode_matakuliah = $row['D'];
              $nama_mata_kuliah = $row['E'];
              $kelas = $row['F'];
              $kode_prodi = $row['G'];

              // Cek jika semua data tidak diisi
              if(empty($nim) && empty($nama) && empty($semester) && empty($kode_matakuliah) && empty($nama_mata_kuliah) && empty($kelas) && empty($kode_prodi))
                continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

              // Cek $numrow apakah lebih dari 1
              // Artinya karena baris pertama adalah nama-nama kolom
              // Jadi dilewat saja, tidak usah diimport
              if($numrow > 1){
                // Validasi apakah semua data telah diisi
                $nim_td = ( ! empty($nim))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
                $nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
                $semester_td = ( ! empty($semester))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                $kode_matakuliah_td = ( ! empty($kode_matakuliah))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                $nama_mata_kuliah_td = ( ! empty($nama_mata_kuliah))? "" : " style='background: #E07171;'";
                $kelas_td = ( ! empty($kelas))? "" : " style='background: #E07171;'";
                $kode_prodi_td = ( ! empty($kode_prodi))? "" : " style='background: #E07171;'";

                // Jika salah satu data ada yang kosong
                if(empty($nim) or empty($nama) or empty($semester) or empty($kode_matakuliah) or empty($nama_mata_kuliah) or empty($kelas) or empty($kode_prodi)){
                  $kosong++; // Tambah 1 variabel $kosong
                }

                echo "<tr>";
                echo "<td".$nim_td.">".$nim."</td>";
                echo "<td".$nama_td.">".$nama."</td>";
                echo "<td".$semester_td.">".$semester."</td>";
                echo "<td".$kode_matakuliah_td.">".$kode_matakuliah."</td>";
                echo "<td".$nama_mata_kuliah_td.">".$nama_mata_kuliah."</td>";
                echo "<td".$kelas_td.">".$kelas."</td>";
                echo "<td".$kode_prodi_td.">".$kode_prodi."</td>";
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
              echo "<a href='".base_url("index.php/krs")."' class='btn btn-primary'>Cancel</a>";
            }

            echo "</form>";
          }
          ?>
