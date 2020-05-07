<?php
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php"); 
	}
	elseif($akses=="admin" or $akses=="super"){
		$query=mysqli_query($koneksi, "SELECT favicon FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$favicon=$data['favicon'];
		if ($data['favicon']=="") { $fav="favicon.png"; } else { $fav=$data['favicon']; }
		$linkhalaman=$linksub."/".$adm."/".$mod;
		$linkpict="//".$domain."/picture/".$fav;
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		if (empty($_POST['proses'])) { ?>
			<h2>Favicon</h2> 
			<form action="" method="post" enctype="multipart/form-data">
				<input name="proses" type="hidden" value="edit"/> 
				<input type="hidden" name="faviconlama" id="faviconlama" value="<?php echo $favicon;?>"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td></td><td><img src="<?php echo $linkpict;?>" alt="favicon"/></td></tr>
					<tr><td width="140">Pilih Gambar</td><td><input type="file" name="favicon" id="favicon" style="width:95%; max-width:250px; padding:0px;"/></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekfavicon();" class="button"/></td></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") { 
			if (empty($_SESSION['kode'])) {?>
				<h3>Favicon Berhasil Disimpan</h3>Selamat, Favicon Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if ($_FILES['favicon']['tmp_name']=="") { ?> 
					<h3>Gambar Masih Kosong</h3>Maaf, Gambar Harus Diisi<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
				} 
				else {	
					$favicon=$_FILES['favicon']['tmp_name'];
					$favicon_name=$_FILES['favicon']['name'];
					$favicon_size=$_FILES['favicon']['size'];
					$favicon_type=$_FILES['favicon']['type'];
					$acak=rand(00000000,99999999);
					$judul_baru=$acak.$favicon_name;
					$judul_baru=str_replace(" ","",$judul_baru);
					$favicon_dimensi=getimagesize($favicon);
					if ($favicon_type!="image/jpg" and $favicon_type!="image/png" and $favicon_type!="image/gif" and $favicon_type!="image/jpeg"){ ?>
						<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
					} 
					elseif ($favicon_dimensi['0']>"100" or $favicon_dimensi['1']>"100") { ?>
						<h3>Resolusi File Terlalu Besar</h3>Maaf, Resolusi Gambar Maksimal 100 X 100 pixels<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
					} 
					else {
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						include($folder.'/function/validasiupload.php');
						$image=new ValidasiUpload($favicon,$judul_baru);
						$image->putGambarType($favicon_type);
						if(!$image->validGambar()){?>
							<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
							exit;
						}
						mysqli_query($koneksi, "UPDATE setting SET favicon='$judul_baru' WHERE subdomain='$subdomain'");
						copy ($favicon, "$folder/picture/".$judul_baru);
						$uploader->uploadPicture($judul_baru);
						if($_POST['faviconlama']==""){ } else { /*unlink("$folder/picture/".$_POST['faviconlama']); $uploader->deletePicture($judul_baru);*/}  ?>
						<h3>Favicon Berhasil Disimpan</h3>Selamat, Favicon Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
					}
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