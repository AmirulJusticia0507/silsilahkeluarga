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
<div class="container mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Silsilah Keluarga</li>
        </ol>
    </nav>
    <h2>SILSILAH KELUARGA</h2>
    <div class="tree">
    <ul>
        <?php
        // Koneksi ke database
        include 'koneksi.php'; // Ganti dengan file koneksi yang sesuai

        // Fungsi untuk mengambil data anak berdasarkan orangtua_id
        function getAnak($orangtua_id) {
            global $koneksiku;
            $query = "SELECT id, nama, jenis_kelamin FROM anggota_keluarga WHERE orangtua_id = $orangtua_id";
            $result = $koneksiku->query($query);
            $anak_list = [];
            while ($row = $result->fetch_assoc()) {
                $anak_list[] = $row;
            }
            return $anak_list;
        }

        // Fungsi untuk mengambil data cucu berdasarkan anak_id
        function getCucu($anak_id) {
            global $koneksiku;
            $query = "SELECT id, nama, jenis_kelamin FROM anggota_keluarga WHERE orangtua_id = $anak_id";
            $result = $koneksiku->query($query);
            $cucu_list = [];
            while ($row = $result->fetch_assoc()) {
                $cucu_list[] = $row;
            }
            return $cucu_list;
        }

        // Fungsi untuk membuat struktur organisasi
        function generateOrganisasi($anggota) {
            echo "<li>";
            echo "<a class='link' href='#'>{$anggota['nama']}<br><img style='width:50px; border-radius:40px' src='phpmu.gif'><br>{$anggota['jenis_kelamin']}</a>";

            $anak_list = getAnak($anggota['id']);
            if (!empty($anak_list)) {
                echo "<ul>";
                foreach ($anak_list as $anak) {
                    echo "<li>";
                    echo "<a class='link' href='#' id='{$anak['nama']}-btn'>{$anak['nama']}<br><img style='width:50px; border-radius:40px' src='phpmu.gif'><br>Anak</a>";

                    $cucu_list = getAnak($anak['id']);
                    if (!empty($cucu_list)) {
                        echo "<ul id='cucu-{$anak['nama']}' style='display: none;'>";
                        foreach ($cucu_list as $cucu) {
                            echo "<li>";
                            echo "<a class='link' href='#' id='{$cucu['nama']}-btn'>{$cucu['nama']}<br><img style='width:50px; border-radius:40px' src='phpmu.gif'><br>Cucu</a>";

                            $cicit_list = getCucu($cucu['id']);
                            if (!empty($cicit_list)) {
                                echo "<ul id='cicit-{$cucu['nama']}' style='display: none;'>";
                                foreach ($cicit_list as $cicit) {
                                    echo "<li>";
                                    echo "<a class='link' href='#'>{$cicit['nama']}<br><img style='width:50px; border-radius:40px' src='phpmu.gif'><br>Cicit</a>";
                                    echo "</li>";
                                }
                                echo "</ul>";
                            }

                            echo "</li>";
                        }
                        echo "</ul>";
                    }

                    echo "</li>";
                }
                echo "</ul>";
            }

            echo "</li>";
        }

        // Mulai dari Budi (Kakek)
        $budi = [
            'id' => 1,
            'nama' => 'Budi',
            'jenis_kelamin' => 'Laki-Laki'
        ];
        generateOrganisasi($budi);


        ?>
    </ul>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Tampilkan atau sembunyikan cucu dari Budi ketika Dedi di klik
    $('#dedi-btn').click(function() {
        $('#cucu-budi').toggle();
    });

    // Tampilkan atau sembunyikan cucu dari Budi ketika Dodi di klik
    $('#dodi-btn').click(function() {
        $('#cucu-dedi').toggle();
    });

    // Tampilkan atau sembunyikan cucu dari Budi ketika Dede di klik
    $('#dede-btn').click(function() {
        $('#cucu-dedi').toggle();
    });
    // Tampilkan atau sembunyikan cucu dari Dedi ketika Farah di klik
    $('#farah-btn').click(function() {
        $('#cucu-farah').toggle();
    });

    // Tampilkan atau sembunyikan cucu dari Dodi ketika Gugus di klik
    $('#gugus-btn').click(function() {
        $('#cucu-gugus').toggle();
    });

    // Tampilkan atau sembunyikan cucu dari Dodi ketika Gandi di klik
    $('#gandi-btn').click(function() {
        $('#cucu-gandi').toggle();
    });

    // Tampilkan atau sembunyikan cucu dari Dede ketika Hana di klik
    $('#hana-btn').click(function() {
        $('#cucu-hana').toggle();
    });

    // Tampilkan atau sembunyikan cucu dari Dede ketika Hani di klik
    $('#hani-btn').click(function() {
        $('#cucu-hani').toggle();
    });
});
</script>
</body>
</html>