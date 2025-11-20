-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2025 pada 13.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `alamat` varchar(67) NOT NULL,
  `no_handphone` varchar(34) NOT NULL,
  `lokasi_presensi` varchar(56) NOT NULL,
  `foto` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `username`, `password`, `status`, `role`, `nama`, `jenis_kelamin`, `alamat`, `no_handphone`, `lokasi_presensi`, `foto`) VALUES
(8, 'admin', '$2y$10$LAIeCIMholKGi4YF6OI.4OI4/2muNk3L51EYlF9Xu5OvMS1HA2Nr2', 'aktif', 'admin', 'guru', 'laki-laki', 'njfd', '5tr', 'xdjt', 'foto/hero-bg.jpg'),
(12, 'guru', '$2y$10$JndjpVbDZivVHEjSz9kBcOqBbdiFVZMiI/SORMBnE01QUvpHMUhUS', 'aktif', 'guru', 'guru', 'laki-laki', 'puncu', '087957', '0poqje', '../../siswa/home/profilemasuk_2025-05-20_05-07-36.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `jabatan`) VALUES
(2, 'admin'),
(3, 'guru'),
(4, 'siswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi_presensi`
--

CREATE TABLE `lokasi_presensi` (
  `id` int(11) NOT NULL,
  `nama_lokasi` varchar(255) NOT NULL,
  `alamat_lokasi` varchar(255) NOT NULL,
  `tipe_lokasi` varchar(255) NOT NULL,
  `latitut` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `radius` int(11) NOT NULL,
  `zona_waktu` varchar(4) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `lokasi_presensi`
--

INSERT INTO `lokasi_presensi` (`id`, `nama_lokasi`, `alamat_lokasi`, `tipe_lokasi`, `latitut`, `longitude`, `radius`, `zona_waktu`, `jam_masuk`, `jam_pulang`) VALUES
(1, 'Kampus 1\r\n', 'adfadfafda', 'Pusat', '-7.76636150824456', '112.19107524207931', 100, 'WIB', '13:48:00', '13:49:00'),
(11, 'Kampus 2', '3io', 'Cabang', '-7,8582990', '112,2648048', 20, 'WIB', '16:10:00', '20:10:00'),
(13, 'Kampus 3', 'adfadfafda', 'Kampus 4', '-7.766353', '112.1818823', 100, 'WIB', '22:36:00', '22:33:00'),
(14, 'cb', 'pare', 'pusat', '-7.766243713589902', '112.19100419629886', 200000, 'WIB', '17:30:11', '22:33:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `no_handphone` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `lokasi_Presensi` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nis`, `nama`, `jenis_kelamin`, `alamat`, `no_handphone`, `level`, `lokasi_Presensi`, `foto`) VALUES
(1, '000001', 'Reyhan Dwiandika', 'laki laki', 'jl siaga 2', '081805256116', 'admin', 'Kampus 1', 'rhn.jpg'),
(4, '000002', 'Rayu Fajaruni', 'Perempuan', 'resa', '0816667890', 'pegawai', '009575/69860', 'foto/Screenshot 2024-07-18 185554.png'),
(5, '000004', 'Rayu Fajaruni', 'Perempuan', 'resa', '0816667890', 'guru', '009575/69860', 'foto/Screenshot 2024-07-18 185554.png'),
(6, '000003', 'sadang', 'Laki-laki', 'pare', '087957', 'siswa', '2987098/87-98790', 'foto/Capture.PNG'),
(7, '000006', 'sadang', 'Laki-laki', 'pare', '087957', 'siswa', '2987098/87-98790', 'foto/Capture.PNG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `foto_masuk` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `id_siswa`, `tanggal_masuk`, `jam_masuk`, `foto_masuk`) VALUES
(78, 33, '2025-05-22', '08:12:00', 'masuk_2025-05-22_03-12-00.png'),
(79, 30, '2025-05-22', '08:15:05', 'masuk_2025-05-22_03-15-05.png'),
(80, 40, '2025-05-22', '08:35:04', 'masuk_2025-05-22_03-35-04.png'),
(81, 33, '2025-05-23', '05:14:41', 'masuk_2025-05-23_00-14-41.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi_out`
--

CREATE TABLE `presensi_out` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `jam_keluar` time NOT NULL,
  `foto_keluar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `presensi_out`
--

INSERT INTO `presensi_out` (`id`, `id_siswa`, `tanggal_keluar`, `jam_keluar`, `foto_keluar`) VALUES
(13, 30, '2025-05-22', '08:15:23', 'keluar_2025-05-22_03-15-23.png'),
(14, 33, '2025-05-22', '21:22:15', 'keluar_2025-05-22_16-22-15.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(225) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `no_handphone` varchar(50) NOT NULL,
  `lokasi_presensi` varchar(50) NOT NULL,
  `foto` varchar(67) NOT NULL,
  `status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jenis_kelamin`, `alamat`, `no_handphone`, `lokasi_presensi`, `foto`, `status`) VALUES
(15, '000001', 'NUR WAFIROTUL MAGFIROH', 'XI_TKJ_3', 'Perempuan', 'pare', '085707149416', 'Kampus 3', 'foto/TKJ3  NUR WAFIROTU  7146.JPG', 'aktif'),
(16, '000002', 'NURMA FEBRIYANTI', 'XI_TKJ_3', 'Perempuan', 'Ds.kepung barat,Kec.', '081217673678', 'Kampus 3', 'foto/TKJ3  NURMA FEBRIY  7103.JPG', 'aktif'),
(17, '000003', 'NURVITA DYAH PUSPITONINGRUM', 'XI_TKJ_3', 'Perempuan', 'JL. SLAMET NO.19 RT.', '082334158533', 'Kampus 3', 'foto/TKJ3  NURVITA DYAH  7107.JPG', 'aktif'),
(18, '000004', 'OLIVIA TRISNA WULANDARI', 'XI_TKJ_3', 'Perempuan', 'pare', '085755254982', 'Kampus 3', 'foto/TKJ3  OLIVIA TRISN  7092.JPG', 'aktif'),
(19, '000005', 'PANJI ANGGER RAMADANI', 'XI_TKJ_3', 'Laki-Laki', 'pare', '088991877383', 'Kampus 3', 'foto/TKJ3  PANJI ANGGER  7083.JPG', 'aktif'),
(20, '000006', 'PINGKAN WULANDARI DZA', 'XI_TKJ_3', 'Laki-Laki', 'pare', '085784567026', 'Kampus 3', 'foto/TKJ3  PINGKAN WULA  7106.JPG', 'aktif'),
(21, '000007', 'PYCO MAHARANI', 'XI_TKJ_3', 'Laki-Laki', 'pare', '089625490030', 'Kampus 3', 'foto/TKJ3  PYCO MAHARAN  7090.JPG', 'aktif'),
(23, '000008', 'QONI\'ATUZ ZAHRA VELIRA ADISTIA', 'XI_TKJ_3', 'Laki-Laki', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  QONI\'ATUZ ZA  7098.JPG', 'aktif'),
(24, '000009', 'RADITYA REZA EKA PRATAMA', 'XI_TKJ_3', 'Laki-Laki', 'Kec. Badas Kab. Kedi', '085713117031', 'Kampus 3', 'foto/TKJ3  RADITYA REZA  7078.JPG', 'aktif'),
(25, '000010', 'RAFIASKA DETALENTA PUTRA', 'XI_TKJ_3', 'Laki-Laki', 'pare', '082337829623', 'Kampus 3', 'foto/TKJ3  RAFIASKA DET  7084.JPG', 'aktif'),
(26, '000011', 'RAHMA KURNIA DEWI', 'XI_TKJ_3', 'Perempuan', 'pare', '087758034839', 'Kampus 3', 'foto/TKJ3  RAHMA KURNIA  7110.JPG', 'aktif'),
(27, '000012', 'RAKHA AZZAHRO ALVASTO', 'XI_TKJ_3', 'Laki-Laki', 'pare', '085707291352', 'Kampus 3', 'foto/TKJ3  RAKHA AZZARO  7147.JPG', 'aktif'),
(28, '000013', 'RARATRISMA HANIKMATUL RIZKI', 'XI_TKJ_3', 'Perempuan', 'pare', '082123146657', 'Kampus 3', 'foto/TKJ3  RARA TRISMA   7102.JPG', 'aktif'),
(29, '000014', 'RAYA AISYA PUTRI', 'XI_TKJ_3', 'Perempuan', 'pare', '089509947864', 'Kampus 3', 'foto/TKJ3  RAYA AISYA P  7100.JPG', 'aktif'),
(30, '000015', 'RAYU FAJARUNI', 'XI_TKJ_3', 'Perempuan', 'pare', '082228289216', 'Kampus 3', 'foto/TKJ3  RAYU FAJARUN  7086.JPG', 'aktif'),
(31, '000016', 'REVA AZZAHRA', 'XI_TKJ_3', 'Perempuan', 'pare', '08888', 'Kampus 3', 'foto/TKJ3  REVA AZZAHRA  7091.JPG', 'aktif'),
(32, '000017', 'REVI MARSKA', 'XI_TKJ_3', 'Laki-Laki', 'pare', '083112289114', 'Kampus 3', 'foto/TKJ3  REVI MARISKA  7089.JPG', 'aktif'),
(33, '000018', 'REYHAN DWIANDIKA ', 'XII_TKJ_3', 'Laki-Laki', 'pare', '081815256116', 'Kampus 1', 'foto/TKJ3  REYHAN DWIAN  7085.JPG', 'aktif'),
(34, '000019', 'ROBI\'AH AL ADAWIYAH ', 'XI_TKJ_3', 'Perempuan', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  ROBI\'AH AL A  7096.JPG', 'aktif'),
(35, '000020', 'ROFIATUL SAFIRA', 'XI_TKJ_3', 'Perempuan', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  ROFIATUL SAF  7097.JPG', 'aktif'),
(36, '000021', 'SATRIA MAJID', 'XI_TKJ_3', 'Laki-Laki', 'Badas', '087957', 'Kampus 3', 'foto/TKJ3  SATRIA MAJID  7076.JPG', 'aktif'),
(37, '000022', 'SEFINA RAMADHANI', 'XI_TKJ_3', 'Perempuan', 'jombangan', '085852701829', 'Kampus 3', '', 'aktif'),
(38, '000023', 'SELA DWI KIRANA ', 'XI_TKJ_3', 'Laki-Laki', 'pare', '081553546241', 'Kampus 3', 'foto/TKJ3  SELA DWI SUR  7079.JPG', 'aktif'),
(39, '000024', 'SELLVIA MAJID SANTOSO', 'XI_TKJ_3', 'Perempuan', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  SELLVIA MAJI  7105.JPG', 'aktif'),
(40, '000025', 'SHADANG ADRIANSYAH MAULANA R.', 'XI_TKJ_3', 'Laki-Laki', 'pare', '085232186580', 'Kampus 3', 'foto/TKJ3  SHADANG ANDR  0021.jpg', 'aktif'),
(41, '000026', 'SHAFIRA NURUL AFIFFAH', 'XI_TKJ_3', 'Perempuan', 'pare', '085784575908', 'Kampus 3', 'foto/TKJ3  SHAFIRA NURU  7104.JPG', 'aktif'),
(42, '000027', 'SYLVIA YULVIANA', 'XI_TKJ_3', 'Perempuan', 'pare', '087851658334', 'Kampus 3', 'foto/TKJ3  SYLVIA YULVI  7109.JPG', 'aktif'),
(43, '000028', 'TAUFIQ AKBAR WAKHID MAULANA', 'XI_TKJ_3', 'Laki-Laki', 'puncu', '082338005558', 'Kampus 3', 'foto/TKJ3  TAUFIQ AKBAR  7075.JPG', 'aktif'),
(44, '000029', 'TIARA SILVI RAHAYU', 'XI_TKJ_3', 'Perempuan', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  TIARA SILVI   7095.JPG', 'aktif'),
(45, '000030', 'TONI LUCKMAN HADY LULUT WIJAYA', 'XI_TKJ_3', 'Perempuan', 'puncu', '087957', 'Kampus 3', 'foto/TKJ3  TONI LUCKMAN  7077.JPG', 'aktif'),
(46, '000031', 'VALENTINO FAHRESI', 'XI_TKJ_3', 'Laki-Laki', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  VALENTINO FA  7081.JPG', 'aktif'),
(47, '000032', 'VICO ARI BRILIANSYAH ', 'XI_TKJ_3', 'Laki-Laki', 'pare', '081334774943', 'Kampus 3', 'foto/TKJ3  VICO ARI BRI  7082.JPG', 'aktif'),
(48, '000033', 'VIKA ANASTASYA PUTRI', 'XI_TKJ_3', 'Perempuan', 'puncu', '088214926545', 'Kampus 3', 'foto/TKJ3  VIKA ANASTAS  7101.JPG', 'aktif'),
(49, '000034', 'WIDHESKA BIAS BUMIARSA', 'XI_TKJ_3', 'Laki-Laki', 'pare', '081215099104', 'Kampus 3', 'foto/TKJ3  WIDHESKA BIA  7073.JPG', 'aktif'),
(50, '000035', 'YULI ARUM SARI ', 'XI_TKJ_3', 'Perempuan', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  YULI ARUM SA  7088.JPG', 'aktif'),
(51, '000036', 'YUNINDA VERGANATA ', 'XI_TKJ_3', 'Perempuan', 'puncu', '085745876114', 'Kampus 3', 'foto/TKJ3  YUNINDA VERG  7087.JPG', 'aktif'),
(52, '000037', 'YURINDA DEVANKA NINGTYAS', 'XI_TKJ_3', 'Perempuan', 'pare', '082334824245', 'Kampus 3', 'foto/TKJ3  YURINDA DEVA  7093.JPG', 'aktif'),
(53, '000038', 'YUSUF MAULANA ', 'XI_TKJ_3', 'Laki-Laki', 'pare', '085894658780', 'Kampus 3', 'foto/TKJ3  YUSUF MAULAN  7080.JPG', 'aktif'),
(54, '000039', 'ZAHRA NURAINI', 'XI_TKJ_3', 'Perempuan', 'pare', '087957', 'Kampus 3', 'foto/TKJ3  ZAHRA NURAIN  7108.JPG', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_pegawai`, `username`, `password`, `status`, `role`) VALUES
(2, 1, 'reyhan', '$2y$10$0sEmBXz9UPGsg3y2I7ZDx.gOeZZB2vXRwSZ6FkYRhFTUgCzOwTOfm', 'aktif', 'admin'),
(3, 4, 'rayu', '$2y$10$IMVzrDfgolps47dNuWAh5uN2r0piOyn/igtxU7RW53o56jK44Rfk2', 'aktif', 'pegawai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi_presensi`
--
ALTER TABLE `lokasi_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_siswa`);

--
-- Indeks untuk tabel `presensi_out`
--
ALTER TABLE `presensi_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`,`nis`),
  ADD KEY `nis` (`nis`),
  ADD KEY `nis_2` (`nis`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id pegawai` (`id_pegawai`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `lokasi_presensi`
--
ALTER TABLE `lokasi_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `presensi_out`
--
ALTER TABLE `presensi_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`);

--
-- Ketidakleluasaan untuk tabel `presensi_out`
--
ALTER TABLE `presensi_out`
  ADD CONSTRAINT `presensi_out_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
