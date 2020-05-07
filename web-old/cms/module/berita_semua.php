<?php 
if ($tampil==1) {   
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ 
		$tabel="berita"; ?>
		<h2><?php echo $haljudul;?></h2><?php
$module=new publik();
		$module->get_variable();	
		$haltipe="";
		$halidtipe="";
		$module->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe);
	}		
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>