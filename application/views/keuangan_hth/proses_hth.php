<?php
/*
Script ini hanyalah contoh. Untuk implementasi silahkan sesuaikan dengan struktur database di kampus.
*/
// konfigurasi
$kampus     = 'STAIN Sultan Abdurrahman Kepulauan Riau';
$secret_key = 'ahjsg@6567JHJ47KJHksa;pd'; // contoh

//$allowed_ips = array('119.2.80.1', '119.2.80.2', '119.2.80.3'); // ini adalah IP Switching Makara. Silahkan ditambahkan IP mana saja yang diperbolehkan akses.
$allowed_ips               = array('127.0.0.1','::1','114.125.62.84', '103.236.151.58','103.219.249.2'); // Ini IP localhost untuk testing
$allowed_collecting_agents = array('BSM','BNIS'); // Bank mana aja yg bekerja sama.
$allowed_channels          = array('TELLER', 'IBANK', 'ATM', 'SMS','MBANK');
$db_host                   = 'localhost';
$db_user                   = 'siakad_2019'; // contoh
$db_pass                   = 'admin2019'; // contoh
$db_name                   = 'siakad_keuangan'; // contoh

$log_directory = 'log/'; // harus writable


// start functions -------------------------------------------------------------
function debugLog($o) {
    // ini adalah fungsi untuk menulis log setiap request dan response ke dalam sebuah file.
    // Jika ada waktu, silahkan buat loh nya ke dalam database.
    $file_debug = $GLOBALS['log_directory'] . 'debug-h2h-' . date("Y-m-d") . '.log';
    ob_start();
    var_dump(date("Y-m-d h:i:s"));
    var_dump($o);
    $c = ob_get_contents();
    ob_end_clean();

    $f = fopen($file_debug, "a");
    fputs($f, "$c\n");
    fflush($f);
    fclose($f);
}
function response($arrayData){
    echo json_encode($arrayData,JSON_FORCE_OBJECT);
    exit();
}
// end functions ---------------------------------------------------------------

$request = json_decode($_POST['request'],true);
debugLog('REQUEST: ');
debugLog($request);

if ($request === false){
    response(array(
        'code'    => '30',
        'message' => 'Salah format request dari bank'
    ));
}
if (!in_array($_SERVER['REMOTE_ADDR'],$allowed_ips)) {
    response(array(
        'code'    => 'NA',
        'message' => 'Fungsi tidak diperbolehkan dari ' . $_SERVER['REMOTE_ADDR']
    ));
}
if (sha1($request['nomorPembayaran'].$secret_key.$request['tanggalTransaksi']) != $request['checksum']) {
    response(array(
        'code'    => 'NA',
        'message' => 'Fungsi tidak diperbolehkan di ' . $kampus
    ));
}
//asumsinya database pakai MySQL, silahkan sesuaikan dengan database kampus
// $koneksi = mysqli_connect($db_host, $db_user, $db_pass,$db_name);
$keuangan = $this->load->database('keuangan', TRUE);
if (!$koneksi) {
    response(array(
        'code'    => '91',
        'message' => 'Gagal koneksi database di ' . $kampus
    ));
}

switch ($_POST['action']) {
    case 'inquiry':
        // ini yang dikirim oleh bank
        $kodeBank         = $request['kodeBank'];
        $kodeChannel      = $request['kodeChannel'];
        $kodeTerminal     = $request['kodeTerminal'];
        $nomorPembayaran  = $request['nomorPembayaran'];
        $tanggalTransaksi = $request['tanggalTransaksi'];
        $idTransaksi      = $request['idTransaksi'];

        // mulai proses
        // cek apakah variable yang dikirim lengkap?
        if (empty($kodeBank) || empty($kodeChannel) || empty($kodeTerminal) || empty($nomorPembayaran) || empty($tanggalTransaksi) || empty($idTransaksi)) {
            response(array(
                'code'    => '30',
                'message' => 'Salah format message dari bank'
            ));
        }
        // cek apakah bank terdaftar?
        if (!in_array($kodeBank, $allowed_collecting_agents)) {
            response(array(
                'code'    => '31',
                'message' => 'Collecting agent tidak terdaftar di ' . $kampus
            ));
        }
        // cek apakah channel disupport?
        if (!in_array($kodeChannel, $allowed_channels)) {
            response(array(
                'code'    => '58',
                'message' => 'Channel tidak diperbolehkan di ' . $kampus
            ));
        }
        // cek apakah ada data tagihan?
        $isAdaTagihan = false; // silahkan cek di database apakah ada tagihan dengan nomor pembayaran tersebut?
        if ($isAdaTagihan == false) {
            response(array(
                'code'    => '14',
                'message' => 'Tagihan tidak ditemukan di ' . $kampus
            ));
        }
        // cek apakah masih dalam periode pembayaran yang diperbolehkan?
        $isDalamPeriodepembayaran = false; // silahkan cek di database apakah tagihan masih dalam periode pembayaran?
        if ($isDalamPeriodepembayaran == false) {
            response(array(
                'code'    => '14',
                'message' => 'Tidak berlaku periode bayar di ' . $kampus
            ));
        }
        // cek apakah sudah lunas apa belum?
        $sudahLunas = false; // silahkan cek di database apakah tagihan tersebut sudah lunas apa belum.
        if ($sudahLunas == true) {
            response(array(
                'code'    => '88',
                'message' => 'Tagihan sudah terbayar di ' . $kampus
            ));
        }
        $dataTagihan = array( // silahkan diambil dari database untuk datagihannya
            'nomorPembayaran' => $nomorPembayaran,
            'idTagihan'       => 'abc123456',
            'nomorInduk'      => '123456',
            'nama'            => 'Abdulloh Umar',
            'fakultas'        => 'Ekonomi',
            'jurusan'         => 'Manajemen',
            'strata'          => 'S1',
            'periode'         => '2016/2017',
            'angkatan'        => '2015',
            'totalNominal'    => 1000000,
            'rincianTagihan'  => array(
                array(
                    'kodeDetailTagihan' => '123',
                    'deskripsiPendek'   => 'SPP',
                    'deskripsiPanjang'  => 'Sumbangan Pembinaan Pendidikan',
                    'nominal'           => 700000
                ),
                array(
                    'kodeDetailTagihan' => '45678',
                    'deskripsiPendek'   => 'GEDUNG',
                    'deskripsiPanjang'  => 'Uang Gedung',
                    'nominal'           => 300000
                )
            )
        );
        if (!is_array($dataTagihan)) {
            response(array(
                'code'    => '14',
                'message' => 'Tagihan yang bisa dibayar tidak ditemukan di ' . $kampus
            ));
        }
        $jumlahRincian = count($dataTagihan['rincianTagihan']);
        $total_nominal_rincian = 0;
        for ($i = 0; $i < $jumlahRincian; $i++) {
            $total_nominal_rincian += $dataTagihan['rincianTagihan'][$i]['nominal'];
        }
        if ($total_nominal_rincian != $dataTagihan['totalNominal']) {
            response(array(
                'code'    => '30',
                'message' => 'Salah format nilai tagihan dari ' . $kampus
            ));
        }

        debugLog('RESPONSE: ');
        debugLog($dataTagihan);
        response(array(
            'code'    => '00',
            'message' => 'Inquiry berhasil di '.$kampus,
            'data'    => $dataTagihan
        ));
        break;

    case 'payment':
        // ini yang dikirim oleh bank
        $kodeBank             = $request['kodeBank'];
        $kodeChannel          = $request['kodeChannel'];
        $kodeTerminal         = $request['kodeTerminal'];
        $nomorPembayaran      = $request['nomorPembayaran'];
        $idTagihan            = $request['idTagihan']; // tidak mandatory
        $tanggalTransaksi     = $request['tanggalTransaksi'];
        $idTransaksi          = $request['idTransaksi'];
        $totalNominal         = $request['totalNominal'];
        $nomorJurnalPembukuan = $request['nomorJurnalPembukuan'];
        $rincianTagihan       = $request['rincianTagihan'];
        // mulai proses
        // cek apakah variable yang dikirim lengkap?
        if (empty($kodeBank) || empty($kodeChannel) || empty($kodeTerminal) || empty($nomorPembayaran) || empty($tanggalTransaksi) || empty($idTransaksi) || empty($totalNominal) || empty($nomorJurnalPembukuan) || empty($rincianTagihan)) {
            response(array(
                'code'    => '30',
                'message' => 'Salah format message dari bank'
            ));
        }
        // cek apakah bank terdaftar?
        if (!in_array($kodeBank, $allowed_collecting_agents)) {
            response(array(
                'code'    => '31',
                'message' => 'Collecting agent tidak terdaftar di ' . $kampus
            ));
        }
        // cek apakah channel disupport?
        if (!in_array($kodeChannel, $allowed_channels)) {
            response(array(
                'code'    => '58',
                'message' => 'Channel tidak diperbolehkan di ' . $kampus
            ));
        }

        $jumlahRincian = count($rincianTagihan);
        $total_nominal_rincian = 0;
        for ($i = 0; $i < $jumlahRincian; $i++) {
            $total_nominal_rincian += $rincianTagihan[$i]['nominal'];
        }
        if ($total_nominal_rincian != $totalNominal) {
            response(array(
                'code'    => '30',
                'message' => 'Salah format nilai tagihan dari bank'
            ));
        }

        // cek apakah ada data tagihan?
        $isAdaTagihan = false; // silahkan cek di database apakah ada tagihan dengan nomor pembayaran tersebut?
        if ($isAdaTagihan == false) {
            response(array(
                'code'    => '14',
                'message' => 'Tagihan tidak ditemukan di ' . $kampus
            ));
        }
        // cek apakah masih dalam periode pembayaran yang diperbolehkan?
        $isDalamPeriodepembayaran = false; // silahkan cek di database apakah tagihan masih dalam periode pembayaran?
        if ($isDalamPeriodepembayaran == false) {
            response(array(
                'code'    => '14',
                'message' => 'Tidak berlaku periode bayar di ' . $kampus
            ));
        }
        // cek apakah sudah lunas apa belum?
        $sudahLunas = false; // silahkan cek di database apakah tagihan tersebut sudah lunas apa belum.
        if ($sudahLunas == true) {
            response(array(
                'code'    => '88',
                'message' => 'Tagihan sudah terbayar di ' . $kampus
            ));
        }
        $dataTagihan = array( // silahkan diambil dari database untuk datagihannya
            'nomorPembayaran' => $nomorPembayaran,
            'idTagihan'       => 'abc123456',
            'nomorInduk'      => '123456',
            'nama'            => 'Abdulloh Umar',
            'fakultas'        => 'Ekonomi',
            'jurusan'         => 'Manajemen',
            'strata'          => 'S1',
            'periode'         => '2016/2017',
            'angkatan'        => '2015',
            'totalNominal'    => 1000000,
            'rincianTagihan'  => array(
                array(
                    'kodeDetailTagihan' => '123',
                    'deskripsiPendek'   => 'SPP',
                    'deskripsiPanjang'  => 'Sumbangan Pembinaan Pendidikan',
                    'nominal'           => 700000
                ),
                array(
                    'kodeDetailTagihan' => '45678',
                    'deskripsiPendek'   => 'GEDUNG',
                    'deskripsiPanjang'  => 'Uang Gedung',
                    'nominal'           => 300000
                )
            )
        );
        if (!is_array($dataTagihan)) {
            response(array(
                'code'    => '14',
                'message' => 'Tagihan yang bisa dibayar tidak ditemukan di ' . $kampus
            ));
        }
        $jumlahRincian = count($dataTagihan['rincianTagihan']);
        $total_nominal_rincian = 0;
        for ($i = 0; $i < $jumlahRincian; $i++) {
            $total_nominal_rincian += $dataTagihan['rincianTagihan'][$i]['nominal'];
        }
        if ($total_nominal_rincian != $dataTagihan['totalNominal']) {
            response(array(
                'code'    => '30',
                'message' => 'Salah format nilai tagihan dari ' . $kampus
            ));
        }

        $prosesmasukkanDatabase = false; // Silahkan memasukkan data pembayaran ke database.
        if ($prosesmasukkanDatabase == false) {
            response(array(
                'code'    => '91',
                'message' => 'Database error saat proses FLAG Bayar di ' . $kampus
            ));
        }
        unset($dataTagihan['rincianTagihan']); // rincianTagihan tidak diperlukan saat payment response
        debugLog('RESPONSE:');
        debugLog($dataTagihan);
        response(array(
            'code'    => '00',
            'message' => 'Pembayaran sukses dicatat di '.$kampus,
            'data'    => $dataTagihan
        ));
        break;

    case 'reversal':
        // ini yang dikirim oleh bank
        $kodeBank             = $request['kodeBank'];
        $kodeChannel          = $request['kodeChannel'];
        $kodeTerminal         = $request['kodeTerminal'];
        $nomorPembayaran      = $request['nomorPembayaran'];
        $idTagihan            = $request['idTagihan']; // tidak mandatory
        $tanggalTransaksi     = $request['tanggalTransaksi'];
        $tanggalTransaksiAsal = $request['tanggalTransaksiAsal'];
        $nomorJurnalPembukuan = $request['nomorJurnalPembukuan'];
        $idTransaksi          = $request['idTransaksi'];
        $totalNominal         = $request['totalNominal'];

        // mulai proses
        // cek apakah variable yang dikirim lengkap?
        if (empty($kodeBank) || empty($kodeChannel) || empty($kodeTerminal) || empty($nomorPembayaran) || empty($tanggalTransaksi) || empty($tanggalTransaksiAsal) || empty($nomorJurnalPembukuan) || empty($totalNominal)) {
            response(array(
                'code'    => '30',
                'message' => 'Salah format message dari bank'
            ));
        }
        // cek apakah bank terdaftar?
        if (!in_array($kodeBank, $allowed_collecting_agents)) {
            response(array(
                'code'    => '31',
                'message' => 'Collecting agent tidak terdaftar di '.$kampus
            ));
        }
        // cek apakah channel disupport?
        if (!in_array($kodeChannel, $allowed_channels)) {
            response(array(
                'code'    => '58',
                'message' => 'Collecting agent tidak terdaftar di '.$kampus
            ));
        }
        // cek apakah ada transaksi pembayaran tersebut sebelumnya?
        $isAdaDataPembayaranSebelumnya = false; // silahkan cek di database
        if ($isAdaDataPembayaranSebelumnya == false) {
            response(array(
                'code'    => '63',
                'message' => 'Reversal ditolak. Tagihan belum dibayar di '.$kampus
            ));
        }

        $isSudahDireversal = false; // cek di database apakah sudah dilakukan reversal sebelumnya
        if ($isSudahDireversal == true) {
            response(array(
                'code'    => '94',
                'message' => 'Reversal ditolak. Reversal sebelumnya sudah dilakukan di '.$kampus
            ));
        }
        $dataTagihan = array( // silahkan diambil dari database untuk datagihannya
            'nomorPembayaran' => $nomorPembayaran,
            'idTagihan'       => 'abc123456',
            'nomorInduk'      => '123456',
            'nama'            => 'Abdulloh Umar',
            'fakultas'        => 'Ekonomi',
            'jurusan'         => 'Manajemen',
            'strata'          => 'S1',
            'periode'         => '2016/2017',
            'angkatan'        => '2015',
            'totalNominal'    => 1000000
        );
        if (!is_array($dataTagihan)) {
            response(array(
                'code'    => '14',
                'message' => 'Tagihan tidak ditemukan di ' . $kampus
            ));
        }
        $prosesReversalDiDatabase = false; // Silahkan membatalkan data pembayaran ke database.
        if ($prosesReversalDiDatabase == false) {
            response(array(
                'code'    => '91',
                'message' => 'Database error saat proses FLAG Reversal di ' . $kampus
            ));
        }
        debugLog('RESPONSE:');
        debugLog($dataTagihan);
        response(array(
            'code'    => '00',
            'message' => 'Reversal sukses dilakukan di '.$kampus,
            'data'    => $dataTagihan
        ));
        break;

    default:
        response(array(
            'code'    => '30',
            'message' => 'Fungsi tidak tersedia di '.$kampus,
            'data'    => $dataTagihan
        ));
}
