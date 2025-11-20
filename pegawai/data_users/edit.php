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

// Get the NIS from the URL
$nis = $_GET['nis'] ?? null;

if (!$nis) {
    die("NIS tidak valid!");
}

// Fetch the existing student data
$stmt = $conection->prepare("SELECT * FROM siswa WHERE nis = ?");
$stmt->bind_param("s", $nis);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Data siswa tidak ditemukan!");
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = htmlspecialchars($_POST['kelas']);  // TAMBAHKAN INI
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_handphone = htmlspecialchars($_POST['no_handphone']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);
    $status = htmlspecialchars($_POST['status']);
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    $errors = [];

    if (empty($nama)) $errors[] = "Nama wajib diisi";
    if (empty($kelas)) $errors[] = "Kelas wajib diisi";  // TAMBAHKAN VALIDASI INI
    if (empty($jenis_kelamin)) $errors[] = "Jenis Kelamin wajib diisi";
    if (empty($alamat)) $errors[] = "Alamat wajib diisi";
    if (empty($no_handphone)) $errors[] = "No Handphone wajib diisi";
    if (empty($lokasi_presensi)) $errors[] = "Lokasi Presensi wajib diisi";
    if (empty($status)) $errors[] = "Status wajib diisi";


    // If a new photo is uploaded, validate it
    if (!empty($foto)) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['foto']['type'], $allowed_types)) {
            $errors[] = "Format foto tidak valid. Harap unggah file JPG, PNG, atau GIF.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['validasi'] = implode("<br>", $errors);
    } else {
        // If a new photo is uploaded, handle the upload
        if (!empty($foto)) {
            $foto_path = 'foto/' . basename($foto);
            if (move_uploaded_file($foto_tmp, $foto_path)) {
                // Delete the old photo if it exists
                if (!empty($student['foto']) && file_exists($student['foto'])) {
                    unlink($student['foto']);
                }
            } else {
                $_SESSION['validasi'] = "Gagal mengunggah foto.";
            }
        } else {
            // If no new photo is uploaded, keep the old photo path
            $foto_path = $student['foto'];
        }

        // Update the student data in the database
        $stmt = $conection->prepare("UPDATE siswa SET nama=?, kelas=?, jenis_kelamin=?, alamat=?, no_handphone=?, lokasi_presensi=?, foto=?, status=? WHERE nis=?");
        $stmt->bind_param("sssssssss", $nama, $kelas, $jenis_kelamin, $alamat, $no_handphone, $lokasi_presensi, $foto_path, $status, $nis);


        if ($stmt->execute()) {
            $_SESSION['berhasil'] = "Data Berhasil Diperbarui";
            header("Location: users.php");
            exit();
        } else {
            $_SESSION['validasi'] = "Terjadi kesalahan dalam menyimpan data.";
        }
        $stmt->close();
    }
}

include('../layout/header.php');
?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Edit Data Siswa</h2>
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
                            <input type="text" class="form-control" name="nis" value="<?= htmlspecialchars($student['nis']); ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($student['nama']); ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Pilih Kelas</label>
                            <select name="kelas" class="form-control" required>
                                <option value="">--Pilih Kelas--</option>
                                <!-- X -->
                                <option value="X_TKJ_1" <?= ($student['kelas'] === 'X_TKJ_1') ? 'selected' : '' ?>>X TKJ 1</option>
                                <option value="X_TKJ_2" <?= ($student['kelas'] === 'X_TKJ_2') ? 'selected' : '' ?>>X TKJ 2</option>
                                <option value="X_TKJ_3" <?= ($student['kelas'] === 'X_TKJ_3') ? 'selected' : '' ?>>X TKJ 3</option>
                                <option value="X_TPM_1" <?= ($student['kelas'] === 'X_TPM_1') ? 'selected' : '' ?>>X TPM 1</option>
                                <option value="X_TPM_2" <?= ($student['kelas'] === 'X_TPM_2') ? 'selected' : '' ?>>X TPM 2</option>
                                <option value="X_TPM_3" <?= ($student['kelas'] === 'X_TPM_3') ? 'selected' : '' ?>>X TPM 3</option>
                                <option value="X_TPM_4" <?= ($student['kelas'] === 'X_TPM_4') ? 'selected' : '' ?>>X TPM 4</option>
                                <option value="X_TPM_5" <?= ($student['kelas'] === 'X_TPM_5') ? 'selected' : '' ?>>X TPM 5</option>
                                <option value="X_TKR_1" <?= ($student['kelas'] === 'X_TKR_1') ? 'selected' : '' ?>>X TKR 1</option>
                                <option value="X_TKR_2" <?= ($student['kelas'] === 'X_TKR_2') ? 'selected' : '' ?>>X TKR 2</option>
                                <option value="X_TKR_3" <?= ($student['kelas'] === 'X_TKR_3') ? 'selected' : '' ?>>X TKR 3</option>
                                <option value="X_TITL_1" <?= ($student['kelas'] === 'X_TITL_1') ? 'selected' : '' ?>>X TITL 1</option>
                                <option value="X_TITL_2" <?= ($student['kelas'] === 'X_TITL_2') ? 'selected' : '' ?>>X TITL 2</option>
                                <option value="X_TITL_3" <?= ($student['kelas'] === 'X_TITL_3') ? 'selected' : '' ?>>X TITL 3</option>
                                <option value="X_DPIB_1" <?= ($student['kelas'] === 'X_DPIB_1') ? 'selected' : '' ?>>X DPIB 1</option>
                                <option value="X_DPIB_2" <?= ($student['kelas'] === 'X_DPIB_2') ? 'selected' : '' ?>>X DPIB 2</option>
                                <option value="X_TOI_1" <?= ($student['kelas'] === 'X_TOI_1') ? 'selected' : '' ?>>X TOI 1</option>
                                <option value="X_TOI_2" <?= ($student['kelas'] === 'X_TOI_2') ? 'selected' : '' ?>>X TOI 2</option>

                                <!-- XI -->
                                <option value="XI_TKJ_1" <?= ($student['kelas'] === 'XI_TKJ_1') ? 'selected' : '' ?>>XI TKJ 1</option>
                                <option value="XI_TKJ_2" <?= ($student['kelas'] === 'XI_TKJ_2') ? 'selected' : '' ?>>XI TKJ 2</option>
                                <option value="XI_TKJ_3" <?= ($student['kelas'] === 'XI_TKJ_3') ? 'selected' : '' ?>>XI TKJ 3</option>
                                <option value="XI_TPM_1" <?= ($student['kelas'] === 'XI_TPM_1') ? 'selected' : '' ?>>XI TPM 1</option>
                                <option value="XI_TPM_2" <?= ($student['kelas'] === 'XI_TPM_2') ? 'selected' : '' ?>>XI TPM 2</option>
                                <option value="XI_TPM_3" <?= ($student['kelas'] === 'XI_TPM_3') ? 'selected' : '' ?>>XI TPM 3</option>
                                <option value="XI_TPM_4" <?= ($student['kelas'] === 'XI_TPM_4') ? 'selected' : '' ?>>XI TPM 4</option>
                                <option value="XI_TPM_5" <?= ($student['kelas'] === 'XI_TPM_5') ? 'selected' : '' ?>>XI TPM 5</option>
                                <option value="XI_TKR_1" <?= ($student['kelas'] === 'XI_TKR_1') ? 'selected' : '' ?>>XI TKR 1</option>
                                <option value="XI_TKR_2" <?= ($student['kelas'] === 'XI_TKR_2') ? 'selected' : '' ?>>XI TKR 2</option>
                                <option value="XI_TKR_3" <?= ($student['kelas'] === 'XI_TKR_3') ? 'selected' : '' ?>>XI TKR 3</option>
                                <option value="XI_TITL_1" <?= ($student['kelas'] === 'XI_TITL_1') ? 'selected' : '' ?>>XI TITL 1</option>
                                <option value="XI_TITL_2" <?= ($student['kelas'] === 'XI_TITL_2') ? 'selected' : '' ?>>XI TITL 2</option>
                                <option value="XI_TITL_3" <?= ($student['kelas'] === 'XI_TITL_3') ? 'selected' : '' ?>>XI TITL 3</option>
                                <option value="XI_DPIB_1" <?= ($student['kelas'] === 'XI_DPIB_1') ? 'selected' : '' ?>>XI DPIB 1</option>
                                <option value="XI_DPIB_2" <?= ($student['kelas'] === 'XI_DPIB_2') ? 'selected' : '' ?>>XI DPIB 2</option>
                                <option value="XI_TOI_1" <?= ($student['kelas'] === 'XI_TOI_1') ? 'selected' : '' ?>>XI TOI 1</option>
                                <option value="XI_TOI_2" <?= ($student['kelas'] === 'XI_TOI_2') ? 'selected' : '' ?>>XI TOI 2</option>

                                <!-- XII -->
                                <option value="XII_TKJ_1" <?= ($student['kelas'] === 'XII_TKJ_1') ? 'selected' : '' ?>>XII TKJ 1</option>
                                <option value="XII_TKJ_2" <?= ($student['kelas'] === 'XII_TKJ_2') ? 'selected' : '' ?>>XII TKJ 2</option>
                                <option value="XII_TKJ_3" <?= ($student['kelas'] === 'XII_TKJ_3') ? 'selected' : '' ?>>XII TKJ 3</option>
                                <option value="XII_TPM_1" <?= ($student['kelas'] === 'XII_TPM_1') ? 'selected' : '' ?>>XII TPM 1</option>
                                <option value="XII_TPM_2" <?= ($student['kelas'] === 'XII_TPM_2') ? 'selected' : '' ?>>XII TPM 2</option>
                                <option value="XII_TPM_3" <?= ($student['kelas'] === 'XII_TPM_3') ? 'selected' : '' ?>>XII TPM 3</option>
                                <option value="XII_TPM_4" <?= ($student['kelas'] === 'XII_TPM_4') ? 'selected' : '' ?>>XII TPM 4</option>
                                <option value="XII_TPM_5" <?= ($student['kelas'] === 'XII_TPM_5') ? 'selected' : '' ?>>XII TPM 5</option>
                                <option value="XII_TKR_1" <?= ($student['kelas'] === 'XII_TKR_1') ? 'selected' : '' ?>>XII TKR 1</option>
                                <option value="XII_TKR_2" <?= ($student['kelas'] === 'XII_TKR_2') ? 'selected' : '' ?>>XII TKR 2</option>
                                <option value="XII_TKR_3" <?= ($student['kelas'] === 'XII_TKR_3') ? 'selected' : '' ?>>XII TKR 3</option>
                                <option value="XII_TITL_1" <?= ($student['kelas'] === 'XII_TITL_1') ? 'selected' : '' ?>>XII TITL 1</option>
                                <option value="XII_TITL_2" <?= ($student['kelas'] === 'XII_TITL_2') ? 'selected' : '' ?>>XII TITL 2</option>
                                <option value="XII_TITL_3" <?= ($student['kelas'] === 'XII_TITL_3') ? 'selected' : '' ?>>XII TITL 3</option>
                                <option value="XII_DPIB_1" <?= ($student['kelas'] === 'XII_DPIB_1') ? 'selected' : '' ?>>XII DPIB 1</option>
                                <option value="XII_DPIB_2" <?= ($student['kelas'] === 'XII_DPIB_2') ? 'selected' : '' ?>>XII DPIB 2</option>
                                <option value="XII_TOI_1" <?= ($student['kelas'] === 'XII_TOI_1') ? 'selected' : '' ?>>XII TOI 1</option>
                                <option value="XII_TOI_2" <?= ($student['kelas'] === 'XII_TOI_2') ? 'selected' : '' ?>>XII TOI 2</option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="Laki-Laki" <?= ($student['jenis_kelamin'] === 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="Perempuan" <?= ($student['jenis_kelamin'] === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= htmlspecialchars($student['alamat']); ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">No Handphone</label>
                            <input type="text" class="form-control" name="no_handphone" value="<?= htmlspecialchars($student['no_handphone']); ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Lokasi Presensi</label>
                            <select name="lokasi_presensi" class="form-control" required>
                                <option value="">--Pilih Lokasi Presensi--</option>
                                <option value="Kampus 1" <?= ($student['lokasi_presensi'] === 'Kampus 1') ? 'selected' : '' ?>>Kampus 1</option>
                                <option value="Kampus 2" <?= ($student['lokasi_presensi'] === 'Kampus 2') ? 'selected' : '' ?>>Kampus 2</option>
                                <option value="Kampus 3" <?= ($student['lokasi_presensi'] === 'Kampus 3') ? 'selected' : '' ?>>Kampus 3</option>
                                <option value="Kampus 4" <?= ($student['lokasi_presensi'] === 'Kampus 4') ? 'selected' : '' ?>>Kampus 4</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">--Pilih Status--</option>
                                <option value="aktif" <?= ($student['status'] === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                <option value="tidak aktif" <?= ($student['status'] === 'tidak aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto">
                            <?php if (!empty($student['foto'])): ?>
                                <br>
                                <img src="<?= htmlspecialchars($student['foto']); ?>" width="100" alt="Foto Siswa">
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>