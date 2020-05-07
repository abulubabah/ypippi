<?php  
function contact_list($linksub,$subdomain) {
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	$linkcreate="$linksub/$adm/$mod/act/create/konsultasi/ok";
	$linkdetail="$linksub/$adm/$mod/act/detail";
	?> 
	<div style="display:table; width:100%">
		<div style="float:left"><h2>Hubungi Admin</h2></div>
		<div class="button" style="float:right; padding:1px 3px;"><a href="<?php echo $admin->getHttp();?>://<?php echo $linkcreate;?>" title="Kirim Pesan">Kirim Pesan</a></div>
	</div>
	<div class="bar"><?php
	$query=mysqli_query($koneksi, "SELECT no,judul,status,DATE_FORMAT(tgl,'%d-%m-%Y %H:%i:%s') as tanggal FROM contact WHERE iduser='$uname' AND subdomain='$subdomain'  AND status!='closed' ORDER BY tgl DESC");
	$jumlah=mysqli_num_rows($query); 
	if ($jumlah==0) { ?>Anda Tidak Memilik Status Pesan Dengan Admin<br>Mulai <a href="<?php echo $admin->getHttp();?>://<?php echo $linkcreate;?>" title="Kirim Pesan">Kirim Pesan</a> Ke Admin<?php }
	else { ?>
		<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
			<tr height="30" align="left">
				<th width="100" style="text-align:center">Tanggal</th>
				<th >Judul</th>
				<th width="100" style="text-align:center">Status</th>
				<th width="100" style="text-align:center">Aksi</th>
			</tr><?php
		$nomor=1;
		$y=1;
		while($data=mysqli_fetch_array($query)) { 
				$no=$data['no'];
				$tanggal=$data['tanggal'];
				$judul=$data['judul'];
				$status=$data['status'];
				if ($y%2==0) { $latar="#F0F0F0"; } else { $latar="#FFFFFF"; }
				if ($status=="closed") { $latar=$latar; $bold="normal"; $warna="";  } else { 
					if ($status=="answered") { $latar="#FFFFCC"; $bold="bold"; $warna="#CC0000"; }
					else { $latar="$latar"; $bold="normal"; $warna=""; } 
				}?>
				<tr bgcolor="<?php echo $latar; ?>">
					<td style="color:<?php echo $warna;?>; font-weight:<?php echo $bold;?>;"><?php echo $tanggal;?></td>
					<td style="font-weight:<?php echo $bold;?>; color:<?php echo $warna;?>; text-transform:capitalize; text-align:left"><?php echo $judul;?></td>
					<td style="font-weight:<?php echo $bold;?>; color:<?php echo $warna;?>; text-transform:capitalize;"><?php echo $status;?></td>
					<td style="color:<?php echo $warna;?>; font-weight:<?php echo $bold;?>;"><a href="<?php echo $admin->getHttp();?>://<?php echo $linkdetail."/".$no;?>" title="Detail">Detail</a></td>
				</tr><?php
				$nomor++; $y++;
		} ?>
		</table><?php
	} ?>
	</div><?php
	
} 

function contact_create ($linksub,$subdomain) { 
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	$folder=$admin->domain;
	$folderpicture="$folder/picture/";
	?>
	<h2>Kirim Pesan Ke Admin</h2><?php
	if (empty($_POST['process'])) { ?>		
		<div class="bar">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="process" value="save">
				<input type="hidden" name="idmember" readonly value="<?php echo $uname;?>"/>
				<b>Judul :</b><br>
				<input type="text" name="judul" id="judul" required  style="width:96%; margin-bottom:10px;"/><br>
				<b>Isi Pesan :</b><br>
				<textarea name="isi" id="isi" maxlength="500" required style="width:96%; height:80px; margin-bottom:10px;"></textarea><br>
				<input type="submit" name="submit" value="KIRIM" class="button"  style="text-align:right; padding:3px 6px;">
			</form>
		</div><?php
		$randkode=rand(111111,999999); 
		$_SESSION["kode"]=$randkode; 
	}
	elseif ($_POST['process']=="save") {
		if (empty($_SESSION['kode'])) {  ?><h3>Session Habis</h3>Maaf,Session Telah Habis<br/><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a> <?php	}
		else {
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
			$idmember=strip_tags($_POST['idmember']); $idmember=str_replace('"','',$idmember); $idmember=str_replace("'","",$idmember);
			$judul=strip_tags($_POST['judul']); $judul=str_replace('"','',$judul); $judul=str_replace("'","",$judul);			
			$isi=strip_tags($_POST['isi']); $isi=str_replace('"','',$isi); $isi=str_replace("'","",$isi);
			if ($judul=="") { ?><div class="warning"><h3>Judul Masih Kosong</h3>Judul Harus Diisi. Silahkan Ulangi Lagi<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a></div><?php }
			elseif ($isi=="") { ?><div class="warning"><h3>Isi Pesan Masih Kosong</h3>Isi Pesan Harus Diisi. Silahkan Ulangi Lagi<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a></div><?php }
			else {
				if (empty($_FILES['gambar']['tmp_name'])) {
					mysqli_query($koneksi, "INSERT INTO contact (iduser,subdomain, judul, status, tgl) VALUES ('$idmember','$subdomain', '$judul', 'open', sysdate())");
					$qlast=mysqli_query($koneksi, "SELECT no FROM contact WHERE iduser='$uname' ORDER BY tgl DESC");
					$dlast=mysqli_fetch_array($qlast);
					$id_contact=$dlast['no'];
					mysqli_query($koneksi, "INSERT INTO contact_isi (id_contact,subdomain, iduser, isi, tgl) VALUES ('$id_contact','$subdomain', '$idmember', '$isi', sysdate())");?>
					<div class="success"><h3>Pesan Anda Telah Terkirim</h3>Tunggu Informasi Balasan Dari Admin<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a></div><?php
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
					if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){  ?>
						<div class="error"><h3>Format File Tidak Valid</h3>Format File Yang Diijinkan Adalah .JPG, .PNG, .GIF<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a></div><?php
					}
					else {
						//move_uploaded_file ($gambar,"//$folderpicture".$judul_baru);
						mysqli_query($koneksi, "INSERT INTO contact (iduser,subdomain judul, status, tgl) VALUES ('$idmember','$subdomain', '$judul', 'open', sysdate())");
						$qlast=mysqli_query($koneksi, "SELECT no FROM contact WHERE iduser='$uname' and subdomain='$subdomain' ORDER BY tgl DESC");
						$dlast=mysqli_fetch_array($qlast);
						$id_contact=$dlast['no'];
						mysqli_query($koneksi, "INSERT INTO contact_isi (id_contact,subdomain, iduser, isi, gambar, tgl) VALUES ('$id_contact','$subdomain', '$idmember', '$isi', '$judul_baru', sysdate())");?>
						<div class="success"><h3>Pesan Anda Telah Terkirim</h3>Tunggu Informasi Balasan Dari Admin.</div><?php
											
					}
				}
			}
		}
	}
}

function contact_detail($linksub,$subdomain) {
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$picture=$admin->domain;
	$linkpic="$picture/picture";
	$uname=$_SESSION['uname']; 
	if (empty ($_GET['no'])) { ?> <h3>Session Habis</h3>Maaf,Session Telah Habis<br/><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a> <?php }
	else { 
		$id_contact=$_GET['no']/1;
		$qcontact=mysqli_query($koneksi, "SELECT judul FROM contact WHERE no='$id_contact'");
		$dcontact=mysqli_fetch_array($qcontact);
		$judul=$dcontact['judul']; ?>
		<h2>Detail Pesan : <?php echo $judul;?></h2><?php
		$nomor=1;
		$y=1;
		$query=mysqli_query($koneksi, "SELECT no,isi,iduser,gambar,DATE_FORMAT(tgl,'%d-%m-%Y | %H:%i:%s') as tanggal FROM contact_isi WHERE id_contact='$id_contact' ORDER BY tgl ASC");
		while($data=mysqli_fetch_array($query)) { 
			$no=$data['no'];
			$tanggal=$data['tanggal'];
			$isi=$data['isi'];
			$iduser=$data['iduser'];
			$gambar=$data['gambar'];
			$qmem=mysqli_query($koneksi, "SELECT nama FROM user WHERE email='$iduser'");
			$dmem=mysqli_fetch_array($qmem);	
			if ($iduser=="mysuper") { $namamem="Admin Mysch"; } else { $namamem=$dmem['nama']." [".$iduser."]"; }
			if ($gambar=="") { $linkgambar=""; } else { $linkgambar="<a href=\"http:$linkpic/$gambar\" target=\"_blank\">Download Picture</a>"; }
			if ($iduser=="mysuper") { $latar="#88EEFF"; } else { $latar="#EAEAEA";} ?>
			<div style="background:<?php echo $latar;?>;padding:1%; margin-bottom:5px;display:table; width:98%;">
				<b><?php echo $namamem;?> :</b><br>
				<div style="margin:6px 0px;"><?php $kalimat=nl2br($isi); echo ($kalimat); echo ("  "); ?></div>
				<span style="float:left; color:#888888"><h6><?php //echo $linkgambar;?></h6></span>
				<span style="float:right; color:#888888"><h6>Tanggal : <?php echo $tanggal;?></i></span>
			</div><?php
			$nomor++; $y++;
		} ?>
		<div class="bar">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="process" value="reply">
				<input type="hidden" name="id_contact" value="<?php echo $id_contact;?>"/>
				<input type="hidden" name="idmember" value="<?php echo $uname;?>"/>
				<b>Balas Pesan Ke Admin :</b><br>
				<textarea name="isi" id="isi" required maxlength="500" style="width:96%; height:80px;margin-bottom:10px;"></textarea><br>
				<input type="submit" name="submit" value="KIRIM" class="button"  style="text-align:right; padding:1px 5px;">
			</form>
			<form action="" method="post" style="float:right; margin-top:-20px;">
				<input type="hidden" name="process" value="closed">
				<input type="hidden" name="id_contact" readonly value="<?php echo $id_contact;?>"/>
				<input type="submit" name="submit" value="Tutup" class="button" onclick="return confirm ('Anda Yakin Menutup Topik Ini ?');" style="text-align:right; padding:1px 5px;background:#FF5555;border:1px solid #CC5555;">
			</form>
		</div><?php
		$randkode=rand(111111,999999); 
		$_SESSION["kode"]=$randkode; 
	}
}

function contact_reply ($linksub,$subdomain) { 
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	$folder=$admin->domain;
	$folderpicture="$folder/picture/";
	if (empty($_POST['process'])) {  ?><h3>URL Salah</h3>Maaf,URL Salah<br/><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a> <?php }
	elseif ($_POST['process']=="reply") {
		if (empty($_SESSION['kode'])) {?>  <h3>Session Habis</h3>Maaf,Session Telah Habis<br/><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a> <?php	}
		else {
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); 
			$qlast=mysqli_query($koneksi, "SELECT no FROM contact WHERE iduser='$uname' and subdomain='$subdomain' ORDER BY tgl DESC");
			$dlast=mysqli_fetch_array($qlast);
			$id_contact=$dlast['no'];
			$idmember=$_SESSION['uname'];
			$isi=strip_tags($_POST['isi']); $isi=str_replace('"','',$isi); $isi=str_replace("'","",$isi);
			if ($isi=="" or $isi=="Tulis Komentar...") { ?><div class="warning"><h3>Isi Masih Kosong</h3>Silahkan Ulagi Lagi<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a> </div><?php }
			else {
				if (empty($_FILES['gambar']['tmp_name'])) {
					mysqli_query($koneksi, "INSERT INTO contact_isi (id_contact,subdomain, iduser, isi, tgl) VALUES ('$id_contact','$subdomain','$idmember', '$isi', sysdate())");
					mysqli_query($koneksi, "UPDATE contact SET status='reply', tgl=sysdate() WHERE no='$id_contact'"); ?>
					<div class="success"><h3>Pesan Anda Telah Terkirim</h3>Tunggu Informasi / Balasan Dari Admin<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a> </div><?php
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
					if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){  ?>
						<div class="error"><h3>Format File Not Valid</h3>Format File Yang Diijinkan Adalah .JPG, .PNG, .GIF<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">Kembali</a></div><?php
					}
					else {
						//move_uploaded_file ($gambar,"//$folderpicture".$judul_baru);
						mysqli_query($koneksi, "INSERT INTO contact_isi (id_contact,subdomain, iduser, isi, gambar, tgl) VALUES ('$id_contact','$subdomain', '$idmember', '$isi', '$judul_baru', sysdate())");
						mysqli_query($koneksi, "UPDATE contact SET status='reply', tgl=sysdate() WHERE no='$id_contact'"); ?>
						<div class="success"><h3>Pesan Anda Telah Terkirim</h3>Tunggu Informasi / Balasan Dari Admin<br>
						<a href="" onclick="document.location;history.go(-1);" title="Kembali">&laquo; Kembali</a></div><?php
						/*
						$ftp_conn = ftp_connect("ftp.puspitaradja.org") or die("FTP ERROR");
						$login = ftp_login($ftp_conn, "picture@puspitaradja.org", "gunungtugel1972");
						ftp_put($ftp_conn, $judul_baru, $gambar, FTP_BINARY);
						ftp_close($ftp_conn);
						*/
						}
					}
				}
			}
		}
	}
}


function contact_closed ($linksub,$subdomain) { 
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	if (empty($_POST['process'])) {  ?><div class="warning"><h3>Maaf, URL Salah</h3>Silahkan Ulangi Lagi</div><?php }
	elseif ($_POST['process']=="closed") {
		if (empty($_SESSION['kode'])) {  $member->notify("empty_session");	}
		else {
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); 
			$id_contact=strip_tags($_POST['id_contact']);
			mysqli_query($koneksi, "UPDATE contact SET status='closed', tgl=sysdate() WHERE no='$id_contact'"); ?>
			<div class="success"><h3>Pesan Ke Admin Telah Ditutup</h3>Terima Kasih Atas Partisipasi Anda</div><?php	
			}			
		}
	}
}

function contact_superlist ($linksub,$subdomain,$act) { 
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	$linkcreate="$linksub/$adm/$mod/act/create/konsultasi/ok";
	$linkdetail="$linksub/$adm/$mod/act/detail"; ?>
	<h2 style="text-transform:capitalize;">Data Pesan Kategori <?php echo $act;?></h2>
	<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
		<tr height="30" align="left">
			<th width="90">Tanggal</th>
			<th width="180" style="text-align:left">ID Member</th>
			<th style="text-align:left">Isi</th><?php
			if ($act=="answered") { ?><th width="80" width="90">Waktu</th><?php } else { } ?>
			<th width="80" width="90">Aksi</th>
		</tr><?php
	$nomor=1;
	$y=1;
	$totbantuan=0;
	$query=mysqli_query($koneksi, "SELECT no,tgl,iduser,DATE_FORMAT(tgl,'%d-%m-%Y %H:%i:%s') as tanggal FROM contact WHERE status='$act' AND iduser!='super' ORDER BY tgl DESC");
	while($data=mysqli_fetch_array($query)) { 
			$no=$data['no'];
			$tanggal=$data['tanggal'];
			$tgl_contact=$data['tgl'];
			$iduser=$data['iduser'];
			$qmem=mysqli_query($koneksi, "SELECT nama,subdomain FROM user WHERE email='$iduser'");
			$dmem=mysqli_fetch_array($qmem);
			$namamember=$dmem['nama']; $subdomainmem=$dmem['subdomain'];
			$qcontactisi=mysqli_query($koneksi, "SELECT isi FROM contact_isi WHERE id_contact='$no' ORDER BY tgl ASC");
			$dcontactisi=mysqli_fetch_array($qcontactisi);
			$isi=$dcontactisi['isi'];
			if ($y%2==0) { $latar="#F0F0F0"; } else { $latar="#FFFFFF"; } ?>
			<tr bgcolor="<?php echo $latar; ?>">
				<td><?php echo $tanggal;?></td>
				<td style="text-align:left"><?php echo $namamember."<br>".$iduser." - ".$subdomainmem;?></td>
				<td style="text-align:left"><?php echo $isi;?></td><?php
				if ($act=="answered") { 
					$thnini=date('Y');
					$blnini=date('m');
					$tglini=date('d');
					$jamini=date('H'); 
					$tglini=date('d');
					$mntini=date('i'); 
					$dtkini=date('s'); 
					$waktuini=mktime($jamini, $mntini, $dtkini, $blnini, $tglini, $thnini);
					$jamskrg=date("Y-m-d H:i:s", $waktuini);
					$waktuskrg=strtotime($jamskrg);
					$waktu_contact=strtotime($tgl_contact);
					$selisih_waktu=($waktuskrg-$waktu_contact)/3600;
					$selisih_jam=floor($selisih_waktu);
					$sisajam=72-$selisih_jam;?>
					<td><?php echo $sisajam;?> Jam</td><?php 
				} 				
				else { } ?>
				<td><a href="<?php echo $admin->getHttp();?>://<?php echo $linkdetail."/".$no;?>/">Detail</a></td>
			</tr><?php
			$nomor++; $y++;
	} ?>
	</table><?php  
}

function contact_superdetail($linksub,$subdomain,$act) {
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	if (empty ($_GET['no'])) { $admin->notify("empty"); }
	else { 
		$id_contact=$_GET['no']/1;
		$qcontact=mysqli_query($koneksi, "SELECT judul,subdomain FROM contact WHERE no='$id_contact'");
		$dcontact=mysqli_fetch_array($qcontact);
		$judul=$dcontact['judul'];
		$subdomaincontack=$dcontact['subdomain'];
		?>
		<h2>Detail Pesan : <?php echo $judul;?></h2><?php		
		$nomor=1;
		$y=1;
		$query=mysqli_query($koneksi, "SELECT no,isi,iduser,gambar,DATE_FORMAT(tgl,'%d-%m-%Y %H:%i:%s') as tanggal FROM contact_isi WHERE id_contact='$id_contact' ORDER BY tgl ASC");
		while($data=mysqli_fetch_array($query)) { 
			$no=$data['no'];
			$tanggal=$data['tanggal'];
			$isi=$data['isi'];
			$iduser=$data['iduser'];
			$gambar=$data['gambar'];
			$qmem=mysqli_query($koneksi, "SELECT nama,subdomain FROM user WHERE email='$iduser'");
			$dmem=mysqli_fetch_array($qmem);	
			if ($iduser=="mysuper") { $namamem="Admin Mysch"; } else { $namamem=$dmem['nama']." [".$iduser."] "." - ".$dmem['subdomain']; }
			if ($gambar=="") { $linkgambar=""; } else { $linkgambar="Download Picture"; }
			if ($iduser=="mysuper") { $latar="#88EEFF"; } else { $latar="#EAEAEA";} ?>
			<div style="padding:0.7%; width:98.4%; background:<?php echo $latar;?>; display:table; margin:5px 0px;">
				<b><?php echo $namamem;?> :</b><br>
				<div style="margin:6px 0px;"><?php $kalimat=nl2br($isi); echo ($kalimat); echo ("  "); ?></div>
				<span style="float:left; color:#888888"><h6><?php echo $linkgambar;?></h6></span>
				<span style="float:right; color:#888888"><h6>Ditulis Tanggal : <?php echo $tanggal;?></h6></span>
			</div><?php
			$nomor++; $y++;
		} ?>
		<div class="divlist" style="padding:0.7%; width:98.4%;">
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="process" value="answer">
			<input type="hidden" name="id_contact" readonly value="<?php echo $id_contact;?>"/>
			<b>Balas :</b><br>
			<textarea name="isi" id="isi" required maxlength="500" style="width:99%; height:80px; margin-bottom:10px;" placeholder="Tulis Jawaban......"></textarea><br>
			<b>Gambar :</b><br>
			<input type="file" name="gambar" id="gambar" style="width:99%;padding:0px;"/>
			<h6 style="margin-bottom:10px;">Format File Yang Diijinkan a .JPG, .PNG, .GIF</h6>
			<input type="submit" name="submit" value="KIRIM" class="button" style="text-align:right; padding:1px 5px;">
		</form>
		<form action="" method="post" style="float:right;">
				<input type="hidden" name="process" value="closed">
				<input type="hidden" name="id_contact" value="<?php echo $id_contact;?>"/>
				<input type="hidden" name="subdomain_contack" value="<?php echo $subdomaincontack;?>">
				<input type="submit" name="submit" value="TUTUP PESAN" class="button2" onclick="return confirm ('Apakah Anda Yakin Akan Menutup Pesan Ini?')" style="text-align:right; padding:1px 5px;cursor:pointer; background:#FF8888">
			</form>
		</div><?php
		$randkode=rand(111111,999999); 
		$_SESSION["kode"]=$randkode; 
	}
}


function contact_answer($linksub,$subdomain,$act) { 
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	$folder=$admin->domain;
	$folderpicture="$folder/picture/";
	if (empty($_POST['process'])) {  ?><div class="warning"><h3>URL Salah</h3>Silahkan Ulangi Lagi<br></div><?php }
	elseif ($_POST['process']=="answer") {
		if (empty($_SESSION['kode'])) {  $admin->notify($subdomain,$linksub,"empty_session");	}
		else {
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
			$id_contact=strip_tags($_POST['id_contact']); 
			$isi=strip_tags($_POST['isi']); $isi=str_replace('"','',$isi); $isi=str_replace("'","",$isi);
			$qcekiduser=mysqli_query($koneksi, "select iduser,subdomain from contact_isi where id_contact='$id_contact'");
			$diduser=mysqli_fetch_array($qcekiduser);
			$iduser=$diduser['iduser'];
			$subdomain_contack=$diduser['subdomain'];
			if ($isi=="" or $isi=="Tulis Jawaban...") { ?><div class="warning"><h3>Komentar Masih Kosong</h3>Silahkan Isi Jawaban Anda<br><a href="<?php echo $admin->getHttp();?>://<?php echo $linkmod."/act/detail/".$id_contact."/admin/";?>" title="Kembali">&laquo; Kembali</a></div><?php }
			else {
				if (empty($_FILES['gambar']['tmp_name'])) {
					mysqli_query($koneksi, "INSERT INTO contact_isi (id_contact,subdomain,iduser, isi, tgl) VALUES ('$id_contact','$subdomain_contack', 'mysuper', '$isi', sysdate())");
					mysqli_query($koneksi, "UPDATE contact SET status='answered', tgl=sysdate() WHERE no='$id_contact'"); ?>
					<div class="success"><h3>Jawaban Pesan Anda Telah Terkirim</h3>Terima Kasih Sudah Menjawab Pesan  Partisipan.<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">&laquo; Kembali</a></div><?php
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
					if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){  ?>
						<div class="error"><h3>Maaf, Format File Tidak Valid</h3>Format File Yang Diijinkan .JPG, .PNG, .GIF</div><?php
					}
					elseif ($gambar_dimensi['0']>"2000" or $gambar_dimensi['1']>"2000") { ?>
						<div class="error"><h3>Maaf, Resolusi Terlalu Besar</h3>Maximum  2000 X 2000 pixels</div><?php
					} 
					else {
						//move_uploaded_file ($gambar,"//$folderpicture".$judul_baru);
						mysqli_query($koneksi, "INSERT INTO contact_isi (id_contact,subdomain, iduser, isi, tgl) VALUES ('$id_contact','$subdomain_contack', 'mysuper', '$isi', sysdate())");
						mysqli_query($koneksi, "UPDATE contact SET status='answered', tgl=sysdate() WHERE no='$id_contact'"); ?>
						<div class="success"><h3>Jawaban Pesan Anda Telah Terkirim</h3>Terima Kasih Sudah Menjawab Pesan  Partisipan.<br><a href="" onclick="document.location;history.go(-1);" title="Kembali">&laquo; Kembali</a></div><?php
					}				
				}
			}
		}
	}
}

function contact_superclosed($linksub,$subdomain,$act) { 
	$admin=new admin ();
	$admin->get_variable();
	$admin->setLinkSub($linksub);
	$adm=$admin->adm;
	$mod=$admin->mod;
	$uname=$_SESSION['uname'];
	$folder=$admin->domain;
	if (empty($_POST['process'])) {  ?><div class="warning"><h3>URL Salah</h3>Silahkan Ulangi Lagi<br></div><?php }
	elseif ($_POST['process']=="closed") {
		if (empty($_SESSION['kode'])) {  $admin->notify("empty_session");	}
		else {
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
			$id_contact=strip_tags($_POST['id_contact']);
			mysqli_query($koneksi, "UPDATE contact SET status='closed', tgl=sysdate() WHERE no='$id_contact'"); ?>
			<div class="success"><h3>Pesan Telah Ditutup</h3>Terima Kasih Sudah Menjawab Pesan Partisipan.</div><?php
		}
	}
}


if ($tampil==1) {  
	if (empty($akses)) { 
		header("location:index.php"); 
	}
	elseif($akses=="admin"  && $_SESSION['kat']=="admin"){
		if ($act=="") {				
				contact_list($linksub,$subdomain);
			}
			elseif ($act=="detail") {
				if (empty($_POST['process'])) {
					contact_detail($linksub,$subdomain);	
				}
				elseif ($_POST['process']=="reply") {
					contact_reply($linksub,$subdomain);	
				}
				elseif ($_POST['process']=="closed") {
					contact_closed($linksub,$subdomain);	
				}
			}
			elseif ($act=="create") {
				contact_create($linksub,$subdomain);
			}
			else {
				contact_list($linksub,$subdomain);
			}		
		
	}
	else if ($akses=="admin"  && $_SESSION['kat']=="super"){
		if (empty ($act)) {
			$act="open";
				contact_superlist($linksub,$subdomain,$act);
			} 
			elseif ($act=="open" or $act=="closed" or $act=="reply" or $act=="answered") {
				contact_superlist($linksub,$subdomain,$act);
			} 
			elseif ($act=="detail") {
				if (empty($_POST['process'])) {
					contact_superdetail($linksub,$subdomain,$act);
				}
				elseif ($_POST['process']=="answer") {
					contact_answer($linksub,$subdomain,$act);
				}
				elseif ($_POST['process']=="closed") {
					contact_superclosed($linksub,$subdomain,$act);
				}				
			} 
			else {
$act="open";
				contact_superlist($linksub,$subdomain,$act);
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