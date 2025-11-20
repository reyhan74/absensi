<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ../../auth/login.php?pesan=belum_login");
}
include_once('../../config.php');
include('../layout/header.php');

// Proses form masuk
if (isset($_POST['tombol_masuk'])) {
    $latitude_pegawai = $_POST['latitude_pegawai'];
    $longitude_pegawai = $_POST['longitude_pegawai'];
    $latitude_kantor = $_POST['latitude_kantor'];
    $longitude_kantor = $_POST['longitude_kantor'];
    $radius = $_POST['radius'];
    $zona_waktu = $_POST['zona_waktu'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $jam_masuk = $_POST['jam_masuk'];

    // Hitung jarak
    $perbedaan_koordinat = $longitude_pegawai - $longitude_kantor;
    $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) +
             cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($perbedaan_koordinat));
    $jarak = acos($jarak);
    $jarak = rad2deg($jarak);
    $mil = $jarak * 60 * 1.1515;
    $jarak_km = $mil * 1.609344;
    $jarak_meter = $jarak_km * 1000;

    // Cek apakah di dalam radius
    if ($jarak_meter > $radius) {
        $_SESSION['gagal'] = "Anda berada di luar sekolah";
        header("Location: ../home/home.php");
        exit;
    }
?>

<!-- Tampilkan halaman jika dalam radius -->
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <!-- Map -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7906.4737621706945!2d<?= $longitude_pegawai ?>!3d<?= $latitude_pegawai ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1745071015835!5m2!1sid!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    
                    </div>
                </div>
            </div>

            <!-- Kamera dan info -->
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body" style="margin: auto;">
                        <div id="my_camera"></div>
                        <div id="my_result"></div>
                        <div id="tanggal-dan-jam"></div>
                        <button class="btn btn-primary mt-2" id="ambil-foto">Ambil Foto & Presensi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateTanggalDanJam() {
        const now = new Date();
        const optionsTanggal = { day: '2-digit', month: 'long', year: 'numeric' };
        const tanggal = now.toLocaleDateString('id-ID', optionsTanggal);
        const jam = now.toLocaleTimeString('id-ID');
        document.getElementById('tanggal-dan-jam').innerText = `${tanggal} - ${jam}`;
    }

    updateTanggalDanJam();
    setInterval(updateTanggalDanJam, 1000);
</script>

<!-- Webcam Script -->
<script language="JavaScript">
    Webcam.set({
        width: 354,
        height: 472,
        image_format: 'jpeg',
        jpeg_quality: 90,
        force_flash: false
    });
    Webcam.attach('#my_camera');

    document.getElementById('ambil-foto').addEventListener('click', function () {
        Webcam.snap(function (data_uri) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>';
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                window.location.href = '../home/home.php';
            }
            };
            xhttp.open("POST", "presensi_masuk_aksi.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(
                'photo=' + encodeURIComponent(data_uri)
            );
        });
    });
</script>

<?php } ?>

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

<?php include('../layout/foother.php'); ?>
