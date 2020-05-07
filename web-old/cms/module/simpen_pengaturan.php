<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
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
				$query=mysqli_query($koneksi, "SELECT * FROM simpen_setting WHERE subdomain='$subdomain'");
				$jumlah=mysqli_num_rows($query);
				$data=mysqli_fetch_array($query);
				$head1=$data['head1']; 
				$head2=$data['head2']; 
				$head3=$data['head3']; 
				$alamat=$data['alamat']; 
				$tahun_ajaran=$data['tahun_ajaran']; 
				$tanggal_buka=$data['tanggal_buka']; 
				$jam_buka=$data['jam_buka']; 
				$tempat_keputusan=$data['tempat_keputusan']; 
				$tanggal_keputusan=$data['tanggal_keputusan']; 
				$nama_kepsek=$data['nama_kepsek']; 
				$nip_kepsek=$data['nip_kepsek']; 
				$ttd_kepsek=$data['ttd_kepsek']; 
				$stempel=$data['stempel']; 
				$logo=$data['logo'];
				$logo2=$data['logo2'];
				$linkhalaman=$linksub."/".$adm."/".$mod;
				/*
				if ($jumlah>0) { $ada="1"; } 
				else { $ada=0; 
					$head1=""; $head2=""; $head3=""; $alamat=""; $tahun_ajaran=""; $tanggal_buka=""; $jam_buka="";  $logo=""; $logo2="";
					$tempat_keputusan=""; $tanggal_keputusan=""; $nama_kepsek=""; $nip_kepsek=""; $ttd_kepsek=""; $stempel="";
				}
				*/
				if (empty($_POST['proses'])) { ?>
					<h2>Pengaturan Simpen</h2>
					<form action="" method="post" enctype="multipart/form-data">
						<input name="proses" type="hidden" value="edit"/>
						<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
							<tr><td colspan="3"><b>WAKTU SIMPEN</b></d></tr>
							<tr><td width="160">Tahun Ajaran</td><td><input type="text" name="tahun_ajaran" id="tahun_ajaran" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $tahun_ajaran;?>" required/></td></tr>
							<tr><td>Tanggal Buka</td><td><input type="text" name="tanggal_buka" id="tanggal_buka" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $tanggal_buka;?>" required/></td></tr>
							<tr><td>Jam Buka</td><td><input type="text" name="jam_buka" id="jam_buka" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $jam_buka;?>" required/></td></tr>
							<tr><td colspan="3"><b>KOP SURAT</b></d></tr>
							<tr><td>Header 1</td><td><input type="text" name="head1" id="head1" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $head1;?>" required/></td></tr>
							<tr><td>Header 2</td><td><input type="text" name="head2" id="head2" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $head2;?>" required/></td></tr>
							<tr><td>Header 3</td><td><input type="text" name="head3" id="head3" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $head3;?>" required/></td></tr>
							<tr><td>Alamat Kop</td><td><input type="text" name="alamat" id="alamat" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $alamat;?>" required/></td></tr>
							<tr><td>Logo Kiri</td><td><input type="file" name="logo" id="logo" style="width:95%;max-width:500px;" maxlength="200" /></td></tr>
							<tr><td>Logo Kanan</td><td><input type="file" name="logo2" id="logo2" style="width:95%;max-width:500px;" maxlength="200" /></td></tr>
							<tr><td colspan="3"><b>KEPUTUSAN</b></d></tr>
							<tr><td>Tempat Keputusan</td><td><input type="text" name="tempat_keputusan" id="tempat_keputusan" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $tempat_keputusan;?>" required/></td></tr>
							<tr><td>Tanggal Keputusan</td><td><input type="text" name="tanggal_keputusan" id="tanggal_keputusan" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $tanggal_keputusan;?>" required/></td></tr>
							<tr><td>Nama Kepala Sekolah</td><td><input type="text" name="nama_kepsek" id="nama_kepsek" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $nama_kepsek;?>" required/></td></tr>
							<tr><td>NIP Kepala Sekolah</td><td><input type="text" name="nip_kepsek" id="nip_kepsek" style="width:95%;max-width:500px;" maxlength="200" value="<?php echo $nip_kepsek;?>" required/></td></tr>
							<tr><td>Scan TTD Kepsek</td><td><input type="file" name="ttd_kepsek" id="ttd_kepsek" style="width:95%;max-width:500px;" maxlength="200" /></td></tr>
							<tr><td>Stempel Sekolah</td><td><input type="file" name="stempel" id="stempel" style="width:95%;max-width:500px;" maxlength="200" /></td></tr>
		
							<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></tr> 
						</table>
					</form><?php
					$randkode=rand(111111,999999); 
					$_SESSION['kode']=$randkode;
				}
				elseif ($_POST['proses']=="edit") {
					if (empty($_SESSION['kode'])) {?>
						<h3>Pengaturan Simpen Berhasil Disimpan</h3>Selamat, Pengaturan Simpen Berhasil Disimpan<br/><a href="//<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
					}
					else {
						$tahun_ajaran=strip_tags($_POST['tahun_ajaran']); $tahun_ajaran=str_replace('"','',$tahun_ajaran); $tahun_ajaran=str_replace("'","",$tahun_ajaran);
						$tanggal_buka=strip_tags($_POST['tanggal_buka']); $tanggal_buka=str_replace('"','',$tanggal_buka); $tanggal_buka=str_replace("'","",$tanggal_buka);
						$jam_buka=strip_tags($_POST['jam_buka']); $jam_buka=str_replace('"','',$jam_buka); $jam_buka=str_replace("'","",$jam_buka);				
						$head1=strip_tags($_POST['head1']); $head1=str_replace('"','',$head1); $head1=str_replace("'","",$head1);
						$head2=strip_tags($_POST['head2']); $head2=str_replace('"','',$head2); $head2=str_replace("'","",$head2);
						$head3=strip_tags($_POST['head3']); $head3=str_replace('"','',$head3); $head3=str_replace("'","",$head3);
						$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
		
		
						$tempat_keputusan=strip_tags($_POST['tempat_keputusan']); $tempat_keputusan=str_replace('"','',$tempat_keputusan); $tempat_keputusan=str_replace("'","",$tempat_keputusan);
						$tanggal_keputusan=strip_tags($_POST['tanggal_keputusan']); $tanggal_keputusan=str_replace('"','',$tanggal_keputusan); $tanggal_keputusan=str_replace("'","",$tanggal_keputusan);
						$nama_kepsek=strip_tags($_POST['nama_kepsek']); $nama_kepsek=str_replace('"','',$nama_kepsek); $nama_kepsek=str_replace("'","",$nama_kepsek);
						$nip_kepsek=strip_tags($_POST['nip_kepsek']); $nip_kepsek=str_replace('"','',$nip_kepsek); $nip_kepsek=str_replace("'","",$nip_kepsek);
						$ttd_kepsek=strip_tags($_POST['ttd_kepsek']); $ttd_kepsek=str_replace('"','',$ttd_kepsek); $ttd_kepsek=str_replace("'","",$ttd_kepsek);
						$stempel=strip_tags($_POST['stempel']); $stempel=str_replace('"','',$stempel); $stempel=str_replace("'","",$stempel);
						include($folder.'/function/validasiupload.php');
						if ($jumlah>=1) {
							if ($_FILES['logo']['tmp_name']=="") { } 
							else {
								$logo=$_FILES['logo']['tmp_name']; $logo_name=$_FILES['logo']['name']; $logo_size=$_FILES['logo']['size']; $logo_type=$_FILES['logo']['type'];
								$acak=rand(00000000,99999999);
								$logo_baru=$acak.$logo_name; $logo_baru=str_replace(" ","",$logo_baru);
								$image=new ValidasiUpload($logo,$logo_baru);
								$image->putGambarType($logo_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif A<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($logo, "$folder/picture/".$logo_baru);	
								
								mysqli_query($koneksi, "UPDATE simpen_setting SET logo='$logo_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($logo_baru);
							} 
							if ($_FILES['logo2']['tmp_name']=="") { } 
							else {
								$logo2=$_FILES['logo2']['tmp_name']; $logo2_name=$_FILES['logo2']['name']; $logo2_size=$_FILES['logo2']['size']; $logo2_type=$_FILES['logo2']['type'];
								$acak=rand(00000000,99999999);
								$logo2_baru=$acak.$logo2_name; $logo2_baru=str_replace(" ","",$logo2_baru);
								$image=new ValidasiUpload($logo2,$logo2_baru);
								$image->putGambarType($logo2_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif B<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($logo2, "$folder/picture/".$logo2_baru);		
								mysqli_query($koneksi, "UPDATE simpen_setting SET logo2='$logo2_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($logo2_baru);
							} 
							if ($_FILES['ttd_kepsek']['tmp_name']=="") { } 
							else {
								$ttd_kepsek=$_FILES['ttd_kepsek']['tmp_name']; $ttd_kepsek_name=$_FILES['ttd_kepsek']['name']; $ttd_kepsek_size=$_FILES['ttd_kepsek']['size']; $ttd_kepsek_type=$_FILES['ttd_kepsek']['type'];
								$acak=rand(00000000,99999999);
								$ttd_kepsek_baru=$acak.$ttd_kepsek_name; $ttd_kepsek_baru=str_replace(" ","",$ttd_kepsek_baru);
								$image=new ValidasiUpload($ttd_kepsek,$ttd_kepsek_baru);
								$image->putGambarType($ttd_kepsek_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif C<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($ttd_kepsek, "$folder/picture/".$ttd_kepsek_baru);		
								mysqli_query($koneksi, "UPDATE simpen_setting SET ttd_kepsek='$ttd_kepsek_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($ttd_kepsek_baru);
							} 
							if ($_FILES['stempel']['tmp_name']=="") { } 
							else {
								$stempel=$_FILES['stempel']['tmp_name']; $stempel_name=$_FILES['stempel']['name']; $stempel_size=$_FILES['stempel']['size']; $stempel_type=$_FILES['stempel']['type'];
								$acak=rand(00000000,99999999);
								$stempel_baru=$acak.$stempel_name; $stempel_baru=str_replace(" ","",$stempel_baru);
								$image=new ValidasiUpload($stempel,$stempel_baru);
								$image->putGambarType($stempel_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif D<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($stempel, "$folder/picture/".$stempel_baru);		
								mysqli_query($koneksi, "UPDATE simpen_setting SET stempel='$stempel_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($stempel_baru);
							}
							mysqli_query($koneksi, "UPDATE simpen_setting SET tahun_ajaran='$tahun_ajaran', tanggal_buka='$tanggal_buka', jam_buka='$jam_buka', head1='$head1', head2='$head2', head3='$head3', alamat='$alamat',
								tempat_keputusan='$tempat_keputusan', tanggal_keputusan='$tanggal_keputusan', nama_kepsek='$nama_kepsek', nip_kepsek='$nip_kepsek'  
								WHERE subdomain='$subdomain'"); 
						}
						else if ($jumlah<1){
					        mysqli_query($koneksi, "INSERT INTO simpen_setting SET subdomain='$subdomain',tahun_ajaran='$tahun_ajaran', tanggal_buka='$tanggal_buka', jam_buka='$jam_buka', head1='$head1', head2='$head2', head3='$head3', alamat='$alamat',
							tempat_keputusan='$tempat_keputusan', tanggal_keputusan='$tanggal_keputusan', nama_kepsek='$nama_kepsek', nip_kepsek='$nip_kepsek'  
							"); 
							if ($_FILES['logo']['tmp_name']=="") { $logo_baru=""; } 
							else {
								$logo=$_FILES['logo']['tmp_name']; $logo_name=$_FILES['logo']['name']; $logo_size=$_FILES['logo']['size']; $logo_type=$_FILES['logo']['type'];
								$acak=rand(00000000,99999999);
								$logo_baru=$acak.$logo_name; $logo_baru=str_replace(" ","",$logo_baru);
								$image=new ValidasiUpload($logo,$logo_baru);
								$image->putGambarType($logo_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif E<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($logo, "$folder/picture/".$logo_baru);
								mysqli_query($koneksi, "UPDATE simpen_setting SET logo='$logo_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($logo_baru);
							} 
							if ($_FILES['logo2']['tmp_name']=="") { $logo2_baru=""; } 
							else {
								$logo2=$_FILES['logo2']['tmp_name']; $logo2_name=$_FILES['logo2']['name']; $logo2_size=$_FILES['logo2']['size']; $logo2_type=$_FILES['logo2']['type'];
								$acak=rand(00000000,99999999);
								$logo2_baru=$acak.$logo2_name; $logo2_baru=str_replace(" ","",$logo2_baru);
								$image=new ValidasiUpload($logo2,$logo2_baru);
								$image->putGambarType($logo2_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif F<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($logo2, "$folder/picture/".$logo2_baru);	
								mysqli_query($koneksi, "UPDATE simpen_setting SET logo2='$logo2_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($logo2_baru);
							} 
							if ($_FILES['ttd_kepsek']['tmp_name']=="") { $ttd_kepsek_baru="";} 
							else {
								$ttd_kepsek=$_FILES['ttd_kepsek']['tmp_name']; $ttd_kepsek_name=$_FILES['ttd_kepsek']['name']; $ttd_kepsek_size=$_FILES['ttd_kepsek']['size']; $ttd_kepsek_type=$_FILES['ttd_kepsek']['type'];
								$acak=rand(00000000,99999999);
								$ttd_kepsek_baru=$acak.$ttd_kepsek_name; $ttd_kepsek_baru=str_replace(" ","",$ttd_kepsek_baru);
								$image=new ValidasiUpload($ttd_kepsek,$ttd_kepsek_baru);
								$image->putGambarType($ttd_kepsek_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif G<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($ttd_kepsek, "$folder/picture/".$ttd_kepsek_baru);
								mysqli_query($koneksi, "UPDATE simpen_setting SET ttd_kepsek='$ttd_kepsek_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($ttd_kepsek_baru);
							} 
							if ($_FILES['stempel']['tmp_name']=="") { $stempel_baru=""; } 
							else {
								$stempel=$_FILES['stempel']['tmp_name']; $stempel_name=$_FILES['stempel']['name']; $stempel_size=$_FILES['stempel']['size']; $stempel_type=$_FILES['stempel']['type'];
								$acak=rand(00000000,99999999);
								$stempel_baru=$acak.$stempel_name; $stempel_baru=str_replace(" ","",$stempel_baru);
								$image=new ValidasiUpload($stempel,$stempel_baru);
								$image->putGambarType($stempel_type);
								if (!$image->validGambar()){?>
									<h3>Format File Salah</h3>Maaf, File Yang Diijinkan Adalah File Gambar dengan Format .jpg, .png, .gif H<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
									exit;
								}
								copy ($stempel, "$folder/picture/".$stempel_baru);	
								mysqli_query($koneksi, "UPDATE simpen_setting SET stempel='$stempel_baru' WHERE subdomain='$subdomain'");
								$uploader->uploadPicture($stempel_baru);
							}
							
								
							if ($subdomain == "smanduababelan.sch.id") {
							    //echo "INSERT INTO simpen_sambutan (subdomain, tahun_ajaran, tanggal_buka, jam_buka, head1, head2, head3, tempat_keputusan, tanggal_keputusan, nama_kepsek, nip_kepsek,logo,logo2,ttd_kepsek,stempel, tgl) 
								//VALUES ('$subdomain', '$tahun_ajaran', '$tanggal_buka', '$jam_buka', '$head1', '$head2', '$head3', '$tempat_keputusan', '$tanggal_keputusan', '$nama_kepsek', '$nip_kepsek','$logo_baru','$logo2_baru','$ttd_kepsek_baru','$stempel_baru', sysdate())";
							}
						}
						else { 
							echo "Kesalahan Tidak Di Ketahui";
						} 									
						 unset($_SESSION['kode']); 
						?>
						<h3>Setting Simpen Berhasil Disimpan</h3>Selamat, Setting Simpen Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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