<?php 
if ($tampil==1) { 
	if(empty($akses)){
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ 
	
		//halaman yang di cache halamn yang tidak ada pagingnya
		
		$dvid=array();
		if (!is_dir(DIR_CACHE.$subdomain)){
			mkdir(DIR_CACHE.$subdomain,0755);
		}
		
		if (file_exists(DIR_CACHE.$subdomain.'/cache.'.$layouttipe.'.'.$layoutno)){
			$dvid=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.'.$layouttipe.'.'.$layoutno),true);
		}
		
		if (empty($dvid)){
			$query=$db->query("SELECT judul,url FROM video WHERE id_module='$layoutno' AND publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC");
			$dvid=$query->rows;
			$filemanager->set(DIR_CACHE.$subdomain.'/cache.'.$layouttipe.'.'.$layoutno,json_encode($dvid));
		}
		if ($layoutposisi=="main") { 
			if ($no=="" or $no=="1") { $haljudul="Video"; }
			if ($link=="") { ?>
				<div class="<?php echo $stylepanel;?>"><?php  
					if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php }  ?>
					<div class="<?php echo $styleisi;?>"><?php
						foreach($dvid as $data) {
							$judul=$data['judul'];
							$url=$data['url'];
							$url=str_replace("watch?v=","embed/","$url"); ?>
							<iframe width="100%" height="400" src="<?php echo $url;?>" frameborder="0" allowfullscreen></iframe><?php
						} ?>
					</div>
				</div><?php
			} 
			else { ?>
				<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2><?php
				$publik=new publik();
            	$publik->get_variable(); 
            	$domain=$publik->domain;
            	$link=$publik->link;
            	$linkmodule=$linksub."/".$link;
            	$kategori="";
				$kolom=2; $batas=10; $width="100%"; $height="225"; 
				$lebar=100/$kolom;
				$query=mysqli_query($koneksi, "SELECT * FROM video WHERE publish='1' AND subdomain='$subdomain'");
				$jumlah=mysqli_num_rows($query); 
				if ($jumlah==0) { $publik->terjemahkan("Video Tidak Ada",$bahasa); }
				else {
					$i=0;
					if ($page=="") { $page=1; } else { $page=$page; }
					if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; $page=$page; } ?>
					<table width="100%"><?php
						$query=mysqli_query($koneksi, "SELECT judul,url FROM video WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT $posisi,$batas");
						while ($data=mysqli_fetch_array($query)) { 
							$judul=$data['judul'];
							$url=$data['url'];
							$url=str_replace("watch?v=","embed/","$url");
							if ($i%$kolom==0) { ?><tr valign="top"><?php } ?> 
								<td align="center" width="<?php echo $lebar;?>%" style="padding:10px;">
									<iframe width="<?php echo $width;?>" height="<?php echo $height;?>" src="<?php echo $url;?>" frameborder="0" allowfullscreen></iframe><br>
									<h4><?php echo $judul; ?></h4>
								</td><?php
							if (($i%$kolom)==($kolom-1) or ($i+1)==$jumlah) { ?></tr><?php }
							$i++;
						} ?>
					</table><?php
					$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
				}
			}
		}
		else { ?>
			<div class="<?php echo $stylepanel;?>"><?php  
				if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php }  ?>
				<div class="<?php echo $styleisi;?>"><?php
					foreach($dvid as $data) {
						$judul=$data['judul'];
						$url=$data['url'];
						$url=str_replace("watch?v=","embed/","$url"); ?>
						<iframe width="100%" height="225" src="<?php echo $url;?>" frameborder="0" allowfullscreen></iframe><?php
					} ?>
				</div>
			</div><?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){
		$judulmod="Video";
		$tabel="video";
		$batas=30;
		$kolom="judul";
		$lebar="200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="single";
		$tipedetail="video";
		$isidetail="url";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekJudul";
		$tipeinput="";
		$forminput="judul,url";
		$jenisinputrinci="";
		$onclickrinci="cekJudul";
		$tipeinputrinci="";
		$forminputrinci="judul,url,publish";
		$formeditrinci="judul,url,publish,tgl";
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
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete(DIR_CACHE.$subdomain.'/'.$value);
				}
				
			}
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete(DIR_CACHE.$subdomain.'/'.$value);
				}
				
			}
		} 
		elseif ($act=="tambah") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete(DIR_CACHE.$subdomain.'/'.$value);
				}
				
			}
		} 
		elseif ($act=="tambahrinci") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete(DIR_CACHE.$subdomain.'/'.$value);
				}
				
			}
		} 
		elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete(DIR_CACHE.$subdomain.'/'.$value);
				}
				
			}
		} 
		elseif ($act=="ubahrinci") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
		} 
		else {
			$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete(DIR_CACHE.$subdomain.'/'.$value);
				}
				
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