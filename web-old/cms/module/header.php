<?php      
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){ 
		if ($tipe_header=="banner") { ?>
			<img data-src="/<?php echo $domain."/picture/".$header;?>" width="100%" alt="Header"><?php
		}
		else { ?>
			<div class="headleft">
				<a href="//<?php echo $linksub;?>">
				<img data-src="//<?php echo $domain."/picture/".$logo;?>" height="90" alt="Logo" align="left" style="margin-right:15px;"><?php
				if ($subdomain!="syaairullah.sch.id"){ ?>
				<span style="font-size:16px;">Selamat Datang Di</span>
				<h1><?php echo $namaweb;?></h1>
				<span style="font-size:18px;"><?php echo $subnamaweb;?></span><?php } ?>
				</a>
			</div>
			<div class="headright"><?php echo $header_kanan;?></div><?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$query=mysqli_query($koneksi, "SELECT header,tipe_header FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$header=$data['header']; $tipe_header=$data['tipe_header'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		$linktataletak=$linksub."/".$adm."/tataletak";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		if (empty($_POST['proses'])) { ?>
			<h2>Header</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<input name="proses" type="hidden" value="edit"/>
				<input type="hidden" name="headerlama" id="headerlama" value="<?php echo $header;?>"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0"><?php
					if ($header=="") { } else { ?><tr><td></td><td><img src="<?php echo $module->getHttp();?>://<?php echo $domain."/picture/".$header;?>" alt="header" style="width:95%;"/></td></tr><?php } ?>					
					<tr><td width="140">Pilih Gambar</td><td><input type="file" name="gambar" id="gambar" style="width:95%; max-width:300px; padding:0px;"/></td></tr>
					<tr><td>Gunakan Header Ini</td><td>
						<select name="tipe_header"><?php
							if ($tipe_header=="banner") { ?><option value="banner">Ya</option><option value="logo">Tidak</option><?php }
							else { ?><option value="logo">Tidak</option><option value="banner">Ya</option><?php } ?>
						</select>
						</td>
					</tr>					
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekheader();" class="button"/></td></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Header Berhasil Disimpan</h3>Selamat, Header Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
			}
			else {
				$tipe_header=strip_tags($_POST['tipe_header']);
				if ($_FILES['gambar']['tmp_name']=="") {  
					if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
					mysqli_query($koneksi, "UPDATE setting SET tipe_header='$tipe_header' WHERE subdomain='$subdomain'");?>
					<h3>Header Berhasil Disimpan</h3>Selamat, Header Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
				} 
				else {
					$gambar=$_FILES['gambar']['tmp_name'];
					$header_name=$_FILES['gambar']['name'];
					$header_size=$_FILES['gambar']['size'];
					$header_type=$_FILES['gambar']['type'];
					$acak=rand(00000000,99999999);
					$judul_baru=$acak.$header_name;
					$judul_baru=str_replace(" ","",$judul_baru);
					$header_dimensi=getimagesize($gambar);
					if ($header_type!="image/jpg" and $header_type!="image/png" and $header_type!="image/gif" and $header_type!="image/jpeg"){ ?>
						<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
					} 
					elseif ($header_dimensi['0']>"1500" or $header_dimensi['1']>"1500") { ?>
						<h3>Resolusi File Terlalu Besar</h3>Maaf, Resolusi Gambar Maksimal 1500X1500 pixels<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
					} 
					else {
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						include($folder.'/function/validasiupload.php');
						$image=new ValidasiUpload($gambar,$judul_baru);
						$image->putGambarType($header_type);
						if (!$image->validGambar()){?>
							<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
							exit;
						}
						mysqli_query($koneksi, "UPDATE setting SET header='$judul_baru',tipe_header='$tipe_header' WHERE subdomain='$subdomain'");
						copy ($gambar, "$folder/picture/".$judul_baru);
						$uploader->uploadPicture($judul_baru);
						if($_POST['headerlama']==""){ } else { /*unlink("$folder/picture/".$_POST['headerlama']);$uploader->deletePicture($judul_baru); */}  ?>
						<h3>Header Berhasil Disimpan</h3>Selamat, Header Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
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