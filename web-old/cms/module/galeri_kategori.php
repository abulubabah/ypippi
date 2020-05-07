<?php  
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){ 
		$tabel="galeri";
		$module=new publik();
		$module->get_variable();
		$domain=$module->domain;  
		if ($no=="") { $linkhalgaleri=$linksub."/".$link; $nogaleri=$halidtipe; } else { $linkhalgaleri=$linksub."/".$link."/".$no."/".$linkhal; $nogaleri=$no; } ?>
		<h2><a href="//<?php echo $linkhalgaleri;?>/" title="<?php echo $judulweb;?>"><?php echo $judulweb;?></a></h2><?php
		$qkatgal=mysqli_query($koneksi, "SELECT link FROM galeri_kategori WHERE no='$nogaleri'  AND subdomain='$subdomain'");
		$dkatgal=mysqli_fetch_array($qkatgal); 
		$kategori=$dkatgal['link'];
		$module->galeri_list($subdomain,$linksub,$bahasa,$kategori,$nogaleri); ?>
		<script type="text/javascript" charset="utf-8" src="//storage.googleapis.com/s.mysch.id/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/js/prettyPhoto.css"/>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$("area[rel^='prettyPhoto']").prettyPhoto();				
			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: true});
			$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',slideshow:10000, hideflash: true});		
		});
		</script><?php	
	}
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}
?>