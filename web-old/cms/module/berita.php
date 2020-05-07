<?php  
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ 
		$tabel="berita";	
		$module=new publik();
		$module->get_variable();	
		if ($no=="") { 					
			if ($link=="" or $link=="home" or $link=="beranda") { 
				if($layouttampiljudul==1){ ?><h3 class="<?php echo $stylejudul;?>"><?php echo $layoutjudul;?></h3><?php } 
			}
			else {  ?>
				<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php $module->terjemahkan("Berita",$bahasa);?>"><?php $module->terjemahkan("Berita",$bahasa);?></a></h2><?php 
			}
			$haltipe="";
			$halidtipe="";
			$module->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe);
		}
		else { 
			if ($act=="") {
				$no=$no/1;
				$module->artikel_view ($subdomain,$linksub,$bahasa,$tabel,$no);?>
			<?php
			}
			elseif ($act=="komentar") {
				$module->komentar_send ($subdomain,$linksub,$bahasa);
			}
		}
	}
	elseif($akses=="admin" or $akses=="super"){	
		function artikel_tambah ($subdomain,$linksub,$judulmod,$folder) {
			$module=new admin ();
			$module->get_variable();
			$module->setLinkSub($linksub);
			$domain=$module->domain;
			$mod=$module->mod;
			$adm=$module->adm;
			$linkmod=$linksub."/".$adm."/".$mod;
			
				function tambah_berita($subdomain,$linksub,$judulmod,$folder){
				$module=new admin();
				$module->get_variable();
				$module->setLinkSub($linksub);
				$domain=$module->domain;
				global $uploader;
				if (empty ($_POST['proses'])) {?>
					<h2>Tambah <?php echo $judulmod;?></h2>
					<form action="" method="post" enctype="multipart/form-data" name="judulform">
					<input name="proses" type="hidden" value="simpan"/>
					<div style="display:table; width:100%">
					<div style="float:left; width:550px; border-right:1px solid #F0F0F0; line-height:28px;">
						Judul Berita :<br/><input type="text" name="judul" id="judul" style="width:520px;" maxlength="200"/><br/>
						Isi :<br/><textarea name="isi" id="editor" style="width:528px; height:410px;"></textarea>
						Kata Kunci :<br/><textarea name="kata_kunci" id="kata_kunci" style="width:520px; height:60px;"></textarea><br/>
						Gambar :<br/><input type="file" name="gambar" id="gambar" style="width:525px; padding:0px;"/><br/>
					</div>
					<div style="float:left; width:195px; line-height:28px; margin-left:20px;">
						Kategori : <br/>
						<script type="text/javascript">
							function enableselections() {
								var e = document.getElementById('selections');
									e.disabled = false;
								var i = 0;
								var n = e.options.length;
								for (i = 0; i < n; i++) {
									e.options[i].disabled = false;
								}
							}
						</script>			
						<select disabled="disabled" name="selections[]" id="selections" class="inputbox" style="width:190px; height:170px;" multiple="multiple"><?php 
							$qkat=mysqli_query($koneksi, "SELECT no,judul FROM berita_kategori WHERE subdomain='$subdomain' ORDER BY judul ASC");
							while($dkat=mysqli_fetch_array($qkat)){ ?><option value="<?php echo $dkat['no'];?>"><?php echo $dkat['judul'];?></option><?php } ?>
						</select>
						<script type="text/javascript">enableselections();</script>
						Tampilkan Judul :<br/><select name="tampilkan_judul" style="width:190px;">
							<option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select><br/>					
						Tampilkan Isi :<br/><select name="tampilkan_isi" style="width:190px;">
							<option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select><br/>
						Tampilkan Gambar :<br/><select name="tampilkan_gambar" style="width:190px;">
							<option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select><br/>
						Tampilkan Tanggal :<br/><select name="tampilkan_tanggal" style="width:190px;">
							<option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select><br/>
						Tampilkan Pembaca :<br/><select name="tampilkan_pembaca" style="width:190px;">
							<option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select><br/>
						Tampilkan Berbagi :<br/><select name="tampilkan_berbagi" style="width:190px;">
							<option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select><br/>
						Tampilkan Kata Kunci :<br/><select name="tampilkan_katakunci" style="width:190px">
							<option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select><br/>
						Tampilkan Komentar :<br/><select name="tampilkan_komentar" style="width:190px;">
							<option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select><br/>
						Tampilkan Form Komentar :<br/><select name="tampilkan_formulir" style="width:190px;">
							<option value="0">Sembunyikan</option><option value="1">Tampilkan</option></select><br/>
					</div>
					</div>
					<div style="margin-top:10px;">
					<input type="submit" name="submit" value="SIMPAN" onclick="return cekartikel();" class="button"/>&nbsp;&nbsp;
					<input type="reset" name="reset" value="RESET" class="button_back"/>
					</div>
					</form><?php
					$randkode=rand(111111,888888); 
					$_SESSION['kode']=$randkode;
				}
				elseif ($_POST['proses']=="simpan") {
					if (empty($_SESSION['kode'])) { $module->notify($subdomain,$linksub,"save_ok"); }
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
						$isi=$_POST['isi'];
						$kata_kunci=strip_tags($_POST['kata_kunci']);
						if (empty($_POST['selections'])) { $kategori=""; }
						else { $pilih=$_POST['selections'];	$jumpil=count($pilih); $kategori=","; for($i=0;$i<$jumpil;$i++) { $kategori=$kategori.$pilih[$i].","; } }
						$tampilkan_judul=strip_tags($_POST['tampilkan_judul']);
						$tampilkan_tanggal=strip_tags($_POST['tampilkan_tanggal']);
						$tampilkan_isi=strip_tags($_POST['tampilkan_isi']);
						$tampilkan_gambar=strip_tags($_POST['tampilkan_gambar']);
						$tampilkan_pembaca=strip_tags($_POST['tampilkan_pembaca']);
						$tampilkan_berbagi=strip_tags($_POST['tampilkan_berbagi']);
						$tampilkan_katakunci=strip_tags($_POST['tampilkan_katakunci']);
						$tampilkan_komentar=strip_tags($_POST['tampilkan_komentar']);
						$tampilkan_formulir=strip_tags($_POST['tampilkan_formulir']);
						if ($_FILES['gambar']['tmp_name']=="") {
							if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
							mysqli_query($koneksi, "INSERT INTO berita (subdomain, judul, link, isi, kata_kunci, kategori, tampilkan_judul, tampilkan_tanggal, 
								tampilkan_isi, tampilkan_gambar, tampilkan_pembaca, tampilkan_berbagi, tampilkan_katakunci, tampilkan_komentar, tampilkan_formulir, tgl) 
							VALUES ('$subdomain', '$judul', '$linkhasil', '$isi', '$kata_kunci', '$kategori', '$tampilkan_judul', '$tampilkan_tanggal', 
								'$tampilkan_isi', '$tampilkan_gambar', '$tampilkan_pembaca', '$tampilkan_berbagi', '$tampilkan_katakunci', '$tampilkan_komentar', '$tampilkan_formulir', sysdate())");
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
								if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
								include($folder.'/function/validasiupload.php');
								$image=new ValidasiUpload($gambar,$judul_baru);
								$image->putGambarType($gambar_type);
								if (!$image->validGambar()){
									$module->notify($subdomain,$linksub,"img_format");
									exit;
								}
								mysqli_query($koneksi, "INSERT INTO berita (subdomain, judul, link, isi, kata_kunci, kategori, tampilkan_judul, 
									tampilkan_tanggal, tampilkan_isi, tampilkan_gambar, tampilkan_pembaca, tampilkan_berbagi, tampilkan_katakunci, tampilkan_komentar, tampilkan_formulir, gambar, tgl) 
								VALUES ('$subdomain', '$judul', '$linkhasil', '$isi', '$kata_kunci', '$kategori', '$tampilkan_judul', 
									'$tampilkan_tanggal', '$tampilkan_isi', '$tampilkan_gambar', '$tampilkan_pembaca', '$tampilkan_berbagi', '$tampilkan_katakunci', '$tampilkan_komentar','$tampilkan_formulir', '$judul_baru', sysdate())");
								copy ($gambar, "$folder/picture/".$judul_baru);
								$uploader->uploadPicture($judul_baru);
								$module->notify($subdomain,$linksub,"save_ok");
							}
						}
					}
				}
			}
			
			if ($paket=="free"){
				if ($jum==12 or $jum==13 or $jum==14){
					echo '<marquee behavior="alternate">Berita Anda Hampir Mendekati Batas Maksimum</marquee>';
				}
				elseif ($jum==15){
					echo '<marquee behavior="alternate">Anda Sudah Tidak Bisa Menambahkan Berita</marquee>';
				}
				if ($jum<15){
					
				}
			}
			else {
				tambah_berita($subdomain,$linksub,$judulmod,$folder);
			}
		}
		
		
		function artikel_ubah ($subdomain,$linksub,$judulmod,$folder) {
			$module=new admin();
			$module->get_variable();
			$module->setLinkSub($linksub);
			$domain=$module->domain;
			$mod=$module->mod;
			$base_folder=$module->base_folder;
			$adm=$module->adm;
			$act=$module->act;
			$no=$module->no;
			$linkmod=$linksub."/".$adm."/".$mod;
			global $uploader;
			if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
			else {
				$no=$no/1;
				$query=mysqli_query($koneksi, "SELECT * FROM berita WHERE no='$no' AND subdomain='$subdomain'");
				$data=mysqli_fetch_array($query);
				$no=$data['no'];
				$publish=$data['publish'];
				if ($no=="") {  $module->notify($subdomain,$linksub,"empty"); }
				else {
					if (empty ($_POST['proses'])) { 
						$judul=$data['judul'];
						$isi=$data['isi'];
						$kata_kunci=$data['kata_kunci'];
						$gambar=$data['gambar'];
						$tampilkan_judul=$data['tampilkan_judul'];
						$tampilkan_tanggal=$data['tampilkan_tanggal'];
						$tampilkan_isi=$data['tampilkan_isi'];
						$tampilkan_gambar=$data['tampilkan_gambar'];
						$tampilkan_pembaca=$data['tampilkan_pembaca'];
						$tampilkan_berbagi=$data['tampilkan_berbagi'];
						$tampilkan_katakunci=$data['tampilkan_katakunci'];
						$tampilkan_komentar=$data['tampilkan_komentar'];
						$tampilkan_formulir=$data['tampilkan_formulir'];
						$publish=$data['publish'];
						$tgl=$data['tgl']; ?>
						<h2>Ubah <?php echo $judulmod;?></h2>
						<form action="" method="post" enctype="multipart/form-data" name="judulform">
						<input name="proses" type="hidden" value="simpan"/>
						<input name="gambarlama" type="hidden" value="<?php echo $gambar;?>"/>
						<input name="no" type="hidden" value="<?php echo $no;?>"/>
						<div style="display:table; width:100%">
						<div style="float:left; width:550px; border-right:1px solid #F0F0F0; line-height:28px;">
							Judul Artikel :<br/><input type="text" name="judul" id="judul" style="width:520px;" maxlength="200" value="<?php echo $judul;?>"/><br/>
							Isi :<br/><textarea name="isi" id="editor" style="width:528px; height:518px;"><?php echo $isi;?></textarea>
							Kata Kunci :<br/><textarea name="kata_kunci" id="kata_kunci" style="width:520px; height:64px;"><?php echo $kata_kunci;?></textarea><br/>
							Gambar :<br/><?php
							if ($gambar=="") { ?><input type="file" name="gambar" id="gambar" style="width:525px; padding:0px;"/><?php	}
							else { ?>
								<img src="<?php echo $module->getHttp();?>://<?php echo $domain;?>/image.php/<?php echo $gambar;?>?width=80&nocache&quality=100&image=/<?php echo $base_folder;?>cms/picture/<?php echo $gambar;?>" width="80" height="60" alt="gambar" align="left" style="margin-right:10px;"/>
								<input type="file" name="gambar" id="gambar" style="width:435px; padding:0px;"/>
								<h5><i>Kosongkon fom ini jika tidak ada perubahan gambar</i></h5>
								<h5><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/hapusgambar/<?php echo $no;?>.html" title="Hapus Gambar" onclick="return confirm ('Yakin Akan Menghapus Gambar Ini ?')">Hapus Gambar</a></h5><?php
							} ?>
						</div>
						<div style="float:left; width:200px; margin-left:20px; line-height:28px;">
							Kategori : <br/>
							<script type="text/javascript">
								function enableselections() {
									var e = document.getElementById('selections');
										e.disabled = false;
									var i = 0;
									var n = e.options.length;
									for (i = 0; i < n; i++) {
										e.options[i].disabled = false;
									}
								}
							</script>			
							<select disabled="disabled" name="selections[]" id="selections" class="inputbox" style="width:190px; height:170px;" multiple="multiple"><?php 
								$qkat=mysqli_query($koneksi, "SELECT no,judul FROM berita_kategori WHERE subdomain='$subdomain' ORDER BY judul ASC");
								while($dkat=mysqli_fetch_array($qkat)){ 
									$nokat=$dkat['no'];
									$qcekart=mysqli_query($koneksi, "SELECT no FROM berita WHERE kategori LIKE '%,$nokat,%' AND no='$no' AND subdomain='$subdomain'");
									$jumcekart=mysqli_num_rows($qcekart);
									if ($jumcekart>=1) { ?><option value="<?php echo $dkat['no'];?>" selected="selected"><?php echo $dkat['judul'];?></option><?php }
									else { ?><option value="<?php echo $dkat['no'];?>"><?php echo $dkat['judul'];?></option><?php }
								} ?>
							</select>
							<script type="text/javascript">enableselections();</script>
							<b>Tampilkan Di Website :</b><br/>
								<select name="publish" style="width:190px;"><?php
								if ($publish==1) { ?><option value="1" selected="selected">Tampilkan</option><option value="0">Sembunyikan</option><?php }
								else { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php } ?>
								</select><br/>
							<b>Tanggal :</b><br/>
								<input type="text" name="tgl" id="tgl" style="width:160px" value="<?php echo $tgl;?>"/>
								<a href="javascript:showCal('tgl')" title="Pilih Tanggal"><img src="<?php echo $module->getHttp();?>://<?php echo $domain;?>/image/tanggal.png" alt="tgl"></a>
								<script type="text/javascript">	addCalendar("tgl", "Select Date", "tgl", "judulform"); setWidth(90, 1, 15, 1); </script>
							Tampilkan Judul :<br/>
							<select name="tampilkan_judul" style="width:190px;"><?php
								if ($tampilkan_judul==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Tanggal :<br/>
							<select name="tampilkan_tanggal" style="width:190px;"><?php
								if ($tampilkan_tanggal==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Isi :<br/>
							<select name="tampilkan_isi" style="width:190px;"><?php
								if ($tampilkan_isi==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Gambar :<br/>
							<select name="tampilkan_gambar" style="width:190px;"><?php
								if ($tampilkan_gambar==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Pembaca :<br/>
							<select name="tampilkan_pembaca" style="width:190px;"><?php
								if ($tampilkan_pembaca==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Berbagi :<br/>
							<select name="tampilkan_berbagi" style="width:190px;"><?php
								if ($tampilkan_berbagi==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Kata Kunci :<br/>
							<select name="tampilkan_katakunci" style="width:190px;"><?php
								if ($tampilkan_katakunci==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Komentar :<br/>
							<select name="tampilkan_komentar" style="width:190px;"><?php
								if ($tampilkan_komentar==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
							Tampilkan Form Komentar :<br/>
							<select name="tampilkan_formulir" style="width:190px;"><?php
								if ($tampilkan_formulir==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
								else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
							</select><br/>
						</div>
						</div>
						<div style="margin-top:10px;">
						<input type="submit" name="submit" value="SIMPAN" onclick="return cekartikel();" class="button"/>&nbsp;&nbsp;
						<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/>
						</div>
						</form><?php
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
							$isi=$_POST['isi'];
							$kata_kunci=strip_tags($_POST['kata_kunci']);
							if (empty($_POST['selections'])) { $kategori=""; }
							else { $pilih=$_POST['selections'];	$jumpil=count($pilih); $kategori=","; for($i=0;$i<$jumpil;$i++) { $kategori=$kategori.$pilih[$i].","; } }
							$tampilkan_judul=strip_tags($_POST['tampilkan_judul']);
							$tampilkan_tanggal=strip_tags($_POST['tampilkan_tanggal']);
							$tampilkan_isi=strip_tags($_POST['tampilkan_isi']);
							$tampilkan_gambar=strip_tags($_POST['tampilkan_gambar']);
							$tampilkan_pembaca=strip_tags($_POST['tampilkan_pembaca']);
							$tampilkan_berbagi=strip_tags($_POST['tampilkan_berbagi']);
							$tampilkan_katakunci=strip_tags($_POST['tampilkan_katakunci']);
							$tampilkan_komentar=strip_tags($_POST['tampilkan_komentar']);
							$tampilkan_formulir=strip_tags($_POST['tampilkan_formulir']);
							$publish=strip_tags($_POST['publish']);
							$tgl=strip_tags($_POST['tgl']);
							if ($_FILES['gambar']['tmp_name']=="") {
								if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
								mysqli_query($koneksi, "UPDATE berita SET 
								judul='$judul', 
								link='$linkhasil',
								isi='$isi',
								kata_kunci='$kata_kunci',
								kategori='$kategori',
								tampilkan_judul='$tampilkan_judul',
								tampilkan_tanggal='$tampilkan_tanggal',
								tampilkan_isi='$tampilkan_isi',
								tampilkan_gambar='$tampilkan_gambar',
								tampilkan_pembaca='$tampilkan_pembaca',
								tampilkan_berbagi='$tampilkan_berbagi',
								tampilkan_katakunci='$tampilkan_katakunci',
								tampilkan_komentar='$tampilkan_komentar',
								tampilkan_formulir='$tampilkan_formulir',
								tgl='$tgl',
								publish='$publish'
								WHERE no='$no' AND subdomain='$subdomain'");
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
									if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
									include ($folder.'/function/validasiupload.php');
									$image=new ValidasiUpload($gambar,$judul_baru);
									$image->putGambarType($gambar_type);
									if (!$image->validGambar()){
										$module->notify($subdomain,$linksub,"img_format");
										exit;
									}
									mysqli_query($koneksi, "UPDATE berita SET 
									judul='$judul', 
									link='$linkhasil',
									isi='$isi',
									kata_kunci='$kata_kunci',
									kategori='$kategori',
									tampilkan_judul='$tampilkan_judul',
									tampilkan_tanggal='$tampilkan_tanggal',
									tampilkan_isi='$tampilkan_isi',
									tampilkan_gambar='$tampilkan_gambar',
									tampilkan_pembaca='$tampilkan_pembaca',
									tampilkan_berbagi='$tampilkan_berbagi',
									tampilkan_katakunci='$tampilkan_katakunci',
									tampilkan_komentar='$tampilkan_komentar',
									tampilkan_formulir='$tampilkan_formulir',
									gambar='$judul_baru',
									tgl='$tgl',
									publish='$publish'
									WHERE no='$no' AND subdomain='$subdomain'");
									copy ($gambar, "$folder/picture/".$judul_baru);
									$uploader->uploadPicture($judul_baru);
									if($_POST['gambarlama']=="" or $_POST['gambarlama']=="a1.jpg"  or $_POST['gambarlama']=="a2.jpg"  or $_POST['gambarlama']=="a3.jpg"  or $_POST['gambarlama']=="a4.jpg"  or $_POST['gambarlama']=="b1.jpg"  or $_POST['gambarlama']=="b2.jpg"  or $_POST['gambarlama']=="b3.jpg"  or $_POST['gambarlama']=="b4.jpg"){ } else { unlink("$folder/picture/".$_POST['gambarlama']); }
									$module->notify($subdomain,$linksub,"save_ok");
								}
							}
						}			
					}
				}
			}
		}
			
			
			
		$judulmod="Berita";
		$tabel="berita";
		$batas=30;
		$kolom="judul";
		$lebar="200";
		$kolomtgl=1;
		$kolomvisit=1;
		$kolomkomen=1;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="multi";
		$tipedetail="";
		$isidetail="judul,tgl,gambar,isi";
		$tipedelete="gambar";
		$jenisinput="gambar";
		$onclick="cekartikel";
		$tipeinput="";
		$forminput="judul,isi,kata_kunci,gambar";
		$formedit="judul,isi,kata_kunci,publish,tgl,gambar";
		$tabelkat="berita_kategori";
		$kolomkat="judul";
		$lebarkat="100";
		$tombolkat="ubah,hapus";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		global $filemanager;
		global $db;

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
		elseif($act=="kategori" or $act=="kattambah" or $act=="katubah" or $act=="katurut" or $act=="katcari"){
			$module->kategori($subdomain,$linksub,$judulmod,$tabelkat,$batas,$act,$kolomkat,$lebarkat,$tombolkat);
		}
		elseif($act=="kathapus"){
			$module->hapus($subdomain,$linksub,$tabelkat,"",$folder);
			$module->kategori($subdomain,$linksub,$judulmod,$tabelkat,$batas,$act,$kolomkat,$lebarkat,$tombolkat);
		}
		elseif($act=="kathapusmulti"){
			$module->hapusmulti($subdomain,$linksub,$tabelkat,"",$folder);
			$module->kategori($subdomain,$linksub,$judulmod,$tabelkat,$batas,$act,$kolomkat,$lebarkat,$tombolkat);
		}
		elseif ($act=="lihat") {
			$module->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail);
		} 
		elseif ($act=="hapus") {
			$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
		} 
		elseif ($act=="tambah") { 
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
		} 
		elseif ($act=="tambahrinci") {
			$qcekjumartikel=mysqli_query($koneksi, "select no from berita where subdomain='$subdomain'");
			$jumartikel=mysqli_num_rows($qcekjumartikel);
			$qcekpaket=mysqli_query($koneksi, "select paket from setting where subdomain='$subdomain'");
			$dpaket=mysqli_fetch_array($qcekpaket);
			$paket=$dpaket['paket'];
			if ($paket=="free") {
				if ($jumartikel>=15) { ?>
				<h3>Tambah Berita Ditolak</h3>
				Maaf, Anda Tidak dapat menambah Berita karena sudah melebihi batas paket Free.<br/>
				Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
				Klik <a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
				<?php
				}
				elseif ($jumartikel>=12) {  ?>
				<div style="background:#FFFFAA; padding:1%; margin-bottom:10px;">
				<h3>Peringatan : Kapasitas Berita Hampir Penuh</h3>
				Jumlah menu halaman website Anda hampir melebihi batas maksimal Paket Free.<br/>
				Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
				Klik <a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
				</div><?php
				artikel_tambah($subdomain,$linksub,$judulmod,$folder);
				}
				else {
				artikel_tambah($subdomain,$linksub,$judulmod,$folder);
				}
				}
				else {			
				artikel_tambah($subdomain,$linksub,$judulmod,$folder);
				}
				foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
		} 
		elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$formedit,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
		} 
		elseif ($act=="ubahrinci") {
			artikel_ubah($subdomain,$linksub,$judulmod,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
		} 
		elseif ($act=="hapusgambar") {
			$no=$module->no;
			if ($no=="") { }
			else {
				$no=$no/1;
				$qcekart=mysqli_query($koneksi, "SELECT gambar FROM artikel WHERE no='$no'");
				$dcekart=mysqli_fetch_array($qcekart);
				if($dcekart['gambar']=="" or $dcekart['gambar']=="s1.jpg" or $dcekart['gambar']=="s2.jpg" or $dcekart['gambar']=="s3.jpg" or $dcekart['gambar']=="s4.jpg" or $dcekart['gambar']=="a1.jpg" or $dcekart['gambar']=="a2.jpg" or $dcekart['gambar']=="a3.jpg" or $dcekart['gambar']=="a4.jpg" or $dcekart['gambar']=="b1.jpg" or $dcekart['gambar']=="b2.jpg" or $dcekart['gambar']=="b3.jpg" or $dcekart['gambar']=="b4.jpg"or $dcekart['gambar']=="ban1.jpg" or $dcekart['gambar']=="str1.jpg" or $dcekart['gambar']=="f1.jpg" or $dcekart['gambar']=="f2.jpg" or $dcekart['gambar']=="f3.jpg" or $dcekart['gambar']=="samb1.jpg") { }
				else {
					unlink("$folder/picture/".$dcekart['gambar']);
					mysqli_query($koneksi, "UPDATE artikel SET gambar='' WHERE no='$no'");
				}
			}
			artikel_ubah($subdomain,$linksub,$judulmod,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->hapus($value);
				}
				
			}
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