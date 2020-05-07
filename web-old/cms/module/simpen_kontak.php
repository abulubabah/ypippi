<?php
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ 
		$query=mysqli_query($koneksi, "SELECT judul,alamat,kota,provinsi,kodepos,telepon,telepon2,fax,email,website,facebook,twitter,google_plus
			FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
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
		$google_plus=$data['google_plus'];?>
		<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $judulweb;?>"><?php echo $judulweb;?></a></h2>
		<h3><?php echo $judulkon;?></h3>
		<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
			<tr><td width="130">Alamat</td><td width="15">:</td><td><?php echo $alamat;?></td></tr><?php
			if($kota=="") { } else { ?><tr><td>Kota / Kab</td><td>:</td><td><?php echo $kota;?></td></tr><?php }
			if($provinsi=="") { } else { ?><tr><td>Provinsi</td><td>:</td><td><?php echo $provinsi;?></td></tr><?php }
			if($kodepos=="") { } else { ?><tr><td>Kode Pos</td><td>:</td><td><?php echo $kodepos;?></td></tr><?php }
			if($telepon=="") { } else { ?><tr><td>Telepon</td><td>:</td><td><?php echo $telepon;?></td></tr><?php }
			if($telepon2=="") { } else { ?><tr><td>Telepon 2</td><td>:</td><td><?php echo $telepon2;?></td></tr><?php }
			if($fax=="") { } else { ?><tr><td>Fax</td><td>:</td><td><?php echo $fax;?></td></tr><?php }
			if($email=="") { } else { ?><tr><td>Email</td><td>:</td><td><?php echo $email;?></td></tr><?php }
			if($website=="") { } else { ?><tr><td>Web</td><td>:</td><td><?php echo $website;?></td></tr><?php }
			if($facebook=="") { } else { ?><tr><td>FB</td><td>:</td><td><?php echo $facebook;?></td></tr><?php }
			if($twitter=="") { } else { ?><tr><td>Twitter</td><td>:</td><td><?php echo $twitter;?></td></tr><?php }
			if($google_plus=="") { } else { ?><tr><td>Google+</td><td>:</td><td><?php echo $google_plus;?></td></tr><?php } ?>
		</table><?php
	}
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>