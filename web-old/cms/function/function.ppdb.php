<?php  
class ppdb {
	public $domain;
	public $link;  
	public $no;
	public $linkhal;
	public $act;
	public $kategori;
	public $page;
	
	public $resize;
	
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
		$this->domain="www.ypippijkt.localhost/cms";
		$this->link=$link;
		$this->no=$no;
		$this->linkhal=$linkhal;
		$this->act=$act;
		$this->kategori=$kategori;
		$this->page=$page;
		$this->base_folder="";
	}



	function artikel_list ($subdomain,$linksub,$bahasa,$tabel,$halamantipe,$halamanidtipe) {
		
		$this->get_variable();
		$domain=$this->domain;		
		$link=$this->link;
		$page=$this->page;
		$no=$this->no;		
		$link=$this->link; $link="pengumuman";	
		$query=mysqli_query($koneksi, "SELECT no FROM $tabel WHERE publish='1' AND subdomain='$subdomain' $querytambahan");
		$jumlah=mysqli_num_rows($query); 
		if ($jumlah==0) { echo "Maaf, Halaman Tidak Ada"; }
		else {
			$batas=10;
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; $page=$page; }
			$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC LIMIT $posisi,$batas");
			while ($data=mysqli_fetch_array($query)) { 
				$nomor=$data['no'];
				$judul=$data['judul'];
				$linkhal=$data['link'];
				$tgl=$data['tgl'];
				$gambar=$data['gambar'];
				$isi=$data['isi']; $isi=str_replace("’","",$isi); $isi=str_replace("–","",$isi);
				$kata_kunci=$data['kata_kunci'];
				$linkartikel=$linksub."/".$link."/".$nomor."/".$linkhal; ?>
				<article style="padding-bottom:15px; display:table; width:100%;">
					<h3><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h3>
					<?php if ($gambar=="") { } else { ?><img src="<?php echo $this->resize->ubah($gambar,240,240);?>" alt="<?php echo $judul;?>" class="gambarkecil" align="left"/><?php } ?>
					<?php $isi=strip_tags($isi); $kalimat=strtok($isi,"  "); for ($i=1;$i<=40;$i++) { echo ($kalimat);echo ("  "); $kalimat=strtok ("  "); } ?>
				</article><?php
			} 
			if ($no=="") { $linkmodule=$linksub."/".$link; } 
			elseif ($no=="1") { $linkmodule=$linksub."/".$link; }
			else { $linkmodule=$linksub."/".$link; }
			$this->paging($linkmodule,$jumlah,$batas,$page,$kategori);
		} 
	}
	
	
	function artikel_view ($subdomain,$linksub,$bahasa,$tabel,$nomor) {
		$this->get_variable();
		$domain=$this->domain;
		$link=$ppdb->link;
		if (!is_dir(DIR_CACHE.$subdomain)){
			mkdir(DIR_CACHE.$subdomain,0755);
		}
		if ($nomor==0) { echo "Maaf, Halaman Tidak Ada"; }
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
			if (!$data) { echo "Halaman Tidak Ada"; }
			else {
				$nomor=$data['no'];
				$judul=$data['judul'];
				$linkhal=$data['link'];
				$tgl=$data['tgl'];
				$gambar=$data['gambar'];
				$isi=$data['isi']; $isi=str_replace("”","",$isi); $isi=str_replace("’","",$isi); $isi=str_replace("–","",$isi);
				$kata_kunci=$data['kata_kunci'];
				$linkartikel=$linksub."/".$tabel."/".$nomor."/".$linkhal;
				$linkgambar=$domain."/picture/".$gambar;
				$linkthumnail=$domain."/picure/".$gambar; ?>				
				<h2><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h2><?php
				if ($gambar=="") { } else { ?><div class="gallery clearfix"><a href="//<?php echo $linkgambar;?>" rel="prettyPhoto[gallery1]"  title="<?php echo $judul;?>"><img src="<?php echo $this->resize->ubah($gambar,420,420);?>" alt="<?php echo $judul;?>" class="gambarbesar" align="left"/></a></div><?php  }
				echo $isi."<br/>";?>
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
	
	
	
	
	
	function paging($linkmodule,$jumlah,$batas,$page,$kategori) { 
		$this->get_variable(); 
		$link=$this->link; 
		$linkhalaman=$linkmodule; 
		$jumhal=ceil($jumlah/$batas);
		$linkhal=$linkhalaman."/page";?>
		<div style="display:table; width:100%;">
			<div style="float:left; width:200px"><?php
				if ($page<=1) { } else { $prev=$page-1; ?><h6><a href="//<?php echo $linkhal."/".$prev;?>/" title="Selanjutnya">Selanjutnya</a></h6><?php } ?>
			</div>
			<div style="float:right; text-align:right; width:200px"><?php
				if ($page>=$jumhal){ } else { $next=$page+1; ?><h6><a href="//<?php echo $linkhal."/".$next;?>/" title="Sebelumnya">Sebelumnya</a></h6><?php } ?>
			</div>
		</div><?php
	}
	
}

?>