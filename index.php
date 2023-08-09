<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Silsilah Keluarga</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
        /* Now the CSS */
        * {margin: 0; padding: 0;}

        .tree ul {
            padding-top: 20px; position: relative;
            
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /* We will use ::before and ::after to draw the connectors */
        .tree li::before, .tree li::after {
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 20px;
        }
        .tree li::after {
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

        /* We need to remove left-right connectors from elements without any siblings */
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        /* Remove space from the top of single children */
        .tree li:only-child { padding-top: 0; }

        /* Remove left connector from first child and right connector from last child */
        .tree li:first-child::before, .tree li:last-child::after {
            border: 0 none;
        }
        /* Adding back the vertical connector to the last nodes */
        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        /* Time to add downward connectors from parents */
        .tree ul ul::before {
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        .tree li a {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;
            
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /* Time for some hover effects */
        /* We will apply the hover effect the the lineage of the element also */
        .tree li a:hover, .tree li a:hover+ul li a {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }
        /* Connector styles on hover */
        .tree li a:hover+ul li::after, 
        .tree li a:hover+ul li::before, 
        .tree li a:hover+ul::before, 
        .tree li a:hover+ul ul::before {
            border-color: #94a0b4;
        }
    </style>
</head>
<body>
<?php
    // Fungsi untuk mendapatkan pilihan anggota keluarga
    function getAnggotaKeluargaOptions($koneksiku) {
        $query = "SELECT id, nama FROM anggota_keluarga";
        $result = $koneksiku->query($query);
        $options = "<option value=''>Pilih Anggota Keluarga</option>";
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='".$row['id']."'>".$row['nama']."</option>";
        }
        return $options;
    }

    // Koneksi ke database
    include 'koneksi.php'; // Ganti dengan file koneksi yang sesuai

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $nama = $_POST['nama'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $orangtua_id = $_POST['orangtua_id'];
        $pasangan_id = $_POST['pasangan_id'];
        $anak_id = $_POST['anak_id'];

        // Query INSERT
        $query = "INSERT INTO anggota_keluarga (nama, tanggal_lahir, jenis_kelamin, orangtua_id, pasangan_id, anak_id)
                VALUES ('$nama', '$tanggal_lahir', '$jenis_kelamin', $orangtua_id, $pasangan_id, $anak_id)";
        
        if ($koneksiku->query($query) === TRUE) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Error: " . $query . "<br>" . $koneksiku->error;
        }
    }
    ?>
    <!-- Modal Tabel -->
<div class="modal fade" id="modalTabel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tabel Anggota Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tempat untuk menampilkan tabel -->
                <!-- Isi dengan kode HTML tabel yang sesuai -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Grafik -->
<!-- <div class="modal fade" id="modalGrafik" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Grafik Struktur Organisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tree" id="chart_div"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> -->


<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Silsilah Keluarga</li>
        </ol>
    </nav>
    <h2>SILSILAH KELUARGA</h2>
    <form action="proses_silsilah_keluarga.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama Pasangan</label>
            <input type="text" name="nama" id="nama" class="form-control" required style="width: 50%;">
        </div>
        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required style="width: 50%;">
        </div>
        <div class="form-group">
            <label>Jenis Kelamin:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Laki-Laki" value="Laki-Laki" required>
                <label class="form-check-label" for="Laki-Laki">Laki-Laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" required>
                <label class="form-check-label" for="Perempuan">Perempuan</label>
            </div>
        </div>
        <div class="form-group">
    <label for="orangtua_id">Orang Tua dari :</label>
    <select name="orangtua_id" class="form-control" style="width: 30%;">
            <?php echo getAnggotaKeluargaOptions($koneksiku); ?>
        </select><br>
</div>
<div class="form-group">
    <label for="pasangan_id">Pasangan dari :</label>
    <select name="pasangan_id" class="form-control" style="width: 30%;">
            <?php echo getAnggotaKeluargaOptions($koneksiku); ?>
        </select><br>
</div>
<div class="form-group">
    <label for="anak_id">Anak dari :</label>
    <select name="anak_id" class="form-control" style="width: 30%;">
            <?php echo getAnggotaKeluargaOptions($koneksiku); ?>
        </select><br>
</div>

        <div class="form-group">
            <input type="submit" value="Submit" class="btn btn-success">
            <input type="reset" value="Batal" class="btn btn-danger">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTabel">Lihat Tabel</button>
            <button type="button" class="btn btn-primary" onclick="location.href='chart_page.php';">Lihat Grafik</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Skrip JavaScript Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Skrip JavaScript Google Charts -->
<script type="text/javascript">
        google.charts.load('current', {'packages':['orgchart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'ID');
            data.addColumn('string', 'Nama');
            data.addColumn('string', 'ParentID');

            // Isi data dari basis data
            <?php
            // Koneksi ke database
            // include 'koneksi.php'; // Ganti dengan file koneksi yang sesuai

            // Query untuk mengambil data dari tabel anggota_keluarga
            $query = "SELECT id, nama, orangtua_id FROM anggota_keluarga";
            $result = $koneksiku->query($query);

            $data_rows = [];
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $nama = $row['nama'];
                $orangtua_id = $row['orangtua_id'];

                // Tambahkan data dalam format JavaScript ke dalam array
                $data_rows[] = "['$id', '$nama', '$orangtua_id']";
            }

            // Gabungkan semua data dalam format JavaScript menjadi satu string
            $data_js = implode(",", $data_rows);

            // Echo data JavaScript yang sudah diisi
            echo "data.addRows([$data_js]);";
            ?>

            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            chart.draw(data, {allowHtml:true});
        }
    </script>

</body>
</html>