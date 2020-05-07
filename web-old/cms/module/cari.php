<?php 
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php");
	}
	elseif($akses=="publik" or $akses=="member"){
		$module=new publik();
		$module->get_variable();
		$act=$module->act; 
		$kategori=$module->kategori; 
		if (empty($_POST['keyword'])) {  
			if ($kategori=="") {?> 
				<h2><?php $module->terjemahkan("Form Pencarian",$bahasa);?></h2>
				<h3><?php $module->terjemahkan("Kata Kunci",$bahasa);?> :</h3>
				<div class="cari">
					<form action="//<?php echo $linksub;?>/cari/" method="post">
						<input type="text" name="keyword" id="keyword" value="Search" maxlength="40" onblur="if (this.value=='') this.value='Search';" onfocus="if (this.value=='Search') this.value='';"/>
						<input name="cari" type="submit" value="" onClick="return cekKeyword();" id="tombol" style="cursor:pointer"/>
					</form>
				</div><?php
			}
			else { 
				$tabel="berita";
				$haltipe="cari";  
				$halidtipe=$kategori=strtok($kategori,"'"); ?>
				<h2><a href="//<?php echo $linksub."/cari/1/".$halidtipe;?>/" title="<?php echo $halidtipe;?>"><?php echo $halidtipe;?></a></h2><?php
				$module->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe); 
			} 
		}
		else { 
			$tabel="berita";
			$haltipe="cari";
			$halidtipe=strip_tags($_POST['keyword']);?>
			<h2><?php $module->terjemahkan("Hasil Pencarian",$bahasa);?></h2><?php
			$module->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe);
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