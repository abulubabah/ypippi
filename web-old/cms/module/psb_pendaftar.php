<?php
if ($tampil == 1) {
    if (empty($akses)) {
        header("Location: index.php");
    } elseif ($akses == "publik" or $akses == "member") {
        $sqlSiswa = "SELECT nama, asal_sekolah, nilai_un FROM psb_member WHERE subdomain = '" . $subdomain . "' ORDER BY nilai_un DESC";
        $querySiswa = mysqli_query($koneksi, $sqlSiswa);
        ?>
        <style>
            .table-pendaftar {
                border-collapse: collapse;
                min-width: 700px;
                width: 100%;
            }
            
            .table-pendaftar th, .table-pendaftar td {
                border: 1px solid rgba(40, 40, 40, .7);
                padding: 4px 7px;
                text-align: left;
                text-transform: capitalize;
            }
            
            .table-pendaftar th {
                font-size: 17px;
                font-weight: 700;
            }
            
            .table-pendaftar td {
                font-size: 14px;
            }
        </style>
        <div style="width: 100%; padding: 0 10px; overflow-x: scroll; overflow-y: hidden;">
            <table class="table-pendaftar">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Calon Siswa</th>
                        <th>Sekolah Asal</th>
                        <th style="width: 15%;">Jumlah Nilai UN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomorUrut = 1;
                    
                    while ($dataSiswa = mysqli_fetch_assoc($querySiswa)) {
                        $namaSiswa = $dataSiswa['nama'];
                        $asalSekolahSiswa = $dataSiswa['asal_sekolah'];
                        $nilaiUnSiswa = $dataSiswa['nilai_un'];
                        ?>
                        <tr>
                            <td style="text-align: right;"><?php echo $nomorUrut; ?></td>
                            <td><?php echo $namaSiswa; ?></td>
                            <td><?php echo $asalSekolahSiswa; ?></td>
                            <td style="text-align: right;"><?php echo $nilaiUnSiswa; ?></td>
                        </tr>
                        <?php
                        $nomorUrut++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}