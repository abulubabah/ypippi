<?php 
if ($tampil==1) {
	if(empty($akses)){  
		header("location:index.php"); 
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$query=mysqli_query($koneksi, "SELECT header_bawah FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query); 
		$header_bawah =$data['header_bawah'];
		$linkhalaman=$linksub."/".$adm."/".$mod;
		$linktataletak=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Header Bawah</h2> 
			<form action="" method="post" enctype="multipart/form-data">
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">						
					<tr><td width="140">Header Kanan</td><td><textarea name="header_bawah" id="header_bawah" style="width:94%; max-width:500px; height:100px"><?php echo $header_bawah;?></textarea></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></td></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Header Bawah Berhasil Disimpan</h3>Selamat, Header Bawah Berhasil Disimpan<br/><a href="//<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$header_bawah=$_POST['header_bawah']; $header_bawah=str_replace('"','',$header_bawah); $header_bawah=str_replace("'","",$header_bawah);
				 mysqli_query($koneksi, "UPDATE setting SET header_bawah='$header_bawah' WHERE subdomain='$subdomain'"); ?>
				<h3>Header Bawah Berhasil Disimpan</h3>Selamat, Header Bawah Berhasil Disimpan<br/><a href="//<?php echo $linktataletak;?>" title="Kembali">Kembali</a><?php				
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