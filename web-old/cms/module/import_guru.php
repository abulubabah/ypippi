<?php
if ($tampil === 1) {
    if ($akses === "admin" or $akses === "super") {
        include_once $folder . '/vendor/autoload.php';
        $sqlSetting = "SELECT paket, aktif FROM setting WHERE subdomain = '" . $subdomain . "' LIMIT 1";
        $querySetting = mysqli_query($koneksi, $sqlSetting);
        $dataSetting = mysqli_fetch_assoc($querySetting);
        $paketWebsite = $dataSetting['paket'];
        $statusAktifWebsite = $dataSetting['aktif'];
        // Cek Isi Paket Website
        $paketWebsite = (empty($paketWebsite)) ? "free" : $paketWebsite;
        
        if ($paketWebsite === "free") {
            ?>
            <h3>Fitur Tidak Aktif</h3> Maaf, fitur ini hanya aktif untuk website dengan paket berbayar.
            <?php
        } else {
            if (empty($statusAktifWebsite)) {
                ?>
                <h3>Fitur Tidak Aktif</h3> Maaf, fitur ini tidak aktif sementara karena Anda belum melakukan pembayaran.
                <?php
            } else {
                ?>
                <h3>Import Data Guru</h3>
                <br>
                <?php
                if (empty($_POST['import_data'])) {
                    ?>
                    <p>
                        Fitur <i>Import Data</i> adalah layanan yang digunakan untuk input data ke database secara massal dengan meng-inputkan file Microsoft Excel yang berisi <strong>data yang</strong> ingin <strong>di-inputkan sesuai dengan format data yang telah ditetapkan oleh MySch.id seperti</strong> pada <strong>contoh <a href="https://drive.google.com/open?id=12qpmXoVjGEIMxYCSANmrsN5keU3YUiFm" title="Contoh Format File Import Data Guru" target="_blank">LINK</a></strong> berikut ini.
                        <br>
                        <br>
                        Berikut langkah-langkah meng-import data guru ke MySch.id:
                        <ol>
                            <li>Download File Format Data Guru di <a href="https://drive.google.com/open?id=1KeVh2gBbEEPER2tF3eLbbyTJ3LmMZkvT" title="Format File Import Data Guru" target="_blank">LINK</a> berikut</li>
                            <li>Isi file diatas dengan data guru yang ingin di-inputkan
                                <br>
                                Catatan format data yang di-inputkan:
                                <ul>
                                    <li>Format data kolom NIP, NUPTK, tahun sertifikasi, kode pos dan telepon menjadi Text.</li>
                                    <li>Format data kolom tanggal lahir dengan format YYYY-MM-DD, contoh: 1997-05-07.</li>
                                    <li>Setiap file hanya berisi maksimal 75 data. <strong>Jika jumlah data melebihi 75, maka hanya 75 data pertama yang masuk database</strong>.</li>
                                    <li>Disarankan untuk memisahkan data menjadi beberapa file dan meng-import secara bergantian, jika jumlah data melebihi 75 buah.</li>
                                </ul>
                            </li>
                            <li>Klik tombol "IMPORT DATA GURU" dibawah</li>
                            <li>Upload file data guru dan tunggu proses hingga selesai</li>
                        </ol>
                    </p>
                    <br>
                    <form method="post">
                        <input name="import_data" type="hidden" value="gotoImportDataForm">
                        <input type="submit" class="button" style="display: block; margin: 5px auto 18px; padding: 6px 10px;" value="IMPORT DATA GURU SEKARANG">
                    </form>
                    <?php
                } elseif ($_POST['import_data'] === "gotoImportDataForm") {
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <input name="import_data" type="hidden" value="processInputFile">
                        <div><span>Pilih File Data Guru</span></div>
                        <input type="file" name="excel_file" accept=".xls, .xlsx" required>
                        <input type="submit" class="button" style="display: block; margin: 5px 0 18px; padding: 6px 10px;" value="IMPORT">
                    </form>
                    <?php
                    $processRandCode = rand(100000, 999999);
                    $_SESSION['processRandCode'] = $processRandCode;
                } elseif ($_POST['import_data'] === "processInputFile") {
                    if (empty($_SESSION['processRandCode'])) {
                        ?>
                        <h4>Maaf, Kami Kebingungan</h4> Maaf kami kebingungan, silahkan coba beberapa saat lagi.
                        <?php
                    } else {
                        unset($_SESSION['processRandCode']);
                        
                        $allowedFileType = [ 
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/xls',
                            'text/xlsx'
                        ];
                        
                        if (in_array($_FILES['excel_file']['type'], $allowedFileType)) {
                            $fileName = $_FILES['excel_file']['name'];
                            $randomInt = rand(10000000, 99999999);
                            $modifiedFileName = $randomInt . $fileName;
                            $fileTmpName = $_FILES['excel_file']['tmp_name'];
                            $fileType = $_FILES['excel_file']['type'];
                            $targetPath = $folder . "/file/" . $modifiedFileName;
                            move_uploaded_file($fileTmpName, $targetPath);
                        
                            if ($fileType === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" OR $fileType === "text/xlsx") {
                                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                            } else {
                                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                            }
                        
                            $reader->setReadDataOnly(true);
                            $spreadsheet = $reader->load($targetPath);
                            $worksheet = $spreadsheet->getActiveSheet();
                            $rows = $worksheet->toArray();
                            $dataCount = count($rows);
                            $highestIndexInData = $dataCount - 1;
                            
                            $sql = "INSERT INTO guru (subdomain, nama, link, nip, nuptk, tahun_sertifikasi, status, pendidikan, pangkat_golongan, mata_pelajaran, kelamin_jenis, agama, tempat_lahir, tanggal_lahir, alamat, kodepos, telepon, tgl) VALUES";
                            
                            $rowIndex = 1;
                            foreach ($rows as $row) {
                                if ($rowIndex > 1) {
                                    // Format Long Number
                                    // $spreadsheet->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode('0');
                                    
                                    $guruNama = strip_tags($row[0]);
                                        $guruNama = str_replace("'", "", $guruNama);
                                        $guruNama = str_replace('"', '', $guruNama);
                                        $guruNama = strtolower($guruNama);
                                    $guruLink = str_replace(' ','-', $guruNama);
                                        $guruLink = preg_replace('/[^a-zA-Z0-9_-]/', '', $guruLink);
                                        $guruLink = preg_replace('/(.)\1+/', '$1', $guruLink);
                                    $guruNip = strip_tags($row[1]);
                                        $guruNip = str_replace("'", "", $guruNip);
                                        $guruNip = str_replace('"', '', $guruNip);
                                    $guruNuptk = strip_tags($row[2]);
                                        $guruNuptk = str_replace("'", "", $guruNuptk);
                                        $guruNuptk = str_replace('"', '', $guruNuptk);
                                    $guruTahunSertifikasi = strip_tags($row[3]);
                                        $guruTahunSertifikasi = str_replace("'", "", $guruTahunSertifikasi);
                                        $guruTahunSertifikasi = str_replace('"', '', $guruTahunSertifikasi);
                                    $guruStatus = strip_tags($row[4]);
                                        $guruStatus = str_replace("'", "", $guruStatus);
                                        $guruStatus = str_replace('"', '', $guruStatus);
                                    $guruPendidikan = strip_tags($row[5]);
                                        $guruPendidikan = str_replace("'", "", $guruPendidikan);
                                        $guruPendidikan = str_replace('"', '', $guruPendidikan);
                                    $guruPangkat = strip_tags($row[6]);
                                        $guruPangkat = str_replace("'", "", $guruPangkat);
                                        $guruPangkat = str_replace('"', '', $guruPangkat);
                                    $guruMapel = strip_tags($row[7]);
                                        $guruMapel = str_replace("'", "", $guruMapel);
                                        $guruMapel = str_replace('"', '', $guruMapel);
                                    $guruGender = strip_tags($row[8]);
                                        $guruGender = str_replace("'", "", $guruGender);
                                        $guruGender = str_replace('"', '', $guruGender);
                                    $guruAgama = strip_tags($row[9]);
                                        $guruAgama = str_replace("'", "", $guruAgama);
                                        $guruAgama = str_replace('"', '', $guruAgama);
                                    $guruTempatLahir = strip_tags($row[10]);
                                        $guruTempatLahir  = str_replace("'", "", $guruTempatLahir );
                                        $guruTempatLahir  = str_replace('"', '', $guruTempatLahir );
                                    $guruTanggalLahir = strip_tags($row[11]);
                                        $guruTanggalLahir  = str_replace("'", "", $guruTanggalLahir );
                                        $guruTanggalLahir  = str_replace('"', '', $guruTanggalLahir );
                                    $guruAlamat = strip_tags($row[12]);
                                        $guruAlamat  = str_replace("'", "", $guruAlamat );
                                        $guruAlamat  = str_replace('"', '', $guruAlamat );
                                    $guruKodePos = strip_tags($row[13]);
                                        $guruKodePos  = str_replace("'", "", $guruKodePos );
                                        $guruKodePos  = str_replace('"', '', $guruKodePos );
                                    $guruTelepon = strip_tags($row[14]);
                                        $guruTelepon  = str_replace("'", "", $guruTelepon );
                                        $guruTelepon  = str_replace('"', '', $guruTelepon );
                                    
                                    $sql .= " ('" . $subdomain . "', '" . $guruNama . "', '" . $guruLink . "', '" . $guruNip . "', '" . $guruNuptk . "', '" . $guruTahunSertifikasi . "', '" . $guruStatus . "', '" . $guruPendidikan . "', '" . $guruPangkat . "', '" . $guruMapel . "', '" . $guruGender . "', '" . $guruAgama . "', '" . $guruTempatLahir . "', '" . $guruTanggalLahir . "', '" . $guruAlamat . "', '" . $guruKodePos . "', '" . $guruTelepon . "', SYSDATE())";
                                    
                                    $sql .= ($rowIndex === $dataCount) ? ';' : ',';
                                }
                            
                                $rowIndex++;
                            }
                            
                            $queryImportData = mysqli_query($koneksi, $sql);
                            
                            if ($queryImportData) {
                                ?>
                                <h4>Data Guru Berhasil Di-import</h4> Selamat data guru berhasil di-import.
                                <br>
                                <a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/import_guru/" class="button">KEMBALI</a>
                                <?php
                            } else {
                                ?>
                                <h4 style="color: red;">Data Guru Gagal Di-import</h4> Data guru gagal di-import silahkan periksa format data Anda.
                                <br>
                                <a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/import_guru/" class="button">KEMBALI</a>
                                <?php
                            }
                        }
                    }
                } else {
                    ?>
                    <h4>Maaf, Kami Kebingungan</h4> Maaf kami kebingungan, silahkan coba beberapa saat lagi.
                    <?php
                }
            }
        }
        
    } else {
        header("Location: //mysch.id");
    }
} else {
    header("Location: //mysch.id");
}