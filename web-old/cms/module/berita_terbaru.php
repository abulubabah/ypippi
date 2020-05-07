<?php  
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){
		$publik=new publik();
		$publik->get_variable();
		$domain=$publik->domain;
		$batasisi=40;
		if ($layoutposisi=="main") { ?>
			<div class="<?php echo $stylepanel;?>"><?php
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
			<div class="<?php echo $styleisi;?>"><?php
			if ($layouttampilan=="kolom1") { 
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,9");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
				
				$yy=1;
				foreach($dberitamain as $data) { 
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$gamart=$data['gambar'];
					$tanggalart=$data['tanggal'];
					$tampilkan_tanggalart=$data['tampilkan_tanggal'];
					if($yy==3 or $yy==6 or $yy==9) { $margin="margin:1% 0px 0px 0px;"; } else { $margin="margin:1% 1.2% 0px 0px;"; } ?>
					<article style="<?php echo $margin;?>" class="artkolom">
						<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
							<img data-src="<?php echo $resize->ubah($gamart,240,240);?>" alt="<?php echo $judart;?>" class="gambarkecil" style="width:95%;"/><?php
							if ($tampilkan_tanggalart==1) { ?><span class="artkolomtanggal"><?php echo $tanggalart;?></span><?php } ?>
							<h4><?php echo $judart;?></h4>
						</a>
					</article><?php
					$yy++;
				}
			}
			elseif ($layouttampilan=="kolom2") { 
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,3");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
				$yy=1;
				foreach($dberitamain as $data) { 
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$isiart=$data['isi'];
					$gamart=$data['gambar'];
					$linkgambar=$domain."/thumbsedang.php?gambar=".$gamart;
					$tanggalart=$data['tanggal'];
					$tampilkan_tanggalart=$data['tampilkan_tanggal'];
					if($yy==3 or $yy==6 or $yy==9) { $margin="margin:1% 0px 0px 0px;"; } else { $margin="margin:1% 1.2% 0px 0px;"; } ?>
					<article style="<?php echo $margin;?>;" class="artkolom">
						<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
							<div style="background:url(//<?php echo $domain."/picture/".$gamart;?>) top center no-repeat; background-size:240%; height:300px;"></div><?php
							if ($tampilkan_tanggalart==1) { ?><span class="artkolomtanggal"><?php echo $tanggalart;?></span><?php } ?>
							<h4><?php echo $judart;?></h4>
						</a><?php							
						$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
						for ($ss=1;$ss<=10;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?>...
					</article><?php
					$yy++;
				}
			}
			elseif ($layouttampilan=="kolom3") {
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,gambar,isi FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,10");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
				$yy=1;
				foreach ($dberitamain as $data) { 
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$gamart=$data['gambar'];
					if($yy%2==0) { $margin="margin:2% 0px 0px 0px;"; } else { $margin="margin:2% 2% 0px 0px;"; }?>
					<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
					<article style="background:url(//<?php echo $domain."/picture/".$gamart;?>) center top; background-size:200%; <?php echo $margin;?>" class="artgambar">
						<div class="artgambarspasi"></div>
						<h4 class="artgambarjudul"><?php echo $judart;?></h4>
					</article>
					</a><?php
					$yy++;
				}
			}
			elseif ($layouttampilan=="baris1") { 
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,isi,gambar,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain'  ORDER BY tgl DESC LIMIT 0,10");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
			
				foreach($dberitamain as $data) {
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$isiart=$data['isi'];
					$gamart=$data['gambar'];
					$linkberita=$linksub."/berita/".$noart."/".$linkart;
					$tanggalart=$data['tanggal'];?>
					<article style="padding:10px 0px; display:table; width:100%;">
						<a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>">
							<h3><?php echo $judart;?></h3><?php
							if ($gamart=="") { $jumpot=$batasisi*1.5; } else { $jumpot=$batasisi; ?><img data-src="<?php echo $resize->ubah($gamart,240,240);?>" align="left" alt="<?php echo $judart;?>" class="gambarkecil"/><?php } ?>							
						</a><?php
						$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
						for ($ss=1;$ss<=$jumpot;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?>...<br>
						<h5 style="float:left"><a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
						<h5 style="float:right;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5>							
					</article><?php
				}
			}
			elseif ($layouttampilan=="baris2") { 
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,isi,gambar,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain'  ORDER BY tgl DESC LIMIT 0,10");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
				$yyy=1;
				foreach($dberitamain as $data) { 
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$isiart=$data['isi'];
					$gamart=$data['gambar'];
					$linkberita=$linksub."/berita/".$noart."/".$linkart;
					if ($yyy%2==0) { $pictalign="right"; $pictstyle="margin-right:0px; margin-left:10px;"; } else {  $pictalign="left"; $pictstyle="";  } 
					$tanggalart=$data['tanggal'];?>
					<article style="padding:10px 0px; display:table; width:100%;">
						<a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>">
							<h3><?php echo $judart;?></h3>	<?php
							if ($gamart=="") { $jumpot=$batasisi*1.5; } else { $jumpot=$batasisi;?><img src="<?php echo $resize->ubah($gamart,240,240);?>" align="<?php echo $pictalign;?>" alt="<?php echo $judart;?>" class="gambarkecil" style="<?php echo $pictstyle;?>"/><?php } ?>														
						</a><?php
						$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
						for ($ss=1;$ss<=$jumpot;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?>...<br>							
						<h5 style="float:left"><a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
						<h5 style="float:right;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5>
					</article><?php
					$yyy++;
				}
			}
			elseif ($layouttampilan=="kombinasi1") { 
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,4");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
				
				$satubaris=$dberitamain[0];
				unset($dberitamain[0]);
				$tigabaris=$dberitamain;
				$data=$satubaris;
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$isiart=$data['isi'];
					$gamart=$data['gambar'];
					$linkberita=$linksub."/berita/".$noart."/".$linkart;
					$tanggalart=$data['tanggal'];
					$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
					<article style="width:100%; padding:0px; display:table; margin:8px 0px 5px 0px;">
						<a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>">
						<img data-src="<?php echo $resize->ubah($gamart,420,420);?>" align="left" alt="<?php echo $judart;?>" class="gambarsedang" style="margin:0px; margin-right:10px;"/>
						<h3><?php echo $judart;?></h3>
						</a><?php
						$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
						for ($ss=1;$ss<=$batasisi;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?><br><?php
						if ($tampilkan_tanggalart==1) { ?><h5 style="float:left; margin-top:5px;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php } ?>
						<h5 style="float:right; margin-top:5px; margin-right:10px"><a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
					</article><?php
				$yy=1;
				foreach($tigabaris as $data) { 
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$gamart=$data['gambar'];
					$tanggalart=$data['tanggal'];
					$tampilkan_tanggalart=$data['tampilkan_tanggal'];
					if($yy==3 or $yy==6 or $yy==9) { $margin="margin:1% 0px 0px 0px;"; } else { $margin="margin:1% 1.2% 0px 0px;"; } ?>
					<article style="<?php echo $margin;?>" class="artkolom">
						<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
							<img data-src="<?php echo $resize->ubah($gamart,240,240);?>" alt="<?php echo $judart;?>" class="gambarkecil" style="width:96%;"/><?php
							if ($tampilkan_tanggalart==1) { ?><h5 class="artkolomtanggal"><?php echo $tanggalart;?></h5><?php } ?>
							<h4><?php echo $judart;?></h4>
						</a>
					</article><?php
					$yy++;
				}						
			}
			elseif ($layouttampilan=="kombinasi2") { 
				$dberitamain=array(); 
				if(!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
					$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
				}
				
				if (empty($dberitamain)){
					$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,4");
					$dberitamain=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
				}
				
				$satubaris=$dberitamain[0];
				unset($dberitamain[0]);
				$tigabaris=$dberitamain;
				$data=$satubaris;
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link'];
					$isiart=$data['isi'];
					$gamart=$data['gambar'];
					$linkberita=$linksub."/berita/".$noart."/".$linkart;
					$tanggalart=$data['tanggal'];
					$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
					<article style="width:100%; padding:0px; display:table; margin:8px 0px 5px 0px;">
						<a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>">
						<img data-src="<?php echo $resize->ubah($gamart,420,420);?>" align="left" alt="<?php echo $judart;?>" class="gambarsedang" style="margin:0px; margin-right:10px;"/>
						<h3><?php echo $judart;?></h3>
						</a><?php
						$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
						for ($ss=1;$ss<=$batasisi;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?><br><?php
						if ($tampilkan_tanggalart==1) { ?><h5 style="float:left; margin-top:5px;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php } ?>
						<h5 style="float:right; margin-top:5px; margin-right:10px"><a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
					</article><?php
				$yy=1;
				foreach($tigabaris as $data) {  
					$noart=$data['no'];
					$judart=$data['judul'];
					$linkart=$data['link']; 
					$isiart=$data['isi'];
					$gamart=$data['gambar'];
					$linkberita=$linksub."/berita/".$noart."/".$linkart;
					$tanggalart=$data['tanggal'];
					$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
					$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
					<article style="width:49%; padding:1% 1% 1% 0px; float:left; display:table;">
						<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
							<img data-src="<?php echo $resize->ubah($gamart,240,240);?>" alt="<?php echo $judart;?>" class="gambarkecil" style="margin-right:10px;" align="left"/>								
							<h4><?php echo $judart;?></h4>
						</a><?php
						for ($ss=1;$ss<=5;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); } echo "..."; ?>								
					</article><?php
					$yy++;
				}						
			}
			elseif ($layouttampilan=="kombinasi3") { ?>
				<div style="margin-bottom:10px;">
					<div class="artkategori" style="float:left; "><?php
						$dberitamain=array(); 
						if(!is_dir(DIR_CACHE.$subdomain)){
							mkdir(DIR_CACHE.$subdomain,0755);
						}
				
						if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
							$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
						}
				
						if (empty($dberitamain)){
							$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,4");
							$dberitamain=$query->rows;
							$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
						}
						
						$satubaris=$dberitamain[0];
						unset($dberitamain[0]);
						$tigabaris=$dberitamain;
						$dart=$satubaris;
						$noart=$dart['no'];
						$judart=$dart['judul'];
						$linkart=$dart['link'];
						$isiart=$dart['isi'];
						$gamart=$dart['gambar'];
						$tanggalart=$dart['tanggal']; 
						$tampilkan_tanggalart=$dart['tampilkan_tanggal'];
						$linkhalart=$linksub."/berita/".$noart."/".$linkart;
						$linkgamart=$domain."/picture/".$gamart; ?>
						<article style="display:table; width:100%;margin-top:2px;">
							<img data-src="<?php echo $resize->ubah($gamart,420,420);?>" alt="<?php echo $judart;?>" class="gambarsedang" style="width:100%;"/>
							<h3 style="margin:5px 0px;"><a href="//<?php echo $linkhalart;?>/" title="<?php echo $judart;?>"><?php echo $judart;?></a></h3>
							<div><?php
								$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
								for ($h=1;$h<=$batasisi;$h++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); } ?>...
							</div><?php
							if ($tampilkan_tanggalart==1) { ?><h5 style="float:left;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php } ?>
							<h5 style="float:right;"><a href="//<?php echo $linkhalart;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
						</article>
					</div>
					<div class="artkategori" style="float:right;"><?php
						foreach ($tigabaris as $dartlain) {
							$noart=$dartlain['no'];
							$judart=$dartlain['judul'];
							$linkart=$dartlain['link'];
							$isiartlain=$dartlain['isi'];
							$gamart=$dartlain['gambar'];
							$linkberita=$linksub."/berita/".$noart."/".$linkart;
							$linkgambar=$domain."/thumb.php?gambar=".$gamart;
							$linkblank=$domain."/picture/blank.jpg";
							$isiart=strip_tags($isiart); $kalimat=strtok($isiartlain,"  "); 
							$tanggalart=$dartlain['tanggal'];
							$tampilkan_tanggalart=$dartlain['tampilkan_tanggal']; ?>
							<article class="artkategorilist">
								<a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php
									if ($gamart=="") {  } 
									else { ?><img data-src="<?php echo $resize->ubah($gamart,240,240);?>" align="left" class="gambarkecil"  style="width:36%;  margin-right:10px;" alt="<?php echo $judart;?>"/><?php } ?>
									<h4 class="artkolomjudul"><?php echo $judart;?></h4>
								</a><?php
								for ($ss=1;$ss<=8;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }   ?>
							</article><?php
						} ?>
					</div>
				</div><?php
			}
			else {
				$tabel="berita";
				$haltipe="home";
				$halidtipe=""; 
				$publik->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe);
			} ?>
			</div>
			</div><?php
		}
		else { ?>
			<div class="<?php echo $stylepanel;?>"><?php 
				if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
				 <div class="<?php echo $styleisi;?>"><?php
					if ($layouttampilan=="kolom1") {
						$dberitamain=array(); 
						if(!is_dir(DIR_CACHE.$subdomain)){
							mkdir(DIR_CACHE.$subdomain,0755);
						}
				
						if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
							$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
						}
				
						if (empty($dberitamain)){
							$query=$db->query("SELECT no,judul,link,gambar FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' ORDER BY tgl DESC LIMIT 0,5");
							$dberitamain=$query->rows;
							$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
						}
	
						foreach($dberitamain as $data) {
							$noart=$data['no'];
							$judart=$data['judul'];
							$linkart=$data['link'];
							$gamart=$data['gambar'];
							$linkberita=$linksub."/berita/".$noart."/".$linkart; ?>
							<div style="background:url(//<?php echo $domain."/picture/".$gamart;?>) center top; background-size:150%;" class="artgambarside">
							<div class="artgambarsidespasi"></div><a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><h3 class="artgambarsidejudul"><?php echo $judart;?></h3></a></div><?php
						} 
					}
					elseif ($layouttampilan=="baris1") {  ?>
						<ul><?php
						$dberitamain=array(); 
						if(!is_dir(DIR_CACHE.$subdomain)){
							mkdir(DIR_CACHE.$subdomain,0755);
						}
				
						if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
							$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
						}
				
						if (empty($dberitamain)){
							$query=$db->query("SELECT no,judul,link FROM berita WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT 0,10");
							$dberitamain=$query->rows;
							$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
						}
						foreach($dberitamain as $data) {
							$noart=$data['no'];
							$judart=$data['judul'];
							$linkart=$data['link'];
							$linkberita=$linksub."/berita/".$noart."/".$linkart; ?>
							<li><a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php echo $judart;?></a></li><?php
						}  ?>
						</ul><?php
					}
					else {
						$dberitamain=array(); 
						if(!is_dir(DIR_CACHE.$subdomain)){
							mkdir(DIR_CACHE.$subdomain,0755);
						}
				
						if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno)){
							$dberitamain=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno),true);
						}
				
						if (empty($dberitamain)){
							$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT 0,10");
							$dberitamain=$query->rows;
							$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru.'.$layoutno,json_encode($dberitamain));
						}

						foreach($dberitamain as $data) { 
							$noart=$data['no'];
							$judart=$data['judul'];
							$linkart=$data['link'];
							$isiart=$data['isi'];
							$gamart=$data['gambar'];
							$linkberita=$linksub."/berita/".$noart."/".$linkart;
							$linkgambar=$domain."/thumbkecil.php?gambar=".$gamart;
							$tanggalart=$data['tanggal']; ?>
							<div class="panel_list" style="line-height:24px;">
								<a href="//<?php echo $linkberita;?>/" title="<?php echo $judart;?>"><?php
									if ($gamart=="") { } else { ?><img data-src="<?php echo $resize->ubah($gamart,100,100);?>" align="left" alt="<?php echo $judart;?>" class="gambarkecilsekali"/><?php } ?>
									<?php echo $judart;?>
								</a>
								<h6><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h6>
							</div><?php
						}
					} ?>
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