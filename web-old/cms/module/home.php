<?php
if ($tampil==1) {
	if ($akses=="publik") { 
	}
	elseif ($akses=="member") { ?>
		<h2 style="text-transform:capitalize">Selamat Datang <?php echo $_SESSION['nama'];?></h2>
		Silahkan gunakan layanan yang ada pada area ini dengan meng-klik tombol menu pada bagian samping kanan halaman.<br/>
		Biasakan untuk secara rutin <b>Mengganti Password</b> Anda setiap 1-2 bulan.<br/>
		Jangan lupa untuk selalu <b>Logout</b> setelah Anda selesai menggunakan fasilitas ini.<br/>
		<h4>Website Replika</h4>
		<div style="background:#FFFCCC;padding:10px;">Link Website Replika Anda : //mysch.id/id/<?php echo $_SESSION['uname'];?></div><?php
	}
	elseif ($akses=="admin" or $akses=="super") {
		//hapus cache 
		global $filemanager;
		//print_r($filemanager->listData(DIR_CACHE.$subdomain.'/'));
		foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
			$filemanager->hapus($value);
		}
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);		?>
		<h2 style="text-transform:capitalize">Selamat Datang, <?php echo $_SESSION['nama'];?></h2>
		
		Silahkan gunakan layanan yang ada pada area ini dengan meng-klik tombol menu pada bagian atas halaman ini.<br/>
		Biasakan untuk secara rutin <b>Mengganti Password</b> Anda setiap 1-2 bulan.<br/>
		Jangan lupa untuk selalu <b>Logout</b> setelah Anda selesai menggunakan fasilitas ini.<br/><br/>
		<h3>Buku Panduan</h3>
		Klik <a href="https://drive.google.com/open?id=0B9AbsZr2SwYtaUJnUEJEQm1xcG8" title="Download Buku Panduan" target="_blank">DISINI</a> Untuk Mendapatkan Buku Panduan
		<br/><br/>
		<h3>Tanya Jawab</h3>
		Masih Kesulitan ? Klik <a href="<?php echo $linkticket;?>" title="konsultasi" target="_blank">DISINI</a> Untuk Kirim Pertanyaan Ke Admin<br/><br/>
		<?php
		$qcekpaket=mysqli_query($koneksi, "select paket,aktif from setting where subdomain='$subdomain'");
		$dpaket=mysqli_fetch_array($qcekpaket);
		$paket=$dpaket['paket'];
		if ($paket=="basic"){
			$harga=600000;
		}
		elseif ($paket=="profesional"){
			$harga=1000000;
		}
		$aktif=$dpaket['aktif'];
		if ($paket=="free"){  ?>
		<h3>Upgrade Paket Basic & Profesional!</h3>
		Mau Website Sekolah Dengan Domain Resmi SCH.ID.?<br/><!--
		Dapat DISKON 25% <br/>
		Dapat GRATIS Sistem PPDB Online<br/>
		Dapat GRATIS SIMPEN<br/>
		Dapat GRATIS Puluhan Tema Baru<br/>
		DAPAT GRATIS Aplikasi Android (Website dalam bentuk aplikasi android) bisa download dan pasang di smartphone kamu<br/>-->
		
		Klik <b><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a></b> untuk melakukan Upgrade Sekarang Juga.<?php 
		}
		elseif ($paket!="free" and $aktif==0){ ?>
			<?php if (empty($_POST['proses'])){?>
			Sahabat Mysch Yang Kami Hormati,<br/>
Saat ini kami belum menerima pembayaran atas pesanan website Anda<br/>
			Silahkan lakukan pembayaran sebesar Rp.<?php echo number_format($harga).",- ";?><br>
			Pembayaran dapat dilakukan melalui ATM Transfer, Internet Banking, SMS Banking, Setoran Tunai ke Rekening dibawah ini :<br/><b>
			- BANK MANDIRI No. Rek. 1360010201660 A.N. Tri Astuti<br/>
			- BANK BCA No. Rek. 8030112343 A.N. Tri Astuti<br/>
			- BANK BRI No. Rek. 144701001148505 A.N. Tri Astuti</b><br/>
			Setelah melakukan Pembayaran, Segera lakukan Konfirmasi pada halaman <a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm;?>/konfirmasi/" title="Konfirmasi">KONFIRMASI</a>
			<br><!--
			Atau Jika Anda Akan Membatalkan Pesanan Anda Bisa Klik Tombol Dibawah Ini Untuk Downgrade Ke Paket Free<br/>
			<form method="post">
			<input type="hidden" value="simpan" name="proses">
			<input type="submit" value="Downgrade" class="tombol_simpan">
			</form>
-->
			<?php
			
			}
			else if ($_POST['proses']=="simpan"){
				
				mysqli_query($koneksi, "UPDATE setting SET paket='free' WHERE subdomain='$subdomain'");
				?>
				<h3>Paket Berhasil Di Ubah Ke Free</h3>
				<?php
			}
		} else if($paket=='basic'){ ?>
		    <h3>UPGRADE!!</h3>
    		Upgrade website sekolah Anda ke paket profesional sekarang untuk menikmati fitur yang lebih lengkap. <br/>
    		<!--Dapat DISKON 25% <br/>-->
    		Dapat GRATIS Sistem PPDB Online<br/>
    		Dapat GRATIS SIMPEN<br/>
    		Dapat GRATIS Puluhan Tema Baru<br/>
    		Klik <b><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a></b><?php
		    
		}
	}
	else { 
		header("location:../"); 
	}
}
else {
	header("location:../"); 
}
?>