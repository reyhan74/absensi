<?php
ob_start();
session_start();

if (!isset($_SESSION['login'])) {
    header("location: ../../auth/login.php?pesan=belum_login");
    exit();
} elseif ($_SESSION["role"] != 'guru') {
    header("location: ../../auth/login.php?pesan=tolak_akses");
    exit();
}

require_once('../../config.php');

// Get the last NIS from the database
$result = $conection->query("SELECT nis FROM siswa ORDER BY nis DESC LIMIT 1");
$last_nis = $result->fetch_assoc();
$next_nis = $last_nis ? str_pad((int)$last_nis['nis'] + 1, 6, '0', STR_PAD_LEFT) : '000001'; // Start from 000001 if no records exist

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $nis = $next_nis; // Use the automatically generated NIS
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $no_handphone = htmlspecialchars($_POST['no_handphone']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);
    $status = htmlspecialchars($_POST['status']);
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    $errors = [];

    if (empty($nama)) $errors[] = "Nama wajib diisi";
    if (empty($jenis_kelamin)) $errors[] = "Jenis Kelamin wajib diisi";
    if (empty($alamat)) $errors[] = "Alamat wajib diisi";
    if (empty($no_handphone)) $errors[] = "No Handphone wajib diisi";
    if (empty($lokasi_presensi)) $errors[] = "Lokasi Presensi wajib diisi";
    if (empty($status)) $errors[] = "Status wajib diisi";
    if (empty($foto)) $errors[] = "Foto wajib diisi";

    if (!empty($errors)) {
        $_SESSION['validasi'] = implode("<br>", $errors);
    } else {
        $foto_path = 'foto/' . basename($foto);
        if (move_uploaded_file($foto_tmp, $foto_path)) {
        $stmt = $conection->prepare("INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, alamat, no_handphone, lokasi_presensi, foto, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $nis, $nama, $kelas, $jenis_kelamin, $alamat, $no_handphone, $lokasi_presensi, $foto, $status);


            if ($stmt->execute()) {
                $_SESSION['berhasil'] = "Data Berhasil Disimpan";
                header("Location: users.php");
                exit();
            } else {
                $_SESSION['validasi'] = "Terjadi kesalahan dalam menyimpan data.";
            }
            $stmt->close();
        } else {
            $_SESSION['validasi'] = "Gagal mengunggah foto.";
        }
    }
}

include('../layout/header.php');
?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Tambah Lokasi Presensi</h2>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card col-md-8">
            <div class="card-body">
                <?php if (isset($_SESSION['validasi'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['validasi']; unset($_SESSION['validasi']); ?></div>
                <?php endif; ?>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="">NIS</label>
                            <input type="text" class="form-control" name="nis" value="<?= $next_nis; ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= $_POST['nama'] ?? '' ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas" class="form-control">
                                <option value="">--Pilih Kelas--</option>
                                <option value="X_TKJ_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TKJ_1') ? 'selected' : '' ?>>X_TKJ_1</option>
                                <option value="X_TKJ_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TKJ_2') ? 'selected' : '' ?>>X_TKJ_2</option>
                                <option value="X_TKJ_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TKJ_3') ? 'selected' : '' ?>>X_TKJ_3</option>
                                <option value="X_TPM_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TPM_1') ? 'selected' : '' ?>>X_TPM_1</option>
                                <option value="X_TPM_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TPM_2') ? 'selected' : '' ?>>X_TPM_2</option>
                                <option value="X_TPM_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TPM_3') ? 'selected' : '' ?>>X_TPM_3</option>
                                <option value="X_TPM_4" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TPM_4') ? 'selected' : '' ?>>X_TPM_4</option>
                                <option value="X_TPM_5" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TPM_5') ? 'selected' : '' ?>>X_TPM_5</option>
                                <option value="X_TKR_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TKR_1') ? 'selected' : '' ?>>X_TKR_1</option>
                                <option value="X_TKR_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TKR_2') ? 'selected' : '' ?>>X_TKR_2</option>
                                <option value="X_TKR_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TKR_3') ? 'selected' : '' ?>>X_TKR_3</option>
                                <option value="X_TITL_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TITL_1') ? 'selected' : '' ?>>X_TITL_1</option>
                                <option value="X_TITL_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TITL_2') ? 'selected' : '' ?>>X_TITL_2</option>
                                <option value="X_TITL_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TITL_3') ? 'selected' : '' ?>>X_TITL_3</option>
                                <option value="X_DPIB_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_DPIB_1') ? 'selected' : '' ?>>X_DPIB_1</option>
                                <option value="X_DPIB_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_DPIB_2') ? 'selected' : '' ?>>X_DPIB_1</option>
                                <option value="X_TOI_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TOI_1') ? 'selected' : '' ?>>X_TOI_1</option>
                                <option value="X_TOI_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'X_TOI_2') ? 'selected' : '' ?>>X_TOI_2</option>
                                <option value="XI_TKJ_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TKJ_1') ? 'selected' : '' ?>>XI_TKJ_1</option>
                                <option value="XI_TKJ_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TKJ_2') ? 'selected' : '' ?>>XI_TKJ_2</option>
                                <option value="XI_TKJ_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TKJ_3') ? 'selected' : '' ?>>XI_TKJ_3</option>
                                <option value="XI_TPM_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TPM_1') ? 'selected' : '' ?>>XI_TPM_1</option>
                                <option value="XI_TPM_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TPM_2') ? 'selected' : '' ?>>XI_TPM_2</option>
                                <option value="XI_TPM_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TPM_3') ? 'selected' : '' ?>>XI_TPM_3</option>
                                <option value="XI_TPM_4" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TPM_4') ? 'selected' : '' ?>>XI_TPM_4</option>
                                <option value="XI_TPM_5" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TPM_5') ? 'selected' : '' ?>>XI_TPM_5</option>
                                <option value="XI_TKR_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TKR_1') ? 'selected' : '' ?>>XI_TKR_1</option>
                                <option value="XI_TKR_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TKR_2') ? 'selected' : '' ?>>XI_TKR_2</option>
                                <option value="XI_TKR_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TKR_3') ? 'selected' : '' ?>>XI_TKR_3</option>
                                <option value="XI_TITL_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TITL_1') ? 'selected' : '' ?>>XI_TITL_1</option>
                                <option value="XI_TITL_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TITL_2') ? 'selected' : '' ?>>XI_TITL_2</option>
                                <option value="XI_TITL_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TITL_3') ? 'selected' : '' ?>>XI_TITL_3</option>
                                <option value="XI_DPIB_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_DPIB_1') ? 'selected' : '' ?>>XI_DPIB_1</option>
                                <option value="XI_DPIB_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_DPIB_2') ? 'selected' : '' ?>>XI_DPIB_1</option>
                                <option value="XI_TOI_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TOI_1') ? 'selected' : '' ?>>XI_TOI_1</option>
                                <option value="XI_TOI_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XI_TOI_2') ? 'selected' : '' ?>>XI_TOI_2</option>
                                <option value="XII_TKJ_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TKJ_1') ? 'selected' : '' ?>>XII_TKJ_1</option>
                                <option value="XII_TKJ_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TKJ_2') ? 'selected' : '' ?>>XII_TKJ_2</option>
                                <option value="XII_TKJ_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TKJ_3') ? 'selected' : '' ?>>XII_TKJ_3</option>
                                <option value="XII_TPM_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TPM_1') ? 'selected' : '' ?>>XII_TPM_1</option>
                                <option value="XII_TPM_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TPM_2') ? 'selected' : '' ?>>XII_TPM_2</option>
                                <option value="XII_TPM_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TPM_3') ? 'selected' : '' ?>>XII_TPM_3</option>
                                <option value="XII_TPM_4" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TPM_4') ? 'selected' : '' ?>>XII_TPM_4</option>
                                <option value="XII_TPM_5" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TPM_5') ? 'selected' : '' ?>>XII_TPM_5</option>
                                <option value="XII_TKR_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TKR_1') ? 'selected' : '' ?>>XII_TKR_1</option>
                                <option value="XII_TKR_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TKR_2') ? 'selected' : '' ?>>XII_TKR_2</option>
                                <option value="XII_TKR_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TKR_3') ? 'selected' : '' ?>>XII_TKR_3</option>
                                <option value="XII_TITL_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TITL_1') ? 'selected' : '' ?>>XII_TITL_1</option>
                                <option value="XII_TITL_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TITL_2') ? 'selected' : '' ?>>XII_TITL_2</option>
                                <option value="XII_TITL_3" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TITL_3') ? 'selected' : '' ?>>XII_TITL_3</option>
                                <option value="XII_DPIB_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_DPIB_1') ? 'selected' : '' ?>>XII_DPIB_1</option>
                                <option value="XII_DPIB_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_DPIB_2') ? 'selected' : '' ?>>XII_DPIB_2</option>
                                <option value="XII_TOI_1" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TOI_1') ? 'selected' : '' ?>>XII_TOI_1</option>
                                <option value="XII_TOI_2" <?= (isset($_POST['kelas']) && $_POST['kelas'] === 'XII_TOI_2') ? 'selected' : '' ?>>XII_TOI_2</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="Laki-Laki" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] === 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="Perempuan" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= $_POST['alamat'] ?? '' ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">No Handphone</label>
                            <input type="text" class="form-control" name="no_handphone" value="<?= $_POST['no_handphone'] ?? '' ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Lokasi Presensi</label>
                            <select name="lokasi_presensi" class="form-control">
                                <option value="">--Pilih Lokasi Presensi--</option>
                                <option value="Kampus 1" <?= (isset($_POST['lokasi_presensi']) && $_POST['lokasi_presensi'] === 'Kampus 1') ? 'selected' : '' ?>>Kampus 1</option>
                                <option value="Kampus 2" <?= (isset($_POST['lokasi_presensi']) && $_POST['lokasi_presensi'] === 'Kampus 2') ? 'selected' : '' ?>>Kampus 2</option>
                                <option value="Kampus 3" <?= (isset($_POST['lokasi_presensi']) && $_POST['lokasi_presensi'] === 'Kampus 3') ? 'selected' : '' ?>>Kampus 3</option>
                                <option value="Kampus 4" <?= (isset($_POST['lokasi_presensi']) && $_POST['lokasi_presensi'] === 'Kampus 4') ? 'selected' : '' ?>>Kampus 4</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Status</label>
                            <select name="status" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="aktif" <?= (isset($_POST['status']) && $_POST['status'] === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                <option value="tidak aktif" <?= (isset($_POST['status']) && $_POST['status'] === 'tidak aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>