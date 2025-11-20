<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
    exit;
}

include_once('../../config.php');

if (isset($_POST['photo'])) {
    $file_foto = $_POST['photo'];

    // Decode base64 image
    $foto = str_replace('data:image/jpeg;base64,', '', $file_foto);
    $foto = str_replace(' ', '+', $foto);
    $data = base64_decode($foto);

    // Generate unique file name
    $nama_file = 'foto/masuk_' . date('Y-m-d_H-i-s') . '.png';
    $file = basename($nama_file);

    // Ensure foto folder exists
    if (!is_dir('foto')) {
        mkdir('foto', 0777, true);
    }

    // Simpan tanggal dan jam sekarang
    date_default_timezone_set("Asia/Jakarta");
    $tanggal_masuk = date('Y-m-d');
    $jam_masuk = date('H:i:s');

    // Ambil data user dari session
    $id_pegawai = $_SESSION['id'] ?? null;

    if ($id_pegawai) {
        // Cek apakah user sudah presensi masuk hari ini
        $cekQuery = "SELECT * FROM presensi WHERE id_siswa = '$id_pegawai' AND tanggal_masuk = '$tanggal_masuk'";
        $cekResult = mysqli_query($conection, $cekQuery);

        if (mysqli_num_rows($cekResult) > 0) {
            $_SESSION['gagal'] = "Anda sudah melakukan presensi masuk hari ini.";
        } else {
            // Simpan file foto
            file_put_contents($nama_file, $data);

            // Simpan ke database
            $query = "INSERT INTO presensi (id_siswa, tanggal_masuk, jam_masuk, foto_masuk) 
                      VALUES ('$id_pegawai', '$tanggal_masuk', '$jam_masuk', '$file')";
            $result = mysqli_query($conection, $query);

            if ($result) {
                $_SESSION['berhasil'] = "Presensi masuk berhasil.";
            } else {
                $_SESSION['gagal'] = "Presensi masuk gagal: " . mysqli_error($conection);
            }
        }
    } else {
        $_SESSION['gagal'] = "ID pengguna tidak ditemukan.";
    }
} else {
    $_SESSION['gagal'] = "Foto tidak diterima.";
}

// Redirect ke home
header("Location: ../home/home.php");
exit;
?>
