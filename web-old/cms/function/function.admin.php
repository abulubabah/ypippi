<?php
/* covert to php 5.6 standart at 8 november 2016 */  

/* update at 31-12-2017 01:34*/
/*add method send to google storage */

class admin { 
	public $domain; 
	public $mod;
	public $adm;
	public $no;
	public $act;
	public $order;
	public $by;
	public $page;
	
	public $labelisi;
	public $dataisi;

	public $actionkolom;
	public $actionisian;
	public $actionubah;

	public $formtipeisi;
	public $formtabelisi;
	private $linksub='';
	
	public $key;
	public $base_folder;
	
	private $resize;
	private $uploader;
	
	public function __construct(){
	    $this->resize=new Resize();
	    $this->uploader=new Uploader();
	}
	
	public function get_variable() {
		if (empty($_GET['mod'])) { $mod=""; } else { $mod=strtok($_GET['mod'],"'"); }
		if (empty($_GET['no'])) { $no=""; } else { $no=strtok($_GET['no'],"'"); }
		if (empty($_GET['act'])) { $act=""; } else { $act=strtok($_GET['act'],"'"); }
		if (empty($_GET['order'])) { $order=""; } else { $order=strtok($_GET['order'],"'"); }
		if (empty($_GET['key'])) { $key=""; } else { $key=strtok($_GET['key'],"'"); }
		if (empty($_GET['by'])) { $by=""; } else { $by=strtok($_GET['by'],"'"); }
		if (empty($_GET['page'])) { $page=""; } else { $page=strtok($_GET['page'],"'"); }		
		$this->domain="www.ypippijkt.localhost/cms";
		$this->adm="adm";
		$this->mod=$mod;
		$this->no=$no;
		$this->act=$act;
		$this->key=$key;
		$this->base_folder="";
		if ($order=="") { $this->order="tgl"; } else { $this->order=$order; } 
		$this->order;
		if ($by=="") { $this->by="asc"; } elseif ($by=="desc") { $this->by="desc"; } else  { $this->by="asc"; } 
		$this->page=$page;
	}
	
	public function setLinkSub($linksub){
		$this->linksub=$linksub;
	}
	
	public function getLinksub(){
		return $this->linksub;
	}
	
	public function html_decode($str){
		return html_entity_decode($str,ENT_QUOTES,'UTF-8');
	}
	
	public function html_encode($str){
		return htmlentities($str,ENT_QUOTES,'UTF-8');
	}
	
	public function clean($str,$gantispasi=false){
		$g1=str_replace("#","","$str");$g2=str_replace("~","","$g1");
		$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
		$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");
		$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
		$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");
		$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
		$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");
		$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
		$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");
		$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
		$g21=str_replace("]","","$g20");$g22=str_replace("","","$g21");
		$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
		$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");
		$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
		$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");
		$g31=str_replace("'","&quot;","$g30");$g32=str_replace(":","","$g31");$gantispasi=str_replace(" ","-","$g32");
		if ($gantispasi){
			return strtolower($gantispasi);
		}
		
		return $g31;
		
	}
	
	public function isSecure(){
	    return true;
		if ($this->getLinksub()=='demo.mysch.id'){
			return false;
		}
		
		if ($this->getLinksub()=='blog.mysch.id'){
			return false;
		}
		
		if ($this->getLinksub()=='smam3maduran.sch.id'){
			//return false;
		}
		
		if (preg_match('/mysch.id/',$this->getLinksub())){
			return false;
		}
		
		return true;
	}
	
	public function getHttp(){
		if ($this->isSecure()){
			return 'https';
		}
		return 'http';
	}
	
	public function tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact) {
				
		$domain=$this->domain;
		$adm=$this->adm;
		$mod=$this->mod;
		$orderby=$this->order;
		$by=$this->by;
		$page=$this->page;
		$linkmod=$linksub."/".$adm."/".$mod;
		$linkcari=$linkmod."/act/cari/";	
		$batas=$batas;
		if ($act=="") { $act="none"; } else { $act=$act; }	
		if ($act=="cari") { 
			$posisi=0; $page=1; 
			if (empty($_POST['keyword'])) { if (empty($orderby)) { $keycari=""; } else { $keycari=$orderby;  } } else { $keycari=strip_tags(mysql_escape_string($_POST['keyword'])); }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' AND subdomain='$subdomain'");
			if (!$qjum){
			    $qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE nama LIKE '%$keycari%' AND subdomain='$subdomain'");
			}
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' AND subdomain='$subdomain' ORDER BY judul");
			if (!$query){
			    $query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE nama LIKE '%$keycari%' AND subdomain='$subdomain' ORDER BY nama");
			}
			$linkpage=$linkmod."/act/".$act."/".$keycari."/".$by;
		}
		elseif($act=="urut") { 
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain' ORDER BY $orderby $by LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		else {
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain' ORDER BY $orderby DESC LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		$y=1; 
		$nomor=$posisi+1;
		$jumlah=mysqli_num_rows($qjum);
		if ($jumlah==0) { ?>
			<h2>
				<span style="float:left; margin-right:10px;">Tabel <?php echo $judulmod;?></span>
				<span style="font-size:11px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Tambah <?php echo $judulmod;?>" class="button_add">TAMBAH</a></span>
			</h2><?php
			$this->notify($subdomain,$linksub,"empty_write"); 
		}
		else { ?>
			<div style="display:table; width:100%;">
				<h2 style="float:left;">
					<span style="float:left; margin-right:10px;">Tabel <?php echo $judulmod;?></span>
					<span style="font-size:11px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Tambah <?php echo $judulmod;?>" class="button_add">TAMBAH</a></span>
				</h2>
				<div class="cari" style="margin-bottom:5px;">
					<form action="<?php echo $this->getHttp();?>://<?php echo $linkcari;?>" method="post">
						<input type="text" name="keyword" size="20" id="keyword" value="Pencarian" maxlength="30" onblur="if (this.value=='') this.value='Pencarian';" onfocus="if (this.value=='Pencarian') this.value='';"/>&nbsp;
						<input name="cari" type="submit" value="" onClick="return cekkeyword();" id="tombol" style="cursor:pointer"/>
					</form>
				</div>
			</div><?php
			$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
			$dset=mysqli_fetch_array($qset);
			$paket=$dset['paket']; $aktif=$dset['aktif'];
			if ($paket=="free") { 
			if ($aktif==0) {
			if ($mod=="halaman") { $maksimal=15; $warning=12; } else { $maksimal=30; $warning=25; }
			if ($jumlah>=$maksimal) { ?>
			<div style="background:#FFDDDD; padding:1%; margin:5px 0px;">
			<h3>Kapasitas <?php echo $judulmod;?> Sudah Penuh</h3>
			Maaf, Kapasitas <?php echo $judulmod;?> sudah melebihi batas paket Free.<br/>
			Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
			Klik <a href="<?php echo $this->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
			</div><?php
			}
			elseif ($jumlah>=$warning) { ?>
			<div style="background:#FFFFCC; padding:1%; margin:5px 0px;">
			<h3>Kapasitas <?php echo $judulmod;?> Hampir Penuh</h3>
			Jumlah <?php echo $judulmod;?> hampir melebihi batas maksimal Paket Free.<br/>
			Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
			Klik <a href="<?php echo $this->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
			</div><?php
			}
			}
			}
			?>
			<form action="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/hapusmulti/" method="post" name="form_tabel" onsubmit="konfirmHapus();return false;">
			<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
				<tr class="tabelhead">
					<th width="15"></th><?php
					$kolom=explode(",",$kolom);
					$lebar=explode(",",$lebar);
					$jumkolom=count($kolom);
					for($i=0;$i<$jumkolom;$i++){ 
						if ($kolom[$i]=="judul" or $kolom[$i]=="nama") { $width=""; } else { $width=$lebar[$i]; } 
						if ($kolom[$i]=="menu" or $kolom[$i]=="module") { $idurut="id_".$kolom[$i]; } else { $idurut=$kolom[$i]; } 
						if ($by=="desc") { $bybaru="asc"; } elseif ($by=="asc") { $bybaru="desc"; }
						$linkkolom=$linkmod."/act/urut/".$idurut."/".$bybaru."/"; ?>
						<th width="<?php echo $width;?>"><a href="<?php echo $this->getHttp();?>://<?php echo $linkkolom;?>" title="Urut <?php echo $kolom[$i];?>"><?php $this->label($kolom[$i]); echo $this->labelisi;?></a></th><?php 
					} 
					if ($kolomvisit!=1) { } else { ?><th width="50"><?php }
					if ($kolomkomen!=1) { } else { ?></th><th width="40"></th><?php }
					if ($kolomtgl!=1) { } else { ?><th width="60" style="text-align:right"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/urut/tgl/<?php echo $bybaru;?>/" title="Urut Tanggal">Tanggal</a></th><?php } ?>
				</tr><?php
			while($data=mysqli_fetch_array($query)) {
				$no=$data['no'];
				$pub=$data['publish'];
				$tanggal=$data['tanggal'];
				if ($y%2==0) { $latar="#FAFAFA"; } else { $latar="#FFFFFF"; } 
				if ($pub==0) { $latar="FFEEEE"; } else { $latar=$latar; } ?>
				<tr bgcolor="<?php echo $latar; ?>" align="left">
					<td align="center" style="padding:10px 0px;"><input name="cek[]" type="checkbox" value="<?php echo $no;?>"/></td><?php
					for($j=0;$j<$jumkolom;$j++){ ?>
						<td><?php $this->data($tabel,$kolom[$j],$no); echo $this->dataisi;
						if ($kolom[$j]=="judul" or $kolom[$j]=="nama") { ?>
							<div class="tombol"><?php
							$tombolaction=explode(",",$tombolact); $jumtombolact=count($tombolaction);
							for($k=0;$k<$jumtombolact;$k++){ $this->tombolaction($subdomain,$linkmod,$tombolaction[$k],$no,$pub,""); } ?>
							</div><?php
						}
						else { } ?>
						</td><?php 
					} 
					if ($kolomvisit!=1) { } 
					else { 
						$gambarvisit=$this->getHttp()."://".$domain."/image/visitor.png"; 
						$visitor=$data['jumlah_pembaca']; ?>
						<td align="right"><?php echo $visitor?><img src="<?php echo $gambarvisit;?>" style="margin:0px 0px 0px 4px;" align="right"/></td><?php
					}
					if ($kolomkomen!=1) { }
					else { 
						$gambarkomen=$this->getHttp()."://".$domain."/image/comment.png";
						$qkomen=mysqli_query($koneksi, "SELECT no FROM komentar WHERE id_$tabel='$no' AND subdomain='$subdomain'"); $jumkomen=mysqli_num_rows($qkomen); ?>
						<td align="right"><?php echo $jumkomen?><img src="<?php echo $gambarkomen;?>" style="margin:4px 0px 0px 4px;" align="right"/></td><?php
					}
					if ($kolomtgl!=1) { } else { ?><td align="right"><?php echo $tanggal; ?></td><?php } ?>
				</tr><?php
				$nomor++; $y++;
			} ?>
			</table>
			<div style="display:table; width:100%; padding:5px 0px; ">
				<div style="float:left; width:35%; text-align:left;"><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/check.png" title="Tandai Semua" alt="Tandai Semua" class="button_paging" onclick="checkAll();"/><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/uncheck.png" title="Hilangkan Tanda" alt="Hilangkan Tanda" class="button_paging" onclick="uncheckAll();"/><input type="image" src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/hapus.png" class="button_paging" title="Hapus"/></div>
				<div style="float:right; width:65%; text-align:right;"><?php $jumhal=ceil($jumlah/$batas); $this->paging($jumhal,$linkpage,$page); ?></div>
			</div>
			</form><?php 
		}
	}

	public function tabelurut($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,$urutkan) {		
		$domain=$this->domain;
		$adm=$this->adm;
		$mod=$this->mod;
		$orderby=$urutkan;
		$by=$this->by;
		$page=$this->page;
		$linkmod=$linksub."/".$adm."/".$mod;
		$linkcari=$linkmod."/act/cari/";	
		$batas=$batas;
		if ($act=="") { $act="none"; } else { $act=$act; }	
		if ($act=="cari") { 
			$posisi=0; $page=1; 
			if (empty($_POST['keyword'])) { if (empty($orderby)) { $keycari=""; } else { $keycari=$orderby;  } } else { $keycari=strip_tags(mysql_escape_string($_POST['keyword'])); }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' AND subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' AND subdomain='$subdomain' ORDER BY judul");
			$linkpage=$linkmod."/act/".$act."/".$keycari."/".$by;
		}
		elseif($act=="urut") { 
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain' ORDER BY $orderby $by LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		else {
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain' ORDER BY $orderby DESC LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		$y=1; 
		$nomor=$posisi+1;
		$jumlah=mysqli_num_rows($qjum);
		if ($jumlah==0) { ?>
			<h2>
				<span style="float:left; margin-right:10px;">Tabel <?php echo $judulmod;?></span>
				<span style="font-size:11px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Tambah <?php echo $judulmod;?>" class="button_add">TAMBAH</a></span>
			</h2><?php
			$this->notify($subdomain,$linksub,"empty_write"); 
		}
		else { ?>
			<div style="display:table; width:100%;">
				<h2 style="float:left;">
					<span style="float:left; margin-right:10px;">Tabel <?php echo $judulmod;?></span>
					<span style="font-size:11px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Tambah <?php echo $judulmod;?>" class="button_add">TAMBAH</a></span>
				</h2>
				<div class="cari" style="margin-bottom:5px;">
					<form action="<?php echo $this->getHttp();?>://<?php echo $linkcari;?>" method="post">
						<input type="text" name="keyword" size="20" id="keyword" value="Pencarian" maxlength="30" onblur="if (this.value=='') this.value='Pencarian';" onfocus="if (this.value=='Pencarian') this.value='';"/>&nbsp;
						<input name="cari" type="submit" value="" onClick="return cekkeyword();" id="tombol" style="cursor:pointer"/>
					</form>
				</div>
			</div><?php
			$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
			$dset=mysqli_fetch_array($qset);
			$paket=$dset['paket']; $aktif=$dset['aktif'];
			if ($paket=="free") { 
			if ($aktif==0) {
			if ($mod=="halaman") { $maksimal=15; $warning=12; } else { $maksimal=30; $warning=25; }
			if ($jumlah>=$maksimal) { ?>
			<div style="background:#FFDDDD; padding:1%; margin:5px 0px;">
			<h3>Kapasitas <?php echo $judulmod;?> Sudah Penuh</h3>
			Maaf, Kapasitas <?php echo $judulmod;?> sudah melebihi batas paket Free.<br/>
			Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
			Klik <a href="<?php echo $this->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
			</div><?php
			}
			elseif ($jumlah>=$warning) { ?>
			<div style="background:#FFFFCC; padding:1%; margin:5px 0px;">
			<h3>Kapasitas <?php echo $judulmod;?> Hampir Penuh</h3>
			Jumlah <?php echo $judulmod;?> hampir melebihi batas maksimal Paket Free.<br/>
			Segera upgrade Paket Website Anda untuk mendapatkan kapasitas unlimited.<br/>
			Klik <a href="<?php echo $this->getHttp();?>://<?php echo $linksub."/".$adm;?>/upgrade/" title="Upgrade Paket">DISINI</a> untuk melakukan Upgrade.
			</div><?php
			}
			}
			}
			?>
			<form action="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/hapusmulti/" method="post" name="form_tabel" onsubmit="konfirmHapus();return false;">
			<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
				<tr class="tabelhead">
					<th width="15"></th><?php
					$kolom=explode(",",$kolom);
					$lebar=explode(",",$lebar);
					$jumkolom=count($kolom);
					for($i=0;$i<$jumkolom;$i++){ 
						if ($kolom[$i]=="judul" or $kolom[$i]=="nama") { $width=""; } else { $width=$lebar[$i]; } 
						if ($kolom[$i]=="menu" or $kolom[$i]=="module") { $idurut="id_".$kolom[$i]; } else { $idurut=$kolom[$i]; } 
						if ($by=="desc") { $bybaru="asc"; } elseif ($by=="asc") { $bybaru="desc"; }
						$linkkolom=$linkmod."/act/urut/".$idurut."/".$bybaru."/"; ?>
						<th width="<?php echo $width;?>"><a href="<?php echo $this->getHttp();?>://<?php echo $linkkolom;?>" title="Urut <?php echo $kolom[$i];?>"><?php $this->label($kolom[$i]); echo $this->labelisi;?></a></th><?php 
					} 
					if ($kolomvisit!=1) { } else { ?><th width="50"><?php }
					if ($kolomkomen!=1) { } else { ?></th><th width="40"></th><?php }
					if ($kolomtgl!=1) { } else { ?><th width="60" style="text-align:right"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/urut/tgl/<?php echo $bybaru;?>/" title="Urut Tanggal">Tanggal</a></th><?php } ?>
				</tr><?php
			while($data=mysqli_fetch_array($query)) {
				$no=$data['no'];
				$pub=$data['publish'];
				$tanggal=$data['tanggal'];
				if ($y%2==0) { $latar="#FAFAFA"; } else { $latar="#FFFFFF"; } 
				if ($pub==0) { $latar="FFEEEE"; } else { $latar=$latar; } ?>
				<tr bgcolor="<?php echo $latar; ?>" align="left">
					<td align="center" style="padding:10px 0px;"><input name="cek[]" type="checkbox" value="<?php echo $no;?>"/></td><?php
					for($j=0;$j<$jumkolom;$j++){ ?>
						<td><?php $this->data($tabel,$kolom[$j],$no); echo $this->dataisi;
						if ($kolom[$j]=="judul" or $kolom[$j]=="nama") { ?>
							<div class="tombol"><?php
							$tombolaction=explode(",",$tombolact); $jumtombolact=count($tombolaction);
							for($k=0;$k<$jumtombolact;$k++){ $this->tombolaction($subdomain,$linkmod,$tombolaction[$k],$no,$pub,""); } ?>
							</div><?php
						}
						else { } ?>
						</td><?php 
					} 
					if ($kolomvisit!=1) { } 
					else { 
						$gambarvisit=$this->getHttp()."://".$domain."/image/visitor.png"; 
						$visitor=$data['jumlah_pembaca']; ?>
						<td align="right"><?php echo $visitor?><img src="<?php echo $gambarvisit;?>" style="margin:0px 0px 0px 4px;" align="right"/></td><?php
					}
					if ($kolomkomen!=1) { }
					else { 
						$gambarkomen=$this->getHttp()."://".$domain."/image/comment.png";
						$qkomen=mysqli_query($koneksi, "SELECT no FROM komentar WHERE id_$tabel='$no' AND subdomain='$subdomain'"); $jumkomen=mysqli_num_rows($qkomen); ?>
						<td align="right"><?php echo $jumkomen?><img src="<?php echo $gambarkomen;?>" style="margin:4px 0px 0px 4px;" align="right"/></td><?php
					}
					if ($kolomtgl!=1) { } else { ?><td align="right"><?php echo $tanggal; ?></td><?php } ?>
				</tr><?php
				$nomor++; $y++;
			} ?>
			</table>
			<div style="display:table; width:100%; padding:5px 0px; ">
				<div style="float:left; width:35%; text-align:left;"><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/check.png" title="Tandai Semua" alt="Tandai Semua" class="button_paging" onclick="checkAll();"/><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/uncheck.png" title="Hilangkan Tanda" alt="Hilangkan Tanda" class="button_paging" onclick="uncheckAll();"/><input type="image" src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/hapus.png" class="button_paging" title="Hapus"/></div>
				<div style="float:right; width:65%; text-align:right;"><?php $jumhal=ceil($jumlah/$batas); $this->paging($jumhal,$linkpage,$page); ?></div>
			</div>
			</form><?php 
		}
	}
	
	public function tombolaction($subdomain,$linkmod,$tipe,$no,$pub,$kategori) { 
		if ($tipe=="hapus" or $tipe=="delete") { $onclick="onclick=\"return confirm('Apakah Anda yakin akan menghapus data ini ?');\""; } else { $onclick=""; } 
		if ($tipe=="formulir") { $linkaction=$subdomain."/psb_cetak.php?no=".$no; $target="_blank"; }
		else if ($tipe=='download' && $subdomain=='smaitalhikmahblitar.sch.id'){
			$linkaction=$subdomain."/download_dokumen.php?no=".$no; $target="_blank";
		}
		else {	$linkaction=$linkmod."/act/".$kategori.$tipe."/".$no."/"; $target="_parent"; }?>
				<h6 class="menuaction"><a href="<?php echo $this->getHttp();?>://<?php echo $linkaction;?>" title="<?php echo $tipe;?>" <?php echo $onclick;?> target="<?php echo $target;?>"><?php echo $tipe;?></a></h6><?php
	}
	
	public function paging($jumhal,$linkhal,$page) { 
		if ($page>1) { 
			$prev=$page-1; ?>
			<span class="button_paging"><a href="<?php echo $this->getHttp();?>://<?php echo $linkhal;?>/" title="First">First</a></span><span class="button_paging"><a href="<?php echo $this->getHttp();?>://<?php echo $linkhal;?>/page/<?php echo $prev;?>/" title="Prev">Prev</a></span><?php
		} 
		else { ?><span class="button_paging">First</span><span class="button_paging">Prev</span><?php } 
		$sebakhir=$jumhal-1;
		if ($jumhal<=3) { $awal=1; $akhir=$jumhal; }
		else {
			if ($page==1) { $awal=1; $akhir=$page+2; }
			elseif ($page==2) { $awal=1; $akhir=$page+2; }
			elseif ($page==$jumhal) { $awal=$page-2; $akhir=$jumhal; }
			elseif ($page==$sebakhir) { $awal=$page-2; $akhir=$jumhal; }
			else { $awal=$page-2; $akhir=$page+2; }
		}
		for ($i=$awal; $i<=$akhir; $i++) {
			if ($i!=$page) { ?><span class="button_paging"><a href="<?php echo $this->getHttp();?>://<?php echo $linkhal;?>/page/<?php echo $i;?>/" title="<?php echo $i;?>"><?php echo $i;?></a></span><?php }  
			else { ?><span class="button_paging" style="color:#FF0000;"><?php echo $i;?></span><?php } 
		}
		if ($page<$jumhal){ 
			$next=$page+1; ?><span class="button_paging"><a href="<?php echo $this->getHttp();?>://<?php echo $linkhal;?>/page/<?php echo $next;?>/" title="Next">Next</a></span><span class="button_paging"><a href="<?php echo $this->getHttp();?>://<?php echo $linkhal;?>/page/<?php echo $jumhal;?>/" title="Last" style="border-right:1px solid #EAEAEA;">Last</a></span><?php
		} 
		else { ?><span class="button_paging">Next</span><span class="button_paging" style="border-right:1px solid #EAEAEA;">Last</span><?php } 
	}
    
	public function kategori($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$lebar,$tombolact) {	
		$domain=$this->domain;
		$adm=$this->adm;
		$mod=$this->mod;
		$no=$this->no;		
		$orderby=$this->order;
		$by=$this->by;
		$page=$this->page;
		$linkmod=$linksub."/".$adm."/".$mod;
		$linkcari=$linkmod."/act/katcari/";	
		$batas=$batas;
		$http=$this->getHttp();
		if ($act=="") { $act="none"; } else { $act=$act; }	
		if ($act=="katcari") { 
			$posisi=0;
			if (empty($_POST['keyword'])) { if (empty($orderby)) { $keycari=""; } else { $keycari=$orderby;  } } else { $keycari=strip_tags(mysql_escape_string($_POST['keyword'])); }
			$qjum=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' AND subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' AND subdomain='$subdomain' ORDER BY judul LIMIT $posisi,$batas");
			$linkpage=$linkmod."/act/".$act."/".$keycari."/".$by;
		}
		elseif($act=="katurut") { 
			if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain' ORDER BY $orderby $by LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		else {
			if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE subdomain='$subdomain' ORDER BY $orderby DESC LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/kategori";
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		$nomor=$posisi+1;
		$y=1; 
		$jumlah=mysqli_num_rows($qjum);
		list ($tabelasli,$kat)=explode("_",$tabel);  
		$judulkat="Kategori ".$tabelasli;?>
		<div style="display:table; width:100%;">
			<h2 style="float:left;"><?php echo $judulkat;?></h2>
			<div class="cari">
				<form action="<?php echo $this->getHttp();?>://<?php echo $linkcari;?>" method="post">
					<input type="text" name="keyword" size="20" id="keyword" value="Pencarian" maxlength="30"
					onblur="if (this.value=='') this.value='Pencarian';" onfocus="if (this.value=='Pencarian') this.value='';"/>&nbsp;
					<input name="cari" type="submit" value="" onClick="return cekkeyword();" id="tombol" style="cursor:pointer"/>
				</form>
			</div>
		</div>
		<div style="display:table; width:100%;">
			<div class="kategori_form" style=" "><?php
				function kategori_form ($subdomain,$judulkat,$tabel,$linkmod,$act,$no,$http='http') { 
					if ($act=="katubah") { 
						$action=$act."/".$no; $proses="katubah"; $submit="Ubah";
						$no=$no/1;
						$qkat=mysqli_query($koneksi, "SELECT judul,publish FROM $tabel WHERE no='$no' AND subdomain='$subdomain'"); $dkat=mysqli_fetch_array($qkat);
						$valjudul=$dkat['judul']; $valpub=$dkat['publish'];
					}
					else { $action="kattambah"; $proses="kattambah"; $submit="Tambah"; $valjudul=""; $valdes=""; $valpub="1"; } ?>
					<form action="<?php echo $http;?>://<?php echo $linkmod."/act/".$action;?>/" method="post">
						<input type="hidden" name="proses" value="<?php echo $proses;?>"/>
						<h3 style="margin:5px 0px; text-transform:capitalize"><?php echo $submit." ".$judulkat;?></h3>
						Judul Kategori<br/><input type="text" name="judul" id="judul" style="width:250px; margin-bottom:10px;" maxlength="50" value="<?php echo $valjudul;?>"/><br/>
						Tampilkan<br/>
							<select name="publish" style="width:256px; margin-bottom:10px;"><?php
							if ($valpub==0) { ?><option value="0">Tidak</option><option value="1">Ya</option><?php }
							else { ?><option value="1">Ya</option><option value="0">Tidak</option><?php } ?>					
							</select>
						<br>
						<input type="submit" value="<?php echo $submit;?>" class="button" onclick="return cekkategori();"/>
					</form><?php
				}
				if (empty($_POST['proses'])) { 
				   
					kategori_form($subdomain,$judulkat,$tabel,$linkmod,$act,$no,$http);
					
					$randkode=rand(111111,999999); $_SESSION['kode']=$randkode; 
				}
				elseif ($_POST['proses']=="kattambah") { 
					if (empty ($_SESSION['kode'])) { kategori_form ($subdomain,$judulkat,$tabel,$linkmod,$act,$no); }
					else { 
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						$judul=$_POST['judul'];
						$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1");$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
						$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
						$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
						$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
						$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
						$g21=str_replace("]","","$g20");$g22=str_replace("","","$g21");$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
						$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
						$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
						$linkhasil=strtolower("$gantispasi");
						$publish=$_POST['publish'];
						mysqli_query($koneksi, "INSERT INTO $tabel (subdomain,judul,link,tgl,publish) VALUES ('$subdomain', '$judul','$linkhasil',sysdate(),'$publish')"); ?>
						<meta http-equiv="refresh" content="0; url=<?php echo $this->getHttp();?>://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"><?php
						kategori_form($subdomain,$judulkat,$tabel,$linkmod,$act,$no,$http);
					}
				}
				elseif ($_POST['proses']=="katubah") { 					
					if (empty ($_SESSION['kode'])) { 
						kategori_form($subdomain,$judulkat,$tabel,$linkmod,$act,$no,$http);
						$randkode=rand(111111,999999); $_SESSION['kode']=$randkode; 
					}
					else { 
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						$judul=$_POST['judul'];
						$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1");$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
						$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
						$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
						$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
						$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
						$g21=str_replace("]","","$g20");$g22=str_replace("","","$g21");$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
						$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
						$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
						$linkhasil=strtolower("$gantispasi");
						$publish=$_POST['publish'];
						$nokat=$no/1;
						mysqli_query($koneksi, "UPDATE $tabel SET judul='$judul', link='$linkhasil', publish='$publish' WHERE no='$nokat' AND subdomain='$subdomain'");
						kategori_form($subdomain,$judulkat,$tabel,$linkmod,$act,$no,$http);
					}
				} ?>
			</div>
			<div class="kategori_tabel">
				<form action="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/kathapusmulti/" method="post" name="form_tabel" onsubmit="konfirmHapus();return false;">
				<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
					<tr class="tabelhead">
						<th width="15"></th><?php
						$kolom=explode(",",$kolom);
						$lebar=explode(",",$lebar);
						$jumkolom=count($kolom);
						for($i=0;$i<$jumkolom;$i++){ 
							if ($kolom[$i]=="judul") { $width=""; } else { $width=$lebar[$i]; } 
							if ($kolom[$i]=="menu" or $kolom[$i]=="module") { $idurut="id_".$kolom[$i]; } else { $idurut=$kolom[$i]; } 
							if ($by=="desc") { $bybaru="asc"; } elseif ($by=="asc") { $bybaru="desc"; }
							$linkkolom=$linkmod."/act/katurut/".$idurut."/".$bybaru."/"; ?>
							<th width="<?php echo $width;?>"><a href="<?php echo $this->getHttp();?>://<?php echo $linkkolom;?>" title="Urut <?php echo $kolom[$i];?>"><?php $this->label($kolom[$i]); echo $this->labelisi;?></a></th><?php 
						} ?>
					</tr><?php
				while($data=mysqli_fetch_array($query)) {
					$no=$data['no'];
					$pub=$data['publish'];
					$tanggal=$data['tanggal'];
					if ($y%2==0) { $latar="#FAFAFA"; } else { $latar="#FFFFFF"; } 
					if ($pub==0) { $latar="FFEEEE"; } else { $latar=$latar; } ?>
					<tr bgcolor="<?php echo $latar; ?>" align="left">
						<td align="center" style="padding:10px 0px;"><input name="cek[]" type="checkbox" value="<?php echo $no;?>"/></td><?php
						for($j=0;$j<$jumkolom;$j++){ ?>
							<td><?php $this->data($tabel,$kolom[$j],$no); echo $this->dataisi;
							if ($kolom[$j]!="judul") { }
							else { ?>
								<div class="tombol"><?php
								$tombolaction=explode(",",$tombolact); $jumtombolact=count($tombolaction);
								for($k=0;$k<$jumtombolact;$k++){ $this->tombolaction($subdomain,$linkmod,$tombolaction[$k],$no,$pub,"kat"); } ?>
								</div><?php
							} ?>
							</td><?php 
						} ?>
					</tr><?php
					$nomor++; $y++;
				} ?>
				</table>
				<div style="display:table; width:100%; padding:5px 0px;">
					<div style="float:left; width:35%; text-align:left;"><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/check.png" title="Tandai Semua" alt="Tandai Semua" class="button_paging" onclick="checkAll();"/><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/uncheck.png" title="Hilangkan Tanda" alt="Hilangkan Tanda" class="button_paging" onclick="uncheckAll();"/><input type="image" src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/hapus.png" class="button_paging" title="Hapus"/></div>
					<div style="float:right; width:65%; text-align:right;"><?php $jumhal=ceil($jumlah/$batas); $this->paging($jumhal,$linkpage,$page); ?></div>
				</div>
				</form>
			</div>
		</div><?php 
	}
    
	public function label($isi) {
		$spasi=explode("_",$isi); 
		$jumspasi=count($spasi);
		if ($jumspasi<=1) { $this->labelisi=$isi; } 
		else {
			$spasi=explode("_",$isi); 
			list ($isijenis,$isijudul)=explode("_",$isi); 
			if ($isijenis=="id" or $isijenis=="code" or $isijenis=="no") { $isilabel=""; for($a=1;$a<$jumspasi;$a++){ $isilabel=$isilabel.$spasi[$a]." "; } }
			elseif ($isijenis=="kelamin") { $isilabel="Jenis Kelamin"; }
			elseif ($isijenis=="waktu") {  $isilabel="Tanggal ".$isijudul; }
			elseif ($isijenis=="show") {  $isilabel=$isijudul; }
			elseif ($isijenis=="list") { $isilabel=$isijudul; }
			else { $isilabel=""; for($a=0;$a<$jumspasi;$a++){ $isilabel=$isilabel.$spasi[$a]." "; } }
			if ($isi=="id_galeri_kategori") { $isilabel="Galeri kategori"; } 
			$this->labelisi=$isilabel;
		}
	}
    
	public function data($tabel,$isi,$noisi) {
		$domain=$this->domain;
		$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE no='$noisi'");
		$data=mysqli_fetch_array($query);
		$spasi=explode("_",$isi); 
		$jumspasi=count($spasi);
		if ($jumspasi<=1) { 
			if ($isi=="halaman" or $isi=="module") { 
				$idurut="id_".$isi;
				$idmod=$data[$idurut];
				$qmod=mysqli_query($koneksi, "SELECT judul FROM $isi WHERE no='$idmod'");
				$damod=mysqli_fetch_array($qmod);
				$this->dataisi=$isitabel=$damod['judul'];
			}
			elseif ($isi=="gambar" or $isi=="gambar2" or $isi=="gambar3" or $isi=="gambar4"){
				if ($data[$isi]=="") { $this->dataisi=""; }
				else { $this->dataisi="<img src=\"//$domain/picture/$data[$isi]\" align=\"left\" class=\"gambar_besar\"/>"; }
			}
			elseif ($isi=="tgl") {
				$this->dataisi="<h6>Ditulis tanggal : $data[$isi]</h6>";
			}
			elseif ($isi=="harga" or $isi=="biaya") {
				$this->dataisi="US$ ".number_format($data[$isi],2);
			}
			else if ($isi=='kode_html'){
				$this->dataisi=$this->html_decode($data[$isi]);
			}
			else { $this->dataisi=$data[$isi]; }
		} 
		else { 
			$spasi=explode("_",$isi); 
			list ($isijenis,$isijudul)=explode("_",$isi); 
			if ($isijenis=="id") {
				$isiid=$data[$isi];
				$qid=mysqli_query($koneksi, "SELECT judul FROM $isijudul WHERE no='$isiid'"); $did=mysqli_fetch_array($qid);
				$isidata=$did['judul'];
			}
			elseif ($isijenis=="code") {
				$isiid=$data[$isi];
				$qcode=mysqli_query($koneksi, "SELECT judul FROM $isijudul WHERE kode='$isiid'"); $dcode=mysqli_fetch_array($qcode);
				$isidata=$dcode['judul'];
			}
			elseif ($isijenis=="no") {
				$isiid=$data[$isi];
				$qcode=mysqli_query($koneksi, "SELECT nama FROM $isijudul WHERE no='$isiid'"); $dcode=mysqli_fetch_array($qcode);
				$isidata=$dcode['nama'];
			}
			elseif ($isijenis=="waktu") {
				$isidata=$data["tgl".$isijudul]."-".$data["bln".$isijudul]."-".$data["thn".$isijudul];
			}
			elseif ($isijenis=="tanggal") {
				$isijudul=$data[$isi]; list ($thn,$bln,$tgl)=explode("-",$isijudul); 
				$isidata=$tgl."-".$bln."-".$thn;
			}
			elseif ($isijenis=="kelamin") {
				if ($data[$isi]=="P") { $isidata="Perempuan"; } else { $isidata="Laki-Laki"; } 
			}
			elseif ($isijenis=="harga" or $isijenis=="biaya") {
				$isidata=number_format($data[$isi]);
			}
			elseif ($isijenis=="transaksi") {
				if ($data[$isi]=="I") { $isidata="Pemasukan"; } else { $isidata="Pengeluaran"; } 
			}
			elseif ($isijenis=="list") {
				$isilist=explode(",",$data[$isi]); $jumlist=count($isilist);
				$isidata=""; 
				for($a=0;$a<$jumlist;$a++){ 
					$isilistid=$isilist[$a];
					$qlist=mysqli_query($koneksi, "SELECT judul FROM $isijudul WHERE no='$isilistid'");
					while ($dlist=mysqli_fetch_array($qlist)) {  $isidata=$isidata.$dlist['judul'].", "; }
				} 
			}
			else { $isidata=$data[$isi]; }
			if ($isi=="id_galeri_kategori") { 
				$isijudul="galeri_kategori";
				$isiid=$data[$isi];
				$qid=mysqli_query($koneksi, "SELECT judul FROM $isijudul WHERE no='$isiid'"); $did=mysqli_fetch_array($qid);
				$isidata=$did['judul'];
			}
			elseif ($isi=="id_produk_kategori") { 
				$isijudul="produk_kategori";
				$isiid=$data[$isi];
				$qid=mysqli_query($koneksi, "SELECT judul FROM $isijudul WHERE no='$isiid'"); $did=mysqli_fetch_array($qid);
				$isidata=$did['judul'];
			}
			$this->dataisi=$isidata; 
		}
	}
    
	public function detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail) {		
		$domain=$this->domain;
		$mod=$this->mod;
		$act=$this->act;
		$no=$this->no;
		if (empty ($no)) { $this->notify($subdomain,$linksub,"empty"); }
		else {  ?>
			<h2>Detail <?php echo $judulmod;?></h2><?php
			$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { $this->notify($subdomain,$linksub,"empty"); } 
			else { 
				if ($jumdetail=="single") {
					$judul=$data['judul']; ?>
					<h3><?php echo $judul;?></h3><?php
					$detail=$data[$isidetail];
					if ($tipedetail=="") {  echo $detail; }
					elseif ($tipedetail=="text") { echo $detail; }
					elseif ($tipedetail=="link") { ?><a href="<?php echo $detail;?>" title="<?php echo $detail;?>" target="_blank"><?php echo $detail;?></a><?php }
					elseif ($tipedetail=="pict") { ?><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/picture/<?php echo $detail;?>" style="width:100%" title="<?php echo $judul;?>"/><?php }
					elseif ($tipedetail=="yahoo") { ?><a href="ymsgr:sendIM?<?php echo $detail;?>" title="<?php echo $judul;?>"><img src="//opi.yahoo.com/online?u=<?php echo $detail;?>&amp;m=g&amp;t=<?php echo $data['tipe_icon'];?>" border="0"/></a><?php	}
					elseif ($tipedetail=="video") { ?><iframe width="600" height="400" src="<?php echo $detail;?>" frameborder="0" allowfullscreen></iframe><?php }
					elseif ($tipedetail=="file") { ?><a href="<?php echo $this->getHttp();?>://<?php echo $domain;?>/file/<?php echo $detail;?>" title="<?php echo $detail;?>" target="_blank"><?php echo $detail;?></a><?php }
					else { echo $detail; } ?>
					<br/><br/>
					<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/><?php
				}
				else {
					if ($tipedetail=="") {
						$isidetail=explode(",",$isidetail);
						$jumisi=count($isidetail);
						for($i=0;$i<$jumisi;$i++){ 
							$spasi=explode("_",$isidetail[$i]); 
							$jumspasi=count($spasi); 
							$this->data($tabel,$isidetail[$i],$no); echo $this->dataisi;
						}
					}
					elseif ($tipedetail=="table") { ?>
						<table cellpadding="0" cellspacing="0" width="100%" id="tabelview"><?php
							$isidetail=explode(",",$isidetail);
							$jumisi=count($isidetail);
							for($i=0;$i<$jumisi;$i++){ ?>
								<tr>
									<td width="140"><?php $this->label($isidetail[$i]); echo $this->labelisi; ?></td>
									<td width="15">:</td>
									<td><?php $this->data($tabel,$isidetail[$i],$no); echo $this->dataisi; ?></td>
								</tr><?php 
							} ?>
						</table><?php
					}
					elseif ($tipedetail=="table-pict") { ?>
						<table cellpadding="0" cellspacing="0" width="100%">
						<tr valign="top"><?php
							if ($data['gambar']=="") { $gambar="blank.jpg"; } else { $gambar=$data['gambar']; } ?>
							<td width="160">
							    <img src="<?php echo $this->resize->ubah($gambar,180,180);?>" class="gambar_member" alt="gambar"/ style="display: block;">
							    <?php
							    if ($subdomain == "smaqueenalfalah.sch.id") {
							        ?>
							        <a href="<?php echo $this->resize->ubah($gambar,3000,3000);?>" target="_blank" title="Download" style="margin: 16px auto 0; display: block; width: 50%;">Download</a>
							        <?php
							    }
							    ?>
							</td>
							<td>
							<table cellpadding="0" cellspacing="0" width="100%" id="tabelview"><?php
								$isidetail=explode(",",$isidetail);
								$jumisi=count($isidetail);
								for($i=0;$i<$jumisi;$i++){ ?>
									<tr>
										<td width="140"><?php $this->label($isidetail[$i]); echo $this->labelisi; ?></td>
										<td width="15">:</td>
										<td><?php $this->data($tabel,$isidetail[$i],$no);echo $this->dataisi; ?></td>
									</tr><?php 
								} ?>
							</table>
							</td>
						</tr>
						</table><?php
					} ?>
					<br/>
					<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/><?php
				}
			} 
		}
	}
    
	public function action_input ($form,$judul_baru) {
		$form=explode(",",$form);
		$jumkoma=count($form);
		$kolom=""; $isian="";
		for($i=0;$i<$jumkoma;$i++){ 
			$spasi=explode("_",$form[$i]); 
			$jumspasi=count($spasi);
			if ($jumspasi<=1) { $forminput=$form[$i]; 
			    
			} else {
			    if($form[$i]=='nama_penyakit'){
			        $forminput=$form[$i];
			    } else if($form[$i]=='nama_ayah'){
			        $forminput=$form[$i];
			    } else if ($form[$i]=='nama_ibu'){
			        $forminput=$form[$i];
			    } else if ($form[$i]=='nama_wali'){
			        $forminput=$form[$i];
			    } else if ($form[$i]=='nama_orang_tua'){
			        $forminput=$form[$i];
			    } else {
			        list($forminput,$isiform)=explode("_",$form[$i]); 
			    }

			}
			if ($forminput=="judul" or $forminput=="nama") {
				$linkhasil=$this->clean($_POST[$form[$i]],true);
				$kolom=$kolom."".$form[$i].", link, ";
				$isian=$isian."'".strip_tags($_POST[$form[$i]])."', '".$linkhasil."', ";
			}
			elseif ($forminput=="waktu") {
				$tglform=$_POST["tgl".$isiform];
				$blnform=$_POST["bln".$isiform];
				$thnform=$_POST["thn".$isiform];
				$waktu=date("Y-m-d",mktime(0,0,0,$blnform,$tglform,$thnform));
				$kolom=$kolom.$form[$i].", "."tgl".$isiform.", "."bln".$isiform.", "."thn".$isiform.", ";
				$isian=$isian."'".$waktu."', '".$tglform."', '".$blnform."', '".$thnform."', ";
			}
			elseif ($forminput=="kode") { $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".$this->html_encode($_POST[$form[$i]])."', "; }
			elseif ($forminput=="isi") { $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".$_POST[$form[$i]]."', "; }
			elseif ($forminput=="password") { $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".md5($_POST[$form[$i]])."', "; }
			elseif ($forminput=="gambar") { $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".$judul_baru."', "; }
			elseif ($forminput=="file") { $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".$judul_baru."', "; }
			elseif ($forminput=="kode_html"){ $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".str_replace("'",'"',$_POST[$form[$i]]) ."', "; }
			else { $kolom=$kolom."".$form[$i].", "; $isian=$isian."'".strip_tags($_POST[$form[$i]])."', "; }
		}
		$this->actionkolom=$kolom;
		$this->actionisian=$isian;
	} 
    
	public function input ($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder) {	
		$domain=$this->domain;
		$adm=$this->adm;
		$mod=$this->mod;
		$act=$this->act;
		$linkmod=$linksub."/".$adm."/".$mod;	
		$linkhalaman=$linkmod."/act/".$act."/";
		if (empty ($_POST['proses'])) { ?>
			<h2>Tambah <?php echo $judulmod;?></h2>
			<form action="" method="post" enctype="multipart/form-data" name="judulform">
				<input name="proses" type="hidden" value="tambah"/>
				<table width="100%" cellpadding="0" cellspacing="0" id="tabelview"><?php
					if ($tipeinput=="modhal") {
                        ?>
						<tr><td width="140">Module</td>
							<td> 
							<select name="id_module" style="width:96%; max-width:510px;"><?php
							$qmod=mysqli_query($koneksi, "SELECT no,judul FROM module WHERE tipe='$tabel' AND subdomain='$subdomain'");
							while($dmod=mysqli_fetch_array($qmod)){?><option value="<?php echo $dmod['no']; ?>"><?php echo $dmod['judul']; ?></option><?php } ?>
							</select>
							</td>
						</tr>
						<tr><td width="140">Halaman</td>
							<td> 
							<select name="id_halaman" style="width:96%; max-width:510px;"><?php
							$qmod=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE tipe='$tabel' AND subdomain='$subdomain'");
							while($dmod=mysqli_fetch_array($qmod)){?><option value="<?php echo $dmod['no']; ?>"><?php echo $dmod['judul']; ?></option><?php } ?>
							</select>
							</td>
						</tr>
						<?php
					} elseif ($tipeinput=="module") {
                        ?>
						<tr><td width="140">Module</td>
							<td> 
							<select name="id_module" style="width:96%; max-width:510px;"><?php
							$qmod=mysqli_query($koneksi, "SELECT no,judul FROM module WHERE tipe='$tabel' AND subdomain='$subdomain'");
							while($dmod=mysqli_fetch_array($qmod)){?><option value="<?php echo $dmod['no']; ?>"><?php echo $dmod['judul']; ?></option><?php } ?>
							</select>
							</td>
						</tr>
						<?php
					} elseif ($tipeinput=="halaman") {
                        ?>
						<tr><td width="140">Halaman</td>
							<td> 
							<select name="id_halaman" style="width:96%; max-width:510px;"><?php
							$qmod=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE tipe='$tabel' AND subdomain='$subdomain'");
							while($dmod=mysqli_fetch_array($qmod)){?><option value="<?php echo $dmod['no']; ?>"><?php echo $dmod['judul']; ?></option><?php } ?>
							</select>
							</td>
						</tr>
						<?php
					} else {
					   // FIX ME
					}
					$form=explode(",",$forminput);
					$jumkoma=count($form);
					for($i=0;$i<$jumkoma;$i++){ $this->form($subdomain,$linksub,$form[$i],"input","",""); echo "\n"; }
					$this->submit($subdomain,$linksub,"input",$onclick); echo "\n"; ?>
				</table>
			</form><?php
			$randkode=rand(111111,999999); 
			$_SESSION['kode']=$randkode;
		}
		elseif ($_POST['proses']=="tambah") {
			if ($tipeinput=="modhal") { 
				if (empty($_POST['id_module'])) { $id_module=""; } else { $id_module=strip_tags($_POST['id_module']); } 
				if (empty($_POST['id_halaman'])) { $id_halaman=""; } else { $id_halaman=strip_tags($_POST['id_halaman']); }
			} 
			elseif ($tipeinput=="module") { if (empty($_POST['id_module'])) { $id_module=""; } else { $id_module=strip_tags($_POST['id_module']); } } 
			elseif ($tipeinput=="halaman") { if (empty($_POST['id_halaman'])) { $id_halaman=""; } else { $id_halaman=strip_tags($_POST['id_halaman']); } } 
			else { }
			if (empty ($_SESSION['kode'])) { $this->notify($subdomain,$linksub,"save_ok"); }
			else { 
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				if ($jenisinput=="") {
					$this->action_input($forminput,"");
					$kolom=$this->actionkolom;
					$isian=$this->actionisian;
					if ($tipeinput=="modhal") { 
						mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman, id_module, $kolom tgl) VALUES ('$subdomain', '$id_halaman', '$id_module', $isian sysdate())"); 
					}
					elseif ($tipeinput=="module") { 
						mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_module, $kolom tgl) VALUES ('$subdomain', '$id_module', $isian sysdate())"); 
					}
					elseif ($tipeinput=="halaman") { 
						mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman, $kolom tgl) VALUES ('$subdomain', '$id_halaman', $isian sysdate())");  
					}
					else { 
						mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, $kolom tgl) VALUES ('$subdomain', $isian sysdate())"); 
						if($this->linksub=='www.sdnporisgaga2.sch.id'){
						    //echo "INSERT INTO $tabel (subdomain, $kolom tgl) VALUES ('$subdomain', $isian sysdate())";
						}
					}
					
					?><div style="display:none"><?php echo"INSERT INTO $tabel (subdomain, $kolom tgl) VALUES ('$subdomain', $isian sysdate())";?> </div><?php
					$this->notify($subdomain,$linksub,"save_ok");
				}
				elseif ($jenisinput=="gambar") {
					if ($_FILES['gambar']['tmp_name']=="") { 
						$this->action_input($forminput,"");
						$kolom=$this->actionkolom;
						$isian=$this->actionisian;
						if ($tipeinput=="modhal") { 
							mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman, id_module, $kolom tgl) VALUES ('$subdomain', '$id_halaman', '$id_module', $isian sysdate())");
						}
						elseif ($tipeinput=="module") { 
							mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_module, $kolom tgl) VALUES ('$subdomain', '$id_module', $isian sysdate())");
						}
						elseif ($tipeinput=="halaman") { 
							mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman, $kolom tgl) VALUES ('$subdomain', '$id_halaman', $isian sysdate())");  
						}
						else { 
							mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, $kolom tgl) VALUES ('$subdomain', $isian sysdate())"); 
						}
						$this->notify($subdomain,$linksub,"save_ok");
					}
					else {
						$gambar=$_FILES['gambar']['tmp_name'];
						$gambar_name=$_FILES['gambar']['name'];
						$gambar_size=$_FILES['gambar']['size'];
						if($subdomain=='smadipso.sch.id'){
						    //echo $gambar_size;
						}
						$gambar_type=$_FILES['gambar']['type'];
						$acak=rand(2131232188,99999999);
						$judul_baru=$acak.$gambar_name;
						$judul_baru=str_replace(" ","",$judul_baru);
						$gambar_dimensi=getimagesize($gambar);
						if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ $this->notify($subdomain,$linksub,"img_format"); }
						elseif ($gambar_dimensi['0']>"2000" or $gambar_dimensi['1']>"2000") { $this->notify($subdomain,$linksub,"image_dimention"); } 
						elseif ($gambar_size > 10485760) { $this->notify($subdomain,$linksub,"image_size"); } 
						else {
							$this->action_input($forminput,$judul_baru);
							$kolom=$this->actionkolom;
							$isian=$this->actionisian;
							if ($tipeinput=="modhal") {
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman,id_module,$kolom tgl) VALUES ('$subdomain', '$id_halaman','$id_module',$isian sysdate())");
							}
							elseif ($tipeinput=="module") { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_module, $kolom tgl) VALUES ('$subdomain', '$id_module', $isian sysdate())"); 
							}
							elseif ($tipeinput=="halaman") { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman, $kolom tgl) VALUES ('$subdomain', '$id_halaman', $isian sysdate())");  
							}
							else { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, $kolom tgl) VALUES ('$subdomain', $isian sysdate())"); 
							}
							$allowed = array(
								'jpg',
								'jpeg',
								'gif',
								'png'
							);

							if (!in_array(strtolower(substr(strrchr($judul_baru, '.'), 1)), $allowed)) {
								exit;
							}

							// Allowed file mime types
							$allowed = array(
								'image/jpeg',
								'image/pjpeg',
								'image/png',
								'image/x-png',
								'image/gif'
							);

							if (!in_array($gambar_type, $allowed)) {
								exit;
							}

							// Check to see if any PHP files are trying to be uploaded
							$content = file_get_contents($gambar);

							if (preg_match('/\<\?php/i', $content)) {
								exit;
							}
							
							copy ($gambar, "$folder/picture/".$judul_baru);
							$this->uploader->uploadPicture($judul_baru);
							$this->notify($subdomain,$linksub,"save_ok");
						}
					}
				}
				elseif ($jenisinput=="file") {
					if ($_FILES['file']['tmp_name']=="") { $this->notify($subdomain,$linksub,"file_empty"); }
					else {
						$file=$_FILES['file']['tmp_name'];
						$file_name=$_FILES['file']['name'];
						$file_size=$_FILES['file']['size'];
						$file_type=$_FILES['file']['type'];
						$acak=rand(00000000,99999999);
						$judul_baru=$acak.$file_name;
						$judul_baru=str_replace(" ","",$judul_baru);
						if ($file_size>"100000000") { $this->notify($subdomain,$linksub,"file_size"); } 
						else {
							$this->action_input($forminput,$judul_baru);
							$kolom=$this->actionkolom;
							$isian=$this->actionisian;
							if ($tipeinput=="modhal") { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman,id_module,$kolom tgl) VALUES ('$subdomain', '$id_halaman','$id_module',$isian sysdate())");
							}
							elseif ($tipeinput=="module") { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_module, $kolom tgl) VALUES ('$subdomain', '$id_module', $isian sysdate())"); 
							}
							elseif ($tipeinput=="halaman") { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, id_halaman, $kolom tgl) VALUES ('$subdomain', '$id_halaman', $isian sysdate())");  
							}
							else { 
								mysqli_query($koneksi, "INSERT INTO $tabel (subdomain, $kolom tgl) VALUES ('$subdomain', $isian sysdate())"); 
							}
							$not_allowed = array(
								'php',
								'php4',
								'php5',
								'php6',
								'php7'
							);

							if (in_array(strtolower(substr(strrchr($file_name, '.'), 1)), $not_allowed)) {
								exit;
							}
							// Check to see if any PHP files are trying to be uploaded
							$content = file_get_contents($file);

							if (preg_match('/\<\?php/i', $content)) {
								exit;
							}
							copy ($file, "$folder/file/".$judul_baru);
							$this->uploader->uploadFile($judul_baru);
							$this->notify($subdomain,$linksub,"save_ok");
						}
					}
				}
			}
		}
	}
	
	
	public function action_edit ($form,$judul_baru) {
		$form=explode(",",$form);
		$jumkoma=count($form);
		$ubah="";
		for($i=0;$i<$jumkoma;$i++){
			$spasi=explode("_",$form[$i]); 
			$jumspasi=count($spasi);
			if ($jumspasi<=1) {
			    $forminput=$form[$i];
			    } else { 
			         if($form[$i]=='nama_penyakit'){
    			        $forminput=$form[$i];
        			    } else if($form[$i]=='nama_ayah'){
        			        $forminput=$form[$i];
        			    } else if ($form[$i]=='nama_ibu'){
        			        $forminput=$form[$i];
        			    } else if ($form[$i]=='nama_wali'){
        			        $forminput=$form[$i];
        			    }  else if ($form[$i]=='nama_orang_tua'){
    			        $forminput=$form[$i];
    			        }  else {
        			        list($forminput,$isiform)=explode("_",$form[$i]); 
        			    }
			    }
			if ($forminput=="judul" or $forminput=="nama") {
				$jeneng=$_POST[$form[$i]];
				$g1=str_replace("#","","$jeneng");$g2=str_replace("~","","$g1");
				$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
				$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");
				$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
				$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");
				$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
				$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");
				$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
				$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");
				$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
				$g21=str_replace("]","","$g20");$g22=str_replace("","","$g21");
				$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
				$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");
				$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
				$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");
				$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
				$linkhasil=strtolower("$gantispasi");
				$isian=strip_tags($_POST[$form[$i]])."', link='".$linkhasil;
			}
			elseif ($forminput=="waktu") {
				$tglform=$_POST["tgl".$isiform];
				$blnform=$_POST["bln".$isiform];
				$thnform=$_POST["thn".$isiform];
				$waktu=date("Y-m-d",mktime(0,0,0,$blnform,$tglform,$thnform));
				$isian=$waktu."', tgl".$isiform."='".$tglform."', bln".$isiform."='".$blnform."', thn".$isiform."='".$thnform;
			}
			elseif ($forminput=="kode") { $isian=$this->html_encode($_POST[$form[$i]]); }
			elseif ($forminput=="isi") { $isian=$_POST[$form[$i]]; }
			elseif ($forminput=="password") { $isian=md5($_POST[$form[$i]]); }
			elseif ($forminput=="gambar") { $isian=$judul_baru; }
			elseif ($forminput=="favicon") { $isian=$judul_baru; }
			elseif ($forminput=="file") { $isian=$judul_baru; }
			else { $isian=strip_tags($_POST[$form[$i]]);  }
			$ubah=$ubah.$form[$i]."='".$isian."', ";
		}
		$this->actionubah=$ubah;
	}


	public function edit ($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder) {	
		$domain=$this->domain;
		$adm=$this->adm;
		$mod=$this->mod;
		$act=$this->act;
		$no=$this->no;
		$linkmod=$linksub."/".$adm."/".$mod;
		if ($no=="") {  $this->notify($subdomain,$linksub,"empty"); }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE no='$no'");
			$data=mysqli_fetch_array($query);
			$publish=$data['publish'];
			$linkhalaman=$linkmod."/act/".$act."/".$no."/";
			if ($data['no']=="") {  $this->notify($subdomain,$linksub,"empty");  }
			else {
				if (empty ($_POST['proses'])) { ?>
					<h2>Ubah <?php echo $judulmod;?></h2>
					<form action="" method="post" enctype="multipart/form-data" name="judulform">
						<input name="proses" type="hidden" value="edit">
						<input name="no" type="hidden" value="<?php echo $no;?>"/>
						<table width="100%" cellpadding="0" cellspacing="0" id="tabelview"><?php
							if ($tipeinput=="modhal") { ?>
								<tr><td width="140">Module</td> 
								<td>
									<select name="id_module" style="width:96%; max-width:510px;"><?php	
									$qmodula=mysqli_query($koneksi, "SELECT no,judul FROM module WHERE no='$data[id_module]' AND subdomain='$subdomain'"); 
									$dmodula=mysqli_fetch_array($qmodula);?>
									<option value="<?php echo $dmodula['no'];?>" ><?php echo $dmodula['judul'];?></option><?php
									$qmodul=mysqli_query($koneksi, "SELECT no,judul FROM module WHERE tipe='$tabel' AND subdomain='$subdomain'");
									while($dmodul=mysqli_fetch_array($qmodul)){?>
										<option value="<?php echo $dmodul['no'];?>"><?php echo $dmodul['judul']; ?></option><?php 
									}?>
									</select>
								</td>
								</tr>
								<tr><td width="140">Halaman</td> 
								<td>
									<select name="id_halaman" style="width:96%; max-width:510px;"><?php	
									$qmodula=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE no='$data[id_halaman]' AND subdomain='$subdomain'"); 
									$dmodula=mysqli_fetch_array($qmodula);?>
									<option value="<?php echo $dmodula['no'];?>" ><?php echo $dmodula['judul'];?></option><?php
									$qmodul=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE tipe='$tabel' AND subdomain='$subdomain'");
									while($dmodul=mysqli_fetch_array($qmodul)){?>
										<option value="<?php echo $dmodul['no'];?>"><?php echo $dmodul['judul']; ?></option><?php 
									}?>
									</select>
								</td>
								</tr><?php
							}
							elseif ($tipeinput=="module") { ?>
								<tr><td width="140">Module</td> 
								<td>
									<select name="id_module" style="width:96%; max-width:510px;"><?php	
									$qmodula=mysqli_query($koneksi, "SELECT no,judul FROM module WHERE no='$data[id_module]' AND subdomain='$subdomain'"); 
									$dmodula=mysqli_fetch_array($qmodula);?>
									<option value="<?php echo $dmodula['no'];?>" ><?php echo $dmodula['judul'];?></option><?php
									$qmodul=mysqli_query($koneksi, "SELECT no,judul FROM module WHERE tipe='$tabel' AND subdomain='$subdomain'");
									while($dmodul=mysqli_fetch_array($qmodul)){?>
										<option value="<?php echo $dmodul['no'];?>"><?php echo $dmodul['judul']; ?></option><?php 
									}?>
									</select>
								</td>
								</tr><?php
							}
							elseif ($tipeinput=="halaman") { ?>
								<tr><td width="140">Halaman</td> 
								<td>
									<select name="id_halaman" style="width:96%; max-width:510px;"><?php	
									$qmodula=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE no='$data[id_halaman]' AND subdomain='$subdomain'"); 
									$dmodula=mysqli_fetch_array($qmodula);?>
										<option value="<?php echo $dmodula['no'];?>" ><?php echo $dmodula['judul'];?></option><?php
									$qmodul=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE tipe='$tabel' AND subdomain='$subdomain'");
									while($dmodul=mysqli_fetch_array($qmodul)){?>
										<option value="<?php echo $dmodul['no'];?>"><?php echo $dmodul['judul']; ?></option><?php 
									}?>
									</select>
								</td>
								</tr><?php
							}
							else { }
							$form=explode(",",$forminput);
							$jumkoma=count($form);
							for($i=0;$i<$jumkoma;$i++){  $this->form($subdomain,$linksub,$form[$i],"edit",$data[$form[$i]],""); echo "\n"; }
							$this->submit($subdomain,$linksub,"edit",$onclick); echo "\n"; ?>
						</table>
					</form><?php
					$randkode=rand(111111,999999); 
					$_SESSION['kode']=$randkode;
				}
				elseif ($_POST['proses']=="edit") {
					$no=strip_tags($_POST['no']);
					if ($tipeinput=="modhal") { $id_module=strip_tags($_POST['id_module']);	$id_halaman=strip_tags($_POST['id_halaman']); } 
					elseif ($tipeinput=="module") { $id_module=strip_tags($_POST['id_module']); } 
					elseif ($tipeinput=="halaman") { $id_halaman=strip_tags($_POST['id_halaman']); } 
					else { }
					if (empty ($_SESSION['kode'])) {  $this->notify($subdomain,$linksub,"edit_ok"); }
					else { 
						if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						if ($jenisinput=="") {
							$this->action_edit($forminput,"");
							$ubah=$this->actionubah;
							if ($tipeinput=="modhal") { 
								mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module',id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
							}
							elseif ($tipeinput=="module") { 
								mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
							}
							elseif ($tipeinput=="halaman") { 
								mysqli_query($koneksi, "UPDATE $tabel SET id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'");  
							}
							else { 
								mysqli_query($koneksi, "UPDATE $tabel SET $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								//echo "UPDATE $tabel SET $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'";
							}
							$this->notify($subdomain,$linksub,"edit_ok");
						}
						elseif ($jenisinput=="gambar") {
							if (empty($_FILES['gambar']['tmp_name'])) {
								$this->action_edit($forminput,$_POST['gambarlama']);
								$ubah=$this->actionubah;
								if ($tipeinput=="modhal") { 
									mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module',id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								}
								elseif ($tipeinput=="module") { 
									mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								}
								elseif ($tipeinput=="halaman") { 
									mysqli_query($koneksi, "UPDATE $tabel SET id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'");  
								}
								else {
									mysqli_query($koneksi, "UPDATE $tabel SET $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								}
								$this->notify($subdomain,$linksub,"edit_ok");
							}
							else {
								$gambar=$_FILES['gambar']['tmp_name'];
								$gambar_name=$_FILES['gambar']['name'];
								$gambar_size=$_FILES['gambar']['size'];
								$gambar_type=$_FILES['gambar']['type'];
								$acak=rand(00000000,99999999);
								$judul_baru=$acak.$gambar_name;
								$judul_baru=str_replace(" ","",$judul_baru);
								$gambar_dimensi=getimagesize($gambar);
								if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ 
									$this->notify($subdomain,$linksub,"img_format");
								} 
								elseif ($gambar_dimensi['0']>"2000" or $gambar_dimensi['1']>"2000") { 
									$this->notify($subdomain,$linksub,"image_dimention"); 
								} 
								elseif ($gambar_size>"1000000") { 
									$this->notify($subdomain,$linksub,"image_size"); 
								} 
								else {
									$this->action_edit($forminput,$judul_baru);
									$ubah=$this->actionubah;
									if ($tipeinput=="modhal") { 
										mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', id_halaman='$id_halaman',$ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
									}
									elseif ($tipeinput=="module") { 
										mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
									}
									elseif ($tipeinput=="halaman") { 
										mysqli_query($koneksi, "UPDATE $tabel SET id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'");  
									}
									else { 
										mysqli_query($koneksi, "UPDATE $tabel SET $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
									}
									
									$allowed = array(
										'jpg',
										'jpeg',
										'gif',
										'png'
									);
									if (!in_array(strtolower(substr(strrchr($judul_baru, '.'), 1)), $allowed)) {
										
										exit;
									}

									// Allowed file mime types
									$allowed = array(
										'image/jpeg',
										'image/pjpeg',
										'image/png',
										'image/x-png',
										'image/gif'
									);

									if (!in_array($gambar_type, $allowed)) {
										exit;
									}

									// Check to see if any PHP files are trying to be uploaded
									$content = file_get_contents($gambar);

									if (preg_match('/\<\?php/i', $content)) {
										exit;
									}
									
									copy ($gambar, "$folder/picture/".$judul_baru);
									$this->uploader->uploadPicture($judul_baru);
									if(empty($_POST['gambarlama']) or $_POST['gambarlama']=="" or $_POST['gambarlama']=="s1.jpg" or $_POST['gambarlama']=="s2.jpg" or $_POST['gambarlama']=="s3.jpg" or $_POST['gambarlama']=="s4.jpg" or $_POST['gambarlama']=="a1.jpg" or $_POST['gambarlama']=="a2.jpg" or $_POST['gambarlama']=="a3.jpg" or $_POST['gambarlama']=="a4.jpg" or $_POST['gambarlama']=="b1.jpg" or $_POST['gambarlama']=="b2.jpg" or $_POST['gambarlama']=="b3.jpg" or $_POST['gambarlama']=="b4.jpg"or $_POST['gambarlama']=="ban1.jpg" or $_POST['gambarlama']=="str1.jpg" or $_POST['gambarlama']=="f1.jpg" or $_POST['gambarlama']=="f2.jpg" or $_POST['gambarlama']=="f3.jpg" or $_POST['gambarlama']=="samb1.jpg") { } else { unlink("$folder/picture/".$_POST['gambarlama']);
									$this->notify($subdomain,$linksub,"edit_ok");									}
								}
							}
						}
						elseif ($jenisinput=="file") {
							if (empty($_FILES['file']['tmp_name'])) {
								$this->action_edit($forminput,$_POST['filelama']);
								$ubah=$this->actionubah;
								if ($tipeinput=="modhal") { 
									mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module',id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								}
								elseif ($tipeinput=="module") { 
									mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								}
								elseif ($tipeinput=="halaman") { 
									mysqli_query($koneksi, "UPDATE $tabel SET id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'");  
								}
								else { 
									mysqli_query($koneksi, "UPDATE $tabel SET $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
								}
								$this->notify($subdomain,$linksub,"edit_ok");
							}
							else {
								$file=$_FILES['file']['tmp_name'];
								$file_name=$_FILES['file']['name'];
								$file_size=$_FILES['file']['size'];
								$file_type=$_FILES['file']['type'];
								$acak=rand(00000000,99999999);
								$judul_baru=$acak.$file_name;
								$judul_baru=str_replace(" ","",$judul_baru);
								if ($file_size>"100000000") { 
									$this->notify($subdomain,$linksub,"image_size"); 
								} 
								else {
									$this->action_edit($forminput,$judul_baru);
									$ubah=$this->actionubah;
									if ($tipeinput=="modhal") { 
										mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', id_halaman='$id_halaman',$ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
									}
									elseif ($tipeinput=="module") { 
										mysqli_query($koneksi, "UPDATE $tabel SET id_module='$id_module', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
									}
									elseif ($tipeinput=="halaman") { 
										mysqli_query($koneksi, "UPDATE $tabel SET id_halaman='$id_halaman', $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'");  
									}
									else { 
										mysqli_query($koneksi, "UPDATE $tabel SET $ubah no='$no' WHERE no='$no' AND subdomain='$subdomain'"); 
									}
									
									$not_allowed = array(
										'php',
										'php4',
										'php5',
										'php6',
										'php7'
									);

									if (in_array(strtolower(substr(strrchr($judul_baru, '.'), 1)), $not_allowed)) {
										exit;
									}
									// Check to see if any PHP files are trying to be uploaded
									$content = file_get_contents($file);

									if (preg_match('/\<\?php/i', $content)) {
										exit;
									}
									
									copy ($file, "$folder/file/".$judul_baru);
									$this->uploader->uploadFile($judul_baru);
									if($_POST['filelama']==""){ } else { unlink("$folder/file/".$_POST['filelama']); }
									$this->notify($subdomain,$linksub,"edit_ok");
								}
							}
						}
					}
				}
			}
		}
	}


	public function submit ($subdomain,$linksub,$tipe,$onclick) {	
		$adm=$this->adm;
		$mod=$this->mod;
		$act=$this->act;	
		$no=$this->no;
		$linkmod=$linksub."/".$adm."/".$mod;
		if ($tipe=="input") {?>
			<tr><td></td>
				<td>
				<input type="submit" name="submit" value="SIMPAN" onclick="return <?php echo $onclick;?>();" class="button"/><?php
				if ($act=="tambahrinci") { ?><span style="float:right; font-size:12px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Mode Sederhana">Mode Sederhana</a></span><?php }
				else { ?><span style="float:right; font-size:12px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambahrinci/" title="Mode Rinci">Mode Rinci</a></span><?php } ?>
				</td>
			</tr><?php
		}
		elseif ($tipe=="edit") { 
			if (empty($no)) { $no=1; } else { $no=$no/1; }?>
			<tr><td></td>
				<td>
				<input type="submit" name="submit" value="SIMPAN" onclick="return <?php echo $onclick;?>();" class="button" style="margin-bottom:8px;"/>
				&nbsp;&nbsp;<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/><?php
				if ($act=="ubahrinci") { ?><span style="float:right; font-size:12px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/ubah/<?php echo $no;?>/" title="Mode Sederhana">Mode Sederhana</a></span><?php }
				else { ?><span style="float:right; font-size:12px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/ubahrinci/<?php echo $no;?>/" title="Mode Rinci">Mode Rinci</a></span><?php } ?>
				</td>
			</tr><?php
		}
	}


	public function formtipe ($isi) {
		$spasi=explode("_",$isi); 
		$jumspasi=count($spasi);
		if ($jumspasi<=1) {  $judulisi=$isi; $tabelisi=$isi; } else { list ($judulisi,$tabelisi)=explode("_",$isi); }
		if ($judulisi=="judul") { $tipe="text"; }
		elseif ($judulisi=="penulis") { $tipe="penulis"; }
		elseif ($judulisi=="isi") { $tipe="texteditor"; }
		elseif ($judulisi=="halaman") { $tipe="texteditor"; }
		elseif ($judulisi=="admin") { $tipe="texteditor"; }
		elseif ($judulisi=="fitur") { $tipe="texteditor"; }
		elseif ($judulisi=="penjelasan") { $tipe="textarea"; }
		elseif ($judulisi=="kata") { $tipe="textarea"; }
		elseif ($judulisi=="alamat") { $tipe="textarea"; }
		elseif ($judulisi=="komentar") { $tipe="textarea"; }
		elseif ($judulisi=="kode") { $tipe="textarea"; }
		elseif ($judulisi=="tombol") { $tipe="textarea"; }
		elseif ($judulisi=="admin") { $tipe="textarea"; }
		elseif ($judulisi=="keterangan") { $tipe="textarea"; }		
		elseif ($judulisi=="deskripsi") { $tipe="textarea"; }
		elseif ($judulisi=="catatan") { $tipe="textarea"; }
		elseif ($judulisi=="pertanyaan") { $tipe="textarea"; }
		elseif ($judulisi=="jawaban12") { $tipe="textarea"; }
		elseif ($judulisi=="gambar") { $tipe="gambar"; }
		elseif ($judulisi=="logo") { $tipe="gambar"; }
		elseif ($judulisi=="cover") { $tipe="gambar"; }
		elseif ($judulisi=="favicon") { $tipe="gambar"; }
		elseif ($judulisi=="file") { $tipe="file"; }
		elseif ($judulisi=="id") { $tipe="id"; }
		elseif ($judulisi=="code") { $tipe="code"; }
		elseif ($judulisi=="no") { $tipe="no"; }
		elseif ($judulisi=="password") { $tipe="password"; }
		elseif ($judulisi=="kelamin") { $tipe="kelamin"; }
		elseif ($judulisi=="transaksi") { $tipe="transaksi"; }
		elseif ($judulisi=="tanggal") { $tipe="tanggal"; }
		elseif ($judulisi=="tanggal_lahir") { $tipe="waktu"; }
		elseif ($judulisi=="tgl") { $tipe="tgl"; }
		elseif ($judulisi=="tampilkan") { $tipe="optiontampil"; }
		elseif ($judulisi=="tipe") { $tipe="optionnumber"; }
		elseif ($judulisi=="layout") { $tipe="optionlayout"; }
		elseif ($judulisi=="target") { $tipe="optiontarget"; }
		elseif ($judulisi=="waktu") { $tipe="waktu"; }
		elseif ($judulisi=="publish") { $tipe="publish"; }
		elseif ($judulisi == "pengembangan") { $tipe = "textarea"; }
		else { $tipe="text"; }
		if ($isi=="id_galeri_kategori") { $tabelisi="galeri_kategori"; } 
		elseif ($isi=="id_produk_kategori") { $tabelisi="produk_kategori"; } 
		else {  $tabelisi= $tabelisi; }
		$this->formtipeisi=$tipe;
		$this->formtabelisi=$tabelisi;
	}


	public function form($subdomain,$linksub,$judul,$action,$value,$tampilan) {
		$spasi=explode("_",$judul); 
		$jumspasi=count($spasi);
		if ($jumspasi<=1) {  $judulisi=$judul; $tabelisi=$judul; } 
		else { list ($judulisi,$tabelisi)=explode("_",$judul); }
		$domain=$this->domain;
		$this->label($judul); 
		$label=$this->labelisi;
		$this->formtipe($judul); 
		$tipe=$this->formtipeisi;
		$tabelisi=$this->formtabelisi;
		if ($tipe=="text") { 
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<input type="text" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;" value="<?php echo $value;?>"/><br/><?php 
			}
			else { ?>
				<tr><td width="140" style="text"><?php echo $label;?></td>
					<td style="text-transform:none;"><input type="text" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;" value="<?php echo $value;?>"/></td></tr><?php
			}
		}
		elseif ($tipe=="password") { 
			if ($tampilan=="spasi") {
				echo $label;?><br/>
				<input type="password" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;"/><br/><?php 
			}
			else { ?>
				<tr><td width="140"><?php echo $label;?></td>
					<td style="text-transform:none;"><input type="password" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;"/></td></tr><?php
			}
		}
		elseif ($tipe=="texteditor") {
			if ($tampilan=="spasi") {
				echo $label;?><br/>
				<textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px;" rows="20"><?php echo $value;?></textarea><br/><?php
			}
			else { ?>
				<tr><td width="140"><?php echo $label;?></td>
					<td style="text-transform:none;"><textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $value;?></textarea></td></tr><?php
			}
		}
		elseif ($tipe == "pengembangan_pembiasaan") {
		    if ($tampilan == "spasi") {
		        echo $label;
		        ?>
		        <br>
		        <textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px;" rows="20"><?php echo $value;?></textarea>
		        <br>
		        <?php
		    } else {
		        ?>
		        <tr>
		            <td width="140"><?php echo $label;?></td>
		            <td><textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $value;?></textarea></td>
		        </tr>
		        <?php
		    }
		}
		elseif ($tipe == "pengembangan_kemampuan_dasar") {
		    if ($tampilan == "spasi") {
		        echo $label;
		        ?>
		        <br>
		        <textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px;" rows="20"><?php echo $value;?></textarea>
		        <br>
		        <?php
		    } else {
		        ?>
		        <tr>
		            <td width="140"><?php echo $label;?></td>
		            <td><textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $value;?></textarea></td>
		        </tr>
		        <?php
		    }
		}
		elseif ($tipe == "pendidikan_religiositas") {
		    if ($tampilan == "spasi") {
		        echo $label;
		        ?>
		        <br>
		        <textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px;" rows="20"><?php echo $value;?></textarea>
		        <br>
		        <?php
		    } else {
		        ?>
		        <tr>
		            <td width="140"><?php echo $label;?></td>
		            <td><textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $value;?></textarea></td>
		        </tr>
		        <?php
		    }
		}
		elseif ($tipe=="tanggal_lahir") {
			if ($tampilan=="spasi") {
				echo $label;?><br/>
				<textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px;" rows="20"><?php echo $value;?></textarea><br/><?php
			}
			else { ?>
				<tr><td width="140"><?php echo $label;?></td>
					<td style="text-transform:none;"><textarea name="<?php echo $judul;?>" id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $value;?></textarea></td></tr><?php
			}
		}
		elseif ($tipe=="textarea") {
			if ($tampilan=="spasi") {
				echo $label;?><br/>
				<textarea name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;" rows="4"><?php echo $value;?></textarea><br/><?php
			}
			else { ?>
				<tr><td width="140"><?php echo $label;?></td>
					<td style="text-transform:none;"><textarea name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px; text-transform:none;" rows="4"><?php echo $value;?></textarea></td></tr><?php
			}
		}
		elseif ($tipe=="gambar") { 
			if ($tampilan=="spasi") { 
				echo $label;?><br/><?php
				if ($value=="") { ?>
					<input name="gambarlama" type="hidden" value="<?php echo $value;?>"/>
					<input type="file" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px; padding:0px; padding-right:5px;"/><br/><?php 
				} 
				else { ?>
					<img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/picture/<?php echo $value;?>" width="80" height="60" alt="<?php echo $value;?>" style="margin:5px 10px 5px 0px;"/><br/>
					<input name="gambarlama" type="hidden" value="<?php echo $value;?>"/>
					<input type="file" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px; padding:0px;padding-right:5px;"/><br/>
					<h6>Kosongkon fom ini jika tidak ada perubahan gambar</h6><br/><?php 
				} 
			}
			else { ?>
				<tr><td width="140"><?php echo $label;?></td><td><?php 
				if ($value=="") { ?>
					<input name="gambarlama" type="hidden" value="<?php echo $value;?>"/>
					<input type="file" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px; padding:0px; padding-right:5px;"/><?php 
				} 
				else { ?>
					<img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/picture/<?php echo $value;?>" width="80" height="60" alt="<?php echo $value;?>" style="margin:5px 10px 5px 0px;"/><br/>
					<input name="gambarlama" type="hidden" value="<?php echo $value;?>"/>
					<input type="file" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px; padding:0px;padding-right:5px"/>
					<h6>Kosongkon fom ini jika tidak ada perubahan gambar</h6><?php 
				} ?>
				</td></tr><?php
			}
		}
		elseif ($tipe=="file") { 
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<input type="file" name="file" id="file" style="width:95%; max-width:500px; padding:0px;padding-right:5px"/><br/><?php
				if ($value=="") { ?><input name="filelama" type="hidden" value="<?php echo $value;?>"/><?php } 
				else { ?>
					<input name="filelama" type="hidden" value="<?php echo $value;?>" />
					<h6>Kosongkon fom ini jika tidak ada perubahan file</h6><br/><?php 
				} 
			}
			else { ?>
				<tr><td><?php echo $label;?></td><td>
				<input type="file" name="file" id="file" style="width:95%; max-width:500px; padding:0px;padding-right:5px;"/><?php 
				if ($value=="") { ?><input name="filelama" type="hidden" value="<?php echo $value;?>"/><?php } 
				else { ?>
					<input name="filelama" type="hidden" value="<?php echo $value;?>" />
					<h6>Kosongkon fom ini jika tidak ada perubahan file</h6><?php 
				} ?>
				</td></tr><?php
			}
		}
		elseif ($tipe=="id" or $tipe=="code"  or $tipe=="no") { 
			if ($tipe=="id") { $kolom="no"; $juduldata="judul"; } elseif ($tipe=="code") { $kolom="kode";  $juduldata="judul"; } else { $kolom="no"; $juduldata="nama"; }
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php
					if ($value=="") { } 
					else {
						$qidid=mysqli_query($koneksi, "SELECT * FROM $tabelisi WHERE $kolom='$value' AND subdomain='$subdomain'");
						$didid=mysqli_fetch_array($qidid); ?>
						<option value="<?php echo $didid[$kolom];?>"><?php if ($kolom=="no"){ echo $did[$juduldata].$did['jurusan'].$did['kelompok'];} else { echo $did[$juduldata]; }?></option><?php
					}
					$qid=mysqli_query($koneksi, "SELECT * FROM $tabelisi WHERE subdomain='$subdomain'");
					while($did=mysqli_fetch_array($qid)){ ?><option value="<?php echo $did[$kolom];?>"><?php 
					if ($kolom=="no"){ echo $did[$juduldata].$did['jurusan'].$did['kelompok'];} else { echo $did[$juduldata]; }?></option><?php } ?>
				</select><?php
			}
			else {  ?>
				<tr><td><?php echo $label;?></td>
					<td>
						<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php
							if ($value=="") { } 
							else {
								$qidid=mysqli_query($koneksi, "SELECT * FROM $tabelisi WHERE $kolom='$value' AND subdomain='$subdomain'");
								$didid=mysqli_fetch_array($qidid); ?>
								<option value="<?php echo $didid[$kolom];?>"><?php echo $didid[$juduldata];?></option><?php
							}
							$qid=mysqli_query($koneksi, "SELECT * FROM $tabelisi WHERE subdomain='$subdomain'");
							while($did=mysqli_fetch_array($qid)){ ?><option value="<?php echo $did[$kolom];?>"><?php echo $did[$juduldata];?></option><?php } ?>
						</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="optionnumber") { 
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<select name="<?php echo $judul;?>"><?php 
				if ($value==""){ } else { ?><option value="<?php echo $value;?>"><?php echo $value;?></option><?php }
				$idtipe=1; do { ?><option value="<?php echo $idtipe;?>"><?php echo $idtipe;?></option><?php $idtipe++; } while ($idtipe<=10);?>
				</select><?php
			}
			else { ?>
				<tr><td><?php echo $label;?></td>
					<td>
					<select name="<?php echo $judul;?>"><?php 
					if ($value==""){ } else { ?><option value="<?php echo $value;?>"><?php echo $value;?></option><?php }
					$idtipe=1; do { ?><option value="<?php echo $idtipe;?>"><?php echo $idtipe;?></option><?php $idtipe++; } while ($idtipe<=10);?>
					</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="optionmember") {
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php 
					if ($value==""){ } else { ?><option value="<?php echo $value;?>"><?php echo $value;?></option><?php } ?>
					<option value="member">Member</option>
					<option value="admin">Administrator</option>
					<option value="super">Super Administrator</option>
				</select><br/><?php 
			}
			else { ?>
				<tr><td><?php echo $label;?></td>
					<td>
					<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php 
						if ($value==""){ } else { ?><option value="<?php echo $value;?>"><?php echo $value;?></option><?php } ?>
						<option value="member">Member</option>
						<option value="admin">Administrator</option>
						<option value="super">Super Administrator</option>
					</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="optiontarget") { 
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<select name="target" style="width:96%; max-width:510px;"><?php
					if ($value=="") { ?><option value="_parent">Buka Di Halaman Yang Sama</option><option value="_blank">Buka Di Tab Yang Baru</option><?php }
					elseif ($value=="_parent"){ ?><option value="_parent">Buka Di Halaman Yang Sama</option><option value="_blank">Buka Di Tab Yang Baru</option><?php } 
					else { ?><option value="_blank">Buka Di Tab Yang Baru</option><option value="_parent">Buka Di Halaman Yang Sama</option><?php } ?>
				</select><br/><?php 
			}
			else { ?>
				<tr><td><?php echo $label;?></td>
					<td>
					<select name="target" style="width:96%; max-width:510px;"><?php
						if ($value=="") { ?><option value="_parent">Buka Di Halaman Yang Sama</option><option value="_blank">Buka Di Tab Yang Baru</option><?php }
						elseif ($value=="_parent"){ ?><option value="_parent">Buka Di Halaman Yang Sama</option><option value="_blank">Buka Di Tab Yang Baru</option><?php } 
						else { ?><option value="_blank">Buka Di Tab Yang Baru</option><option value="_parent">Buka Di Halaman Yang Sama</option><?php } ?>
					</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="optiontampil") {
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php
					if ($value=="") { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php }
					elseif ($value=="1"){ ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } 
					else { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php } ?>
				</select><br/><?php 
			}
			else { ?>
				<tr><td><?php echo $label;?></td>
					<td>
					<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php 
						if ($value==""){ ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } 
						elseif ($value==1) { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } 
						elseif ($value==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php } ?>
					</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="publish") {
			if ($tampilan=="spasi") { ?>
				Tampilkan<br/>
				<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php
					if ($value=="") { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php }
					elseif ($value=="1"){ ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } 
					else { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php } ?>
				</select><br/><?php 
			}
			else { ?>
				<tr><td>Tampilkan</td>
					<td>
					<select name="<?php echo $judul;?>" style="width:96%; max-width:510px;"><?php 
						if ($value==""){ ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } 
						elseif ($value==1) { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } 
						elseif ($value==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php } ?>
					</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="waktu") {
			if ($value==""){ } else { list ($tahun,$bulan,$tanggal)=explode("-",$value); }
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<input type="hidden" name="waktu_<?php echo $isiform; ?>"/>
				Tanggal 
				<select name="tgl<?php echo $tabelisi; ?>"><?php 
					if ($value==""){ } else { ?><option value="<?php echo $tanggal;?>"><?php echo $tanggal;?></option><?php }
					$tgl=1;do {?><option value="<?php echo $tgl;?>"><?php echo $tgl;?></option><?php $tgl++;} while ($tgl<=31);?>
				</select>&nbsp;&nbsp;
				Bulan 
				<select name="bln<?php echo $tabelisi; ?>"><?php 
					if ($value==""){ } else { ?><option value="<?php echo $bulan;?>"><?php echo $bulan;?></option><?php }
					$bln=1; do {?><option value="<?php echo $bln;?>"><?php echo $bln;?></option><?php $bln++;} while ($bln<=12);?>
				</select>&nbsp;&nbsp;
				Tahun 
				<select name="thn<?php echo $tabelisi; ?>"><?php 
					if ($value==""){ } else { ?><option value="<?php echo $tahun;?>"><?php echo $tahun;?></option><?php }
					$thn=date("Y"); $thnakhir=date("Y")+1; 
					do {?><option value="<?php echo $thn;?>"><?php echo $thn;?></option><?php $thn++;} while ($thn<=$thnakhir);?>
				</select><br/><?php 
			}
			else { ?>
				<tr><td><?php echo $label;?></td>
					<td>
					<input type="hidden" name="waktu_<?php echo $isiform; ?>">
					Tanggal 
					<select name="tgl<?php echo $tabelisi; ?>"><?php 
						if ($value==""){ } else { ?><option value="<?php echo $tanggal;?>"><?php echo $tanggal;?></option><?php }
						$tgl=1;do {?><option value="<?php echo $tgl;?>"><?php echo $tgl;?></option><?php $tgl++;} while ($tgl<=31);?>
					</select>&nbsp;&nbsp;
					Bulan 
					<select name="bln<?php echo $tabelisi; ?>"><?php 
						if ($value==""){ } else { ?><option value="<?php echo $bulan;?>"><?php echo $bulan;?></option><?php }
						$bln=1; do {?><option value="<?php echo $bln;?>"><?php echo $bln;?></option><?php $bln++;} while ($bln<=12);?>
					</select>&nbsp;&nbsp;
					Tahun 
					<select name="thn<?php echo $tabelisi; ?>"><?php 
						if ($value==""){ } else { ?><option value="<?php echo $tahun;?>"><?php echo $tahun;?></option><?php }
						$thn=date("Y"); $thnakhir=date("Y")+1; 
						do {?><option value="<?php echo $thn;?>"><?php echo $thn;?></option><?php $thn++;} while ($thn<=$thnakhir);?>
					</select>
					</td>
				</tr><?php
			}
		}
		elseif ($tipe=="tgl") {
			if ($tampilan=="spasi") { ?>
				Tanggal<br/>
				<input type="text" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;" value="<?php echo $value; ?>"/>
				<script type="text/javascript">$(document).ready(function(){$('#<?php echo $judul;?>').Zebra_DatePicker();});</script>
				<br/><?php 
			}
			else { ?>
				<tr><td width="140">Tanggal</td>
					<td><input type="text" name="<?php echo $judul;?>" id="<?php echo $judul;?>" style="width:95%; max-width:500px;" value="<?php echo $value; ?>"/>
						<script type="text/javascript">$(document).ready(function(){$('#<?php echo $judul;?>').Zebra_DatePicker();});</script>
					</td>
				</tr><?php
			}
		}
		else {
			if ($tampilan=="spasi") { 
				echo $label;?><br/>
				<input type="text" name="<?php echo $judul;?>" id="<?php echo $judul; ?>"style="width:95%; max-width:500px;" value="<?php echo $value; ?>"/><br/><?php 
			}
			else { ?>
				<tr><td width="140"><?php echo $label;?></td>
					<td><input type="text" name="<?php echo $judul;?>" id="<?php echo $judul; ?>"style="width:95%; max-width:500px;" value="<?php echo $value; ?>"/></td></tr><?php
			}
		}
	}


	public function publish ($subdomain,$linksub,$tabel) {
		$no=$this->no;
		if (empty ($no)) { $this->notify($subdomain,$linksub,"empty"); }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT no,publish FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { $this->notify($subdomain,$linksub,"empty"); }
			else { 
				if($data['publish']==1) { mysqli_query($koneksi, "UPDATE $tabel SET publish='0' WHERE no='$no' AND subdomain='$subdomain'");  } 
				elseif ($data['publish']==0) { mysqli_query($koneksi, "UPDATE $tabel SET publish='1' WHERE no='$no' AND subdomain='$subdomain'"); } 
				else { mysqli_query($koneksi, "UPDATE $tabel SET publish='1' WHERE no='$no' AND subdomain='$subdomain'"); }
			}
		}
	}


	public function terbaru ($subdomain,$linksub,$tabel) {
		$no=$this->no;
		if (empty ($no)) { $this->notify($subdomain,$linksub,"empty"); }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT no FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { $this->notify($subdomain,$linksub,"empty"); } 
			else { mysqli_query($koneksi, "UPDATE $tabel SET tgl=sysdate() WHERE no='$no' AND subdomain='$subdomain'"); }
		}
	}
	

	public function urutan ($subdomain,$linksub,$tabel) {
		$no=$this->no;
		$key=$this->key;
		if (empty ($no)) { $this->notify($subdomain,$linksub,"empty"); }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT no,urutan FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { $this->notify($subdomain,$linksub,"empty"); } 
			else { 
				$urutan=$data['urutan'];
				if ($key=="minus") {
					if ($urutan==0) { $urutanbaru=$urutan; } else { $urutanbaru=$urutan-1; }
					mysqli_query($koneksi, "UPDATE $tabel SET urutan='$urutanbaru' WHERE no='$no' AND subdomain='$subdomain'");
				} 
				elseif ($key=="plus") {
					$urutanbaru=$urutan+1;
					mysqli_query($koneksi, "UPDATE $tabel SET urutan='$urutanbaru' WHERE no='$no' AND subdomain='$subdomain'");
				}
			}
		}
	}

	
	public function hapus ($subdomain,$linksub,$tabel,$tipe,$folder) {
		$no=$this->no;
		if (empty ($no)) { $this->notify($subdomain,$linksub,"empty"); }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { $this->notify($subdomain,$linksub,"empty"); }
			else {
				if($tipe=="gambar"){ 
					if(empty($data['gambar']) or $data['gambar']=="") { } 
					elseif ($data['gambar']=="s1.jpg" or $data['gambar']=="s2.jpg" or $data['gambar']=="s3.jpg" or $data['gambar']=="s4.jpg") { }
					elseif ($data['gambar']=="a1.jpg" or $data['gambar']=="a2.jpg" or $data['gambar']=="a3.jpg" or $data['gambar']=="a4.jpg") { }
					elseif ($data['gambar']=="b1.jpg" or $data['gambar']=="b2.jpg" or $data['gambar']=="b3.jpg" or $data['gambar']=="b4.jpg") { }
					elseif ($data['gambar']=="ban1.jpg" or $data['gambar']=="str1.jpg" or $data['gambar']=="f1.jpg" or $data['gambar']=="f2.jpg" or $data['gambar']=="f3.jpg" or $data['gambar']=="samb1.jpg") { }
					else { unlink("$folder/picture/".$data['gambar']); }
				}
				elseif($tipe=="file"){ 
					if(empty($data['file']) or $data['file']=="") { } else { unlink("$folder/file/".$data['file']); }
				}
				else {  }
				mysqli_query($koneksi, "DELETE FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
				$this->notify($subdomain,$linksub,"hapus_ok");
			}
		}
	}


	public function hapusmulti ($subdomain,$linksub,$tabel,$tipe,$folder) {
		$cek=$_POST['cek'];
		$jumdata=count($cek);
		if ($jumdata==0) { }
		else {
			for ($i="0"; $i<$jumdata; $i++) {
				$no=$cek[$i];
				$query=mysqli_query($koneksi, "SELECT * FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
				$data=mysqli_fetch_array($query);
				if($tipe=="gambar"){ 
					if(empty($data['gambar']) or $data['gambar']=="") { } 
					elseif ($data['gambar']=="s1.jpg" or $data['gambar']=="s2.jpg" or $data['gambar']=="s3.jpg" or $data['gambar']=="s4.jpg") { }
					elseif ($data['gambar']=="a1.jpg" or $data['gambar']=="a2.jpg" or $data['gambar']=="a3.jpg" or $data['gambar']=="a4.jpg") { }
					elseif ($data['gambar']=="b1.jpg" or $data['gambar']=="b2.jpg" or $data['gambar']=="b3.jpg" or $data['gambar']=="b4.jpg") { }
					elseif ($data['gambar']=="ban1.jpg" or $data['gambar']=="str1.jpg" or $data['gambar']=="f1.jpg" or $data['gambar']=="f2.jpg" or $data['gambar']=="f3.jpg" or $data['gambar']=="samb1.jpg") { }
					else { unlink("$folder/picture/".$data['gambar']); }
				}
				elseif($tabel=="file"){ 
					if(empty($data['file']) or $data['file']=="") { } else { /*unlink("$folder/file/".$data['file']);*/ }
				}
				mysqli_query($koneksi, "DELETE FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
			}
			$this->notify($subdomain,$linksub,"hapus_ok");
		}
	}


	public function notify ($subdomain,$linksub,$tipe) {
		$mod=$this->mod;
		$adm=$this->adm;
		$linkmod=$linksub."/".$adm."/".$mod;
		if($tipe=="empty"){ ?>
			<h3>Data Tidak Ada</h3>Maaf, Data Yang Anda Cari Tidak Ada<?php
		}
		elseif($tipe=="empty_write"){ ?>
			<h3>Data Masih Kosong</h3>Maaf, Data Anda Masih Kosong<?php
		}
		elseif($tipe=="img_empty"){ ?>
			<h3>Gambar Masih Kosong</h3>Gambar Harus Diisi<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="img_format"){ ?>
			<h3>Format Gambar Tidak Sesuai</h3>Format Gambar Yang Diijinkan adalah (JPG, PNG, GIF)<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="image_dimention"){ ?>
			<h3>Resolusi Gambar Terlalu Besar</h3>Ukuran Gambar Yang Diijinkan Maksimal 1000 X 1000 pixels<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="image_size"){ ?>
			<h3>Ukuran Gambar Terlalu Besar</h3>Ukuran Gambar Yang Diijinkan Maksimal 10 MB<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="file_empty"){ ?>
			<h3>File Masih Kosong</h3>File Harus Diisi<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="file_size"){ ?>
			<h3>Ukuran File Terlalu Besar</h3>Ukuran File Yang Diijinkan Maksimal 10 MB<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="nosession"){ ?>
			<h3>Data Berhasil Disimpan</h3>Selamat, Data Telah Berhasil Disimpan<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="save_ok"){ ?>
			<h3>Data Berhasil Disimpan</h3>Selamat, Data Telah Berhasil Disimpan<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="password_ok"){ ?>
			<h3>Password Berhasil Disimpan</h3>Selamat, Password Telah Berhasil Disimpan<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="email_ok"){ ?>
			<h3>Email Berhasil Dikirm</h3>Selamat, Email Anda Telah Berhasil Dikirm<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="save_fail"){ ?>
			<h3>Data Gagal Disimpan</h3>Maaf, Data Gagal Disimpan<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="edit_ok"){ ?>
			<h3>Data Berhasil Diubah</h3>Selamat, Data Telah Berhasil Diubah<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="hapus_ok"){ ?>
			<h3>Data Berhasil Dihapus</h3>Selamat, Data Telah Berhasil Dihapus<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="hapus_pictok"){ ?>
			<h3>Gambar Berhasil Dihapus</h3>Selamat, Gambar Telah Berhasil Dihapus<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		elseif($tipe=="email_notvalid"){ ?>
			<h3>Email Tidak Valid</h3>Maaf, Email Anda Tidak Valid<br/><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
		}
		else {
		}
	}	



	public function tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,$syarat) {		
		$domain=$this->domain;
		$adm=$this->adm;
		$mod=$this->mod;
		$orderby=$this->order;
		$by=$this->by;
		$page=$this->page;
		$linkmod=$linksub."/".$adm."/".$mod;
		$linkcari=$linkmod."/act/cari/";	
		$batas=$batas;
		if ($act=="") { $act="none"; } else { $act=$act; }	
		if ($act=="cari") { 
			$posisi=0; $page=1; 
			if (empty($_POST['keyword'])) { if (empty($orderby)) { $keycari=""; } else { $keycari=$orderby;  } } else { $keycari=strip_tags(mysql_escape_string($_POST['keyword'])); }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%'");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel WHERE judul LIKE '%$keycari%' ORDER BY judul");
			$linkpage=$linkmod."/act/".$act."/".$keycari."/".$by;
		}
		elseif($act=="urut") { 
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel ORDER BY $orderby $by LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		else {
			if ($page=="") { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
			$qjum =mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel $syarat");
			$query=mysqli_query($koneksi, "SELECT *,DATE_FORMAT(tgl,'%d-%m-%y<h5>%H:%i:%s</h5>') as tanggal FROM $tabel $syarat ORDER BY $orderby DESC LIMIT $posisi,$batas ");
			$linkpage=$linkmod."/act/".$act."/".$orderby."/".$by;
		}
		$y=1; 
		$nomor=$posisi+1;
		$jumlah=mysqli_num_rows($qjum);
		if ($jumlah==0) { ?>
			<h2>
				<span style="float:left; margin-right:10px;">Tabel <?php echo $judulmod;?></span>
				<span style="font-size:11px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Tambah <?php echo $judulmod;?>" class="button_add">TAMBAH</a></span>
			</h2><?php
			$this->notify($subdomain,$linksub,"empty_write"); 
		}
		else { ?>
			<div style="display:table; width:100%;">
				<h2 style="float:left;">
					<span style="float:left; margin-right:10px;">Tabel <?php echo $judulmod;?></span>
					<span style="font-size:11px;"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" title="Tambah <?php echo $judulmod;?>" class="button_add">TAMBAH</a></span>
				</h2>
				<div class="cari" style="margin-bottom:5px;">
					<form action="<?php echo $this->getHttp();?>://<?php echo $linkcari;?>" method="post">
						<input type="text" name="keyword" size="20" id="keyword" value="Pencarian" maxlength="30" onblur="if (this.value=='') this.value='Pencarian';" onfocus="if (this.value=='Pencarian') this.value='';"/>&nbsp;
						<input name="cari" type="submit" value="" onClick="return cekkeyword();" id="tombol" style="cursor:pointer"/>
					</form>
				</div>
			</div>
			<form action="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/hapusmulti/" method="post" name="form_tabel" onsubmit="konfirmHapus();return false;">
			<table width="100%" id="tabellist" cellpadding="0" cellspacing="0">
				<tr class="tabelhead">
					<th width="15"></th><?php
					$kolom=explode(",",$kolom);
					$lebar=explode(",",$lebar);
					$jumkolom=count($kolom);
					for($i=0;$i<$jumkolom;$i++){ 
						if ($kolom[$i]=="judul" or $kolom[$i]=="nama") { $width=""; } else { $width=$lebar[$i]; } 
						if ($kolom[$i]=="menu" or $kolom[$i]=="module") { $idurut="id_".$kolom[$i]; } else { $idurut=$kolom[$i]; } 
						if ($by=="desc") { $bybaru="asc"; } elseif ($by=="asc") { $bybaru="desc"; }
						$linkkolom=$linkmod."/act/urut/".$idurut."/".$bybaru."/"; ?>
						<th width="<?php echo $width;?>"><a href="<?php echo $this->getHttp();?>://<?php echo $linkkolom;?>" title="Urut <?php echo $kolom[$i];?>"><?php $this->label($kolom[$i]); echo $this->labelisi;?></a></th><?php 
					} 
					if ($kolomvisit!=1) { } else { ?><th width="50"><?php }
					if ($kolomkomen!=1) { } else { ?></th><th width="40"></th><?php }
					if ($kolomtgl!=1) { } else { ?><th width="60" style="text-align:right"><a href="<?php echo $this->getHttp();?>://<?php echo $linkmod;?>/act/urut/tgl/<?php echo $bybaru;?>/" title="Urut Tanggal">Tanggal</a></th><?php } ?>
				</tr><?php
			while($data=mysqli_fetch_array($query)) {
				$no=$data['no'];
				$pub=$data['publish'];
				$aktif=$data['aktif'];
				$paket=$data['paket'];
				if ($data['subdomain']==""){
					$sub=$data['domain'];
					$kataimbuhan="";
				}
				else {
					$sub=$data['subdomain'];
					$kataimbuhan=".mysch.id";
				}
				$tanggal=$data['tanggal'];
				if ($y%2==0) { $latar="#FAFAFA"; } else { $latar="#FFFFFF"; } 
				if ($pub==0) { $latar="FFDDDD"; } else { $latar=$latar; }
				if ($tabel=="setting"){
				if ($aktif==0 && $paket!="free") { $latar="#CCFFCC"; } else { $latar=$latar; }
				}
				else{
					if ($aktif==0) { $latar="#6FFFFF"; } else { $latar=$latar; }
				}?>
				<tr bgcolor="<?php echo $latar; ?>" align="left">
					<td align="center" style="padding:10px 0px;"><input name="cek[]" type="checkbox" value="<?php echo $no;?>"/></td><?php
					for($j=0;$j<$jumkolom;$j++){ ?>
						<td><?php $this->data($tabel,$kolom[$j],$no); echo $this->dataisi;
						if ($kolom[$j]=="judul" or $kolom[$j]=="nama") { ?>
							<div class="tombol"><h6 class="menuaction"><a href="//<?php echo $sub.$kataimbuhan;?>" target="_blank"  title="Lihat Web"/>Lihat Web</a></h6>
							<?php
							$tombolaction=explode(",",$tombolact); $jumtombolact=count($tombolaction);
							for($k=0;$k<$jumtombolact;$k++){ $this->tombolaction($subdomain,$linkmod,$tombolaction[$k],$no,$pub,""); } ?>
							</div><?php
						}
						else { } ?>
						</td><?php 
					} 
					if ($kolomvisit!=1) { } 
					else { 
						$gambarvisit=$this->getHttp()."://".$domain."/image/visitor.png"; 
						$visitor=$data['jumlah_pembaca']; ?>
						<td align="right"><?php echo $visitor?><img src="<?php echo $gambarvisit;?>" style="margin:0px 0px 0px 4px;" align="right"/></td><?php
					}
					if ($kolomkomen!=1) { }
					else { 
						$gambarkomen=$this->getHttp()."://".$domain."/image/comment.png";
						$qkomen=mysqli_query($koneksi, "SELECT no FROM komentar WHERE id_$tabel='$no' AND subdomain='$subdomain'"); $jumkomen=mysqli_num_rows($qkomen); ?>
						<td align="right"><?php echo $jumkomen?><img src="<?php echo $gambarkomen;?>" style="margin:4px 0px 0px 4px;" align="right"/></td><?php
					}
					if ($kolomtgl!=1) { } else { ?><td align="right"><?php echo $tanggal; ?></td><?php } ?>
				</tr><?php
				$nomor++; $y++;
			} ?>
			</table>
			<div style="display:table; width:100%; padding:5px 0px; ">
				<div style="float:left; width:35%; text-align:left;"><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/check.png" title="Tandai Semua" alt="Tandai Semua" class="button_paging" onclick="checkAll();"/><img src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/uncheck.png" title="Hilangkan Tanda" alt="Hilangkan Tanda" class="button_paging" onclick="uncheckAll();"/><input type="image" src="<?php echo $this->getHttp();?>://<?php echo $domain;?>/image/hapus.png" class="button_paging" title="Hapus"/></div>
				<div style="float:right; width:65%; text-align:right;"><?php $jumhal=ceil($jumlah/$batas); $this->paging($jumhal,$linkpage,$page); ?></div>
			</div>
			</form><?php 
		}
	}
}
?>
