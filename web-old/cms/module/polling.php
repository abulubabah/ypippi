<?php  
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){
		if ($layoutposisi=="main") { 
			function polling_form ($subdomain,$linksub,$haljudul) { 
				$publik=new publik ();
				$publik->get_variable(); 
				$no=$publik->no;
				$link=$publik->link;?>
				<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2><?php
				$query=mysqli_query($koneksi, "SELECT no,judul,link,jawaban_1,jawaban_2,jawaban_3,jawaban_4,jawaban_5 
					FROM polling WHERE subdomain='$subdomain' AND publish='1'");
				$jumlah=mysqli_num_rows($query);
				if ($jumlah==0) { }
				else {
					$data=mysqli_fetch_array($query);
					$nopol=$data['no'];
					$judul=$data['judul'];
					$linkhal=$data['link'];
					$jawaban_1=$data['jawaban_1'];
					$jawaban_2=$data['jawaban_2'];
					$jawaban_3=$data['jawaban_3'];
					$jawaban_4=$data['jawaban_4'];
					$jawaban_5=$data['jawaban_5']; ?>
					<h3><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h3>
					<form action="//<?php echo $linksub."/".$link;?>/kirim/" method="post">
						<input name="idpolling" type="hidden" value="<?php echo $nopol;?>">
						<input name="idhasil" type="radio" value="1" checked>&nbsp; <?php echo $jawaban_1;?><br>
						<input name="idhasil" type="radio" value="2">&nbsp; <?php echo $jawaban_2;?><br>
						<input name="idhasil" type="radio" value="3">&nbsp; <?php echo $jawaban_3;?><br>
						<input name="idhasil" type="radio" value="4">&nbsp; <?php echo $jawaban_4;?><br>
						<input name="idhasil" type="radio" value="5">&nbsp; <?php echo $jawaban_5; ?><br>
						<input name="pilih" type="submit" value="PILIH" class="button">
						&nbsp;&nbsp;<b><a href="//<?php echo $linksub."/".$link;?>/lihat/" title="<?php echo $judul;?>">Hasil Polling</a></b>
					</form><?php
				}
			}
					

			function polling_lihat ($subdomain,$linksub,$haljudul) { 
				$publik=new publik ();
				$publik->get_variable();
				$no=$publik->no;
				$link=$publik->link; 
				$query=mysqli_query($koneksi, "SELECT no,judul,link,jawaban_1,jawaban_2,jawaban_3,jawaban_4,jawaban_5,hasil_1,hasil_2,hasil_3,hasil_4,hasil_5    
					FROM polling WHERE subdomain='$subdomain' AND publish='1'");
				$data=mysqli_fetch_array($query); 
				$judul=$data['judul'];
				$linkhal=$data['link'];
				$jawaban_1=$data['jawaban_1']; $hasil_1=$data['hasil_1'];
				$jawaban_2=$data['jawaban_2']; $hasil_2=$data['hasil_2'];
				$jawaban_3=$data['jawaban_3']; $hasil_3=$data['hasil_3'];
				$jawaban_4=$data['jawaban_4']; $hasil_4=$data['hasil_4'];
				$jawaban_5=$data['jawaban_5'];	$hasil_5=$data['hasil_5'];		
				$total=$hasil_1+$hasil_2+$hasil_3+$hasil_4+$hasil_5;
				$panjangasli=100; ?>
				<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2>
				<h3><?php echo $judul;?></h3>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td align="left" width="30%"><?php echo $jawaban_1;?></td><td width="62%"><?php if ($hasil_1==0) { $nilaipersen=0; } else { $nilaipersen=$hasil_1/$total*100; } $persen="%";?><div style="width:<?php echo $nilaipersen;?>%; display:table; height:25px; background:#000000;">&nbsp;</div></td><td width="8%" style="text-align:right"><?php echo $hasil_1;?></td></tr>
					<tr><td align="left"><?php echo $jawaban_2;?></td><td><?php if ($hasil_2==0) { $nilaipersen=0; } else { $nilaipersen=$hasil_2/$total*100; } $persen="%"; ?><div style="width:<?php echo $nilaipersen;?>%; display:table;height:25px; background:#FFCC00;">&nbsp;</div></td><td style="text-align:right"><?php echo $hasil_2;?></td></tr>
					<tr><td align="left"><?php echo $jawaban_3;?></td><td><?php if ($hasil_3==0) { $nilaipersen=0; } else { $nilaipersen=$hasil_3/$total*100; } $persen="%";?><div style="width:<?php echo $nilaipersen;?>%;  display:table;height:25px; background:#00AA00;">&nbsp;</div></td><td style="text-align:right"><?php echo $hasil_3;?></td></tr>
					<tr><td align="left"><?php echo $jawaban_4;?></td><td><?php if ($hasil_4==0) { $nilaipersen=0; } else { $nilaipersen=$hasil_4/$total*100; } $persen="%";?><div style="width:<?php echo $nilaipersen;?>%;  display:table; height:25px; background:#0000FF;">&nbsp;</div></td><td style="text-align:right"><?php echo $hasil_4;?></td></tr>
					<tr><td align="left"><?php echo $jawaban_5;?></td><td><?php if ($hasil_5==0) { $nilaipersen=0; } else { $nilaipersen=$hasil_5/$total*100; } $persen="%";?><div style="width:<?php echo $nilaipersen;?>%;  display:table; height:25px; background:#FF0000;">&nbsp;</div></td><td style="text-align:right"><?php echo $hasil_5;?></td></tr>
					<tr><td style="font-weight:bold;"><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $judul;?>">Ikuti Polling</a></td><td style="text-align:right; font-weight:bold;">Total Pemilih</td><td style="text-align:right;font-weight:bold;"><?php echo $total;?></td></tr>
				</table><?php
			}

					
					
			function polling_send($subdomain,$linksub,$haljudul) { 
				$publik=new publik ();
				$publik->get_variable();
				$no=$publik->no;
				$link=$publik->link; 
				$query=mysqli_query($koneksi, "SELECT no,judul,link,jawaban_1,jawaban_2,jawaban_3,jawaban_4,jawaban_5,hasil_1,hasil_2,hasil_3,hasil_4,hasil_5 
					FROM polling WHERE subdomain='$subdomain' AND publish='1'");
				$data=mysqli_fetch_array($query);
				$nopol=$data['no'];
				$judulpol=$data['judul'];
				$linkhal=$data['link']; ?>
				<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2>
				<h3><?php echo $judulpol;?></h3><?php
				if (empty ($_SESSION['polling'])) {
					$hasil="hasil_";
					$hasilid=$hasil.$_POST['idhasil'];
					$hasillama=$data[$hasilid];
					$hasilbaru=$hasillama+1;
					mysqli_query($koneksi, "UPDATE polling SET $hasilid='$hasilbaru' WHERE subdomain='$subdomain' ");
					$_SESSION['polling']="polling"; ?>
					<h4>Terima Kasih Atas Partisipasi Anda</h4><a href="//<?php echo $linksub."/".$link;?>/" title="Kembali">Kembali</a><?php
				}
				else { ?>
					<h4>Maaf, Anda Sudah Mengikuti Polling Sebelumnya</h4><a href="//<?php echo $linksub."/".$link;?>/" title="Kembali">Kembali</a><?php
				} 
			}
			
			if ($link=="") { $haljudul="polling"; }
			if (empty($kategori)) {
				polling_form($subdomain,$linksub,$haljudul);	
			}
			elseif ($kategori=="kirim") {
				polling_send($subdomain,$linksub,$haljudul);	
			}
			elseif ($kategori=="lihat") {
				polling_lihat($subdomain,$linksub,$haljudul);	
			}
			else {
				polling_form($subdomain,$linksub,$haljudul);	
			}
		}
		else { ?>
			<div class="<?php echo $stylepanel;?>"><?php  
				if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php }  ?>
				<div class="<?php echo $styleisi;?>"><?php
					$query=mysqli_query($koneksi, "SELECT no,judul,link,jawaban_1,jawaban_2,jawaban_3,jawaban_4,jawaban_5,hasil_1,hasil_2,hasil_3,hasil_4,hasil_5
					FROM polling WHERE subdomain='$subdomain' AND publish='1'");
					$jumlah=mysqli_num_rows($query);
					if ($jumlah==0) { }
					else {
						$data=mysqli_fetch_array($query);
						$nopol=$data['no'];
						$judul=$data['judul'];
						$linkhal=$data['link'];
						$jawaban_1=$data['jawaban_1'];
						$jawaban_2=$data['jawaban_2'];
						$jawaban_3=$data['jawaban_3'];
						$jawaban_4=$data['jawaban_4'];
						$jawaban_5=$data['jawaban_5']; ?>
						<h4><a href="//<?php echo $linksub;?>/polling/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h4>
						<form action="//<?php echo $linksub;?>/polling/kirim/" method="post">
							<input name="idpolling" type="hidden" value="<?php echo $nopol;?>">
							<input name="idhasil" type="radio" value="1" checked>&nbsp; <?php echo $jawaban_1;?><br>
							<input name="idhasil" type="radio" value="2">&nbsp; <?php echo $jawaban_2;?><br>
							<input name="idhasil" type="radio" value="3">&nbsp; <?php echo $jawaban_3;?><br>
							<input name="idhasil" type="radio" value="4">&nbsp; <?php echo $jawaban_4;?><br>
							<input name="idhasil" type="radio" value="5">&nbsp; <?php echo $jawaban_5; ?><br>
							<input name="pilih" type="submit" value="PILIH" class="button">
							&nbsp;&nbsp;<b><a href="//<?php echo $linksub;?>/polling/lihat/" title="<?php echo $judul;?>">Hasil Polling</a></b>
						</form><?php
					} ?>
				</div>
			</div><?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){
		$judulmod="Polling";
		$tabel="polling";
		$batas=30;
		$kolom="judul";
		$lebar="200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="multi";
		$tipedetail="table";
		$isidetail="judul,jawaban_1,hasil_1,jawaban_2,hasil_2,jawaban_3,hasil_3,jawaban_4,hasil_4,jawaban_5,hasil_5";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekJudul";
		$tipeinput="";
		$forminput="judul,jawaban_1,jawaban_2,jawaban_3,jawaban_4,jawaban_5";
		$jenisinputrinci="";
		$onclickrinci="cekJudul";
		$tipeinputrinci=""; 
		$forminputrinci="judul,jawaban_1,hasil_1,jawaban_2,hasil_2,jawaban_3,hasil_3,jawaban_4,hasil_4,jawaban_5,hasil_5,publish,tgl";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
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
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
		} 
		elseif ($act=="tambah") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
		} 
		elseif ($act=="tambahrinci") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
		} 
		elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
		} 
		elseif ($act=="ubahrinci") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
		} 
		elseif ($act=="balas") {
			komentar_balas($subdomain,$linksub);
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