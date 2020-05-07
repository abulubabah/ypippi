<?php  
if ($tampil==1) {  
	if (empty($akses)) {
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ ?>
		<div class="<?php echo $stylepanel;?>"><?php  
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
			<div class="<?php echo $styleisi;?>"><?php
			    $dtext=array();
				if (!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.text.'.$layoutno)){
					$dtext=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.text.'.$layoutno),true);
				}
				
				if (empty($dtext)){
					$query=$db->query("SELECT isi FROM teks WHERE id_module='$layoutno' AND publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC");
					$dtext=$query->rows;
					$filemanager->set(DIR_CACHE.$subdomain.'/cache.text.'.$layoutno,json_encode($dtext));
				}
				
				foreach($dtext as $data) {
					echo $isiteks=$data['isi']; 
				} ?>
			</div>
		</div><?php 
	}
	elseif($akses=="admin" or $akses=="super"){
		$judulmod="Teks";
		$tabel="teks";
		$batas=30;
		$kolom="judul,id_module";
		$lebar="200,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="single";
		$tipedetail="";
		$isidetail="isi";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekJudul";
		$tipeinput="module";
		$forminput="judul,isi";
		$jenisinputrinci="";
		$onclickrinci="cekJudul";
		$tipeinputrinci="module";
		$forminputrinci="judul,publish,isi";
		$formeditrinci="judul,publish,tgl,isi";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
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
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
		} 
		elseif ($act=="tambah") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
		} 
		elseif ($act=="tambahrinci") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
		} 
		elseif ($act=="ubah") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
		} 
		elseif ($act=="ubahrinci") {
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
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