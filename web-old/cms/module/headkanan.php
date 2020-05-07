<?php 
if ($tampil==1) {
	if(empty($akses)){  
		header("location:index.php"); 
	} 
	elseif($akses=="admin" or $akses=="super"){ 
		$query=mysqli_query($koneksi, "SELECT header_kanan FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$header_kanan=$data['header_kanan'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		$linktataletak=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Header Kanan</h2> 
			<form action="" method="post" enctype="multipart/form-data">
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">						
					<tr><td width="140">Header Kanan</td><td><textarea name="header_kanan" id="header_kanan" style="width:94%; max-width:500px; height:100px"><?php echo $header_kanan;?></textarea></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></td></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Header Kanan Berhasil Disimpan</h3>Selamat, Header Kanan Berhasil Disimpan<br/><a href="//<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$header_kanan=$_POST['header_kanan']; $header_kanan=str_replace('"','',$header_kanan); $header_kanan=str_replace("'","",$header_kanan);
				 mysqli_query($koneksi, "UPDATE setting SET header_kanan='$header_kanan' WHERE subdomain='$subdomain'"); ?>
				<h3>Header Kanan Berhasil Disimpan</h3>Selamat, Header Kanan Berhasil Disimpan<br/><a href="//<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php				
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