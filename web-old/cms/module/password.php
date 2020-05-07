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
		$query=mysqli_query($koneksi, "SELECT password FROM user WHERE username='$username' AND subdomain='$subdomain'");
		$data=mysqli_fetch_array($query); 
		$linkhalaman=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Password Admin</h2>
			<form action="" method="post">
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td width="140">Username</td><td><input type="username" name="username" id="username" style="width:95%;max-width:250px;" maxlength="50" value="<?php echo $username;?>" /></td></tr>
					<tr><td>Password Lama</td><td><input type="password" name="oldpass" id="oldpassword" style="width:95%;max-width:250px;" maxlength="50"/></td></tr>
					<tr><td>Password Baru</td><td><input type="password" name="newpass" id="newpassword" style="width:95%;max-width:250px;" maxlength="50"/></td></tr>
					<tr><td>Password Baru</td><td><input type="password" name="renewpass" id="newpassword2" style="width:95%;max-width:250px;" maxlength="50"/><h5>Ulangi Sekali Lagi</h5></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekpassword();" class="button"/></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) { ?>
				<h3>Password Berhasil Disimpan</h3>Selamat, Password Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$passwordlama=$data['password'];
				$oldpass=strip_tags($_POST['oldpass']);
				$newpass=strip_tags($_POST['newpass']); 
				$renewpass=strip_tags($_POST['renewpass']);
				$uname=strip_tags($_POST['username']);
				$oldpassword=md5($oldpass);
				$newpassword=md5($newpass); 
				if ($oldpassword!=$passwordlama) { ?>
					<h3>Password Lama Salah</h3>Maaf, Password Lama Anda Salah<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
				} 
				else {
					mysqli_query($koneksi, "UPDATE user SET password='$newpassword',username='$uname' WHERE username='$username' AND subdomain='$subdomain'");
					$_SESSION['uname']=$uname;
					$_SESSION['pword']=$newpass;?>
					<h3>Password Berhasil Disimpan</h3>Selamat, Password Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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