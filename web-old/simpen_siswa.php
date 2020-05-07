<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$qset=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free" or $paket=="basic") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket Profesional.<?php
		}
		else {
			if ($aktif==0){
				?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
			}
			else {
				$qsetsim=mysqli_query($koneksi, "SELECT * FROM simpen_setting WHERE subdomain='$subdomain'");	
				$dsetsim=mysqli_fetch_array($qsetsim);
				$tingkat=$dsetsim['tingkat'];
				$mapel="pengembangan_pembiasaan,pengembangan_kemampuan_dasar,pendidikan_religiositas,nilai_periodik_dalam_angka,nilai_periodik_dalam_huruf,nilai_akhir_siswa";
				$judulmod="Siswa";
				$tabel="simpen_siswa";
				$batas=30;
				$kolom="nama,nis,kelas,keputusan";
				$lebar="200,150,80,100";
				$kolomtgl=0;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="nama,nis,tanggal_lahir,tempat_lahir,nama_orang_tua,jenis_kelamin,kelas,$mapel,keputusan";
				$tipedelete="";
				$jenisinput="";
				$onclick="cekNama";
				$tipeinput="";
				$forminput="nama,nis,tanggal_lahir,tempat_lahir,nama_orang_tua,jenis_kelamin,kelas,$mapel,keputusan";
				$jenisinputrinci="";
				$onclickrinci="cekJudul";
				$tipeinputrinci="";
				$forminputrinci="nama,nis,tanggal_lahir,tempat_lahir,nama_orang_tua,jenis_kelamin,kelas,keputusan";
				$formeditrinci="nama,nis,tanggal_lahir,tempat_lahir,nama_orang_tua,jenis_kelamin,kelas,keputusan,tgl,publish";
				if (empty ($act)) {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
					
				} elseif($act=="semua"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
					
				} elseif($act=="urut"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
					
				} elseif($act=="cari"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
					
				} elseif ($act=="lihat") {
					include("simpen_fungsi.php");
					$no=$_GET['no']/1;
					$qsiswa=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE subdomain='$subdomain' AND no='$no'");	
					$dsiswa=mysqli_fetch_array($qsiswa);
					$nisn=$dsiswa['nisn'];
					$uname=$dsiswa['nisn'];
					simpen_hasil($subdomain,$domain,$nisn,$uname);
					//$module->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail); ?>
					<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/><?php
					
				} elseif ($act=="hapus") {
					$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
					
				} elseif ($act=="hapusmulti") {
					//$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
					echo "DEMI KEAMANAN, FITUR INI SEMENTARA DINONAKTIFKAN";
					
				} elseif ($act=="tambah") {
					include("simpen_fungsi.php");
					$no=$_GET['no']/1;
					$qsiswa=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE subdomain='$subdomain' AND no='$no'");	
					$dsiswa=mysqli_fetch_array($qsiswa);
					$nisn=$dsiswa['nisn'];
					$uname=$dsiswa['nisn'];
					//simpen_tambah($subdomain,$domain,$nisn,$uname);
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
					
				} elseif ($act=="tambahrinci") {
					//$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
					
				} elseif ($act=="ubah") {
					include("simpen_fungsi.php");
					$no=$_GET['no']/1;
					$qsiswa=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE subdomain='$subdomain' AND no='$no'");	
					$dsiswa=mysqli_fetch_array($qsiswa);
					$nisn=$dsiswa['nisn'];
					$uname=$dsiswa['nisn'];
					//simpen_ubah($subdomain,$domain,$nisn,$uname);
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
					
				} elseif ($act=="ubahrinci") {
					//$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
					
				} else {
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