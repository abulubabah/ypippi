<?php 
if ($tampil==1) {  
	if(empty($akses)){   
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ ?>
		<div class="<?php echo $stylepanel;?>"><?php 
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?> 
			<div class="<?php echo $styleisi;?>"><?php
    			$dhtml=array();
    			if(!is_dir(DIR_CACHE.$subdomain)){
    				mkdir(DIR_CACHE.$subdomain,0755);
    			}
    			
    			if (file_exists(DIR_CACHE.$subdomain.'/cache.html.'.$layoutno)){
    				$dhtml=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.html.'.$layoutno),true);
    			}
    			
    			if (empty($dhtml)){
    				$query=$db->query("SELECT kode_html FROM html WHERE id_module='$layoutno' AND subdomain='$subdomain' AND publish='1' ORDER BY tgl DESC");
    				$dhtml=$query->rows;
    				$filemanager->set(DIR_CACHE.$subdomain.'/cache.html.'.$layoutno,json_encode($dhtml));
    			}
    			
				foreach($dhtml as $data) {
					echo $kode_html=html_entity_decode($data['kode_html'],ENT_QUOTES,'UTF-8');  
				} ?>
			</div>
		</div><?php 
	}
	elseif($akses=="admin" or $akses=="super"){  
		$judulmod="HTML";
		$tabel="html";
		$batas=30;
		$kolom="judul,id_module";
		$lebar="200,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="single";
		$tipedetail="";
		$isidetail="kode_html";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekhtml";
		$tipeinput="module";
		$forminput="judul,kode_html";
		$jenisinputrinci="";
		$onclickrinci="cekhtml";
		$tipeinputrinci="module";
		$forminputrinci="judul,publish,kode_html";
		$formeditrinci="judul,publish,tgl,kode_html";
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