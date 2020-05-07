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
                <h3>Import Data Staff</h3>
                <br>
                <?php
                if (empty($_POST['import_data'])) {
                    ?>
                    <p>
                        Fitur <i>Import Data</i> adalah layanan yang digunakan untuk input data ke database secara massal dengan meng-inputkan file Microsoft Excel yang berisi <strong>data yang</strong> ingin <strong>di-inputkan sesuai dengan format data yang telah ditetapkan oleh MySch.id seperti</strong> pada <strong>contoh <a href="https://drive.google.com/open?id=1rTjPNzRjOLZ9it5X2HsMJ3Lu8b4RCmAH" title="Contoh Format File Import Data Staff" target="_blank">LINK</a> berikut</strong> ini.
                        <br>
                        <br>
                        Berikut langkah-langkah meng-import data staff ke MySch.id:
                        <ol>
                            <li>Download File Format Data Staff di <a href="https://drive.google.com/open?id=17AmE0Cw7eM4dOT536RELyndalG5-tcdz" title="Format File Import Data Staff" target="_blank">LINK</a> berikut</li>
                            <li>Isi file diatas dengan data staff yang ingin di-inputkan
                                <br>
                                Catatan format data yang di-inputkan:
                                <ul>
                                    <li>Format data kolom NISN, NIS dan kode pos menjadi Text.</li>
                                    <li>Format data kolom tanggal lahir dengan format YYYY-MM-DD, contoh: 1997-05-07.</li>
                                    <li>Setiap file hanya berisi maksimal 75 data. <strong>Jika jumlah data melebihi 75, maka hanya 75 data pertama yang masuk database</strong>.</li>
                                    <li>Disarankan untuk memisahkan data menjadi beberapa file dan meng-import secara bergantian, jika jumlah data melebihi 75 buah.</li>
                                </ul>
                            </li>
                            <li>Klik tombol "IMPORT DATA STAFF" dibawah</li>
                            <li>Upload file data staff dan tunggu proses hingga selesai</li>
                        </ol>
                    </p>
                    <br>
                    <form method="post">
                        <input name="import_data" type="hidden" value="gotoImportDataForm">
                        <input type="submit" class="button" style="display: block; margin: 5px auto 18px; padding: 6px 10px;" value="IMPORT DATA STAFF SEKARANG">
                    </form>
                    <?php
                } elseif ($_POST['import_data'] === "gotoImportDataForm") {
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <input name="import_data" type="hidden" value="processInputFile">
                        <div><span>Pilih File Data Staff</span></div>
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
                            
                            
                            $sql = "INSERT INTO staff (subdomain, nama, link, nip, status, pendidikan, jabatan, kelamin_jenis, agama, tempat_lahir, tanggal_lahir, alamat, kota, kodepos, tgl) VALUES";
                            
                            $rowIndex = 1;
                            foreach ($rows as $row) {
                                if ($rowIndex > 1) {
                                    // Format Long Number
                                    // $spreadsheet->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode('0');
                                    
                                    $staffNama = strip_tags($row[0]);
                                        $staffNama = str_replace("'", "", $staffNama);
                                        $staffNama = str_replace('"', '', $staffNama);
                                        $staffNama = strtolower($staffNama);
                                    $staffLink = str_replace(' ','-', $staffNama);
                                        $staffLink = preg_replace('/[^a-zA-Z0-9_-]/', '', $staffLink);
                                        $staffLink = preg_replace('/(.)\1+/', '$1', $staffLink);
                                    $staffNip = strip_tags($row[1]);
                                        $staffNip = str_replace("'", "", $staffNip);
                                        $staffNip = str_replace('"', '', $staffNip);
                                    $staffStatus = strip_tags($row[2]);
                                        $staffStatus = str_replace("'", "", $staffStatus);
                                        $staffStatus = str_replace('"', '', $staffStatus);
                                    $staffPendidikan = strip_tags($row[3]);
                                        $staffPendidikan = str_replace("'", "", $staffPendidikan);
                                        $staffPendidikan = str_replace('"', '', $staffPendidikan);
                                    $staffJabatan = strip_tags($row[4]);
                                        $staffJabatan = str_replace("'", "", $staffJabatan);
                                        $staffJabatan = str_replace('"', '', $staffJabatan);
                                    $staffGender = strip_tags($row[5]);
                                        $staffGender = str_replace("'", "", $staffGender);
                                        $staffGender = str_replace('"', '', $staffGender);
                                    $staffAgama = strip_tags($row[6]);
                                        $staffAgama = str_replace("'", "", $staffAgama);
                                        $staffAgama = str_replace('"', '', $staffAgama);
                                    $staffTempatLahir = strip_tags($row[7]);
                                        $staffTempatLahir  = str_replace("'", "", $staffTempatLahir);
                                        $staffTempatLahir  = str_replace('"', '', $staffTempatLahir );
                                    $staffTanggalLahir = strip_tags($row[8]);
                                        $staffTanggalLahir  = str_replace("'", "", $staffTanggalLahir);
                                        $staffTanggalLahir  = str_replace('"', '', $staffTanggalLahir);
                                    $staffAlamat = strip_tags($row[9]);
                                        $staffAlamat  = str_replace("'", "", $staffAlamat);
                                        $staffAlamat  = str_replace('"', '', $staffAlamat);
                                    $staffKota = strip_tags($row[10]);
                                        $staffKota  = str_replace("'", "", $staffKota);
                                        $staffKota  = str_replace('"', '', $staffKota);
                                    $staffKodePos = strip_tags($row[11]);
                                        $staffKodePos  = str_replace("'", "", $staffKodePos);
                                        $staffKodePos  = str_replace('"', '', $staffKodePos);
                                    
                                    $sql .= " ('" . $subdomain . "', '" . $staffNama . "', '" . $staffLink . "', '" . $staffNip . "', '" . $staffStatus . "', '" . $staffPendidikan . "', '" . $staffJabatan . "', '" . $staffGender . "', '" . $staffNip . "', '" . $staffTempatLahir . "', '" . $staffTanggalLahir . "', '" . $staffAlamat . "', '" . $staffKota . "', '" . $staffKodePos . "', SYSDATE())";
                                    
                                    $sql .= ($rowIndex === $dataCount) ? ';' : ',';
                                }
                            
                                $rowIndex++;
                            }
                            
                            $queryImportData = mysqli_query($koneksi, $sql);
                            
                            echo $sql;
                            
                            if ($queryImportData) {
                                ?>
                                <h4>Data Staff Berhasil Di-import</h4> Selamat data staff berhasil di-import.
                                <br>
                                <a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/import_staff/" class="button">KEMBALI</a>
                                <?php
                            } else {
                                ?>
                                <h4 style="color: red;">Data Staff Gagal Di-import</h4> Data staff gagal di-import silahkan periksa format data Anda.
                                <br>
                                <a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/import_staff/" class="button">KEMBALI</a>
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