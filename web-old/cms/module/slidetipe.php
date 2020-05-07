<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){ 
	    $module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		$query=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$tipe_slideshow=$data['tipe_slideshow']; 
		$linkhalaman=$linksub."/".$adm."/".$mod;
		if (empty($_POST['proses'])) { ?>
			<h2>Setting Tipe Slideshow</h2>
			<form action="" method="post">
				<input name="proses" type="hidden" value="edit"/>
				<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
					<tr><td width="160">Tipe Slideshow</td>
						<td>
							<select name="tipe_slideshow" style="width:96%; max-width:510px;">
								<option value="<?php echo $tipe_slideshow;?>"><?php echo $tipe_slideshow;?></option>
								<option value="standar">Standar</option>
								<option value="zoom">Zoom</option>
								<option value="smooth">Smooth</option>
<option value="mix">Mix</option>	
							</select>
						</td>
					</tr>
					<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" class="button"/></tr> 
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="edit") {
			if (empty($_SESSION['kode'])) {?>
				<h3>Tipe Slideshow Berhasil Disimpan</h3>Selamat, Tipe Slideshow Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
			}
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$tipe_slideshow=strip_tags($_POST['tipe_slideshow']); $tipe_slideshow=str_replace('"','',$tipe_slideshow); $tipe_slideshow=str_replace("'","",$tipe_slideshow);
				mysqli_query($koneksi, "UPDATE setting SET tipe_slideshow='$tipe_slideshow' WHERE subdomain='$subdomain'");  ?>
				<h3>Tipe Slideshow Berhasil Disimpan</h3>Selamat, Tipe Slideshow Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>" title="Kembali">Kembali</a><?php
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