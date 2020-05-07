<?php   
if ($tampil==1) {
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ 
		if ($layoutposisi=="main") { 
			$tabel="berita";
			$module=new publik();
			$module->get_variable();
			if ($no=="") { 		
				if ($link=="" or $link=="home" or $link=="beranda") { 
					if($layouttampiljudul==1){ ?><h3 class="<?php echo $stylejudul;?>"><?php echo $layoutjudul;?></h3><?php } 
				}
				else {  ?>
					<h2><a href="//<?php echo $linksub."/".$link;?>/" title="Berita"><?php echo $haljudul;?></a></h2><?php 
				}
				$module->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe);
			}
			else {
				if ($act=="") {
					$no=$no/1;
					$module->artikel_view ($subdomain,$linksub,$bahasa,$tabel,$no); 
				}
				elseif ($act=="komentar") {
					$module->komentar_send ($subdomain,$linksub,$bahasa);
				}
			}
		}
		else { ?>
			<div class="<?php echo $stylepanel;?>"><?php 
				if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
				<div class="<?php echo $styleisi;?>">
					<ul><?php
					$dberita;
					if (!is_dir(DIR_CACHE.$subdomain)){
						mkdir(DIR_CACHE.$subdomain,0755);
					}
					
					if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_kategori.'.$layoutno)){
						$dberita=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_kategori.'.$layoutno),true);
					}
					
					if (empty($dberita)){
						$query=$db->query("SELECT no,judul,link FROM berita_kategori WHERE publish='1' AND subdomain='$subdomain'  ORDER BY tgl DESC");
						$dberita=$query->rows;
						$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_kategori.'.$layoutno,json_encode($dberita));
					}

					foreach($dberita as $data) {
						$nokat=$data['no']; 
						$judulkat=$data['judul'];
						$linkkat=$data['link']; 
						$linkmod=$linksub."/berita/".$linkkat;?>
						<li><a href="//<?php echo $linkmod;?>/" title="<?php echo $judulkat; ?>"><?php echo $judulkat;?></a></li><?php
					}  ?>
					</ul> 
				</div>
			</div><?php
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