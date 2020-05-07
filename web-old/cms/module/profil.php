<?php  
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$username=$_SESSION['uname'];
		$query=mysqli_query($koneksi, "SELECT no,nama,alamat,kota,telepon,email FROM user WHERE username='$username' AND subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$nama=$data['nama'];
		$alamat=$data['alamat'];
		$kota=$data['kota'];
		$telepon=$data['telepon'];
		$email=$data['email'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Profil Admin</h2>
			<form action="" method="post"> 
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td width="140">Nama Lengkap</td><td><input type="text" name="nama" id="nama" style="width:95%;max-width:500px;" maxlength="50" value="<?php echo $nama;?>" required/></td></tr>
					<tr><td>Alamat</td><td><textarea name="alamat" id="alamat" style="width:95%;max-width:500px; height:50px;"><?php echo $alamat;?></textarea></td></tr>
					<tr><td>Kota / Kabupaten</td><td><input type="text" name="kota" id="kota" style="width:95%;max-width:500px;" maxlength="50" value="<?php echo $kota;?>" required/></td></tr>
					<tr><td>No. Telepon / HP</td><td><input type="text" name="telepon" id="telepon" style="width:95%;max-width:500px;" maxlength="50" value="<?php echo $telepon;?>" required/></td></tr>
					<tr><td>Email</td><td><input type="text" name="email" id="email" style="width:95%;max-width:500px;" maxlength="50" value="<?php echo $email;?>" required/></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekprofil();" class="button"/></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Profil Admin Berhasil Disimpan</h3>Selamat, Profil Admin Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$nama=strip_tags($_POST['nama']); $nama=str_replace('"','',$nama); $nama=str_replace("'","",$nama);
				$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
				$kota=strip_tags($_POST['kota']); $kota=str_replace('"','',$kota); $kota=str_replace("'","",$kota);
				$telepon=strip_tags($_POST['telepon']); $telepon=str_replace('"','',$telepon); $telepon=str_replace("'","",$telepon);
				$email=strip_tags($_POST['email']); $email=str_replace('"','',$email); $email=str_replace("'","",$email);
				mysqli_query($koneksi, "UPDATE user SET nama='$nama', alamat='$alamat', kota='$kota', telepon='$telepon', email='$email' WHERE username='$username' AND subdomain='$subdomain'"); ?>
				<h3>Profil Admin Berhasil Disimpan</h3>Selamat, Profil Admin Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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