<?php
if ($tampil==1) {  
		if(empty($akses)){  
			header("location:index.php"); 
		}
		elseif($akses=="publik" or $akses=="member"){
			$publik=new publik();
			$publik->get_variable();
			$domain=$publik->domain;
			if ($layoutposisi=="main") {
				$qartkat=mysqli_query($koneksi, "SELECT no FROM berita_kategori WHERE publish='1' AND subdomain='$subdomain' AND no='$layoutidtipe'");
				$jartkat=mysqli_num_rows($qartkat); 
				if ($jartkat==0) { ?>
					<div class="<?php echo $stylepanel;?>"><?php
						if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } ?>
						<div class="<?php echo $styleisi;?>"><?php
							$tabel="berita";
							$haltipe="home";
							$halidtipe=""; 
							$publik->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe); ?>
						</div>
					</div><?php
				} 
				else { 
					$qkatart=mysqli_query($koneksi, "SELECT no,judul,link FROM berita_kategori WHERE publish='1' AND subdomain='$subdomain' AND no='$layoutidtipe' ORDER BY tgl DESC");
					$dkatart=mysqli_fetch_array($qkatart);
					$idkat=$dkatart['no'];
					$judkat=$dkatart['judul'];
					$linkkat=$dkatart['link'];
					$linkhalkat=$linksub."/kategori/".$idkat."/".$linkkat; ?>
					<div class="<?php echo $stylepanel;?>"><?php
						if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } ?>
						<div class="<?php echo $styleisi;?>"><?php
						if ($layouttampilan=="kolom1") { ?>
							<style type="text/css">
								.artkolom{ float:left; width:32%; height:220px; display:table; text-align:center; }
								.artkolom a:link, .artkolom a:visited {  text-decoration:none;  }
								.artkolom a:hover { text-decoration:none; opacity:0.85; }
								.artkolomtanggal{ font-size:11px; background:#FFFFFF; float:right; margin:-40px 0 0 0; z-index:1001; padding:0px 5px; position:relative; opacity:0.8; }
							</style><?php
							$dkol1=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dkol1=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}
							
							if (empty($dkol1)){
								$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,9");
								$dkol1=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dkol1));
							}
							$yy=1;
							foreach($dkol1 as $data) { 
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$gamart=$data['gambar'];
								$tanggalart=$data['tanggal'];
								$tampilkan_tanggalart=$data['tampilkan_tanggal'];
								if($yy==3 or $yy==6 or $yy==9) { $margin="margin:1% 0px 0px 0px;"; } else { $margin="margin:1% 1.2% 0px 0px;"; } ?>
								<article style="<?php echo $margin;?>" class="artkolom">
									<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
										<img data-src="<?php echo $resize->ubah($gamart,240,240);?>" alt="<?php echo $judart;?>" class="gambarkecil" style="width:94%;"/><?php
										if ($tampilkan_tanggalart==0) { ?><span class="artkolomtanggal"><?php echo $tanggalart;?></span><?php } ?>
										<h4><?php echo $judart;?></h4>
									</a>
								</article><?php
								$yy++;
							}
						}
						elseif ($layouttampilan=="kolom2") { ?>
							<style type="text/css">
								.artkolom{ float:left; width:32%; height:220px; display:table; text-align:left; }
								.artkolom a:link, .artkolom a:visited {  text-decoration:none;  }
								.artkolom a:hover { text-decoration:none; opacity:0.85; }
								.artkolomtanggal{ font-size:11px; background:#FFFFFF; float:right; margin:-40px 0 0 0; z-index:1001; padding:0px 5px; position:relative; opacity:0.8; }
							</style><?php
							$dkol2=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dkol2=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}							
							
							if (empty($dkol2)){
								$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%'  ORDER BY tgl DESC LIMIT 0,3");
								$dkol2=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dkol2));
							}
							$yy=1;
							foreach($dkol2 as $data) { 
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$isiart=$data['isi'];
								$gamart=$data['gambar'];
								$tanggalart=$data['tanggal'];
								$tampilkan_tanggalart=$data['tampilkan_tanggal'];
								if($yy==3 or $yy==6 or $yy==9) { $margin="margin:1% 0px 0px 0px;"; } else { $margin="margin:1% 1.2% 0px 0px;"; } ?>
								<article style="<?php echo $margin;?>;" class="artkolom">
									<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
										<div style="background:url(<?php echo $resize->ubah($gamart,420,420);?>) top center no-repeat; background-size: 420px 320px; height:320px;"></div>
										<h4><?php echo $judart;?></h4>
									</a><?php
									if ($tampilkan_tanggalart==1) { ?><h6><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h6><?php }
									$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
									for ($ss=1;$ss<=10;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?>...
								</article><?php
								$yy++;
							}
						}
						elseif ($layouttampilan=="kolom3") { ?>
							<style type="text/css">
								.artgambar{ float:left; width:46.5%; height:280px; padding:1%; border:1px solid #EAEAEA; }
								.artgambarspasi{ margin-top:200px; }
								.artgambarjudul{ color:#FFFFFF; background:#333333;  padding:5px; font-size:14px; font-weight:bold; opacity:0.7; border-left:4px solid #FF0000; }
								.artgambarjudul a:link, .artgambarjudul a:visited {  text-decoration:none;  }
								.artgambarjudul a:hover { text-decoration:none;  }
							</style><?php
							$dkol3=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dkol3=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}							
							
							if (empty($dkol2)){
								$query=$db->query("SELECT no,judul,link,gambar FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,10");
								$dkol3=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dkol3));
							}
							$yy=1;
							foreach($dkol3 as $data) { 
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$gamart=$data['gambar'];
								if($yy%2==0) { $margin="margin:1% 0px 0px 0px;"; } else {$margin="margin:1% 2% 0px 0px;"; }?>
								<a href="//<?php echo $linksub."/berita/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
								<article style="background:url(<?php echo $resize->ubah($gamart,420,420);?>) center; background-size: 150%; <?php echo $margin;?>" class="artgambar">
									<div class="artgambarspasi"></div>
									<h4 class="artgambarjudul"><?php echo $judart;?></h4>
								</article>
								</a><?php
								$yy++;
							}
						}
						elseif ($layouttampilan=="baris1") {
							$dbar1=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dbar1=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}
							
							if (empty($dbar1)){
								$query=$db->query("SELECT no,judul,link,isi,gambar,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND kategori LIKE '%,$idkat,%'  ORDER BY tgl DESC LIMIT 0,10");
								$dbar1=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dbar1));
							}
							
							foreach($dbar1 as $data) { 
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$isiart=$data['isi'];
								$gamart=$data['gambar'];
								$linkartikel=$linksub."/berita/".$noart."/".$linkart;
								$tanggalart=$data['tanggal'];?>
								<article style="padding:10px 0px; display:table; width:100%;">
									<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php
										if ($gamart=="") { $jumpot=75; } else { $jumpot=50; ?><img data-src="<?php echo $resize->ubah($gamart,240,240);?>" align="left" alt="<?php echo $judart;?>" class="gambarkecil"/><?php } ?>
										<h3><?php echo $judart;?></h3>
									</a><?php
									$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
									for ($ss=1;$ss<=$jumpot;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?>...<br>
									<h5 style="float:left"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5>
									<h5 style="float:right"><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
								</article><?php
							}
						}
						elseif ($layouttampilan=="baris2") { 
							$dbar2=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dbar2=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}
							
							if (empty($dbar1)){
								$query=$db->query("SELECT no,judul,link,isi,gambar,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND kategori LIKE '%,$idkat,%'  ORDER BY tgl DESC LIMIT 0,10");
								$dbar2=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dbar2));
							}
							$yyy=1;
							foreach($dbar2 as $data) { 
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$isiart=$data['isi'];
								$gamart=$data['gambar'];
								$linkartikel=$linksub."/berita/".$noart."/".$linkart;
								if ($yyy%2==0) { $pictalign="right"; $pictstyle="margin-right:0px; margin-left:10px;"; } else {  $pictalign="left"; $pictstyle="";  } 
								$tanggalart=$data['tanggal'];?>
								<article style="padding:10px 0px; display:table; width:100%;">
									<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>">
										<h3><?php echo $judart;?></h3><?php
										if ($gamart=="") { $jumpot=75; } else { $jumpot=50; ?><img data-src="<?php echo $resize->ubah($gamart,240,240);?>" align="<?php echo $pictalign;?>" alt="<?php echo $judart;?>" class="gambarkecil" style="<?php echo $pictstyle;?>"/><?php } ?>								
									</a><?php
									$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
									for ($ss=1;$ss<=$jumpot;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?>...<br>
									<h5 style="float:left"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5>
									<h5 style="float:right"><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
								</article><?php
								$yyy++;
							}
						}
						elseif ($layouttampilan=="kombinasi1") { 
							$dkom1=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dkom1=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}
							
							if (empty($dkom1)){
								$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,4");
								$dkom1=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dkom1));
							}
							
							// pecah data 4 baris menjadi 1 baris dan 3 baris
							$inis=0;
							$satubaris=array();
							foreach ($dkom1 as $dhahasil){
								$satubaris=$dhahasil;
								//hapus baris 1 baris $dkom1
								unset($dkom1[$inis]);
								//hentikanperulangan
								break;
							}
						
							$tigabaris=$dkom1;
							$data=$satubaris;
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$isiart=$data['isi'];
								$gamart=$data['gambar'];
								$linkartikel=$linksub."/berita/".$noart."/".$linkart;
								$tanggalart=$data['tanggal'];
								$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
								<div style="width:100%; background:#F4ddF4F4; padding:0px; display:table; margin:10px 0px 5px 0px;">
									<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>">
										<img data-src="<?php echo $resize->ubah($gamart,420,420);?>" align="left" alt="<?php echo $judart;?>" class="gambarsedang" style="margin:0px; margin-right:10px;"/>
										<h3 style="margin:8px 0px;"><?php echo $judart;?></h3>
									</a><?php
									$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
									for ($ss=1;$ss<=40;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?><br><?php
									if ($tampilkan_tanggalart==1) { ?><h5 style="float:left; margin-top:5px;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php } ?>
									<h5 style="float:right; margin-top:5px; margin-right:10px"><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
								</div><?php
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
						elseif ($layouttampilan=="kombinasi2") { ?>
							<style type="text/css">
								.artkolom{ float:left; width:32%; height:220px; display:table; text-align:center; }
								.artkolom a:link, .artkolom a:visited {  text-decoration:none;  }
								.artkolom a:hover { text-decoration:none; opacity:0.85; }
								.artkolomtanggal{ font-size:11px; background:#FFFFFF; float:right; margin:-40px 0 0 0; z-index:1001; padding:0px 5px; position:relative; opacity:0.8; }
							</style><?php
							$dkom2=array();
							if (!is_dir(DIR_CACHE.$subdomain)){
								mkdir(DIR_CACHE.$subdomain,0755);
							}
							
							if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
								$dkom2=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
							}
							
							if (empty($dkom2)){
								$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,4");
								$dkom2=$query->rows;
								$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dkom2));
							}
							// pecah data 4 baris menjadi 1 baris dan 3 baris
							$inis=0;
							$satubaris=array();
							foreach ($dkom2 as $dhahasil){
								$satubaris=$dhahasil;
								//hapus baris 1 baris $dkom2
								unset($dkom2[$inis]);
								//hentikanperulangan
								break;
							}
							$tigabaris=$dkom2;
							$data=$satubaris;
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link'];
								$isiart=$data['isi'];
								$gamart=$data['gambar'];
								$linkartikel=$linksub."/berita/".$noart."/".$linkart;
								$tanggalart=$data['tanggal'];
								$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
								<div style="width:100%; background:#F4F4Fdd4; padding:0px; display:table; margin:10px 0px 5px 0px;">
									<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>">
										<img data-src="<?php echo $resize->ubah($gamart,420,420);?>" align="left" alt="<?php echo $judart;?>" class="gambarsedang" style="margin:0px; margin-right:10px;"/>
										<h3 style="margin:8px 0px;"><?php echo $judart;?></h3>
									</a><?php
									$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
									for ($ss=1;$ss<=40;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }?><br><?php
									if ($tampilkan_tanggalart==1) {  ?><h5 style="float:left; margin-top:5px;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php } ?>
									<h5 style="float:right; margin-top:5px; margin-right:10px"><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
								</div><?php
							$yy=1;
							foreach ($tigabaris as $data) { 
								$noart=$data['no'];
								$judart=$data['judul'];
								$linkart=$data['link']; 
								$isiart=$data['isi'];
								$gamart=$data['gambar'];
								$linkartikel=$linksub."/berita/".$noart."/".$linkart;
								$tanggalart=$data['tanggal'];
								$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
								$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
								<div style="width:50%; padding:1% 0% 1% 0px; float:left; display:table; border-bottom:1px solid #F0F0F0;">
									<a href="//<?php echo $linksub."/artikel/".$noart."/".$linkart;?>/" title="<?php echo $judart;?>">
										<img data-src="<?php echo $resize->ubah($gamart,240,240);?>" alt="<?php echo $judart;?>" class="gambarkecilsekali" style="width:40%; margin-right:10px;" align="left"/>								
										<h4><?php echo $judart;?></h4>
								</a><?php
										if ($tampilkan_tanggalart==1) { /* ?><h5 style="float:left; margin-top:5px;"><?php echo $tanggalart;?></h5><?php */ }
										for ($ss=1;$ss<=12;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }  ?>	
									
								</div><?php
								$yy++;
							}						
						}
						elseif ($layouttampilan=="kombinasi3") { ?>
							<style type="text/css">
								.artkategori{ width:49%; display:table; margin:8px 0% ; }
								.artkategoritanggal{ font-size:11px; background:#FFFFFF; float:right; margin:-45px 0px 0px 0px; z-index:1001; padding:0px 0.5%; position:relative; opacity:0.8; }
								.artkategorigambarkecil { width:25%; margin-right:5px; }
								.artkategorilist { display:table; width:100%; padding:5px 0px; border-bottom:1px dotted #F0F0F0; }
							</style>
							<div style="margin-bottom:10px;">
								<div class="artkategori" style="float:left; "><?php
									$dkom3=array();
									if (!is_dir(DIR_CACHE.$subdomain)){
										mkdir(DIR_CACHE.$subdomain,0755);
									}
							
									if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
										$dkom3=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
									}
							
									if (empty($dkom3)){
										$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,4");
										$dkom3=$query->rows;
										$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dkom3));
									}
									// pecah data 4 baris menjadi 1 baris dan 3 baris
									$inis=0;
									$satubaris=array();
									foreach ($dkom3 as $dhahasil){
										$satubaris=$dhahasil;
										//hapus baris 1 baris $dkom3
										unset($dkom2[$inis]);
										//hentikanperulangan
										break;
									}
									$tigabaris=$dkom3;
									$dart=$satubaris;
									$noart=$dart['no'];
									$judart=$dart['judul'];
									$linkart=$dart['link'];
									$isiart=$dart['isi'];
									$gamart=$dart['gambar'];
									$tanggalart=$dart['tanggal']; 
									$tampilkan_tanggalart=$data['tampilkan_tanggal'];
									$linkhalart=$linksub."/berita/".$noart."/".$linkart;
									$linkgamart=$domain."/picture/".$gamart; ?>
									<article style="display:table; width:100%; background:#F4Fdd4F4;  margin-top:3px;">
										<img data-src="<?php echo $resize->ubah($gamart,420,420);?>" alt="<?php echo $judart;?>" class="gambarsedang" style="border:none; width:100%; margin:0px 0px 5px 0px;"/>
										<h3 style="margin:5px 10px;"><a href="//<?php echo $linkhalart;?>/" title="<?php echo $judart;?>"><?php echo $judart;?></a></h3>
										<div style="margin:0px 10px;"><?php
											$isiart=strip_tags($isiart); $kalimat=strtok($isiart,"  "); 
											for ($h=1;$h<=50;$h++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); } ?>...
										</div><?php
										if ($tampilkan_tanggalart==1) { ?><h5 style="float:left; margin:4px 10px;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php } ?>
										<h5 style="float:right; margin:4px 10px;"><a href="//<?php echo $linkhalart;?>/" title="<?php echo $judart;?>"><?php $publik->terjemahkan("selengkapnya",$bahasa);?> &raquo;</a></h5>
									</article>
								</div>
								<div class="artkategori" style="float:right;"><?php
									foreach ($tigabaris as $dartlain) {
										$noart=$dartlain['no'];
										$judart=$dartlain['judul'];
										$linkart=$dartlain['link'];
										$isiartlain=$dartlain['isi'];
										$gamart=$dartlain['gambar'];
										$linkartikel=$linksub."/berita/".$noart."/".$linkart;
										$linkblank=$domain."/picture/blank.jpg";
										$isiart=strip_tags($isiart); $kalimat=strtok($isiartlain,"  "); 
										$tanggalart=$dartlain['tanggal'];
										$tampilkan_tanggalart=$data['tampilkan_tanggal']; ?>
										<article class="artkategorilist">
											<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php
												if ($gamart=="") {  } 
												else { ?><img data-src="<?php echo $resize->ubah($gamart,240,240);?>" align="left" class="gambarkecilsekali"  style="width:36%;  margin-right:10px;" alt="<?php echo $judart;?>"/><?php } ?>
												<h4 class="artkolomjudul"><?php echo $judart;?></h4>
											</a><?php
											if ($tampilkan_tanggalart==1) { ?><h5 style="float:left; margin-top:5px;"><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5><?php }
											for ($ss=1;$ss<=8;$ss++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); }   ?>
										</article><?php
									} ?>
								</div>
							</div><?php
						}
						else {
							$tabel="berita";
							$haltipe="berita_kategori";
							$halidtipe=$idkat; 
							$publik->artikel_list($subdomain,$linksub,$bahasa,$tabel,$haltipe,$halidtipe);
						} ?>
						</div>
					</div><?php
				}
			}
			else { 
				if ($layoutposisi=="bottom") { $limit=5; } else { $limit=10; }
				$qartkat=mysqli_query($koneksi, "SELECT no FROM berita_kategori WHERE publish='1' AND subdomain='$subdomain' AND no='$layoutidtipe'");
				$jartkat=mysqli_num_rows($qartkat); 
				if ($jartkat==0) { ?>
					<div class="<?php echo $stylepanel;?>"><?php 
						if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } ?>
						<div class="<?php echo $styleisi;?>"><?php
						$dbot=array();
						if (!is_dir(DIR_CACHE.$subdomain)){
							mkdir(DIR_CACHE.$subdomain,0755);
						}
							
						if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
							$dbot=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
						}
							
						if (empty($dbot)){
							$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT 0,$limit");
							$dbot=$query->rows;
							$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dbot));
						}
						
						foreach($dbot as $data) { 
							$noart=$data['no'];
							$judart=$data['judul'];
							$linkart=$data['link'];
							$isiart=$data['isi'];
							$gamart=$data['gambar'];
							$linkartikel=$linksub."/berita/".$noart."/".$linkart;
							$tanggalart=$data['tanggal']; ?>						
							<div class="panel_list">
								<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php
									if ($gamart=="") { } else { ?><img data-src="<?php echo $resize->ubah($gamart,100,100);?>" align="left" alt="<?php echo $judart;?>" class="gambarkecilsekali"/><?php } ?>
									<?php echo $judart;?>
								</a>
								<h5><?php $publik->terjemahkan("Tanggal",$bahasa); echo " : ".$tanggalart;?></h5>
							</div><?php
						} ?>
						</div>
					</div><?php
				} 
				else {
					$qkatart=mysqli_query($koneksi, "SELECT no,judul,link  FROM berita_kategori WHERE publish='1' AND subdomain='$subdomain' AND no='$layoutidtipe'  ORDER BY tgl DESC");
					$dkatart=mysqli_fetch_array($qkatart);
					$idkat=$dkatart['no'];
					$judkat=$dkatart['judul'];
					$linkkat=$dkatart['link']; ?>
					<div class="<?php echo $stylepanel;?>"><?php 
						if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
						<div class="<?php echo $styleisi;?>"><?php
							if ($layouttampilan=="kolom1") { ?>
								<style type="text/css">
								.artgambarside{ width:92%; height:150px; padding:4%; margin-bottom:10px;}
								.artgambarsidespasi{ margin-top:100px; }
								.artgambarsidejudul{ color:#FFFFFF; background:#333333; padding:4px; font-size:14px; font-weight:bold; opacity:0.7; border-left:3px solid #FF0000; }
								.artgambarsidejudul a:link, .artgambarsidejudul a:visited {  text-decoration:none;  }
								.artgambarsidejudul a:hover { text-decoration:none; opacity:0.5; }
								</style><?php
								$dbot=array();
								if (!is_dir(DIR_CACHE.$subdomain)){
									mkdir(DIR_CACHE.$subdomain,0755);
								}
							
								if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
									$dbot=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
								}
							
								if (empty($dbot)){
									$query=$db->query("SELECT no,judul,link,gambar FROM berita WHERE publish='1' AND subdomain='$subdomain' AND gambar!='' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,$limit");
									$dbot=$query->rows;
									$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dbot));
								}

								foreach($dbot as $data) {
									$noart=$data['no'];
									$judart=$data['judul'];
									$linkart=$data['link'];
									$gamart=$data['gambar'];
									$linkartikel=$linksub."/berita/".$noart."/".$linkart; ?>
									<div style="background:url(<?php echo $resize->ubah($gamart,240,240);?>)" class="artgambarside">
									<div class="artgambarsidespasi"></div><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><h3 class="artgambarsidejudul"><?php echo $judart;?></h3></a></div><?php
								} 
							}
							elseif ($layouttampilan=="baris1") {  ?>
								<ul><?php
								$dbot=array();
								if (!is_dir(DIR_CACHE.$subdomain)){
									mkdir(DIR_CACHE.$subdomain,0755);
								}
							
								if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
									$dbot=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
								}
							
								if (empty($dbot)){
									$query=$db->query("SELECT no,judul,link FROM berita WHERE publish='1' AND subdomain='$subdomain' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,$limit");
									$dbot=$query->rows;
									$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dbot));
								}
								
								foreach($dbot as $data) {
									$noart=$data['no'];
									$judart=$data['judul'];
									$linkart=$data['link'];
									$linkartikel=$linksub."/berita/".$noart."/".$linkart; ?>
									<li><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php echo $judart;?></a></li><?php
								}  ?>
								</ul><?php
							}
							else {
								$dbot=array();
								if (!is_dir(DIR_CACHE.$subdomain)){
									mkdir(DIR_CACHE.$subdomain,0755);
								}
							
								if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno)){
									$dbot=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno),true);
								}
							
								if (empty($dbot)){
									$query=$db->query("SELECT no,judul,link,isi,gambar,tampilkan_tanggal,DATE_FORMAT(tgl,'%d/%m/%Y') as tanggal FROM berita WHERE publish='1' AND subdomain='$subdomain' AND kategori LIKE '%,$idkat,%' ORDER BY tgl DESC LIMIT 0,$limit");
									$dbot=$query->rows;
									$filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_terbaru_kategori.'.$layoutno,json_encode($dbot));
								}
						
								foreach($dbot as $data) { 
									$noart=$data['no'];
									$judart=$data['judul'];
									$linkart=$data['link'];
									$isiart=$data['isi'];
									$gamart=$data['gambar'];
									$linkartikel=$linksub."/berita/".$noart."/".$linkart;
									$linkgambar=$domain."/thumbkecil.php?gambar=".$gamart;
									$tanggalart=$data['tanggal']; ?>
									<div class="panel_list" style="line-height:24px;">
										<a href="//<?php echo $linkartikel;?>/" title="<?php echo $judart;?>"><?php
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
		}
		else { 
			header("location:index.php"); 
		}
}
else { 
	header("location:index.php"); 
}
?>