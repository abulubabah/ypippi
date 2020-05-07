<?php  
class publik {
	public $domain;
	public $link;   
	public $no;
	public $linkhal;
	public $act;
	public $kategori;
	public $page;
	public $base_folder='';
	public $resize;
	public $db;
	
	public function __construct(){
	    $this->resize=new Resize();
	    $this->filemanager=new FileManager();
	    global $db;
	    $this->db=$db;
	}
	
	function get_variable() {
		if (empty($_GET['link'])) { $link=""; } else { $link=strtok($_GET['link'],"'"); }
		if (empty($_GET['no'])) { $no=""; } else { $no=strtok($_GET['no'],"'"); }
		if (empty($_GET['linkhal'])) { $linkhal=""; } else { $linkhal=strtok($_GET['linkhal'],"'"); }
		if (empty($_GET['act'])) { $act=""; } else { $act=strtok($_GET['act'],"'"); }
		if (empty($_GET['kategori'])) { $kategori=""; } else { $kategori=strtok($_GET['kategori'],"'"); }
		if (empty($_GET['page'])) { $page=""; } else { $page=strtok($_GET['page'],"'"); }	
		$this->domain="www.ypippijkt.sch.id/cms";
		$this->link=$link;
		$this->no=$no;
		$this->linkhal=$linkhal;
		$this->act=$act;
		$this->kategori=$kategori;
		$this->page=$page;
		$this->base_folder="";
	}

	function uri($param){
		$url=substr($_SERVER['REQUEST_URI'],1);
		if (isset($url[$param])){
			return $param;
		}
	}

	function artikel_list ($subdomain,$linksub,$bahasa,$tabel,$halamantipe,$halamanidtipe) {
		$publik=new publik();
		$publik->get_variable();
		$domain=$publik->domain;		
		$link=$publik->link;
		$page=$publik->page;
		$no=$publik->no;		
		if ($halamantipe=="home") { $link="berita"; } else { $link=$publik->link; }
		if ($halamantipe=="berita_kategori") { 
			if ($halamanidtipe=="" or $halamanidtipe=="0") {
				$querytambahan=" "; 
				$kategori="";
				$link=$link;
			}
			else {
				$querytambahan=" AND kategori LIKE '%,$halamanidtipe,%' "; 
				$qkat=mysqli_query($koneksi, "SELECT link FROM berita_kategori WHERE no='$halamanidtipe'");
				$dkat=mysqli_fetch_array($qkat);
				$kategori=$dkat['link'];
				$link=$link;
			}
		}
		elseif ($halamantipe=="berita_semua") { 			
			$querytambahan=" AND judul LIKE '%$halamanidtipe%' "; 
			$kategori="";
			$link=$link; 
		}
		elseif ($halamantipe=="cari") { 			
			$querytambahan=" AND judul LIKE '%$halamanidtipe%' "; 
			$kategori="";
			$link="berita"; 
		} 
		else { 			
			$querytambahan=""; 
			$kategori="";
			$link="berita"; 
		}
		$query=mysqli_query($koneksi, "SELECT no FROM $tabel WHERE publish='1' AND subdomain='$subdomain' $querytambahan");
		$jumlah=mysqli_num_rows($query); 
		if ($jumlah==0) { $publik->terjemahkan("Halaman Tidak Ada",$bahasa); }
		else {
			$batas=10;
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; $page=$page; }
			$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE publish='1' AND subdomain='$subdomain' $querytambahan ORDER BY tgl DESC LIMIT $posisi,$batas");
			while ($data=mysqli_fetch_array($query)) { 
				$nomor=$data['no'];
				$judul=$data['judul'];
				$linkhal=$data['link'];
				$tgl=$data['tgl'];
				$gambar=$data['gambar'];
				$isi=$data['isi']; $isi=str_replace("’","",$isi); $isi=str_replace("–","",$isi);
				$kata_kunci=$data['kata_kunci'];
				$jumbaca=$data['jumlah_pembaca'];
				$jumkomentar=$data['jumlah_pembaca'];
				$tampilkan_judul=$data['tampilkan_judul'];
				$tampilkan_tanggal=$data['tampilkan_tanggal'];
				$tampilkan_isi=$data['tampilkan_isi'];
				$tampilkan_gambar=$data['tampilkan_gambar'];
				$tampilkan_pembaca=$data['tampilkan_pembaca'];
				$tampilkan_katakunci=$data['tampilkan_katakunci']; 
				$tampilkan_berbagi=$data['tampilkan_berbagi']; 
			     //$this->resize->ubah($gambar,240,240);
				$linkartikel=$linksub."/".$tabel."/".$nomor."/".$linkhal; ?>
				<article style="padding-bottom:15px; display:table; width:100%;"><?php
					if($tampilkan_judul==0){ } else { ?><h3><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h3><?php }
					if($tampilkan_gambar==0){ } else { if ($gambar=="") { } else { ?><img data-src="<?php echo $this->resize->ubah($gambar,240,240);?>" alt="<?php echo $judul;?>" class="gambarkecil" align="left"/><?php } }
					if($tampilkan_isi==0){ } else { $isi=strip_tags($isi); $kalimat=strtok($isi,"  "); for ($i=1;$i<=40;$i++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); } }
					if($tampilkan_pembaca==0){ } else { $publik->pembaca($tabel,$nomor,$jumbaca,$jumkomentar,$bahasa); }
					if($tampilkan_katakunci==0){ } else { $publik->kata_kunci($subdomain,$linksub,$kata_kunci); } ?>
				</article><?php
			} 
			if ($no=="") { $linkmodule=$linksub."/".$link; } 
			elseif ($no=="1") { $linkmodule=$linksub."/".$link; }
			else { $linkmodule=$linksub."/".$link; }
			$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
		} 
	}
	
	
	function artikel_view ($subdomain,$linksub,$bahasa,$tabel,$nomor) {
		$publik=new publik();
		$publik->get_variable();
		$domain=$publik->domain;
		$link=$publik->link;
		if (!is_dir(DIR_CACHE.$subdomain)){
			mkdir(DIR_CACHE.$subdomain,0755);
		}
		if ($nomor==0) { $publik->terjemahkan("Halaman Tidak Ada",$bahasa); }
		else {
		    $data=array();
			if (file_exists(DIR_CACHE.$subdomain.'/cache.tulis.'.$tabel.'.'.$nomor)){
				$data=json_decode($this->filemanager->get(DIR_CACHE.$subdomain.'/cache.tulis.'.$tabel.'.'.$nomor),true);
			}
			
			if(empty($data)){
			    $query=$this->db->query("SELECT * FROM $tabel WHERE no='$nomor' AND subdomain='$subdomain' AND publish='1' ");
			    $data=$query->row;
			    $this->filemanager->set(DIR_CACHE.$subdomain.'/cache.tulis.'.$tabel.'.'.$nomor,json_encode($data));
			}
			
			if (!$data) { $publik->terjemahkan("Halaman Tidak Ada",$bahasa); }
			else {
				$nomor=$data['no'];
				$judul=$data['judul'];
				$linkhal=$data['link'];
				$tgl=$data['tgl'];
				$gambar=$data['gambar'];
				$isi=$data['isi']; $isi=str_replace("”","",$isi); $isi=str_replace("’","",$isi); $isi=str_replace("–","",$isi);
				$kata_kunci=$data['kata_kunci'];
				$jumbaca=$data['jumlah_pembaca'];
				$jumkomentar=$data['jumlah_pembaca'];
				$tampilkan_judul=$data['tampilkan_judul'];
				$tampilkan_tanggal=$data['tampilkan_tanggal'];
				$tampilkan_isi=$data['tampilkan_isi'];
				$tampilkan_gambar=$data['tampilkan_gambar'];
				$tampilkan_komentar=$data['tampilkan_komentar'];
				$tampilkan_formulir=$data['tampilkan_formulir'];
				$tampilkan_pembaca=$data['tampilkan_pembaca'];
				$tampilkan_katakunci=$data['tampilkan_katakunci']; 
				$tampilkan_berbagi=$data['tampilkan_berbagi']; 
if ($tabel=="halaman") { $linkartikel=$linksub."/".$linkhal; }
else {	$linkartikel=$linksub."/".$tabel."/".$nomor."/".$linkhal; }
				$linkgambar=$domain."/picture/".$gambar;
				$linkthumnail=$domain."/picure/".$gambar;
				$jumpembacabaru=$data['jumlah_pembaca']+1;
				mysqli_query($koneksi, "UPDATE $tabel SET jumlah_pembaca='$jumpembacabaru' WHERE no='$nomor'"); 
				if($tampilkan_judul==0){ } else { ?><h2><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h2><?php }
				if($tampilkan_gambar==0) { } else {  if ($gambar=="") { } else { ?><div class="gallery clearfix"><a href="//<?php echo $linkgambar;?>" rel="prettyPhoto[gallery1]"  title="<?php echo $judul;?>"><img data-src="<?php echo $this->resize->ubah($gambar,420,420);?>" alt="<?php echo $judul;?>" class="gambarbesar" align="left"/></a></div><?php  }	}
				if($tampilkan_isi==0){ } else { echo $isi."<br/>"; }
				if($tampilkan_pembaca==0){ } else { $publik->pembaca($tabel,$nomor,$jumbaca,$jumkomentar,$bahasa); }
				if($tampilkan_berbagi==0){ } else { $publik->berbagi(); }
				if($tampilkan_katakunci==0){ } else { $publik->kata_kunci($subdomain,$linksub,$kata_kunci); }
				if($tampilkan_komentar==0){ } else { $publik->komentar_list($subdomain,$linksub,$bahasa,$tabel,$nomor); }
				if($tampilkan_formulir==0){ } else { $publik->komentar_form($subdomain,$linksub,$bahasa,$tabel,$tabel,$nomor,$linkhal); } ?>
				<script type="text/javascript" charset="utf-8" src="//storage.googleapis.com/s.mysch.id/js/jquery.prettyPhoto.js"></script>
        		<link rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/js/prettyPhoto.css"/>
        		<script type="text/javascript" charset="utf-8">
        			$(document).ready(function(){
        				$("area[rel^='prettyPhoto']").prettyPhoto();				
        				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_rounded',slideshow:3000, autoplay_slideshow: false});
        			//	$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',slideshow:10000, hideflash: true});		
        			});
        		</script><?php
			}
		}
	}
	

	function pembaca ($tabel,$nomor,$jumbaca,$jumkomentar,$bahasa) { 
		$publik=new publik();
		$qkomen=mysqli_query($koneksi, "SELECT no FROM komentar WHERE id_$tabel='$nomor'"); $jumkomen=mysqli_num_rows($qkomen); ?>
		<h6><?php echo $jumbaca;?> <?php $publik->terjemahkan("Pembaca",$bahasa);?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $jumkomen;?> <?php $publik->terjemahkan("Komentator",$bahasa);?></h6><?php 
	}
	
	
	function berbagi() { 
?>
		<div style="display:table; width:100%; margin-top:10px;">
		    <h5>Share :</h5>
		    <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57d26e4d3382de5c"></script>
			<!-- Go to www.addthis.com/dashboard to customize your tools -->
            <div class="addthis_inline_share_toolbox"></div>
		</div>
		
		<?php
	}
	
	
	function kata_kunci ($subdomain,$linksub,$kata_kunci) {?>
		<h5>
			<b>Tag : </b><?php 
			$tag=explode(", ",$kata_kunci);
			$jumtag=count($tag);
			for($i=0;$i<$jumtag;$i++){
				$hurufkecil=strtolower($tag[$i]);
				$gantilink=str_replace(" ","-","$hurufkecil"); 
				$linktag=$linksub."/cari/".$gantilink."/";?>
				<a href="//<?php echo $linktag;?>" title="<?php echo $tag[$i];?>"><?php echo $tag[$i];?></a><?php
				if ($jumtag>1) { echo ", "; } else { } 
			} ?>
		</h5><?php				
	}
	
	
	function komentar_list ($subdomain,$linksub,$bahasa,$tabel,$no) {
		$publik=new publik();
		$publik->get_variable();
		$domain=$publik->domain;
		$kolom="id_".$tabel;
		$qkom=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%Y %H:%i:%s') as tanggal FROM komentar WHERE $kolom='$no' AND no_komentar='0' AND publish='1'  ORDER BY tgl");
		$jumkom=mysqli_num_rows($qkom);
		if ($jumkom==0) { ?><br/><?php } 
		else { ?>
			<br/><h3><?php $publik->terjemahkan("Komentar",$bahasa);?></h3><?php
			while ($dkom=mysqli_fetch_array($qkom)) { 
				$no=$dkom['no'];
				$nama=$dkom['nama'];
				$komentar=$dkom['komentar'];
				$emailkom=$dkom['email'];
				$tanggal=$dkom['tanggal'];
				//$quserkom=mysqli_query($koneksi, "SELECT gambar FROM user WHERE email='$emailkom'");
				//$duserkom=mysqli_fetch_array($quserkom);
				//$gambarkom=$duserkom['gambar'];
				//if ($gambarkom=="") { $gambarkomen="guest.gif"; } else { $gambarkomen=$gambarkom; }
				$gambarkomen="guest.png"; ?> 
				<div class="komentar" id="<?php echo $no;?>" >
					<img data-src="/<?php echo $domain;?>/picture/<?php echo $gambarkomen;?>" alt="gambar" align="left" style="margin:5px 10px 5px 0px; width:70px; height:70px; border:1px solid #CCCCCC;"/>
					<h4><?php echo $nama;?></h4>
					<h6><?php $publik->terjemahkan("Tanggal",$bahasa);?> : <?php echo $tanggal;?></h6><?php 
					$kalimat=nl2br($komentar); echo ($kalimat); echo ("  "); ?>
				</div><?php
				$qreply=mysqli_query($koneksi, "SELECT no,nama,email,komentar,DATE_FORMAT(tgl,'%d-%m-%Y %H:%i:%s') as tanggal FROM komentar WHERE no_komentar='$no' AND publish='1'  ORDER BY tgl");
				$jumreply=mysqli_num_rows($qreply);
				if ($jumreply==0) { }
				else { ?>
					<div style="margin-left:70px;">
					<h6><?php $publik->terjemahkan("Balasan",$bahasa);?></h6><?php
					while ($dreply=mysqli_fetch_array($qreply)) { 
						$noreply=$dreply['no'];
						$judulreply=$dreply['nama'];
						$emailreply=$dreply['email'];
						$komentarreply=$dreply['komentar'];
						//$quserreply=mysqli_query($koneksi, "SELECT * FROM user WHERE username='$emailreply'");
						//$duserreply=mysqli_fetch_array($quserreply);
						//$gambarreply=$duserreply['gambar'];
						//if ($gambarreply=="") { $gambarbalasan="guest.gif"; } else { $gambarbalasan=$gambarreply; }
						$gambarbalasan="guest.png";
						$tanggalreply=$dreply['tanggal']; ?>
						<div class="komentar" id="<?php echo $noreply;?>">
							<img data-src="<?php echo $this->resize->ubah($gambarbalasan,70,70);?>" align="left" style="margin:2px 10px 5px 0px; width:70px; height:70px; border:1px solid #CCCCCC;" alt="gambar"/>
							<b><?php echo $judulreply;?></b>
							<h6><?php $publik->terjemahkan("Tanggal",$bahasa);?> <?php echo $tanggalreply;?></h6><?php
							$kalimatreply=nl2br($komentarreply); echo ($kalimatreply); echo ("  "); ?>
						</div><?php
					} ?>
					</div><?php
				}
			} ?>
			<br/><?php
		}
	}
	
	
	function komentar_form ($subdomain,$linksub,$bahasa,$tabel,$link,$no,$linkhal) {
		$publik=new publik();
		$publik->get_variable(); ?>
		<h3><?php $publik->terjemahkan("Kirim Pesan Anda",$bahasa);?></h3>
		<form action="//<?php echo $linksub."/".$link."/".$no."/".$linkhal;?>/komentar/" method="post">
			<input type="hidden" name="proses" value="komentar"/>
			<input type="hidden" name="tabel" value="<?php echo $tabel;?>"/>
			<input type="hidden" name="link" value="<?php echo $link;?>"/>
			<input type="hidden" name="no" value="<?php echo $no;?>"/>
			<input type="hidden" name="linkhal" value="<?php echo $linkhal;?>"/>
			<p><label><?php $publik->terjemahkan("Nama",$bahasa);?><br/><input type="text" name="nama" id="nama" maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p>
			<p><label><?php $publik->terjemahkan("Telepon",$bahasa);?><br/><input type="tel" name="telepon" id="telepon" maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p>
<?php if ($subdomain=="sman1jasinga.sch.id") { }
else { ?>		
<p><label><?php $publik->terjemahkan("Email",$bahasa);?><br/><input type="email" name="emailmu" id="emailmu" maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p><?php } ?>

			<p><label><?php $publik->terjemahkan("Komentar",$bahasa);?><br/><textarea name="komentar" id="komentar" style="width:95%; max-width:400px; margin:5px 0px;" rows="8" required></textarea></label></p>
			<p><input type="submit" value="<?php $publik->terjemahkan("KIRIM",$bahasa);?>" onClick="return cekkomentar();" class="button" style="margin:5px 0px;"/></p>
		</form><?php
		$randkode=rand(111111,999999); 
		$_SESSION["kode"]=$randkode;
	}
	
	
	function komentar_send ($subdomain,$linksub,$bahasa) { 
		$publik=new publik();
		$publik->get_variable();
		$domain=$publik->domain;
		if (empty($_POST['proses'])) { $publik->terjemahkan("Maaf, Session Habis",$bahasa); }
		else {
			if (empty($_SESSION['kode'])) { $publik->terjemahkan("Maaf, Session Habis",$bahasa); }
			else {
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				$tabel=strip_tags($_POST['tabel']);
				$link=strip_tags($_POST['link']);
				$no=strip_tags($_POST['no']);
				$linkhal=strip_tags($_POST['linkhal']);
				$nama=strip_tags($_POST['nama']);
				$telepon=strip_tags($_POST['telepon']);
				$emailmu=strip_tags($_POST['emailmu']);
				$komentar=strip_tags($_POST['komentar']);
				$id_tabel="id_".$tabel;
				mysqli_query($koneksi, "INSERT INTO komentar (subdomain,$id_tabel, nama, telepon, email, komentar, tgl, publish) VALUES ('$subdomain', '$no', '$nama', '$telepon', '$emailmu', '$komentar', sysdate(), '0')");
				$qkon=mysqli_query($koneksi, "SELECT username FROM setting WHERE subdomain='$subdomain'");
				$dkon=mysqli_fetch_array($qkon);
				$emailtuju=$dkon['username'];
				$header="From: $nama <$emailmu> \r\n";
			//	mail($emailtuju, "Komentar Dari $nama | $telepon", $komentar, $header);  ?>
				<h3><?php $publik->terjemahkan("Terima Kasih Atas Komentar Anda",$bahasa); ?></h3><?php
			}
		}
	}
	
	function galeri_list ($subdomain,$linksub,$bahasa,$kategori,$nokategori) {
		$tabel="galeri";
		$publik=new publik();
		$publik->get_variable();
		$domain=$publik->domain;		
		$link=$publik->link;
		$no=$publik->no;		
		$page=$publik->page;
		$linkgambar=$domain."/picture/"; $kolom=4; $batas=50;
		$lebar=100/$kolom;
		if ($kategori=="") { 
			$qalbum=mysqli_query($koneksi, "SELECT no FROM galeri_kategori WHERE publish='1' AND subdomain='$subdomain'");
			$jumalbum=mysqli_num_rows($qalbum); 
			if ($jumalbum==0) { 
				$query=mysqli_query($koneksi, "SELECT no FROM galeri WHERE publish='1' AND subdomain='$subdomain'");
				$jumlah=mysqli_num_rows($query); 
				if ($jumlah==0) { $publik->terjemahkan("Gambar Tidak Ada",$bahasa); }
				else { 
					$i=0;
					if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; $page=$page; }?>
					<table width="100%" class="gallery clearfix"><?php
					$query=mysqli_query($koneksi, "SELECT judul,gambar FROM galeri WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT $posisi,$batas");
					
					while ($data=mysqli_fetch_array($query)) { 
						$judul=$data['judul'];
						if ($data['gambar']=="") { $gambar="blank.jpg"; } else { $gambar=$data['gambar']; }
						if ($i%$kolom==0) { ?><tr valign="top"><?php } ?>
							<td align="center" width="<?php echo $lebar;?>%" style="padding:10px;">
								<a href="//<?php echo $linkgambar.$gambar;?>" rel="prettyPhoto[gallery1]" title="<?php echo $judul;?>">
									<img data-src="<?php echo $this->resize->ubah($gambar,180,180);?>" alt="<?php echo $judul;?>" width="100%" class="gambargaleri"/><br/><?php echo $judul; ?>
								</a>
							</td><?php
						if (($i%$kolom)==($kolom-1) or ($i+1)==$jumlah) { ?></tr><?php }
						$i++;
					} ?>
					</table><?php
					if ($no=="") { $linkmodule=$linksub."/".$link; } 
					elseif ($no=="1") { $linkmodule=$linksub."/".$link; }
					else { $linkmodule=$linksub."/".$link; }
					$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
				}
			}
			else { 
				$qalbum=mysqli_query($koneksi, "SELECT no FROM galeri_kategori WHERE publish='1' AND subdomain='$subdomain'");
				$jumalbum=mysqli_num_rows($qalbum); 
				if ($jumalbum==0) { $publik->terjemahkan("Gambar Tidak Ada",$bahasa); }
				else { 
					$i=0;
					if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; $page=$page; } ?>
					<table width="100%"><?php
					$qalbum=mysqli_query($koneksi, "SELECT no,judul,link FROM galeri_kategori WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT $posisi,$batas");
					while ($dalbum=mysqli_fetch_array($qalbum)) { 
						$noalbum=$dalbum['no'];
						$judulalbum=$dalbum['judul'];
						$linkalbum=$dalbum['link'];
						$qjumfoto=mysqli_query($koneksi, "SELECT no FROM galeri WHERE publish='1' AND id_galeri_kategori='$noalbum' AND subdomain='$subdomain'");
						$jumfoto=mysqli_num_rows($qjumfoto); 
						$query=mysqli_query($koneksi, "SELECT gambar FROM galeri WHERE publish='1' AND id_galeri_kategori='$noalbum' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT $posisi,$batas");
						$data=mysqli_fetch_array($query);
						$linkgaleri=$linksub."/album/".$noalbum."/".$linkalbum;
						if ($data['gambar']=="") { $gambar="blank.jpg"; } else { $gambar=$data['gambar']; }
						if ($i%$kolom==0) { ?><tr valign="top"><?php } ?>
							<td align="center" width="<?php echo $lebar;?>%" style="padding:10px;">
								<a href="//<?php echo $linkgaleri;?>/" title="<?php echo $judulalbum;?>"> 
									<img data-src="<?php echo $this->resize->ubah($gambar,180,180);?>" alt="<?php echo $judulalbum;?>" width="100%" class="gambargaleri"/><br/><?php echo $judulalbum; ?></a>
								<h6>(<?php echo $jumfoto;?> Foto)</h6>
							</td><?php
						if (($i%$kolom)==($kolom-1) or ($i+1)==$jumalbum) { ?></tr><?php }
						$i++;
					} ?>
					</table><?php
					if ($no=="") { $linkmodule=$linksub."/".$link; } 
					elseif ($no=="1") { $linkmodule=$linksub."/".$link; }
					else { $linkmodule=$linksub."/".$link; }
					$publik->paging($linkmodule,$jumalbum,$batas,$page,$kategori);
				}
			}
		}
		else { 	
			$query=mysqli_query($koneksi, "SELECT no FROM galeri WHERE id_galeri_kategori='$nokategori' AND subdomain='$subdomain' AND publish='1' ");
			$jumlah=mysqli_num_rows($query); 
			if ($jumlah==0) { $publik->terjemahkan("Gambar Tidak Ada",$bahasa); }
			else {
				$i=0;
				if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; $page=$page; }  ?>
				<table width="100%" class="gallery clearfix"><?php
				$query=mysqli_query($koneksi, "SELECT judul,gambar FROM galeri WHERE id_galeri_kategori='$nokategori' AND subdomain='$subdomain' AND publish='1'  ORDER BY tgl DESC LIMIT $posisi,$batas");
				while ($data=mysqli_fetch_array($query)) { 
					$judul=$data['judul'];
					if ($data['gambar']=="") { $gambar="blank.jpg"; } else { $gambar=$data['gambar']; }
					if ($i%$kolom==0) { ?><tr valign="top"><?php } ?>
						<td align="center" width="<?php echo $lebar;?>%" style="padding:10px;">
							<a href="//<?php echo $linkgambar.$gambar;?>" rel="prettyPhoto[gallery1]" title="<?php echo $judul;?>">
								<img data-src="<?php echo $this->resize->ubah($gambar,180,180);?>" alt="<?php echo $judul;?>" width="100%" class="gambargaleri"/><h4><?php echo $judul; ?></h4>
							</a>
						</td><?php
					if (($i%$kolom)==($kolom-1) or ($i+1)==$jumlah) { ?></tr><?php }
					$i++;
				} ?>
				</table><?php
				if ($no=="") { $linkmodule=$linksub."/".$link; } 
				elseif ($no=="1") { $linkmodule=$linksub."/".$link; }
				else { $linkmodule=$linksub."/".$link; } 
				$publik->paging($linkmodule,$jumlah,$batas,$page,$kategori);
			}
		}
	}

	
	
	function terjemahkan($kata,$bahasa) { 
		switch ($kata) {
			case "selengkapnya"; if ($bahasa=="en") { $hasil="read more"; } else { $hasil=$kata; }  break;
			case "Artikel"; if ($bahasa=="en") { $hasil="Article"; } else { $hasil=$kata; }  break;
			case "Berita"; if ($bahasa=="en") { $hasil="News"; } else { $hasil=$kata; }  break;
			case "Oleh"; if ($bahasa=="en") { $hasil="By"; } else { $hasil=$kata; }  break;
			case "Tanggal"; if ($bahasa=="en") { $hasil="Date"; } else { $hasil=$kata; }  break;
			case "Balasan"; if ($bahasa=="en") { $hasil="Reply"; } else { $hasil=$kata; }  break;
			case "Pembaca"; if ($bahasa=="en") { $hasil="Viewers"; } else { $hasil=$kata; }  break;
			case "Form Pencarian"; if ($bahasa=="en") { $hasil="Search"; } else { $hasil=$kata; }  break;
			case "Kata Kunci"; if ($bahasa=="en") { $hasil="Keyword"; } else { $hasil=$kata; }  break;
			case "Pencarian"; if ($bahasa=="en") { $hasil="Search"; } else { $hasil=$kata; }  break;
			case "Hasil Pencarian"; if ($bahasa=="en") { $hasil="Result"; } else { $hasil=$kata; }  break;
			case "Produk"; if ($bahasa=="en") { $hasil="Product"; } else { $hasil=$kata; }  break;
			case "Jumlah"; if ($bahasa=="en") { $hasil="Quantity"; } else { $hasil=$kata; }  break;
			case "Galeri"; if ($bahasa=="en") { $hasil="Gallery"; } else { $hasil=$kata; }  break;
			case "Halaman Tidak Ada"; if ($bahasa=="en") { $hasil="Page Not Found"; } else { $hasil=$kata; }  break;
			case "Deskripsi"; if ($bahasa=="en") { $hasil="Description"; } else { $hasil=$kata; }  break;
			case "Harga"; if ($bahasa=="en") { $hasil="Price"; } else { $hasil=$kata; }  break;
			case "Formulir Order"; if ($bahasa=="en") { $hasil="Form Order"; } else { $hasil=$kata; }  break;
			case "Kirim Pesan Anda"; if ($bahasa=="en") { $hasil="Send Message"; } else { $hasil=$kata; }  break;
			case "Nama"; if ($bahasa=="en") { $hasil="Name"; } else { $hasil=$kata; }  break;
			case "Alamat"; if ($bahasa=="en") { $hasil="Address"; } else { $hasil=$kata; }  break;
			case "Kota"; if ($bahasa=="en") { $hasil="City"; } else { $hasil=$kata; }  break;
			case "Telepon"; if ($bahasa=="en") { $hasil="Phone"; } else { $hasil=$kata; }  break;
			case "Email"; if ($bahasa=="en") { $hasil="Email"; } else { $hasil=$kata; }  break;
			case "Komentar"; if ($bahasa=="en") { $hasil="Comment"; } else { $hasil=$kata; }  break;
			case "Komentator"; if ($bahasa=="en") { $hasil="Comments"; } else { $hasil=$kata; }  break;
			case "Keterangan"; if ($bahasa=="en") { $hasil="Note"; } else { $hasil=$kata; }  break;
			case "KIRIM"; if ($bahasa=="en") { $hasil="SUBMIT"; } else { $hasil=$kata; }  break;
			case "Maaf, Session Habis"; if ($bahasa=="en") { $hasil="Sorry, Your Session Is Wrong"; } else { $hasil=$kata; }  break;
			case "Maaf, Email Anda Tidak Valid"; if ($bahasa=="en") { $hasil="Sorry, Your Email Is Not Valid"; } else { $hasil=$kata; }  break;
			case "Pesanan Anda Berhasil Dikirim"; if ($bahasa=="en") { $hasil="Your Order Has Been Saved"; } else { $hasil=$kata; }  break;
			case "Terima Kasih Atas Komentar Anda"; if ($bahasa=="en") { $hasil="Thanks For Your Comment"; } else { $hasil=$kata; }  break;
			case "Gambar Tidak Ada"; if ($bahasa=="en") { $hasil="Picture Not Found"; } else { $hasil=$kata; }  break;
		}
		echo $hasil;
	}
	
	
	
	function paging($linkmodule,$jumlah,$batas,$page,$kategori) { 
		$publik=new publik();
		$publik->get_variable(); 
		$link=$publik->link; 
		$linkhalaman=$linkmodule; 
		$jumhal=ceil($jumlah/$batas);
		$linkhal=$linkhalaman."/page";?>
		<div style="display:table; width:100%;">
			<div style="float:left; width:200px"><?php
				if ($page<=1) { } else { $prev=$page-1; ?><h6><a href="//<?php echo $linkhal."/".$prev;?>/" title="Sebelumnya">Sebelumnya</a></h6><?php } ?>
			</div>
			<div style="float:right; text-align:right; width:200px"><?php
				if ($page>=$jumhal){ } else { $next=$page+1; ?><h6><a href="//<?php echo $linkhal."/".$next;?>/" title="Selanjutnya">Selanjutnya</a></h6><?php } ?>
			</div>
		</div><?php
	}
	
}

?>