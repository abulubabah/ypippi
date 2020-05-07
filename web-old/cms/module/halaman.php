<?php   
if ($tampil==1) {
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ 
		$module=new publik(); 
		if ($act=="") { 
			if ($haltipe=="artikel") {
				$tabel="artikel";
				$halno=$halidtipe;
				$module->artikel_view($subdomain,$linksub,$bahasa,$tabel,$halno);
			}
			else {
				if (empty($no)) {
					$tabel="halaman";
					$module->artikel_view($subdomain,$linksub,$bahasa,$tabel,$halno);
				}
				else {
					$tabel="halaman";
					$halno=$no;
					$module->artikel_view($subdomain,$linksub,$bahasa,$tabel,$halno);
				}
			}
		}
		elseif ($act=="komentar") {
			$module->komentar_send ($subdomain,$linksub,$bahasa);
		}
	}
	elseif($akses=="admin" or $akses=="super"){
		function halaman_tambah($subdomain,$linksub,$folder) {
			$module=new admin ();
			$module->get_variable();
			$module->setLinkSub($linksub);
			$domain=$module->domain; 
			$mod=$module->mod; 
			$adm=$module->adm; 
			$act=$module->act;
			global $resize;
			global $uploader;
			$linkmod=$linksub."/".$adm."/".$mod;?>
			<h2>Tambah Menu</h2><?php 
			if (empty ($_POST['proses'])) {?>
				<h3>Step 1 : Pilih Tipe Menu</h3><?php
				$qhaltipesub=mysqli_query($koneksi, "SELECT judul,deskripsi,tipe FROM halamantipe WHERE publish='1' AND subdomain LIKE '%$subdomain%' ORDER BY no ASC");
				$qhaltipe=mysqli_query($koneksi, "SELECT judul,deskripsi,tipe FROM halamantipe WHERE publish='1' ORDER BY no ASC");
				while($dhaltipe=mysqli_fetch_array($qhaltipe) or $dhaltipe=mysqli_fetch_array($qhaltipesub)){ 
					$judhal=$dhaltipe['judul'];
					$deshal=$dhaltipe['deskripsi'];
					$tipehal=$dhaltipe['tipe']; ?>
					<form action="" method="post">
						<input name="proses" type="hidden" value="tipe"/>
						<div style="display:table; width:98%; padding:0.5% 1%; margin-bottom:5px; background:#FBFBFB; border:1px solid #F0F0F0;">
							<div style="float:left;"><b><?php echo $judhal;?></b><br/><?php echo $deshal;?></div>
							<div style="float:right;">
								<input name="tipe" type="hidden" value="<?php echo $tipehal;?>"/>
								<input type="image" src="https://<?php echo $domain;?>/image/next.png" value="LANJUT" style="border:none; background:none;" title="LANJUT"/>
							</div>
						</div>
					</form><?php 
				} 
			}
			elseif ($_POST['proses']=="tipe") {
				$tipe=strip_tags($_POST['tipe']);?>
				<h3>Step 2 : Isi Detail Menu</h3>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="proses" value="simpan"/>
					<input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
					<input type="hidden" name="uphalaman" value="0"/>
					<input type="hidden" name="urutan" value="10"/>
					<input type="hidden" name="tampilkan_judul" value="1"/>
					<input type="hidden" name="tampilkan_tanggal" value="0"/>
					<input type="hidden" name="tampilkan_isi" value="1"/>
					<input type="hidden" name="tampilkan_gambar" value="1"/>
					<input type="hidden" name="tampilkan_pembaca" value="0"/>
					<input type="hidden" name="tampilkan_berbagi" value="0"/>
					<input type="hidden" name="tampilkan_katakunci" value="0"/>
					<input type="hidden" name="tampilkan_komentar" value="0"/>
					<input type="hidden" name="tampilkan_formulir" value="0"/>
					<table cellspacing="0" cellpadding="0" width="100%" id="tabelview">
						<tr><td width="140">Judul Halaman</td><td><input type="text" name="judul" id="judul" style="width:95%; max-width:500px;" maxlength="200"/></td></tr><?php
						if ($tipe=="tulis") { ?>
							<input type="hidden" name="idtipe" value=""/>
							<tr><td>Isi</td><td><textarea name="isi" id="editor" style="width:96%; max-width:505px; height:340px;"></textarea></td></tr>
							<tr><td>Kata Kunci</td><td><textarea name="kata_kunci" id="kata_kunci" style="width:95%; max-width:500px; height:40px;"></textarea></td></tr>
							<tr><td>Gambar</td><td><input type="file" name="gambar" id="gambar" style="width:96%; max-width:505px; padding:0px;"/></td></tr><?php
						}
						elseif ($tipe=="berita" or $tipe=="berita_kategori" or $tipe=="galeri_kategori") {
							if ($tipe=="berita") { $labelhal="Pilih ".$tipe; } 
							else { list ($tabelkat,$tulisankat)=explode("_",$tipe); $labelhal="Pilih Kategori ".$tabelkat; } ?>
							<input type="hidden" name="isi" value=""/>
							<input type="hidden" name="kata_kunci" value=""/>
							<input type="hidden" name="gambar" value=""/>
							<tr><td><?php echo $labelhal;?></td>
								<td>
									<select name="idtipe" style="width:96%; max-width:510px;"><?php
										$qkat=mysqli_query($koneksi, "SELECT no,judul FROM $tipe WHERE subdomain='$subdomain' ORDER BY judul ASC");
										while ($dkat=mysqli_fetch_array($qkat)) { $nokat=$dkat['no']; $judulkat=$dkat['judul'];?>
											<option value="<?php echo $nokat;?>"><?php echo $judulkat;?></option><?php
										} ?>
									</select>
								</td>
							</tr><?php
						}
						else { ?>
							<input type="hidden" name="idtipe" value=""/>
							<input type="hidden" name="isi" value=""/>
							<input type="hidden" name="kata_kunci" value=""/>
							<input type="hidden" name="gambar" value=""/><?php
						} ?>
						<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekhalaman();" class="button"/></td></tr>
					</table>
				</form>
				<div style="float:right; text-align:right">
					<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" method="post">
						<input type="hidden" name="proses" value="tiperinci"/>
						<input type="hidden" name="tipe" value="<?php echo $tipe; ?>"/>
						<input type="submit" value="Mode Rinci" style="cursor:pointer; border:none; padding:0px;"/>
					</form>
				</div><?php
				$randkode=rand(111111,888888); 
				$_SESSION['kode']=$randkode;
			}
			elseif ($_POST['proses']=="tiperinci") { 
				$tipe=strip_tags($_POST['tipe']);?>
				<h3>Step 2 : Isi Detail Menu</h3>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="proses" value="simpan"/>
					<input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
					<table cellspacing="0" cellpadding="0" width="100%" id="tabelview">
						<tr><td width="150">Judul Halaman</td><td><input type="text" name="judul" id="judul" style="width:95%; max-width:500px;" maxlength="200"/></td></tr>
						<tr><td>Sub Halaman Dari</td>
							<td>
								<select name="uphalaman" style="width:96%; max-width:510px;">
									<option value="0">-</option><?php
									$qhal=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='0' AND subdomain='$subdomain' ORDER BY urutan ASC");
									while ($dhal=mysqli_fetch_array($qhal)) { $nohal=$dhal['no']; $judulhal=$dhal['judul'];?>
										<option value="<?php echo $nohal;?>"><?php echo $judulhal;?></option><?php
										$qhal2=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='$nohal' AND subdomain='$subdomain' ORDER BY urutan ASC");
										while ($dhal2=mysqli_fetch_array($qhal2)) { $nohal2=$dhal2['no']; $judulhal2=$dhal2['judul'];?>
											<option value="<?php echo $nohal2;?>"> - <?php echo $judulhal2;?></option><?php
											$qhal3=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='$nohal2' AND subdomain='$subdomain' ORDER BY urutan ASC");
											while ($dhal3=mysqli_fetch_array($qhal3)) { $nohal3=$dhal3['no']; $judulhal3=$dhal3['judul'];?>
												<option value="<?php echo $nohal3;?>"> &nbsp;&nbsp; - <?php echo $judulhal3;?></option><?php
												$qhal4=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='$nohal3' AND subdomain='$subdomain' ORDER BY urutan ASC");
												while ($dhal4=mysqli_fetch_array($qhal4)) { $nohal4=$dhal4['no']; $judulhal4=$dhal4['judul'];?>
													<option value="<?php echo $nohal4;?>"> &nbsp;&nbsp; &nbsp;&nbsp; - <?php echo $judulhal4;?></option><?php
												}
											}
										}
									} ?>
								</select>
							</td>
						</tr>
						<tr><td>Urutan</td>
							<td>
								<select name="urutan" style="width:96%; max-width:510px;"><?php $ii=1; 
								do{ ?><option value="<?php echo $ii;?>"><?php echo $ii;?></option><?php $ii++; } while($ii<=10); ?>
								</select>
							</td>
						</tr><?php
						if ($tipe=="tulis") { ?>
							<input type="hidden" name="idtipe" value=""/>
							<tr><td>Isi</td><td><textarea name="isi" id="editor" style="width:96%; max-width:510px; height:340px;"></textarea></td></tr>
							<tr><td>Kata Kunci</td><td><textarea name="kata_kunci" id="kata_kunci" style="width:95%; max-width:500px; height:40px;"></textarea></td></tr>
							<tr><td>Gambar</td><td><input type="file" name="gambar" id="gambar" style="width:96%; max-width:505px; padding:0px;"/></td></tr>
							<tr><td>Tampilkan Nama</td>
								<td><select name="tampilkan_judul" style="width:96%; max-width:510px;"><option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select></td></tr>
							<tr><td>Tampilkan Tanggal</td>
								<td><select name="tampilkan_tanggal" style="width:96%; max-width:510px;"><option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select></td></tr>
							<tr><td>Tampilkan Isi</td>
								<td><select name="tampilkan_isi" style="width:96%; max-width:510px;"><option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select></td></tr>
							<tr><td>Tampilkan Gambar</td>
								<td><select name="tampilkan_gambar" style="width:96%; max-width:510px;"><option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select></td></tr>
							<tr><td>Tampilkan Pembaca</td>
								<td><select name="tampilkan_pembaca" style="width:96%; max-width:510px;"><option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select></td></tr>
							<tr><td>Tampilkan Berbagi</td>
								<td><select name="tampilkan_berbagi" style="width:96%; max-width:510px;"><option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select></td></tr>
							<tr><td>Tampilkan Kata Kunci</td>
								<td><select name="tampilkan_katakunci" style="width:96%; max-width:510px;"><option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select></td></tr>
							<tr><td>Tampilkan Komentar</td>
								<td><select name="tampilkan_komentar" style="width:96%; max-width:510px;"><option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select></td></tr>
							<tr><td>Tampilkan Formulir</td>
								<td><select name="tampilkan_formulir" style="width:96%; max-width:510px;"><option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select></td></tr>
								<?php
						}
						elseif ($tipe=="berita" or $tipe=="berita_kategori" or $tipe=="galeri_kategori") { 
							if ($tipe=="berita") { $labelhal="Pilih ".$tipe; } else { list ($tabelkat,$tulisankat)=explode("_",$tipe); $labelhal="Pilih Kategori ".$tabelkat; } ?>
							<input type="hidden" name="isi" value=""/>
							<input type="hidden" name="kata_kunci" value=""/>
							<input type="hidden" name="gambar" value=""/>
							<input type="hidden" name="tampilkan_judul" value="1"/>
							<input type="hidden" name="tampilkan_tanggal" value="0"/>
							<input type="hidden" name="tampilkan_isi" value="1"/>
							<input type="hidden" name="tampilkan_gambar" value="1"/>
							<input type="hidden" name="tampilkan_pembaca" value="0"/>
							<input type="hidden" name="tampilkan_berbagi" value="0"/>
							<input type="hidden" name="tampilkan_katakunci" value="0"/>
							<input type="hidden" name="tampilkan_komentar" value="0"/>
							<input type="hidden" name="tampilkan_formulir" value="0"/>
							<tr><td><?php echo $labelhal;?></td>
								<td>
									<select name="idtipe" style="width:96%; max-width:510px;"><?php
										$qkat=mysqli_query($koneksi, "SELECT no,judul FROM $tipe WHERE subdomain='$subdomain' ORDER BY judul ASC");
										while ($dkat=mysqli_fetch_array($qkat)) { $nokat=$dkat['no']; $judulkat=$dkat['judul'];?>
											<option value="<?php echo $nokat;?>"><?php echo $judulkat;?></option><?php
										} ?>
									</select>
								</td>
							</tr><?php
						} 
						else { ?>
							<input type="hidden" name="idtipe" value=""/>
							<input type="hidden" name="isi" value=""/>
							<input type="hidden" name="kata_kunci" value=""/>
							<input type="hidden" name="gambar" value=""/>
							<input type="hidden" name="tampilkan_judul" value="1"/>
							<input type="hidden" name="tampilkan_tanggal" value=""/>
							<input type="hidden" name="tampilkan_isi" value="1"/>
							<input type="hidden" name="tampilkan_gambar" value="1"/>
							<input type="hidden" name="tampilkan_pembaca" value="1"/>
							<input type="hidden" name="tampilkan_berbagi" value="1"/>
							<input type="hidden" name="tampilkan_katakunci" value="1"/>
							<input type="hidden" name="tampilkan_komentar" value="1"/>
							<input type="hidden" name="tampilkan_formulir" value="1"/><?php				
						}?>
						<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekhalaman();" class="button"/></td></tr>
					</table>
				</form>
				<div style="float:right; text-align:right">
					<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" method="post">
						<input type="hidden" name="proses" value="tipe"/>
						<input type="hidden" name="tipe" value="<?php echo $tipe; ?>"/>
						<input type="submit" value="Mode Sederhana" style="cursor:pointer; border:none; padding:0px;"/>
					</form>
				</div><?php
				$randkode=rand(111111,888888); 
				$_SESSION['kode']=$randkode;
			}
			elseif ($_POST['proses']=="simpan") {
				if (empty ($_SESSION['kode'])) { $module->notify($subdomain,$linksub,"save_ok"); }
				else { 
					$judul=strip_tags($_POST['judul']);
						$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1");
						$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
						$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");
						$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
						$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");
						$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
						$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");
						$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
						$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");
						$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
						$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21");
						$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
						$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");
						$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
						$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");
						$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
					$linkhasil=strtolower("$gantispasi");
					if ($linkhasil=="home" or $linkhasil=="beranda" or $linkhasil=="depan") { $linkhasil=""; } else { $linkhasil=$linkhasil; }
					$tipe=strip_tags($_POST['tipe']);
					$idtipe=strip_tags($_POST['idtipe']);
					$isi=$_POST['isi'];
					$kata_kunci=strip_tags($_POST['kata_kunci']);
					$tampilkan_judul=strip_tags($_POST['tampilkan_judul']);
					$tampilkan_tanggal=strip_tags($_POST['tampilkan_tanggal']);
					$tampilkan_isi=strip_tags($_POST['tampilkan_isi']);
					$tampilkan_gambar=strip_tags($_POST['tampilkan_gambar']);
					$tampilkan_komentar=strip_tags($_POST['tampilkan_komentar']);
					$tampilkan_formulir=strip_tags($_POST['tampilkan_formulir']);
					$tampilkan_pembaca=strip_tags($_POST['tampilkan_pembaca']);
					$tampilkan_katakunci=strip_tags($_POST['tampilkan_katakunci']);
					$tampilkan_berbagi=strip_tags($_POST['tampilkan_berbagi']);
					$urutan=strip_tags($_POST['urutan']);
					$uphalaman=strip_tags($_POST['uphalaman']);
					if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
					if ($uphalaman!=0) { mysqli_query($koneksi, "UPDATE halaman SET subhalaman='1' WHERE subdomain='$subdomain' AND no='$uphalaman'"); }	
					if ($tipe=="tulis") {
						if ($_FILES['gambar']['tmp_name']=="") {
							mysqli_query($koneksi, "INSERT INTO halaman (subdomain, judul, link, tipe, isi, kata_kunci, tampilkan_judul, tampilkan_tanggal, tampilkan_isi, tampilkan_gambar, tampilkan_komentar,
								 tampilkan_formulir, tampilkan_pembaca, tampilkan_katakunci, tampilkan_berbagi, urutan, uphalaman, tgl) 
							VALUES ('$subdomain', '$judul', '$linkhasil', '$tipe', '$isi', '$kata_kunci', '$tampilkan_judul', '$tampilkan_tanggal', '$tampilkan_isi', '$tampilkan_gambar', '$tampilkan_komentar', 
								'$tampilkan_formulir', '$tampilkan_pembaca', '$tampilkan_katakunci', '$tampilkan_berbagi', '$urutan', '$uphalaman', sysdate())");
							$module->notify($subdomain,$linksub,"save_ok");
						}
						else {
							$gambar=$_FILES['gambar']['tmp_name'];
							$gambar_name=$_FILES['gambar']['name'];
							$gambar_size=$_FILES['gambar']['size'];
							$gambar_type=$_FILES['gambar']['type'];
							$acak=rand(00000000,99999999);
							$judul_baru=$acak.$gambar_name;
							$judul_baru=str_replace(" ","",$judul_baru);
							$gambar_dimensi=getimagesize($gambar);
							if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ $module->notify($subdomain,$linksub,"img_format");	}
							elseif ($gambar_dimensi['0']>"1000" or $gambar_dimensi['1']>"1000") { $module->notify($subdomain,$linksub,"image_dimention");} 
							elseif ($gambar_size>"1000000") { $module->notify($subdomain,$linksub,"image_size"); } 
							else {
								include ($folder.'/function/validasiupload.php');
								$image=new ValidasiUpload($gambar,$judul_baru);
								$image->putGambarType($gambar_type);
								if (!$image->validGambar()){
									$module->notify($subdomain,$linksub,"img_format");
									exit;
								}
								mysqli_query($koneksi, "INSERT INTO halaman (subdomain, judul, link, tipe, isi, kata_kunci, tampilkan_judul, tampilkan_tanggal, tampilkan_isi, tampilkan_gambar, tampilkan_komentar,
									tampilkan_formulir, tampilkan_pembaca, tampilkan_katakunci, tampilkan_berbagi, gambar, urutan, uphalaman, tgl) 
								VALUES ('$subdomain', '$judul', '$linkhasil', '$tipe', '$isi', '$kata_kunci', '$tampilkan_judul', '$tampilkan_tanggal', '$tampilkan_isi', '$tampilkan_gambar', '$tampilkan_komentar',
									'$tampilkan_formulir', '$tampilkan_pembaca', '$tampilkan_katakunci', '$tampilkan_berbagi', '$judul_baru', '$urutan', '$uphalaman', sysdate())");
								copy ($gambar, "$folder/picture/".$judul_baru);
								$uploader->uploadPicture($judul_baru);
								$module->notify($subdomain,$linksub,"save_ok");
							}
						}
					}
					elseif ($tipe=="berita" or $tipe=="berita_kategori" or $tipe=="galeri_kategori") {
						mysqli_query($koneksi, "INSERT INTO halaman (subdomain, judul, link, tipe, idtipe, urutan, uphalaman, tgl)	VALUE ('$subdomain', '$judul', '$linkhasil', '$tipe', '$idtipe', '$urutan', '$uphalaman', sysdate())");
						$module->notify($subdomain,$linksub,"save_ok");
					}
					else {
						mysqli_query($koneksi, "INSERT INTO halaman (subdomain, judul, link, tipe, urutan, uphalaman, tgl)	VALUE ('$subdomain', '$judul', '$linkhasil', '$tipe', '$urutan', '$uphalaman', sysdate())");
						$module->notify($subdomain,$linksub,"save_ok");
					}
				}
			}
		}


		function halaman_ubah ($subdomain,$linksub,$folder) { 
			$module=new admin ();
			$module->get_variable();
			$module->setLinkSub($linksub);
			$domain=$module->domain; 
			$mod=$module->mod; 
			$adm=$module->adm; 
			$act=$module->act; 
			$no=$module->no; 
			global $resize;
			global $uploader;
			$linkmod=$linksub."/".$adm."/".$mod;
			if (empty ($no)) { $module->notify($subdomain,$linksub,"empty"); }
			else {
				$no=strip_tags($no)/1;
				$query=mysqli_query($koneksi, "SELECT * FROM halaman WHERE no='$no' AND subdomain='$subdomain'");
				$data=mysqli_fetch_array($query);
				$no=$data['no'];
				$judul=$data['judul']; 
				$tipe=$data['tipe']; 
				$idtipe=$data['idtipe']; 
				$isi=$data['isi']; 
				$kata_kunci=$data['kata_kunci']; 
				$tampilkan_judul=$data['tampilkan_judul'];
				$tampilkan_tanggal=$data['tampilkan_tanggal'];
				$tampilkan_isi=$data['tampilkan_isi'];
				$tampilkan_gambar=$data['tampilkan_gambar'];
				$tampilkan_pembaca=$data['tampilkan_pembaca'];
				$tampilkan_berbagi=$data['tampilkan_berbagi'];
				$tampilkan_katakunci=$data['tampilkan_katakunci'];
				$tampilkan_komentar=$data['tampilkan_komentar'];
				$tampilkan_formulir=$data['tampilkan_formulir']; 
				$urutan=$data['urutan']; 
				$uphalaman=$data['uphalaman']; 
				$gambar=$data['gambar'];
				$publish=$data['publish'];
				if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
				else {
					if (empty ($_POST['proses'])) {	?>
						<h2 class="judul_module">Ubah Halaman</h2>
						<h3 style="text-transform:uppercase">UBAH DETAIL HALAMAN</h3>
						<form action="" method="post" enctype="multipart/form-data">
							<input name="proses" type="hidden" value="simpan"/>
							<input name="tipe" type="hidden" value="<?php echo $tipe;?>"/>
							<input name="no" type="hidden" value="<?php echo $no;?>"/>
							<input type="hidden" name="urutan" value="<?php echo $urutan;?>"/>
							<input type="hidden" name="uphalaman" value="<?php echo $uphalaman;?>"/>
							<input type="hidden" name="uphalamanlama" value="<?php echo $uphalaman;?>"/>
							<input type="hidden" name="publish" value="<?php echo $publish;?>"/>
							<table cellspacing="0" cellpadding="0" width="100%" id="tabelview">
								<tr><td width="140">Nama Halaman</td><td><input type="text" name="judul" id="judul" style="width:95%; max-width:500px;" maxlength="200" value="<?php echo $judul;?>"/></td></tr><?php
								if ($tipe=="tulis") { ?>
									<input type="hidden" name="idtipe" value="<?php echo $idtipe;?>"/>
									<input type="hidden" name="tampilkan_judul" value="<?php echo $tampilkan_judul;?>"/>
									<input type="hidden" name="tampilkan_tanggal" value="<?php echo $tampilkan_tanggal;?>"/>
									<input type="hidden" name="tampilkan_isi" value="<?php echo $tampilkan_isi;?>"/>
									<input type="hidden" name="tampilkan_gambar" value="<?php echo $tampilkan_gambar;?>"/>
									<input type="hidden" name="tampilkan_pembaca" value="<?php echo $tampilkan_pembaca;?>"/>
									<input type="hidden" name="tampilkan_berbagi" value="<?php echo $tampilkan_berbagi;?>"/>
									<input type="hidden" name="tampilkan_katakunci" value="<?php echo $tampilkan_katakunci;?>"/>
									<input type="hidden" name="tampilkan_komentar" value="<?php echo $tampilkan_komentar;?>"/>
									<input type="hidden" name="tampilkan_formulir" value="<?php echo $tampilkan_formulir;?>"/>							
									<tr><td>Isi</td><td><textarea name="isi" id="editor" style="width:96%; max-width:505px; height:340px;"><?php echo $isi;?></textarea></td></tr>
									<tr><td>Kata Kunci</td><td><textarea name="kata_kunci" id="kata_kunci" style="width:95%; max-width:500px; height:40px;"><?php echo $kata_kunci;?></textarea></td></tr>
									<tr>
										<td>Gambar</td>
										<td><?php
										if ($gambar=="") { ?>
											<input type="file" name="gambar" id="gambar" style="width:96%; max-width:505px; padding:0px;"/>
											<input name="gambarlama" type="hidden" value="<?php echo $gambar;?>"/><?php
										}
										else { ?>
											<img src="https://<?php echo $domain;?>/thumb.php?gambar=<?php echo $gambar;?>" width="80" height="60" alt="gambar" align="left" style="margin-right:10px;"/>
											<input type="file" name="gambar" id="gambar" style="width:96%; max-width:505px; padding:0px;"/>
											<input name="gambarlama" type="hidden" value="<?php echo $gambar;?>"/>
											<h5><i>Kosongkon fom ini jika tidak ada perubahan gambar</i></h5>
											<h5><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/hapusgambar/<?php echo $no;?>/" title="Hapus Gambar" onclick="return confirm ('Yakin Akan Menghapus Gambar Ini ?')">Hapus Gambar</a></h5><?php
										} ?>
										</td>
									</tr><?php
								}							
								elseif ($tipe=="berita" or $tipe=="berita_kategori" or $tipe=="galeri_kategori") {
									if ($tipe=="berita") { $labelhal="Pilih ".$tipe; } 
									else { list ($tabelkat,$tulisankat)=explode("_",$tipe); $labelhal="Pilih Kategori ".$tabelkat; } ?>
									<tr><td><?php echo $labelhal;?></td>
										<td>
											<select name="idtipe" style="width:96%; max-width:510px;"><?php
												$qkatid=mysqli_query($koneksi, "SELECT no,judul FROM $tipe WHERE no='$idtipe' AND subdomain='$subdomain'");
												$dkatid=mysqli_fetch_array($qkatid);$nokatid=$dkatid['no']; $judulkatid=$dkatid['judul']; ?>
												<option value="<?php echo $nokatid;?>"><?php echo $judulkatid;?></option><?php
												$qkat=mysqli_query($koneksi, "SELECT no,judul FROM $tipe WHERE subdomain='$subdomain' ORDER BY judul ASC");
												while ($dkat=mysqli_fetch_array($qkat)) { $nokat=$dkat['no']; $judulkat=$dkat['judul'];?>
													<option value="<?php echo $nokat;?>"><?php echo $judulkat;?></option><?php
												} ?>
											</select>
										</td>
									</tr><?php
								}
								else { ?>
									<input type="hidden" name="idtipe" value=""/><?php
								} ?>
								<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekhalaman();" class="button"/></td></tr>
							</table>
						</form>
						<div style="float:right; text-align:right">
							<form action="//<?php echo $linkmod."/act/ubah/".$no;?>/" method="post">
								<input name="proses" type="hidden" value="moderinci"/>
								<input type="submit" value="Mode Rinci" style="cursor:pointer; border:none; padding:0px;"/>
							</form>
						</div><?php
						$randkode=rand(111111,888888); 
						$_SESSION['kode']=$randkode;
					}
					elseif ($_POST['proses']=="moderinci") { ?>
						<h2 class="judul_module">Ubah Halaman</h2>
						<h3 style="text-transform:uppercase">UBAH DETAIL HALAMAN</h3>
						<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="proses" value="simpan"/>
							<input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
							<input type="hidden" name="no" value="<?php echo $no;?>"/>
							<input type="hidden" name="uphalamanlama" value="<?php echo $uphalaman;?>"/>
							<table cellspacing="0" cellpadding="0" width="100%" id="tabelview">
								<tr><td width="180">Nama Halaman</td><td><input type="text" name="judul" id="judul" style="width:95%; max-width:500px;" maxlength="200" value="<?php echo $judul;?>"/></td></tr>
								<tr><td>Sub Halaman Dari</td>
									<td>
										<select name="uphalaman" style="width:96%; max-width:510px;"><?php
											if ($uphalaman==0) { ?><option value="0"> - </option><?php }
											else {
												$qhalid=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE no='$uphalaman'  AND subdomain='$subdomain'");
												$dhalid=mysqli_fetch_array($qhalid); $judulhalid=$dhalid['judul']; ?>
												<option value="<?php echo $uphalaman;?>"><?php echo $judulhalid;?></option>
												<option value="0"> - </option><?php
											}
											$qhal=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='0'  AND subdomain='$subdomain' ORDER BY urutan ASC");
											while ($dhal=mysqli_fetch_array($qhal)) { $nohal=$dhal['no']; $judulhal=$dhal['judul'];?>
												<option value="<?php echo $nohal;?>"><?php echo $judulhal;?></option><?php
												$qhal2=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='$nohal'  AND subdomain='$subdomain' ORDER BY urutan ASC");
												while ($dhal2=mysqli_fetch_array($qhal2)) { $nohal2=$dhal2['no']; $judulhal2=$dhal2['judul'];?>
													<option value="<?php echo $nohal2;?>"> - <?php echo $judulhal2;?></option><?php
													$qhal3=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='$nohal2'  AND subdomain='$subdomain' ORDER BY urutan ASC");
													while ($dhal3=mysqli_fetch_array($qhal3)) { $nohal3=$dhal3['no']; $judulhal3=$dhal3['judul'];?>
														<option value="<?php echo $nohal3;?>"> &nbsp;&nbsp; - <?php echo $judulhal3;?></option><?php
														$qhal4=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE uphalaman='$nohal3'  AND subdomain='$subdomain' ORDER BY urutan ASC");
														while ($dhal4=mysqli_fetch_array($qhal4)) { $nohal4=$dhal4['no']; $judulhal4=$dhal4['judul'];?>
															<option value="<?php echo $nohal4;?>"> &nbsp;&nbsp; &nbsp;&nbsp; - <?php echo $judulhal4;?></option><?php
														}
													}
												}
											} ?>
										</select>
									</td>
								</tr>
								<tr><td>Urutan</td>
									<td>
										<select name="urutan" style="width:96%; max-width:510px;">
											<option value="<?php echo $urutan;?>"><?php echo $urutan;?></option><?php 
											$ii=1; do{ ?><option value="<?php echo $ii;?>"><?php echo $ii;?></option><?php $ii++; } while($ii<=10); ?>
										</select>
									</td>
								</tr>
								<tr><td>Tampilkan</td>
									<td>
										<select name="publish" style="width:96%; max-width:510px;"><?php
											if ($publish==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
											else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
										</select>
									</td>
								</tr><?php
								if($tipe=="tulis") { ?>
									<input type="hidden" name="idtipe" value=""/>
									<tr><td>Isi Halaman</td><td><textarea name="isi" id="editor" style="width:96%; max-width:505px; height:340px;"><?php echo $isi;?></textarea></td></tr>
									<tr><td>Kata Kunci</td><td><textarea name="kata_kunci" id="kata_kunci" style="width:95%; max-width:500px; height:40px;"><?php echo $kata_kunci;?></textarea></td></tr>
									<tr>
										<td>Gambar</td>
										<td><?php
										if ($gambar=="") { ?>
											<input type="file" name="gambar" id="gambar" style="width:96%; max-width:505px; padding:0px;"/>
											<input name="gambarlama" type="hidden" value="<?php echo $gambar;?>"/><?php
										}
										else { ?>
											<img src="//<?php echo $domain;?>/thumb.php?gambar=<?php echo $gambar;?>" width="80" height="60" alt="gambar" align="left" style="margin-right:10px;"/>
											<input type="file" name="gambar" id="gambar" style="width:96%; max-width:505px; padding:0px;"/>
											<input name="gambarlama" type="hidden" value="<?php echo $gambar;?>"/>
											<h5><i>Kosongkon fom ini jika tidak ada perubahan gambar</i></h5>
											<h5><a href="//<?php echo $linkmod;?>/act/hapusgambar/<?php echo $no;?>/" title="Hapus Gambar" onclick="return confirm ('Yakin Akan Menghapus Gambar Ini ?')">Hapus Gambar</a></h5><?php
										} ?>
										</td>
									</tr>
									<tr><td>Tampilkan Nama</td>
										<td>
										<select name="tampilkan_judul" style="width:96%; max-width:510px;"><?php
											if ($tampilkan_judul==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
											else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
										</select>
										</td>
									</tr>
									<tr><td>Tampilkan Tanggal</td>
										<td>
											<select name="tampilkan_tanggal" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_tanggal==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Isi</td>
										<td>
											<select name="tampilkan_isi" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_isi==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Gambar</td>
										<td>
											<select name="tampilkan_gambar" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_gambar==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Pembaca</td>
										<td>
											<select name="tampilkan_pembaca" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_pembaca==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Berbagi</td>
										<td>
											<select name="tampilkan_berbagi" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_berbagi==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Kata Kunci</td>
										<td>
											<select name="tampilkan_katakunci" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_katakunci==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Komentar</td>
										<td>
											<select name="tampilkan_komentar" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_komentar==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr>
									<tr><td>Tampilkan Form Komentar</td>
										<td>
											<select name="tampilkan_formulir" style="width:96%; max-width:510px;"><?php
												if ($tampilkan_formulir==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
												else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
											</select>
										</td>
									</tr><?php
								}
								elseif ($tipe=="berita" or $tipe=="berita_kategori" or $tipe=="galeri_kategori") {
									if ($tipe=="berita") { $labelhal="Pilih ".$tipe; } 
									else { list ($tabelkat,$tulisankat)=explode("_",$tipe); $labelhal="Pilih Kategori ".$tabelkat; } ?>
									<tr><td><?php echo $labelhal;?></td>
										<td>
											<select name="idtipe" style="width:96%; max-width:510px;"><?php
												$qkatid=mysqli_query($koneksi, "SELECT no,judul FROM $tipe WHERE no='$idtipe'  AND subdomain='$subdomain'");
												$dkatid=mysqli_fetch_array($qkatid);$nokatid=$dkatid['no']; $judulkatid=$dkatid['judul']; ?>
												<option value="<?php echo $nokatid;?>"><?php echo $judulkatid;?></option><?php
												$qkat=mysqli_query($koneksi, "SELECT no,judul FROM $tipe  WHERE subdomain='$subdomain' ORDER BY judul ASC");
												while ($dkat=mysqli_fetch_array($qkat)) { $nokat=$dkat['no']; $judulkat=$dkat['judul'];?>
													<option value="<?php echo $nokat;?>"><?php echo $judulkat;?></option><?php
												} ?>
											</select>
										</td>
									</tr><?php
								}
								else { ?><input type="hidden" name="idtipe" value=""/><?php	} ?>
								<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekhalaman();" class="button"/></td></tr>
							</table>
						</form>
						<div style="float:right; text-align:right"><a href="//<?php echo $linkmod."/act/ubah/".$no;?>/" title="Mode Sederhana">Mode Sederhana</a></span></div><?php
						$randkode=rand(111111,888888); 
						$_SESSION['kode']=$randkode;
					}
					elseif ($_POST['proses']=="simpan") {
						if (empty($_SESSION['kode'])) { $module->notify($subdomain,$linksub,"save_ok"); }
						else {
							$no=strip_tags($_POST['no']);
							$judul=strip_tags($_POST['judul']);
								$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1");
								$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
								$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");
								$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
								$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");
								$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
								$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");
								$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
								$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");
								$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
								$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21");
								$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
								$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");
								$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
								$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");
								$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
							$linkhasil=strtolower("$gantispasi");
							if ($linkhasil=="home" or $linkhasil=="beranda" or $linkhasil=="depan") { $linkhasil=""; } else { $linkhasil=$linkhasil; }
							$tipe=strip_tags($_POST['tipe']);
							$idtipe=strip_tags($_POST['idtipe']);
							$urutan=strip_tags($_POST['urutan']);
							$uphalaman=strip_tags($_POST['uphalaman']);
							$publish=strip_tags($_POST['publish']);
							if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
							if ($tipe=="tulis") {
								$isi=$_POST['isi'];
								$kata_kunci=strip_tags($_POST['kata_kunci']);
								$tampilkan_judul=strip_tags($_POST['tampilkan_judul']);
								$tampilkan_tanggal=strip_tags($_POST['tampilkan_tanggal']);
								$tampilkan_isi=strip_tags($_POST['tampilkan_isi']);
								$tampilkan_gambar=strip_tags($_POST['tampilkan_gambar']);
								$tampilkan_komentar=strip_tags($_POST['tampilkan_komentar']);
								$tampilkan_formulir=strip_tags($_POST['tampilkan_formulir']);
								$tampilkan_pembaca=strip_tags($_POST['tampilkan_pembaca']);
								$tampilkan_katakunci=strip_tags($_POST['tampilkan_katakunci']);
								$tampilkan_berbagi=strip_tags($_POST['tampilkan_berbagi']);
								if ($_FILES['gambar']['tmp_name']=="") {
									mysqli_query($koneksi, "UPDATE halaman SET 
									judul='$judul', 
									link='$linkhasil',
									isi='$isi',
									kata_kunci='$kata_kunci',
									tampilkan_judul='$tampilkan_judul',
									tampilkan_tanggal='$tampilkan_tanggal',
									tampilkan_isi='$tampilkan_isi',
									tampilkan_gambar='$tampilkan_gambar',
									tampilkan_komentar='$tampilkan_komentar',
									tampilkan_formulir='$tampilkan_formulir',
									tampilkan_pembaca='$tampilkan_pembaca',
									tampilkan_katakunci='$tampilkan_katakunci',
									tampilkan_berbagi='$tampilkan_berbagi',
									urutan='$urutan',
									uphalaman='$uphalaman', 
									publish='$publish', 
									tgl=sysdate()
									WHERE no='$no'  AND subdomain='$subdomain'");
									$module->notify($subdomain,$linksub,"save_ok");
								}
								else {
									$gambar=$_FILES['gambar']['tmp_name'];
									$gambar_name=$_FILES['gambar']['name'];
									$gambar_size=$_FILES['gambar']['size'];
									$gambar_type=$_FILES['gambar']['type'];
									$acak=rand(00000000,99999999);
									$judul_baru=$acak.$gambar_name;
									$judul_baru=str_replace(" ","",$judul_baru);
									$gambar_dimensi=getimagesize($gambar);
									if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ $module->notify($subdomain,$linksub,"img_format"); }
									elseif ($gambar_dimensi['0']>"1000" or $gambar_dimensi['1']>"1000") { $module->notify($subdomain,$linksub,"image_dimention");} 
									elseif ($gambar_size>"1000000") { $module->notify($subdomain,$linksub,"image_size"); } 
									else {
										include($folder.'/function/validasiupload.php');
										$image=new ValidasiUpload($gambar,$judul_baru);
										$image->putGambarType($gambar_type);
										if (!$image->validGambar()){
											$module->notify($subdomain,$linksub,"img_format");
											exit;
										}
										mysqli_query($koneksi, "UPDATE halaman SET 
										judul='$judul', 
										link='$linkhasil',
										isi='$isi',
										kata_kunci='$kata_kunci',
										tampilkan_judul='$tampilkan_judul',
										tampilkan_tanggal='$tampilkan_tanggal',
										tampilkan_isi='$tampilkan_isi',
										tampilkan_gambar='$tampilkan_gambar',
										tampilkan_komentar='$tampilkan_komentar',
										tampilkan_formulir='$tampilkan_formulir',
										tampilkan_pembaca='$tampilkan_pembaca',
										tampilkan_katakunci='$tampilkan_katakunci',
										tampilkan_berbagi='$tampilkan_berbagi',
										urutan='$urutan',
										uphalaman='$uphalaman', 
										gambar='$judul_baru',
										publish='$publish',
										tgl=sysdate()
										WHERE no='$no'  AND subdomain='$subdomain'");
										$module->notify($subdomain,$linksub,"save_ok");
										copy ($gambar, "$folder/picture/".$judul_baru);
										if($_POST['gambarlama']==""){ } else { /*unlink("$folder/picture/".$_POST['gambarlama']);*/ }
									}
								}
							}
							elseif ($tipe=="berita" or $tipe=="berita_kategori" or $tipe=="galeri_kategori") {
								mysqli_query($koneksi, "UPDATE halaman SET judul='$judul', link='$linkhasil', tipe='$tipe',  idtipe='$idtipe', urutan='$urutan', uphalaman='$uphalaman', publish='$publish', tgl=sysdate() WHERE no='$no'  AND subdomain='$subdomain'");
								$module->notify($subdomain,$linksub,"save_ok");
							}
							else { 
								mysqli_query($koneksi, "UPDATE halaman SET judul='$judul', link='$linkhasil', tipe='$tipe', urutan='$urutan', uphalaman='$uphalaman', publish='$publish', tgl=sysdate() WHERE no='$no'  AND subdomain='$subdomain'");
								$module->notify($subdomain,$linksub,"save_ok");
							}
							if ($uphalaman==$uphalamanlama) { }
							else { 
								mysqli_query($koneksi, "UPDATE halaman SET subhalaman='1' WHERE subdomain='$subdomain' AND no='$uphalaman'");
								$quplama=mysqli_query($koneksi, "SELECT no FROM halaman WHERE uphalaman='$uphalamanlama' AND subdomain='$subdomain'"); 
								$jumuplama=mysqli_num_rows($quplama);
								if ($jumuplama==0) { mysqli_query($koneksi, "UPDATE halaman SET subhalaman='0' WHERE subdomain='$subdomain' AND no='$uphalamanlama'"); }
							}
						}
					}
				}
			}
		}
		$judulmod="Menu";
		$tabel="halaman";
		$batas=30;
		$kolom="judul,tipe,urutan";
		$lebar="200,150,100";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,hapus";
		$jumdetail="multi";
		$tipedetail="";
		$isidetail="judul";
		$tipedelete="gambar";
		$jenisinput="gambar";
		$onclick="cekhalaman";
		$tipeinput="";
		$forminput="judul,penulis,isi,deskripsi,kata_kunci,gambar,tampilkan_judul,tampilkan_tanggal,tampilkan_isi,tampilkan_gambar,tampilkan_penulis,tampilkan_pembaca,tampilkan_berbagi,tampilkan_katakunci,tampilkan_komentar,tampilkan_formulir";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		global $db;
		global $filemanager;
			if (empty ($act)) {
				$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
			} 
			elseif($act=="semua"){
				$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
			}
			elseif($act=="urut"){
				$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
			}
			elseif($act=="cari"){
				$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
			}
			elseif ($act=="lihat") {
				$module->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail);
			} 
			elseif ($act=="hapus") {
				$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.menu');
			} 
			elseif ($act=="hapusmulti") {
				$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.menu');
			} 
			elseif ($act=="tambah") {
				//$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput);
					$qjummenu=mysqli_query($koneksi, "select no from halaman where subdomain='$subdomain'");
					$jummenu=mysqli_num_rows($qjummenu);
					$qcekpaket=mysqli_query($koneksi, "select paket from setting where subdomain='$subdomain'");
					$dpaket=mysqli_fetch_array($qcekpaket);
					$paket=$dpaket['paket'];
				if ($paket=="free") {
					if ($jummenu>=15) { ?>
					<h3>Tambah Menu Ditolak</h3>
					Maaf, Anda Tidak dapat menambah Menu karena sudah melebihi batas paket Free.<br/>
					Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
					Klik <a href="//<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
					<?php
					}
					elseif ($jummenu>=12) {  ?>
					<div style="background:#FFFFAA; padding:1%; margin-bottom:10px;">
					<h3>Peringatan : Kapasitas Menu Hampir Penuh</h3>
					Jumlah menu halaman website Anda hampir melebihi batas maksimal Paket Free.<br/>
					Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
					Klik <a href="//<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
					</div><?php
					halaman_tambah ($subdomain,$linksub,$folder);
					}
					else {
					halaman_tambah ($subdomain,$linksub,$folder);
					}
				}
				else {			
				halaman_tambah ($subdomain,$linksub,$folder);
				}
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.menu');
			} 
			elseif ($act=="ubah") {
				//$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput);
				halaman_ubah ($subdomain,$linksub,$folder);
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.menu');
			} 
			elseif ($act=="hapusgambar") {
				$no=$module->no;
				if ($no=="") { }
				else {
					$no=$no/1;
					$qcekart=mysqli_query($koneksi, "SELECT gambar FROM halaman WHERE no='$no'");
					$dcekart=mysqli_fetch_array($qcekart);
					if ($dcekart['gambar']=="") { }
					else { 
						/*unlink("$folder/picture/".$dcekart['gambar']);*/
						mysqli_query($koneksi, "UPDATE halaman SET gambar='' WHERE no='$no'");
					}
				}
				halaman_ubah ($subdomain,$linksub,$folder);
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.menu');
			} 
			else {
				$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
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