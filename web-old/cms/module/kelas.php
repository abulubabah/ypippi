<?php 
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php"); 
	} 
	elseif  ($akses == "publik") {
	    $sql = "SELECT no, nama, jurusan, wali_kelas FROM kelas WHERE subdomain='".$subdomain."'";
	    $query = mysqli_query($koneksi, $sql);
	    $rows = array();
	    
	    while ($row = mysqli_fetch_assoc($query)) {
	        $rows[] = $row;
	        
	    }
	    ?>
	    <h2>Kelas</h2>
	    <table id="tabellist" style="width: 100%;" cellpadding="0" cellspacing="0">
	        <tr>
	            <th>No.</th>
	            <th style="text-align: left; width: 20%;">Kelas</th>
	            <th style="text-align: left; width: 35%;">Jurusan</th>
	            <th style="text-align: left;">Wali Kelas</th>
	        </tr>
	        <?php
	        $nomorUrut = 0;
	        $namaKelas = "";
	        $jurusan = "";
	        $waliKelas = "";
	        
	        if (!empty($rows)) {
	            $nomorUrut = 1;
	            
	            foreach ($rows as $row) {
	                $namaKelas = $row['nama'];
	                $jurusan = $row['jurusan'];
	                $waliKelas = $row['wali_kelas'];
	                ?>
	                <tr>
	                    <td style="text-align: right;"><?php echo $nomorUrut;?></td>
	                    <td style="text-align: left;"><?php echo $namaKelas;?></td>
	                    <td style="text-align: left;"><?php echo (!empty($jurusan)) ? $jurusan : "-";?></td>
	                    <td style="text-align: left;"><?php echo (!empty($waliKelas)) ? $waliKelas : "-";?></td>
	                </tr>
	                <?php
	                $nomorUrut++;
	                
	            }
	        } else {
	            ?>
	            <tr>
	                <td colspan="4" style="text-align: center;">Maaf data kelas masih kosong</td>
	            </tr>
	            <?php
	            
	        }
	        ?>
	    </table>
	    <?php
	}
	elseif($akses=="admin" or $akses=="super"){  
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free" or $paket=="basic") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket Profesional<?php
		}
		else {
			if ($aktif==0){ ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
				
			}
			else {
			$judulmod="Kelas";
			$tabel="kelas";
			$batas=20;
			$kolom="nama,jurusan";
			$lebar="100,100,100,100";
			$kolomtgl=1;
			$kolomvisit=0;
			$kolomkomen=0;
			$tombolact="ubah,lihat,hapus";
			// Lihat
			$jumdetail="multi";
			$tipedetail="table";
			$isidetail="nama,jurusan,wali_kelas";
			// Delete
			$tipedelete="";
			// Tambah
			$jenisinput="";
			$onclick="cekNama";
			$tipeinput="";
			$forminput="nama,jurusan,wali_kelas";
			// Tambah & Edit Rinci
			$jenisinputrinci="";
			$onclickrinci="cekNama";
			$tipeinputrinci="";
			$forminputrinci="nama,jurusan,wali_kelas,publish";
			$formeditrinci="nama,jurusan,wali_kelas,tgl,publish";
			$module=new admin();
			$module->get_variable();
			$module->setLinkSub($linksub);
				if (empty ($act)) {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				} 
				elseif($act=="semua"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="urut"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="cari"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif ($act=="lihat") {
					$module->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail);
				} 
				elseif ($act=="hapus") {
					$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="hapusmulti") {
					$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="tambah") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="tambahrinci") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
				} 
				elseif ($act=="ubah") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="ubahrinci") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
				} 
				else {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
			}
		}
	}
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>