<?php

function editcombo($nama,$table,$class,$field,$pk,$kondisi,$tags,$value,$txt_null='')
{
    $CI =& get_instance();
    $CI->load->model('mcrud');
    if(empty($tags))
    {
        $tagtemp="";
    }
    else
    {
        $tagtemp="";
        foreach($tags as $name => $tag)
        {
            $tagtemp=$tagtemp." $name='$tag' ";
        }
    }
     if($kondisi==null)
    {
      $data=$CI->mcrud->getAll($table)->result();
    }
    else
    {
        $data=$CI->db->get_where($table,$kondisi)->result();
    }
    if ($txt_null!='') {
      $txt_null = 'required';
    }
    echo"<div class='$class'><select class='form-control' name='".$nama."' $tagtemp $txt_null>";
    if ($txt_null!='') {
      echo "<option value=''>- Pilih -</option>";
    }
    foreach ($data as $r)
    {
        echo"<option value='".$r->$pk."' ";
    echo $r->$pk==$value?"selected='selected'":"";
    echo">".strtoupper($r->$field)."</option>";
    }
        echo"</select></div>";
}

function buatcombo($nama,$table,$class,$field,$pk,$kondisi,$tags,$txt_null='')
{
    $CI =& get_instance();
    $CI->load->model('mcrud');

    if(empty($tags))
        {
            $tagtemp="";
        }
        else
        {
            $tagtemp="";
            foreach($tags as $name => $tag)
            {
                $tagtemp=$tagtemp." $name='$tag' ";
            }
        }

    if($kondisi==null)
    {
       $data=$CI->mcrud->getAll($table,$nama)->result();
    }
    else
    {
        $data=$CI->db->get_where($table, $kondisi)->result();
    }

    if ($txt_null!='') {
      $txt_null = 'required';
    }

    echo"<div class='$class'><select name='".$nama."'  class='form-control' $tagtemp $txt_null>";
    if ($txt_null!='') {
      echo "<option value=''>- Pilih -</option>";
    }
    foreach ($data as $r)
    {
        echo" <option value=".$r->$pk.">".strtoupper($r->$field)."</option>";
    }
        echo"</select></div>";
}

function combodumy($name,$id)
{
    return "<select name='$name' id='$id' class='form-control'><option value='0'>Pilih data</option></select>";
}

function rp($x)
{
    if(is_int($x)==FALSE)
    {
        return '';
    }
    else
    {
   return number_format((int)$x,0,",",".");
    }
}

function tahunajaran()
{
   return date('Y') - "1"."/". date('Y');
}

function waktu()
{
   date_default_timezone_set('Asia/Jakarta');
   return date("Y-m-d H:i:s");
}

function tgl_indo($tgl)
{
    return substr($tgl, 8, 2).' '.getbln(substr($tgl, 5,2)).' '.substr($tgl, 0, 4);
}

function tgl_indojam($tgl,$pemisah)
{
    return substr($tgl, 8, 2).' '.getbln(substr($tgl, 5,2)).' '.substr($tgl, 0, 4).' '.$pemisah.' '.  substr($tgl, 11,8);
}


function getbln($bln)
{
    switch ($bln)
    {

        case 1:
            return "Januari";
        break;

        case 2:
            return "Februari";
        break;

        case 3:
            return "Maret";
        break;

        case 4:
            return "April";
        break;

        case 5:
            return "Mei";
        break;

        case 6:
            return "Juni";
        break;

        case 7:
            return "Juli";
        break;

        case 8:
            return "Agustus";
        break;

        case 9:
            return "September";
        break;

         case 10:
            return "Oktober";
        break;

        case 11:
            return "November";
        break;

        case 12:
            return "Desember";
        break;
    }

}

function selisihTGl($tgl1,$tgl2)
{
    $pecah1 = explode("-", $tgl1);
    $date1 = $pecah1[2];
    $month1 = $pecah1[1];
    $year1 = $pecah1[0];

    // memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
    // dari tanggal kedua

    $pecah2 = explode("-", $tgl2);
    $date2 = $pecah2[2];
    $month2 = $pecah2[1];
    $year2 =  $pecah2[0];

    // menghitung JDN dari masing-masing tanggal

    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);

    // hitung selisih hari kedua tanggal

    $selisih = $jd2 - $jd1;
    return $selisih;
}

function seoString($s)
{
    $c = array (' ');
    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');

    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

    $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
    return $s;
}


function breacumb($link)
{
    $CI =& get_instance();
    $main=$CI->db->get_where('mainmenu',array('link'=>$link));
    if($main->num_rows()>0)
    {
        $main=$main->row_array();
        return $main['nama_mainmenu'];
    }
    else
    {
        $sub=$CI->db->get_where('submenu',array('link'=>$link));
        if($sub->num_rows()>0)
        {
            $sub=$sub->row_array();
            return $sub['nama_submenu'];
        }
        else
        {
            return 'tidak diketahui';
        }
    }
}

function jmlPaging()
{
    return 10;
}

function getusersLogin($idusers,$field)
{
    $CI =& get_instance();
    $row=$CI->db->get_where('app_users',array('id_users'=>$idusers));
    if($row->num_rows()>0)
    {
        $row=$row->row_array();
        return $row[$field];
    }
    else
    {
        return '';
    }
}


function getTahunAjaran()
{
    $CI =& get_instance();
    $row=$CI->db->get_where('academic_tahun_ajaran',array('status'=>1))->row_array();
    return $row['tahun_ajaran_id'];
}

function getField($tables,$field,$pk,$value)
{
    $CI =& get_instance();
    $data=$CI->db->query("SELECT $field from $tables where $pk='$value'");
    if($data->num_rows()>0)
    {
        $data=$data->row_array();
        return $data[$field];
    }
    else
    {
        return '';
    }
}


function hitungsiswa($id)
{
    $CI =& get_instance();
    return $CI->db->get_where('student_rombel',array('kelas_id'=>$id))->num_rows();
}


function faktur()
{
    $CI =& get_instance();
    $query = "SELECT max(coba) as coba FROM test";
    $hasil = mysql_query($query);
    $data  = @mysql_fetch_array($hasil);
    $data=$CI->db->query($query)->row_array();
    $kodeUSER = $data['coba'];
    $noUrut = (int) substr($kodeUSER, 18, 6);
    $noUrut++;
    $char = ""; //Aktifkan, Jika ingin menggunakan karakter di depan USER_ID
    $newID = $char . sprintf("%04s", $noUrut);
    return $newID;
}


function kode_daftar($tingkat,$gender)
{
    $CI =& get_instance();
    $query=$CI->db->query("SELECT max(kode_daftar) as kode_daftar FROM pmb_student where gender='$gender' and tingkat='$tingkat'");
    if($query->num_rows()>0)
    {
        $query=$query->row_array();
        $kode=$query['kode_daftar'];
        $noUrut = (int) substr($kode, 9,3);
        $noUrut++;
        //return $noUrut;
        return sprintf("%03s", $noUrut);
        //return (int) $query['kode_daftar'];
    }
    else
    {
        return "001";
    }
}


function ubahtanggal($tanggal)
{
    return $newtanggal= substr($tanggal,8,2).'-'.substr($tanggal, 5,2).'-'.substr($tanggal, 0,4);
}

function ubahtanggal2($tanggal)
{
    return $newtanggal=substr($tanggal,8,2 ).'/'.  substr($tanggal, 5,2).'/'.  substr($tanggal, 0,4);
}

function keteranganlulus($keterangan)
{
    if($keterangan=='tidaklulus')
    {
        return "TIDAK LULUS";
    }
    elseif($keterangan=='lulus')
    {
        return "LULUS";
    }
    else
    {
        return "SEMUA DATA";
    }
}

function psb_hitungssiswa($gender,$tingkat)
{
    $CI =& get_instance();
    $genderid=$tingkat=='smp'?1:2;
    return $CI->db->get_where('pmb_student',array('gender'=>$gender,'tingkat'=>$genderid))->num_rows();
}

function validasi_psb($id,$data)
{
    $CI =& get_instance();
    $stack = array();
    $query = $CI->db->query(  "SELECT nama,
                                tempat_lahir,
                                tanggal_lahir,
                                golongan_darah_id,
                                kabupaten_id,
                                jumlah_saudara_kandung,
                                alamat_rumah,
                                desa,
                                kecamatan,
                                nisn,tahun_lulus,
                                nama_sekolah,
                                alamat_sekolah,
                                kabupaten_id_sekolah,
                                nama_ayah,
                                pekerjaan_ayah,
                                nama_ibu,
                                pekerjaan_ibu,
                                alamat_orang_tua,
                                desa_alamat_ortu,
                                kecamatan_alamat_ortu,
                                kabupaten_id_ortu,
                                orangtua_hp_resmi
                                FROM pmb_student where id_pmb='$id'");
    $r  =   $query->row_array();
    foreach ($query->list_fields() as $field)
        {

            if(empty($r[$field]))
            {
                $pesan=$field." masih kosong";
                array_push($stack, $pesan);
            }
        }
    $find=array('jumlah_saudara_kandung');
    $replace    =   array('jumlah saudara kandung');
    $hasil      =   str_replace($find, $replace,$stack);
    $jumlah     =   count($stack)-1;

    echo "<ul>";
        for($i=0;$i<=$jumlah;$i++)
        {
            echo "<li>$hasil[$i]</li>";
        }
        echo "</ul>";



    if($data=='jumlah')
    {
        return $jumlah;
    }
    else
    {
        return $hasil;
    }

}


    function status_bayar($id)
{
    if($id==0)
    {
        return "Lunas";
    }
    else
    {
        return "Pembayaran Ke $id";
    }
}



function get_tahun_ajaran_aktif($field)
{
     $CI =& get_instance();
     $query     = "  SELECT * FROM akademik_tahun_akademik WHERE status='y'";
     $r          = $CI->db->query($query)->row_array();
     return $r[$field];
}

function cek_ip($nim, $semester)
{
     $CI =& get_instance();
     $query     = "SELECT ip FROM akademik_ip WHERE nim='$nim' and semester='$semester'";
     $r          = $CI->db->query($query)->num_rows();
     return $r;
}

function get_ipk($nim)
{
     $CI =& get_instance();
     $query     = "SELECT AVG(kh.mutu) AS mutu
FROM makul_matakuliah AS mm,akademik_jadwal_kuliah AS jk,akademik_krs AS ak,
app_dosen AS ad,akademik_khs AS kh
WHERE mm.makul_id=jk.makul_id AND ad.dosen_id=jk.dosen_id AND jk.jadwal_id=ak.jadwal_id
AND ak.nim='$nim' AND kh.krs_id=ak.krs_id AND kh.confirm='1'";
     $r          = $CI->db->query($query)->row_array();
     return $r['mutu'];
}

function get_id_prodi($kode_prodi)
{
     $CI =& get_instance();
     $query     = "SELECT prodi_id FROM akademik_prodi WHERE kode_prodi='$kode_prodi' ";
     $r          = $CI->db->query($query)->row_array();
     return $r['prodi_id'];
}

function get_id_konsentrasi($id_prodi)
{
     $CI =& get_instance();
     $query     = "SELECT konsentrasi_id FROM akademik_konsentrasi WHERE prodi_id='$id_prodi' ";
     $r          = $CI->db->query($query)->row_array();
     return $r['konsentrasi_id'];
}

function get_biaya_kuliah($tahun_akademik,$jenis_biaya_kuliah,$konsentrasi,$field)
{
    $CI =& get_instance();
    $where  =   array(  'angkatan_id'=>$tahun_akademik,
                        'jenis_bayar_id'=>$jenis_biaya_kuliah,
                        'konsentrasi_id'=>$konsentrasi);
    $r      =  $CI->db->get_where('keuangan_biaya_kuliah',$where);
    if($r->num_rows()>0)
    {
        $r=$r->row_array();
        return $r[$field];
    }
    else
    {
        return 0;
    }
}

function get_persentase_pembayaran($jumlah_bayar,$sudah_bayar)
{
    if(empty($jumlah_bayar) || empty($sudah_bayar))
    {
        return 0;
    }
    else
    {
        return ($sudah_bayar/$jumlah_bayar)*100;
    }

}

function get_biaya_sudah_bayar($nim,$jenis_bayar_id)
{
    $CI     =   & get_instance();
    $query  =   "SELECT sum(jumlah) as jumlah
                from keuangan_pembayaran_detail
                where nim='$nim' and jenis_bayar_id='$jenis_bayar_id'
                group by jenis_bayar_id";
    $data   =   $CI->db->query($query);
    if($data->num_rows()>0)
    {
        $r  =   $data->row_array();
        return $r['jumlah'];
    }
    else
    {
        return 0;
    }
}

function get_semester_sudah_bayar($nim,$semester)
{
    $CI     =   & get_instance();
    $query  =   "SELECT sum(jumlah) as jumlah
                from keuangan_pembayaran_detail
                where nim='$nim' and jenis_bayar_id='3' and semester='$semester'
                group by jenis_bayar_id";
    $data   =   $CI->db->query($query);
    if($data->num_rows()>0)
    {
        $r  =   $data->row_array();
        return $r['jumlah'];
    }
    else
    {
        return 0;
    }
}


function get_tahun_akademik()
{
    $CI     =   & get_instance();
    $data   =   $CI->db->get_where('akademik_tahun_akademik',array('status'=>'y'))->row_array();
    return $data['tahun_akademik_id'];
}

function chek_bayar($nim,$jenis_bayar,$kode)
{
    // 01 jumlah harus bayar dan 02 jumlah yang sudah dibayar
    $CI     =   & get_instance();
    $m      =   $CI->db->query("select konsentrasi_id,angkatan_id from student_mahasiswa where nim='$nim'")->row_array();
    if($kode==01)
    {

        $j=$CI->db->get_where('keuangan_biaya_kuliah',array( 'jenis_bayar_id'=>$jenis_bayar,'angkatan_id'=>$m['angkatan_id'],'konsentrasi_id'=>$m['konsentrasi_id']))->row_array();
        return  $j['jumlah'];
    }
    else
    {
        $sql="SELECT sum(jumlah) as total from keuangan_pembayaran_detail where nim='$nim' and jenis_bayar_id=$jenis_bayar";
        $data=$CI->db->query($sql);
        if($data->num_rows()>0)
        {
            $r=$data->row_array();
            return $r['total'];
        }
        else
        {
            return 0;
        }
    }
}

function chek_bayar_semester($nim,$semester)
{
    $CI     =   & get_instance();
    $sql="  SELECT sum(jumlah) as jumlah
            FROM keuangan_pembayaran_detail
            WHERE nim='$nim' and jenis_bayar_id='3' and semester='$semester'";
    $data=$CI->db->query($sql);
    if($data->num_rows()>0)
    {
        $r  =   $data->row_array();
        return $r['jumlah'];
    }
    else
    {
        return 0;
    }
}

function jml_spp_konsentrasi($konsentrasi_id,$tahun_akademik_id)
{
    $CI     =   & get_instance();
    // $tahun=  getField('akademik_tahun_akademik', 'tahun_akademik_id', 'tahun', $tahun_akademik_id);
    $data=$CI->db->get_where('keuangan_biaya_kuliah',array('jenis_bayar_id'=>3,'konsentrasi_id'=>$konsentrasi_id,'angkatan_id'=>$tahun_akademik_id));
    if($data->num_rows()>0)
    {
        $r=$data->row_array();
        return $r['jumlah'];
    }
    else
    {
        return 'empty';
    }
    //return $tahun_akademik_id;
}



    function jml_spp_konsentrasi2($konsentrasi_id,$tahun_akademik_id)
{
    $CI     =   & get_instance();
    // $tahun=  getField('akademik_tahun_akademik', 'tahun_akademik_id', 'tahun', $tahun_akademik_id);
    $data=$CI->db->get_where('keuangan_biaya_kuliah',array('jenis_bayar_id'=>3,'konsentrasi_id'=>$konsentrasi_id,'angkatan_id'=>$tahun_akademik_id));
    if($data->num_rows()>0)
    {
        $r=$data->row_array();
        return $r['jumlah'];
    }
    else
    {
        return 'empty';
    }
    //return $tahun_akademik_id;
}


function status_registrasi($tahun_akademik_id,$nim,$field)
{
    $CI     =   & get_instance();
    $data=$CI->db->get_where('akademik_registrasi',array('nim'=>$nim,'tahun_akademik_id'=>$tahun_akademik_id));
    if($data->num_rows()<0)
    {
        return '';
    }
    else
    {
        $r=$data->row_array();
        return $r[$field];
    }
}

function users_keterangan($level,$keterangan)
{
    if($level==2)
    {

        return getField('akademik_prodi', 'nama_prodi', 'prodi_id', $keterangan);
    }
    elseif($level==3)
    {
        return getField('app_dosen', 'nama_lengkap', 'dosen_id', $keterangan);
    }
    else
    {
        return '';
    }
}

function akses_admin()
{
    $CI     =   & get_instance();
    $sess=$CI->session->userdata('level');
    if($sess==1 OR $sess==2)
    {
         "";
    }
    else{
        redirect('Message/pesan');
    }

}

function akses_dosen()
{
    $CI     =   & get_instance();
    $sess   =   $CI->session->userdata('level');
    $dosen  =   $CI->session->userdata('keterangan');
    if($sess==3)
    {
        // chek id ada atau tidak
        $chek   =$CI->db->get_where('app_dosen',array('dosen_id'=>$dosen))->num_rows();
        if($chek<1)
        {
            redirect('login');
        }
    }
    else
    {
        redirect('login');
    }
}

function chek_jadwal_kuliah($konsentrasi,$hari,$tahun_akademik,$semester,$no)
{
    $CI     =   & get_instance();
    $sql="  SELECT jk.jam_mulai,jk.jam_selesai,ah.hari,mm.nama_makul,ar.nama_ruangan,jk.dosen_id,jk.dosen_id2,jk.dosen_id3
            FROM akademik_jadwal_kuliah as jk,app_hari as ah,makul_matakuliah as mm,app_ruangan as ar,app_dosen as ad
            WHERE jk.hari_id=ah.hari_id and mm.makul_id=jk.makul_id and ar.ruangan_id=jk.ruangan_id and ad.dosen_id=jk.dosen_id
            -- and jk.tahun_akademik_id='$tahun_akademik' 
            and jk.konsentrasi_id='$konsentrasi' and jk.semester='$semester' and jk.hari_id='$hari' limit $no,1";
    $data=$CI->db->query($sql);
    if($data->num_rows()>0)
    {
        $r=$data->row_array();
        $nama1='';
        $nama2='';
        $nama3='';
        if($r['dosen_id'] != null){
            $a1 = $CI->db->get_where('app_dosen', array('dosen_id'=>$r['dosen_id']))->row();
            $nama1 = $a1->nama_lengkap;
        }
        if($r['dosen_id2'] != null){
            $a2 = $CI->db->get_where('app_dosen', array('dosen_id'=>$r['dosen_id2']))->row();
            $nama2 = $a2->nama_lengkap;
        }
        if($r['dosen_id3'] != null){
            $a3 = $CI->db->get_where('app_dosen', array('dosen_id'=>$r['dosen_id3']))->row();
            $nama3 = $a3->nama_lengkap;
        }
        return strtoupper($r['nama_makul']).'<br> - '.  strtoupper($nama1).'<br> - '. strtoupper($nama2).'<br> - '. strtoupper($nama3).'<br>'. strtoupper($r['hari']).', '.$r['jam_mulai'].' - '.$r['jam_selesai'].'</b><br>RUANGAN '.  strtoupper($r['nama_ruangan']);
    }
    else
    {
        return '';
    }
}

function inputan($type,$names,$class,$placeholder,$required,$values,$tags)
{
    if(empty($tags))
    {
        $tagtemp="";
    }
    else
    {
        $tagtemp="";
        foreach($tags as $name => $tag)
        {
            $tagtemp=$tagtemp." $name='$tag' ";
        }
    }
    $requred=$required==0?'':"required='required'";
    return "<div class='$class'><input type='$type' name='$names' placeholder='$placeholder' class='form-control' $requred value='$values' $tagtemp></div>";
}

function textarea($name,$id,$class,$rows,$values)
{
        return "<div class='$class'><textarea name='".$name."' id='".$id."' rows='".$rows."' class='form-control'>".$values."</textarea></div>";
}

?>
