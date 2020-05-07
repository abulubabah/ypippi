<?php   
if ($tampil==1) {  
	if (empty($akses)) { 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){  
		$qtipeslide=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
		$dtipeslide=mysqli_fetch_array($qtipeslide);
		$tipeslide=$dtipeslide['tipe_slideshow']; 
		$dslide=array();
		if (!is_dir(DIR_CACHE.$subdomain)){
			mkdir(DIR_CACHE.$subdomain,0755);
		}
		
		if (file_exists(DIR_CACHE.$subdomain.'/cache.slideshow')){
			$dslide=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.slideshow'),true);
		}
		
		if (empty($dslide)){
			$query=$db->query("SELECT judul,url,gambar FROM slideshow WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT 0,12");
			$dslide=$query->rows;
			$filemanager->set(DIR_CACHE.$subdomain.'/cache.slideshow',json_encode($dslide));
		}
		
		if ($tipeslide=="zoom") { $noslide=1; ?>
			<div id="demo-1" data-zs-src='[<?php foreach($dslide as $data) { $linkgambar="/".$domain."/picture/".$data['gambar']; if ($noslide!=1) { echo ","; } ?> "<?php echo $linkgambar;?>"<?php $noslide++; } ?>]' data-zs-overlay="dots">
				<!--<div class="demo-inner-content"><h1>ZoomSlider</h1><p>ZoomSlider creates slideshows with zoom effect using background-image and CSS3.</p></div>-->
			</div>
			<link rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/js/zoomslider.css"/>	
			<link rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/js/zoomslider2.css" />
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/modernizr-2.6.2.min.js"></script>
			<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.zoomslider.min.js"></script><?php
		}
		elseif ($tipeslide=="smooth") { ?>
			<div class="smoothslides" id="myslideshow1"><?php
				foreach($dslide as $data) {
					$judulslide=$data['judul'];
					$urlslide=$data['url']; 
					$gambar=$data['gambar'];
					$linkgambar="/".$domain."/picture/".$gambar; ?>
					<img data-src="<?php echo $linkgambar;?>" alt="<?php echo $judulslide;?>" width="100%"/><?php	
				} ?>
			</div>
			<link rel="stylesheet" href="//storage.googleapis.com/s.mysch.id/js/smoothslides.theme.css">
			<!--<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.js"></script>-->
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/smoothslides-2.2.1.min.js"></script>
			<script type="text/javascript">
				$(window).load( function() {
					$('#myslideshow1').smoothSlides({
						effectDuration:3500
					});
					$('#myslideshow2').smoothSlides({
						effectDuration:3500,
						effectModifier:1.4,
						navigation:false,
						pagination:false
					});
				});
			</script><?php
		}
		elseif ($tipeslide=="mix") { ?>
			<div class="fluid_container">
       			<div class="camera_wrap camera_emboss pattern_1" id="camera_wrap_4">
       				 <?php
					foreach($dslide as $data) {
						$judulslide=$data['judul'];
						$urlslide=$data['url']; 
						$gambar=$data['gambar'];
						$linkgambar="/".$domain."/picture/".$gambar; ?>
						<div data-src="<?php echo $likgambar;?>" data-link="<?php echo $urlslide;?>"></div><?php
					} ?>
				</div>
			</div>
			<link rel="stylesheet" id="camera-css"  href="//storage.googleapis.com/s.mysch.id/js/camera.css" type="text/css" media="all"> 
			<link rel="stylesheet" id="camera-css"  href="//storage.googleapis.com/s.mysch.id/js/camera2.css" type="text/css" media="all"> 
			<!--<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.min.js"></script>-->
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.mobile.customized.min.js"></script>
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/jquery.easing.1.3.js"></script> 
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/camera.min.js"></script>     
			<script>
				$(window).load( function(){			
					$('#camera_wrap_4').camera({
						loader:'bar',
						pagination: false,
						thumbnails: false,
						hover: false,
						opacityOnGrid: false
					});
				});
			</script> <?php
		}
		else { ?>
			<div style="width:100%; display:table;">
				<ul id="demo1"><?php
					foreach($dslide as $data) {
						$judulslide=$data['judul'];
						$urlslide=$data['url']; 
						$gambar=$data['gambar'];
						$linkgambar="/".$domain."/picture/".$gambar; ?>
						<li><a href="<?php echo $urlslide;?>" title="<?php echo $judulslide;?>" target="_blank"><img  data-src="<?php echo $linkgambar; ?>" alt="<?php echo $judulslide;?>" width="100%"/></a></li><?php	
					} ?>
				</ul>
			</div>
			<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/slippry.min.js"></script>
			<link rel="stylesheet" href="//storage.googleapis.com/s.mysch.id/js/slippry.css">
			<script>
				$(window).load( function() {
					var demo1 = $("#demo1").slippry({});				
					$('.prev').click(function () {demo1.goToPrevSlide();return false;});
					$('.next').click(function () {demo1.goToNextSlide();return false;});				
				});
			</script><?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){
		$judulmod="Slideshow";
		$tabel="slideshow";
		$batas=30;
		$kolom="judul";
		$lebar="200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="multi";
		$tipedetail="table-pict";
		$isidetail="judul,url,target";
		$tipedelete="gambar";
		$jenisinput="gambar";
		$onclick="cekJudul";
		$tipeinput="";
		$forminput="judul,gambar";
		$jenisinputrinci="gambar";
		$onclickrinci="cekJudul";
		$tipeinputrinci="";
		$forminputrinci="judul,url,target,publish,gambar";
		$formeditrinci="judul,url,target,publish,tgl,gambar";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		global $db;
		global $filemanager;
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
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.slideshow');
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.slideshow');
		} 
		elseif ($act=="tambah") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);	
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.slideshow');		
		} 
		elseif ($act=="tambahrinci") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.slideshow');
		} 
		elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.slideshow');
		} 
		elseif ($act=="ubahrinci") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.slideshow');
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