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
    $nama_file = 'foto/keluar_' . date('Y-m-d_H-i-s') . '.png';
    $file = basename($nama_file);

    // Ensure foto folder exists
    if (!is_dir('foto')) {
        mkdir('foto', 0777, true);
    }

    // Save image file
    file_put_contents($nama_file, $data);

    // Ambil data user dari session
    $id_pegawai = $_SESSION['id'] ?? null;

    // Simpan tanggal dan jam sekarang
    date_default_timezone_set("Asia/Jakarta");
    $tanggal_keluar = date('Y-m-d');
    $jam_keluar = date('H:i:s');

    if ($id_pegawai) {
        // Simpan ke database
        $query = "INSERT INTO presensi_out (id_siswa, tanggal_keluar, jam_keluar, foto_keluar) 
                    VALUES ('$id_pegawai', '$tanggal_keluar', '$jam_keluar', '$file')";
        $result = mysqli_query($conection, $query);

        if ($result) {
            $_SESSION['berhasil'] = "Presensi keluar berhasil";
        } else {
            $_SESSION['gagal'] = "Presensi keluar gagal: " . mysqli_error($conection);
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
<!-- SweetAlert jika gagal -->
<?php if (isset($_SESSION['gagal'])): ?>
<script>
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "<?= htmlspecialchars($_SESSION['gagal'], ENT_QUOTES); ?>",
    });
</script>
<?php unset($_SESSION['gagal']); ?>
<?php endif; ?>
