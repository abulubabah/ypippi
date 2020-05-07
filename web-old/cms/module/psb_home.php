<?php   
if ($tampil==1) {
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik"){ ?>
		<style type="text/css">
			.tiga{ float:left; width:32%; margin-right:1%; margin-top:1%; margin-bottom:1%; display:table; text-align:center; }
			@media only screen and (max-width:800px) {
				.tiga { width:48%; margin-right:1%; }
			}
			@media only screen and (max-width:480px) {
				.tiga { width:100%; margin-right:0%; margin-top:10px; margin-bottom:10px;  }
			}
		</style>
		<div style="display:table; width:100%;">
			<div class="tiga">
				<img src="//<?php echo $domain;?>/image/alur.png" style="margin:10px 0px;" alt="alur"/><br/><h3>Alur Pendaftaran</h3>
				Informasi mengenai alur pendaftaran sistem PPDB online silahkan pelajari terlebih dahulu. <br/>
				<a style="background:#444444; color:#FFFFFF; padding:6px 8px; cursor:pointer;" href="//<?php echo $linksub;?>/alur/" title="Alur Pendaftaran">Selengkapnya</a>
			</div>
			<div class="tiga">
				<img src="//<?php echo $domain;?>/image/syarat.png" style="margin:10px 0px;" alt="syarat"/><br/><h3>Syarat Pendaftaran</h3>
				Berikut ini adalah syarat dan ketentuan yang harus dipenuhi oleh calon pendaftar. <br/>
				<a style="background:#444444; color:#FFFFFF; padding:6px 8px; cursor:pointer;" href="//<?php echo $linksub;?>/syarat/" title="Syarat Pendaftaran">Selengkapnya</a>
			</div>
			<div class="tiga">
				<img src="//<?php echo $domain;?>/image/panduan.png" style="margin:10px 0px;" alt="panduan"/><br/><h3>Panduan Pendaftaran</h3>
				Untuk mendapat informasi yang lebih lengkap panduan penggunaan PPDB Online.<br/>
				<a style="background:#444444; color:#FFFFFF; padding:6px 8px; cursor:pointer;" href="//<?php echo $linksub;?>/panduan/" title="Panduan Pendaftaran">Selengkapnya</a>
			</div>
		</div>
		<br/><?php
		$qjad=mysqli_query($koneksi, "SELECT tanggal,tempat,deskripsi FROM psb_jadwal WHERE subdomain='$subdomain' AND  publish='1' ORDER BY urutan ASC");
		$jjad=mysqli_num_rows($qjad);
		if ($jjad==0) { } 
		else { ?>
			<h3>RANGKAIAN KEGIATAN</h3>
			<table width="100%" cellspacing="0" cellpadding="0" id="tabellist">
				<tr>
					<th width="30">No</th>
					<th width="120">Tanggal</th>
					<th width="150">Tempat</th>
					<th>Deskripsi</th>
				</tr><?php
				$nomor=1;
				
				while($djad=mysqli_fetch_array($qjad)) {
					$tanggal=$djad['tanggal'];
					$tempat=$djad['tempat'];
					$deskripsi=$djad['deskripsi']; ?>
					<tr >
						<td><?php echo $nomor;?></td>
						<td style="text-align:left;"><?php echo $tanggal;?></td>
						<td style="text-align:left;"><?php echo $tempat;?></td>
						<td style="text-align:left;"><?php echo $deskripsi;?></td>
					</tr><?php
					$nomor++;
				} ?>
			</table><?php
		}
	}
	elseif($akses=="member"){ ?>
		<h2>Selamat Datang, <?php echo $_SESSION['nama'];?></h2>
		Silahkan gunakan layanan yang tersedia pada area ini dengan meng-klik tombol menu pada samping kiri dan atas.<br/>
		Jangan lupa untuk selalu <b>Logout</b> setelah Anda selesai menggunakan area ini.<?php
	}
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>