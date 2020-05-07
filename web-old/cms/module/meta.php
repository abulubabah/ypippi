<?php
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$query=mysqli_query($koneksi, "SELECT judul,subjudul,deskripsi,kata_kunci,footer FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$judulweb=$data['judul']; 
		$subjudulweb=$data['subjudul']; 
		$deskripsiweb=$data['deskripsi']; 
		$katakunciweb=$data['kata_kunci'];
		$footerweb=$data['footer'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Meta Tag</h2>
			<form action="" method="post">
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td width="140">Judul Website</td><td><input type="text" name="judul" id="judul" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $judulweb;?>" required/></td></tr>
					<tr><td>Sub Judul</td><td><input type="text" name="subjudul" id="subjudul" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $subjudulweb;?>" required/></td></tr>
					<tr><td>Deskripsi</td><td><textarea name="deskripsi" id="deskripsi" style="width:95%;max-width:500px; height:60px;"><?php echo $deskripsiweb;?></textarea></td></tr>
					<tr><td>Kata Kunci</td><td><textarea name="kata_kunci" id="kata_kunci" style="width:95%;max-width:500px; height:60px;" ><?php echo $katakunciweb;?></textarea></td></tr>
					<tr><td>Footer</td><td><input type="text" name="footer" id="footer" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $footerweb;?>" required/></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekseo();" class="button"/></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Meta Tag Berhasil Disimpan</h3>Selamat, Meta Tag Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$judul=strip_tags($_POST['judul']); $judul=str_replace('"','',$judul); $judul=str_replace("'","",$judul);
				$subjudul=strip_tags($_POST['subjudul']); $subjudul=str_replace('"','',$subjudul); $subjudul=str_replace("'","",$subjudul);
				$deskripsi=strip_tags($_POST['deskripsi']); $deskripsi=str_replace('"','',$deskripsi); $deskripsi=str_replace("'","",$deskripsi);
				$kata_kunci=strip_tags($_POST['kata_kunci']); $kata_kunci=str_replace('"','',$kata_kunci); $kata_kunci=str_replace("'","",$kata_kunci);
				$footer=strip_tags($_POST['footer']); $footer=str_replace('"','',$footer); $footer=str_replace("'","",$footer);
				mysqli_query($koneksi, "UPDATE setting SET judul='$judul', subjudul='$subjudul', deskripsi='$deskripsi', kata_kunci='$kata_kunci', footer='$footer' WHERE subdomain='$subdomain'"); ?>
				<h3>Meta Tag Berhasil Disimpan</h3>Selamat, Meta Tag Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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