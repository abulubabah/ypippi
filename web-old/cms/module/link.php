<?php 
if ($tampil==1) {   
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){ ?>
		<div class="<?php echo $stylepanel;?>"><?php 
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?> 
			<div class="<?php echo $styleisi;?>">
				<ul><?php
				$dlink=array();
				if (!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.link.'.$layoutno)){
					$dlink=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.link.'.$layoutno),true);
				}
				
				if (empty($dlink)){
					$query=$db->query("SELECT judul,url,target FROM link WHERE id_module='$layoutno' AND subdomain='$subdomain' AND publish='1' ORDER BY tgl DESC");
					$dlink=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.link.'.$layoutno,json_encode($dlink));
				}
				
				foreach($dlink as $data) { 
					$judul=$data['judul']; 
					$url=$data['url'];
					$target=$data['target'];?>
					<li><a href="<?php echo $url;?>" title="<?php echo $judul;?>" target="<?php echo $target;?>"><?php echo $judul;?></a></li><?php
				} ?> 
				</ul>
			</div>
		</div><?php 
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$judulmod="Link";
		$tabel="link"; 
		$batas=30;
		$kolom="judul,id_module";
		$lebar="200,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="single";
		$tipedetail="link";
		$isidetail="url";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekJudul";
		$tipeinput="module";
		$forminput="judul,url";
		$jenisinputrinci="";
		$onclickrinci="cekhtml";
		$tipeinputrinci="module";
		$forminputrinci="judul,url,target";
		$formeditrinci="judul,url,target,publish,tgl";
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
			$no=(int) $module->no;
			$query=$db->query("SELECT id_module FROM link WHERE no='".$no."' AND subdomain='".$db->escape($subdomain)."'");
			$id_module=$query->row['id_module'];
			//delete cache 
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.link.'.$id_module);
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
			foreach ($_POST['cek'] as $key=>$value){
				$no=(int) $value;
				$query=$db->query("SELECT id_module FROM link WHERE no='".$no."' AND subdomain='".$db->escape($subdomain)."'");
				$id_module=$query->row['id_module'];
				//delete cache 
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.link.'.$id_module);
			}
		} 
		elseif ($act=="tambah") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
		} 
		elseif ($act=="tambahrinci") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
		} 
		elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
			$no=(int) $module->no;
			$query=$db->query("SELECT id_module FROM link WHERE no='".$no."' AND subdomain='".$db->escape($subdomain)."'");
			$id_module=$query->row['id_module'];
			//delete cache 
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.link.'.$id_module);
		} 
		elseif ($act=="ubahrinci") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
			$no=(int) $module->no;
			$query=$db->query("SELECT id_module FROM link WHERE no='".$no."' AND subdomain='".$db->escape($subdomain)."'");
			$id_module=$query->row['id_module'];
			//delete cache 
			$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.link.'.$id_module);
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