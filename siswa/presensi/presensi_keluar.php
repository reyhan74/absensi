<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ../../auth/login.php?pesan=belum_login");
    exit;
}
include_once('../../config.php');
include('../layout/header.php');

// Proses form keluar
if (isset($_POST['tombol_keluar'])) {
    $latitude_pegawai = $_POST['latitude_pegawai'];
    $longitude_pegawai = $_POST['longitude_pegawai'];
    $latitude_kantor = $_POST['latitude_kantor'];
    $longitude_kantor = $_POST['longitude_kantor'];
    $radius = $_POST['radius'];

    // Hitung jarak
    $theta = $longitude_pegawai - $longitude_kantor;
    $distance = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + 
                cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($theta));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $miles = $distance * 60 * 1.1515;
    $meters = $miles * 1.609344 * 1000;

    // Cek radius
    if ($meters > $radius) {
        $_SESSION['gagal'] = "Anda berada di luar sekolah";
        header("Location: ../home/home.php");
        exit;
    }
?>

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

            <!-- Kamera dan foto -->
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body" style="margin: auto;">
                        <div id="my_camera"></div>
                        <div id="my_result" class="mt-2"></div>
                        <div id="tanggal-dan-jam" class="mt-2"></div>
                        <button class="btn btn-primary mt-2" id="ambil-foto">Ambil Foto & Keluar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #my_result img {
        width: 354px;
        height: 472px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<script>
    // Update tanggal dan jam realtime
    function updateTanggalDanJam() {
        const now = new Date();
        const optionsTanggal = { day: '2-digit', month: 'long', year: 'numeric' };
        const tanggal = now.toLocaleDateString('id-ID', optionsTanggal);
        const jam = now.toLocaleTimeString('id-ID');
        document.getElementById('tanggal-dan-jam').innerText = `${tanggal} - ${jam}`;
    }

    updateTanggalDanJam();
    setInterval(updateTanggalDanJam, 1000);

    // Setup webcam
    Webcam.set({
        width: 354,
        height: 472,
        image_format: 'jpeg',
        jpeg_quality: 90,
        force_flash: false
    });
    Webcam.attach('#my_camera');

    // Ambil foto dan kirim data
    document.getElementById('ambil-foto').addEventListener('click', function () {
        Webcam.snap(function (data_uri) {
            document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>';
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    window.location.href = '../home/home.php';
                }
            };
            xhttp.open("POST", "presensi_keluar_aksi.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send('photo=' + encodeURIComponent(data_uri));
        });
    });
</script>

<?php } ?>

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
