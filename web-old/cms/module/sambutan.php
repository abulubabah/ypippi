<?php
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ ?>
		<div class="<?php echo $stylepanel;?>" style="display:table;width:100%;"><?php
		    $dsambutan=array();
		    if (!is_dir(DIR_CACHE.$subdomain)){
				mkdir(DIR_CACHE.$subdomain,0755);
			}
			
			if (file_exists(DIR_CACHE.$subdomain.'/cache.sambutan')){
				$dsambutan=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.sambutan'),true);
			}
			
			if(empty($dsambutan)){
			    $query=$db->query("select judul,isi,gambar from sambutan where subdomain='$subdomain' AND publish='1' ORDER BY tgl DESC");
			    $dsambutan=$query->row;
			    $filemanager->set(DIR_CACHE.$subdomain.'/cache.sambutan',json_encode($dsambutan));
			}
			
			
			
			$sjudul=$dsambutan['judul'];
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $sjudul;?></span></div><?php } else {  } ?>
			<div class="<?php echo $styleisi;?>"><?php
				
				$isisambutan=$dsambutan['isi']; 
				$gambarsambutan=$dsambutan['gambar'];  
				if ($gambarsambutan=="") { } else { ?><img data-src="//<?php echo $domain."/picture/".$gambarsambutan;?>" alt="sambutan" class="gambarmember" align="left"><?php }
				echo $isisambutan;?>
			</div>
		</div><?php 	
	}
	elseif($akses=="admin" or $akses=="super"){
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$query=mysqli_query($koneksi, "SELECT judul,isi,gambar FROM sambutan WHERE subdomain='$subdomain'");
		$jumlah=mysqli_num_rows($query);
		$data=mysqli_fetch_array($query);
		$judul=$data['judul']; 
		$isi=$data['isi']; 
		$gambar=$data['gambar']; 
		$linkhalaman=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Sambutan</h2>
			<form action="" method="post" enctype="multipart/form-data">
				<input name="proses" type="hidden" value="edit"/>
				<input type="hidden" name="gambarlama" id="gambarlama" value="<?php echo $gambar;?>"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td width="140">Judul</td><td><input type="text" name="judul" id="judul" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $judul;?>" required/></td></tr>
					<tr><td>Isi</td><td style="text-transform:none;"><textarea name="isi" id="editor" style="width:95%;max-width:505px;text-transform:none;" rows="12"><?php echo $isi;?></textarea></td></tr><?php
					if ($gambar=="") { } else { ?><tr><td></td><td><img src="<?php echo $module->getHttp();?>://<?php echo $domain."/picture/".$gambar;?>" alt="gambar" width="100"/></td></tr><?php } ?>
					<tr><td>Gambar</td><td><input type="file" name="gambar" id="gambar" style="width:95%; max-width:500px; padding:0px; padding-right:5px;"></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Sambutan Berhasil Disimpan</h3>Selamat, Sambutan Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if ($_FILES['gambar']['tmp_name']=="") {
					if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
					$judul=strip_tags($_POST['judul']); $judul=str_replace('"','',$judul); $judul=str_replace("'","",$judul);
					$isi=mysql_escape_string(str_replace("'","",$_POST['isi']));
					if ($jumlah==1) { mysqli_query($koneksi, "UPDATE sambutan SET judul='$judul', isi='$isi' WHERE subdomain='$subdomain'"); }
					else { mysqli_query($koneksi, "INSERT INTO sambutan (subdomain, judul, isi, tgl) VALUES ('$subdomain', '$judul', '$isi', sysdate())"); } ?>
					<h3>Sambutan Berhasil Disimpan</h3>Selamat, Sambutan Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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
					elseif ($header_dimensi['0']>"1000" or $header_dimensi['1']>"1000") { ?>
						<h3>Resolusi File Terlalu Besar</h3>Maaf, Resolusi Gambar Maksimal 1000X1000 pixels<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
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
						$judul=strip_tags($_POST['judul']); $judul=str_replace('"','',$judul); $judul=str_replace("'","",$judul);
						$isi=mysql_escape_string(strip_tags(str_replace("'","",$_POST['isi'])));
						if ($jumlah==1) { mysqli_query($koneksi, "UPDATE sambutan SET judul='$judul', isi='$isi', gambar='$judul_baru' WHERE subdomain='$subdomain'"); }
						else { mysqli_query($koneksi, "INSERT INTO sambutan (subdomain, judul, isi, gambar, tgl) VALUES ('$subdomain', '$judul', '$isi', '$judul_baru', sysdate())"); }
						copy ($gambar, "$folder/picture/".$judul_baru);
						$uploader->uploadPicture($judul_baru);
						if($_POST['gambarlama']==""){ } else { /*unlink("$folder/picture/".$_POST['gambarlama']);*/ } ?>
						<h3>Sambutan Berhasil Disimpan</h3>Selamat, Sambutan Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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