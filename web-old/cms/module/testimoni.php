<?php
function testimoni_member($subdomain,$folder) {
	$uname=$_SESSION['uname'];?>
	<h2>Testimoni</h2><?php
	if (empty($_POST['proses'])) { 
		$qtes=mysqli_query($koneksi, "SELECT no,judul,isi FROM testimoni WHERE username='$uname' and subdomain='$subdomain'");
		$jtes=mysqli_num_rows($qtes);
		if ($jtes>0) { $dtes=mysqli_fetch_array($qtes); $judultes=$dtes['judul']; $isites=$dtes['isi']; $ada=1; } 
		else { $judultes=""; $isites=""; $ada=0; } ?>				
		<form action="" method="post" class="bar">
			<input type="hidden" name="proses" value="send">
			<input type="hidden" name="ada" value="<?php echo $ada;?>">
			<h3>Silahkan Tulis Testimoni Anda</h3>
			<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
				<tr><td width="130">Judul Testimoni</td><td width="15">:</td><td><input type="text" name="judul" required id="judul" style="width:95%;max-width:500px;" value="<?php echo $judultes;?>" maxlength="100"></td></tr>
				<tr><td>Isi Testimoni</td><td>:</td><td><textarea name="isi" id="isi" style="width:95%;max-width:500px; height:100px;" required><?php echo $isites;?></textarea></td></tr>
				<tr><td style="border-bottom:none;">&nbsp;</td><td style="border-bottom:none;"></td><td style="border-bottom:none;"><input type="submit" value="KIRIM" class="button"></td></tr>
			</table>
		</form><?php
		$randkode=rand(111111,999999); 
		$_SESSION["kode"]=$randkode;
	}
	elseif ($_POST['proses']=="send") { 
		if (empty($_SESSION['kode'])) { ?><div class="success" color="red"><h3>Session Habis</h3>Maaf,Session Habis.</div><?php }
		else {
			include ("$folder/function/function.validasistring.php");
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); 
			$ada=strip_tags($_POST['ada']);
			$validasijudul=new validasistring();
			$validasijudul->validasi(strip_tags($_POST['judul']));
			$judul=mysql_escape_string($validasijudul->hasilvalidasi);
			$validasiisi=new validasistring();
			$validasiisi->validasi(strip_tags($_POST['isi']));
			$isi=mysql_escape_string($validasiisi->hasilvalidasi);
			if ($judul=="") { ?><div class="warning"><h3>Judul Testimoni Masih Kosong</h3>Maaf, Judul  Testimoni Masih Kosong. Silahkan Ulangi Lagi.</div><?php }
			elseif ($isi=="") { ?><div class="warning"><h3>Isi Testimoni Masih Kosong</h3>Maaf, Isi  Testimoni Masih Kosong. Silahkan Ulangi Lagi.</div><?php }
			else {
				if ($ada==1) { mysqli_query($koneksi, "UPDATE testimoni SET judul='$judul', link='$subdomain', isi='$isi', publish='0' WHERE username='$uname' AND subdomain='$subdomain'"); } 
				else { mysqli_query($koneksi, "INSERT INTO testimoni (username, subdomain, judul, link, isi, tgl, publish) VALUES ('$uname', '$subdomain', '$judul', '$subdomain', '$isi', sysdate(), '0')"); } ?>
				<div class="success"><h3>Testimoni Berhasil Dikirim</h3>Terima Kasih, Testimoni Anda berhasil dikirim. <br>Admin akan melakukan verifikasi terlebih dahulu sebelum testimoni Anda ditampilkan.</div><?php
				}
			}
		}	
	}
}

if ($tampil==1) {
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif ($akses=="publik"){
		echo "Maaf Tidak Ada Testimoni";
	}
	elseif($akses=="admin" && $_SESSION['kat']=="admin"){ 
		testimoni_member($subdomain,$folder);
	}	
	elseif ($akses=="admin" && $_SESSION['kat']=="super") {
		$judulmod="Testimoni";
		$tabel="testimoni";
		$batas=30;
		$kolom="judul,isi";
		$lebar="150,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,hapus";
		$jumdetail="multi";
		$tipedetail="table";
		$isidetail="judul,isi,pengirim,subdomain,username,gambar";
		$tipedelete="";
		$jenisinput="gambar";
		$onclick="cekJudul";
		$tipeinput="";
		$forminput="judul,isi,pengirim,subdomain,username,gambar";
		$jenisinputrinci="gambar";
		$onclickrinci="cekNama";
		$tipeinputrinci=""; 
		$forminputrinci="judul,isi,pengirim,subdomain,username,gambar";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		function publish ($tabel) {
		$module=new admin();
		$module->get_variable();
		$no=$module->no;
		if (empty ($no)) { echo "Nomor Kosong"; }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE no='$no'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { echo "Nomor Kosong"; }
			else { 
				
					if($data['publish']==1) { mysqli_query($koneksi, "UPDATE $tabel SET publish='0' WHERE no='$no'");  } 
					elseif ($data['publish']==0) { mysqli_query($koneksi, "UPDATE $tabel SET publish='1' WHERE no='$no'"); } 
					else { mysqli_query($koneksi, "UPDATE $tabel SET publish='1' WHERE no='$no'"); }
					mysqli_query($koneksi, "UPDATE $tabel SET aktif='1' WHERE no='$no'");?>
					<h3>Data Berhasil Disimpan</h3><?php
				
			}
		}
	}
		if (empty ($act)) {
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		} 
		elseif($act=="semua"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="urut"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="cari"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif ($act=="tampilkan"){
			publish($tabel);
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif ($act=="sembunyikan"){
			publish($tabel);
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
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
elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
		} 
		elseif ($act=="ubahrinci") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
		}
		else {
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
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