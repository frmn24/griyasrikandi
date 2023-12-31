<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php'); // Redirect pengguna ke halaman login jika mereka belum login
    exit;
}

// Tampilkan konten halaman jika pengguna sudah login
$user_fullname = $_SESSION['user_fullname'];
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3">Admin</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Cari" aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" onclick="confirmLogout()">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="databarang.php">
                            Data Barang
                        </a>
                        <a class="nav-link" href="pemasukan.php">
                            Pemasukan
                        </a>
                        <a class="nav-link" href="pesanan.php">
                            Pesanan
                        </a>
                        <div class="sb-sidenav-menu-heading"></div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-6"></h1>
                    <ol class="breadcrumb mb-5">
                        <li class="breadcrumb-item active" style="font-size: 24px; font-weight: bold;">Pemesanan</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Pemasukan
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Pemasukan
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Pesanan  
                            <button type="button" class="btn btn-primary ms-6 float-end" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Tambah Produk
                            </button>
                        </div>
                        <div class="card-body">
                            <table border='1' id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid black;">Nomor Pemesanan</th>
                                        <th style="border: 1px solid black;">Total Pembayaran</th>
                                        <th style="border: 1px solid black;">Tanggal Pemesanan</th>
                                        <th style="border: 1px solid black;">Total Item</th>
                                        <th style="border: 1px solid black;">Bayar Awal</th>
                                        <th style="border: 1px solid black;">Kurang</th>
                                        <th style="border: 1px solid black;">Kembali</th>
                                        <th style="border: 1px solid black;">Status</th>
                                        <th style="border: 1px solid black;">Diskon</th>
                                        <th style="border: 1px solid black;">Konsumen</th>
                                        <th style="border: 1px solid black;" colspan='2'>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $sql = "select * from pemesanan";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <tr>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["NoPesanan"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Tpembayaran"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["TglPemesanan"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["TItem"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Bawal"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Kurang"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Kembali"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Status"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Diskon"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["IdKonsumen"]; ?>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-warning" role="button" class="btn btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalUbah<?php echo $no; ?>">Update</a>
                                                <a href="#" class="btn btn-danger" role="button" data-bs-toggle="modal"
                                                    data-bs-target="#modalHapus<?php echo $no; ?>">Delete</a>
                                            </td>
                                        </tr>
                                        <!-- Awal Modal Update -->
                                        <div class="modal fade" id="modalUbah<?php echo $no; ?>" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Ubah Produk
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="create.php">
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label for="NoPesanan" class="form-label">Kode
                                                                    Produk</label>
                                                                <input type="text" name="NoPesanan"
                                                                    value="<?php echo $data["NoPesanan"]; ?>"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Tpembayaran" class="form-label">Total Pembayaran</label>
                                                                <input type="text" name="Tpembayaran"
                                                                    value="<?php echo $data["Tpembayaran"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="TglPemesanan" class="form-label">Tanggal Pemesanan</label>
                                                                <input type="number" name="TglPemesanan"
                                                                    value="<?php echo $data["TglPemesanan"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="TItem" class="form-label">Total Item</label>
                                                                <input type="number" name="TItem"
                                                                    value="<?php echo $data["TItem"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Bawal" class="form-label">Bayar Awal</label>
                                                                <input type="number" name="Bawal"
                                                                    value="<?php echo $data["Bawal"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Kurang" class="form-label">Kurang</label>
                                                                <input type="number" name="Kurang"
                                                                    value="<?php echo $data["Kurang"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Kembali" class="form-label">Kembalian</label>
                                                                <input type="number" name="Kembali"
                                                                    value="<?php echo $data["Kembali"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Status" class="form-label">Status</label>
                                                                <input type="number" name="Status"
                                                                    value="<?php echo $data["Status"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Diskon" class="form-label">Diskon</label>
                                                                <input type="number" name="Diskon"
                                                                    value="<?php echo $data["Diskon"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="IdKonsumen" class="form-label">Id Konsumen</label>
                                                                <input type="number" name="IdKonsumen"
                                                                    value="<?php echo $data["IdKonsumen"]; ?>"
                                                                    class="form-control">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="ubah"
                                                                class="btn btn-primary">Ubah</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal Update -->


                                        <!-- Awal Modal Hapus -->
                                        <div class="modal fade" id="modalHapus<?php echo $no; ?>" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="create.php">
                                                        <div class="modal-body">

                                                            <h5 class="text-center"> Apakah Anda Yakin Akan Menghapus Data
                                                                Ini? <br>
                                                                <span class="text-danger">
                                                                    <?= $data["NoPesanan"] ?> -
                                                                    <?= $data["NoPesanan"] ?>
                                                                </span>
                                                            </h5>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="NoPesanan"
                                                                value="<?= $data["NoPesanan"] ?>">
                                                            <button type="submit" name="hapus" class="btn btn-danger">Ya,
                                                                Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal Hapus -->

                                        <?php
                                    endwhile;
                                    ?>
                                </tbody>
                            </table>
                            <!-- Awal Modal Tambah -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Form Tambah Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data" action="create.php">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="kodeproduk" class="form-label">Kode Produk</label>
                                                    <input type="text" name="kodeproduk" id="kodeproduk"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gambar" class="form-label">Gambar Produk</label>
                                                    <input type="file" name="gambar" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="namaproduk" class="form-label">Nama Produk</label>
                                                    <input type="text" name="namaproduk" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="hargajual" class="form-label">Harga Jual</label>
                                                    <input type="number" name="hargajual" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="hargapro" class="form-label">Harga Produksi</label>
                                                    <input type="number" name="hargapro" class="form-control">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="simpan"
                                                    class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Modal Tambah -->
                        </div>
                    </div>
            </main>
        </div>
    </div>
    <script>
        function confirmLogout() {
            var confirmation = confirm("Apakah Anda yakin ingin logout?");
            if (confirmation) {
                window.location.href = "logout.php";
            } else {

            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>