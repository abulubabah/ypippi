<?php
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){
		
		if (!is_dir(DIR_CACHE.$subdomain)){
			mkdir(DIR_CACHE.$subdomain,0755);
		}
		$data=array();
		if (file_exists(DIR_CACHE.$subdomain.'/cache.kontak')){
			$data=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.kontak'),true);
		}
		
	
		
		if (empty($data)){
			$query=$db->query("SELECT judul,alamat,kota,provinsi,kodepos,telepon,telepon2,fax,email,website,facebook,twitter,google_plus  FROM setting WHERE subdomain='$subdomain'");
			$data=array(
				'judul'=>$query->row['judul'],
				'alamat'=>$query->row['alamat'],
				'kota'=>$query->row['kota'],
				'provinsi'=>$query->row['provinsi'],
				'kodepos'=>$query->row['kodepos'],
				'telepon'=>$query->row['telepon'],
				'telepon2'=>$query->row['telepon2'],
				'fax'=>$query->row['fax'],
				'email'=>$query->row['email'],
				'website'=>$query->row['website'],
				'facebook'=>$query->row['facebook'],
				'twitter'=>$query->row['twitter'],
				'google_plus'=>$query->row['google_plus']
			);
			$filemanager->set(DIR_CACHE.$subdomain.'/cache.kontak',json_encode($data));
		}
		
		$judulkon=$data['judul'];  
		$alamat=$data['alamat'];  
		$kota=$data['kota']; 
		$provinsi=$data['provinsi']; 
		$kodepos=$data['kodepos'];
		$telepon=$data['telepon'];
		$telepon2=$data['telepon2'];
		$fax=$data['fax'];
		$email=$data['email'];
		$website=$data['website'];
		$facebook=$data['facebook'];
		$twitter=$data['twitter'];
		$google_plus=$data['google_plus'];
		if ($layoutposisi=="main") { ?>
			<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2>
			<h3><?php echo $judulkon;?></h3>
			<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
				<tr><td width="130">Alamat</td><td width="15">:</td><td><?php echo $alamat;?></td></tr><?php
				if($kota=="") { } else { ?><tr><td>Kota / Kab</td><td>:</td><td><?php echo $kota;?></td></tr><?php }
				if($provinsi=="") { } else { ?><tr><td>Provinsi</td><td>:</td><td><?php echo $provinsi;?></td></tr><?php }
				if($kodepos=="") { } else { ?><tr><td>Kode Pos</td><td>:</td><td><?php echo $kodepos;?></td></tr><?php }
				if($telepon=="") { } else { ?><tr><td>Telepon</td><td>:</td><td><?php echo $telepon;?></td></tr><?php }
				if($telepon2=="") { } else { ?><tr><td>Telepon 2</td><td>:</td><td><?php echo $telepon2;?></td></tr><?php }
				if($fax=="") { } else { ?><tr><td>Fax</td><td>:</td><td><?php echo $fax;?></td></tr><?php }
				if($email=="") { } else { ?><tr><td>Email</td><td>:</td><td style="text-transform:none;"><?php echo $email;?></td></tr><?php }
				if($website=="") { } else { ?><tr><td>Web</td><td>:</td><td style="text-transform:none;"><?php echo $website;?></td></tr><?php }
				if($facebook=="") { } else { ?><tr><td>FB</td><td>:</td><td style="text-transform:none;"><?php echo $facebook;?></td></tr><?php }
				if($twitter=="") { } else { ?><tr><td>Twitter</td><td>:</td style="text-transform:none;"><td><?php echo $twitter;?></td></tr><?php }
				if($google_plus=="") { } else { ?><tr><td>Google+</td><td>:</td><td style="text-transform:none;"><?php echo $google_plus;?></td></tr><?php } ?>
			</table><br/>
			<h3>Kirim Pesan Anda</h3><?php
			if (empty($_POST['proses'])) { ?>
				<form action="" method="post">
					<input type="hidden" name="proses" value="komentar"/>
					<p><label>Nama<br/><input type="text" name="nama" id="nama" maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p>
					<p><label>Telepon<br/><input type="tel" name="telepon" id="telepon" maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p>		
					<p><label>Email<br/><input type="email" name="emailmu" id="emailmu" maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p>
					<p><label>Pesan<br/><textarea name="komentar" id="komentar" style="width:95%; max-width:400px; margin:5px 0px;" rows="8" required></textarea></label></p>
					<p><input type="submit" value="KIRIM" onClick="return cekkomentar();" class="button" style="margin:5px 0px;"/></p>
				</form><?php
				$randkode=rand(111111,999999); 
				$_SESSION["kode"]=$randkode;
				//$module->komentar_form ($subdomain,$linksub,$bahasa,"halaman",$link,$halidtipe,$link);
			}
			elseif($_POST['proses']=="komentar") {
				if (empty($_SESSION['kode'])) { ?>Maaf, Session Habis<?php }
				else {
					if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
					$nama=strip_tags($_POST['nama']); $nama=str_replace('"','',$nama); $nama=str_replace("'","",$nama);
					$telepon=strip_tags($_POST['telepon']); $telepon=str_replace('"','',$telepon); $telepon=str_replace("'","",$telepon);
					$emailmu=strip_tags($_POST['emailmu']); $emailmu=str_replace('"','',$emailmu); $emailmu=str_replace("'","",$emailmu);
					$komentar=strip_tags($_POST['komentar']); $komentar=str_replace('"','',$komentar); $komentar=str_replace("'","",$komentar);
					mysqli_query($koneksi, "INSERT INTO komentar (subdomain,  nama, telepon, email, komentar, tgl, publish) 
						VALUES ('$subdomain', '$nama', '$telepon', '$emailmu', '$komentar', sysdate(), '0')"); ?>
					<h3>Terima Kasih Atas Komentar Anda</h3>Admin akan segera melakukan pengecekkan terhadap pesan Anda.<?php
				}
				//$module->komentar_send ($subdomain,$linksub,$bahasa);
			}
		}
		else { ?>
			<div class="<?php echo $stylepanel;?>"><?php  
				if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php }  ?>
				<div class="<?php echo $styleisi;?>">
				<h4><b><?php echo $judulkon;?></b></h4>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0" border="0">
					<tr><td colspan="3">Alamat :<br/><?php echo $alamat.", ".$kota.", ".$provinsi.", ".$kodepos;?></td></tr><?php
					if($telepon=="") { } else { ?><tr><td width="80">Telepon</td><td width="10">:</td><td><?php echo $telepon;?></td></tr><?php }
					if($telepon2=="") { } else { ?><tr><td>Telepon 2</td><td>:</td><td><?php echo $telepon2;?></td></tr><?php }
					if($fax=="") { } else { ?><tr><td>Fax</td><td>:</td><td><?php echo $fax;?></td></tr><?php }
					if($email=="") { } else { ?><tr><td colspan="3" style="text-transform:none;">Email :<br/><?php echo $email;?></td></tr><?php }
					if($website=="") { } else { ?><tr><td colspan="3" style="text-transform:none;">Website :<br/><?php echo $website;?></td></tr><?php }
					if($facebook=="") { } else { ?><tr><td colspan="3" style="text-transform:none;">Facebook :<br/><?php echo $facebook;?></td></tr><?php }
					if($twitter=="") { } else { ?><tr><td colspan="3" style="text-transform:none;">Twitter :<br/><?php echo $twitter;?></td></tr><?php }
					if($google_plus=="") { } else { ?><tr><td colspan="3" style="text-transform:none;">Google Plus :<br/><?php echo $google_plus;?></td></tr><?php } ?>
				</table>
				</div>
			</div><?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){  
		$query=mysqli_query($koneksi, "SELECT alamat,kota,provinsi,kodepos,telepon,telepon2,fax,email,website,facebook,twitter,google_plus FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$alamat=$data['alamat'];  
		$kota=$data['kota']; 
		$provinsi=$data['provinsi']; 
		$kodepos=$data['kodepos'];
		$telepon=$data['telepon'];
		$telepon2=$data['telepon2'];
		$fax=$data['fax'];
		$email=$data['email'];
		$website=$data['website'];
		$facebook=$data['facebook'];
		$twitter=$data['twitter'];
		$google_plus=$data['google_plus'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		if (empty($_POST['proses'])) { ?>
			<h2>Kontak</h2>
			<form action="" method="post">
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td width="140">Alamat</td><td><textarea name="alamat" id="alamat" style="width:95%;max-width:500px; height:60px;"><?php echo $alamat;?></textarea></td></tr>
					<tr><td>Kota / Kab</td><td><input type="text" name="kota" id="kota" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $kota;?>" required/></td></tr>
					<tr><td>Provinsi</td><td><input type="text" name="provinsi" id="provinsi" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $provinsi;?>" required/></td></tr>
					<tr><td>Kode Pos</td><td><input type="text" name="kodepos" id="kodepos" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $kodepos;?>" required/></td></tr>
					<tr><td>Telepon</td><td><input type="text" name="telepon" id="telepon" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $telepon;?>" required/></td></tr>
					<tr><td>Telepon 2</td><td><input type="text" name="telepon2" id="telepon2" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $telepon2;?>"/></td></tr>
					<tr><td>Fax</td><td><input type="text" name="fax" id="fax" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $fax;?>"/></td></tr>
					<tr><td>Email</td><td><input type="text" name="email" id="email" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $email;?>"/></td></tr>
					<tr><td>Website</td><td><input type="text" name="website" id="website" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $website;?>" required/></td></tr>
					<tr><td>Facebook</td><td><input type="text" name="facebook" id="facebook" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $facebook;?>"/></td></tr>
					<tr><td>Twitter</td><td><input type="text" name="twitter" id="twitter" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $twitter;?>"/></td></tr>
					<tr><td>Google Plus</td><td><input type="text" name="google_plus" id="google_plus" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $google_plus;?>"/></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></tr> 
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
				$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
				$kota=strip_tags($_POST['kota']); $kota=str_replace('"','',$kota); $kota=str_replace("'","",$kota);
				$provinsi=strip_tags($_POST['provinsi']); $provinsi=str_replace('"','',$provinsi); $provinsi=str_replace("'","",$provinsi);
				$kodepos=strip_tags($_POST['kodepos']); $kodepos=str_replace('"','',$kodepos); $kodepos=str_replace("'","",$kodepos);
				$telepon=strip_tags($_POST['telepon']); $telepon=str_replace('"','',$telepon); $telepon=str_replace("'","",$telepon);
				$telepon2=strip_tags($_POST['telepon2']); $telepon2=str_replace('"','',$telepon2); $telepon2=str_replace("'","",$telepon2);
				$fax=strip_tags($_POST['fax']); $fax=str_replace('"','',$fax); $fax=str_replace("'","",$fax);
				$email=strip_tags($_POST['email']); $email=str_replace('"','',$email); $email=str_replace("'","",$email);
				$website=strip_tags($_POST['website']); $website=str_replace('"','',$website); $website=str_replace("'","",$website);
				$facebook=strip_tags($_POST['facebook']); $facebook=str_replace('"','',$facebook); $facebook=str_replace("'","",$facebook);
				$twitter=strip_tags($_POST['twitter']); $twitter=str_replace('"','',$twitter); $twitter=str_replace("'","",$twitter);
				$google_plus=strip_tags($_POST['google_plus']); $google_plus=str_replace('"','',$google_plus); $google_plus=str_replace("'","",$google_plus);
				global $filemanager;
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.kontak');				
				mysqli_query($koneksi, "UPDATE setting SET alamat='$alamat', kota='$kota', provinsi='$provinsi', kodepos='$kodepos', telepon='$telepon', telepon2='$telepon2', fax='$fax', email='$email', website='$website', facebook='$facebook', twitter='$twitter', google_plus='$google_plus' WHERE subdomain='$subdomain'"); ?>
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