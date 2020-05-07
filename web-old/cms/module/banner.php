<?php
//harus ada instansi dari $db,$filemanager di conn.php
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){
	    $queryWhmcs = $db->query("SELECT whmcs FROM setting WHERE subdomain = '" . $subdomain . "' LIMIT 1");
	    $dataWhmcs = $queryWhmcs->row;
	    $whmcs = $dataWhmcs['whmcs'];
    	    ?>
    		<div class="<?php echo $stylepanel;?>"><?php 
    			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
    			<div class="<?php echo $styleisi;?>"><?php
    				if (!is_dir(DIR_CACHE.$subdomain)){
    					mkdir(DIR_CACHE.$subdomain,0755);
    				}
    			
    				$dam=array();
    				if (file_exists(DIR_CACHE.$subdomain.'/cache.banner.'.$layoutno)){
    					$dam=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.banner.'.$layoutno),true);
    				}
    
    				if (empty($dam)){
    					$query=$db->query("SELECT judul,url,target,gambar FROM banner WHERE id_module='$layoutno' AND subdomain='$subdomain' AND publish='1' ORDER BY tgl DESC");
    					$dam=$query->rows;
    					$filemanager->set(DIR_CACHE.$subdomain.'/cache.banner.'.$layoutno,json_encode($dam));
    				
    				}
    				
                    foreach($dam as $data) {
    					$judul=$data['judul'];
    					$url=$data['url'];  
    					$target=$data['target'];
    					$gambar=$data['gambar'];
    					$urlgambar=$domain."/picture/".$gambar;
    					if ($url=="") { ?><img data-src="//<?php echo $urlgambar;?>" border="0" width="100%" alt="<?php echo $judul;?>"/><?php }
    					else { ?><a href="<?php echo $url;?>" title="<?php echo $judul;?>" target="<?php echo $target;?>"><img data-src="//<?php echo $urlgambar;?>" border="0" width="100%" alt="<?php echo $judul;?>"/></a><?php }
    				} ?>
    			</div>
    		</div><?php
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$judulmod="Banner";
		$tabel="banner";
		$batas=30;
		$kolom="judul,id_module";
		$lebar="200,200";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="ubah,lihat,hapus";
		$jumdetail="multi";
		$tipedetail="table-pict";
		$isidetail="judul,id_module,url,target";
		$tipedelete="gambar";
		$jenisinput="gambar";
		$onclick="cekJudul";
		$tipeinput="module";
		$forminput="judul,gambar";
		$jenisinputrinci="gambar";
		$onclickrinci="cekJudul";
		$tipeinputrinci="module";
		$forminputrinci="judul,url,target,publish,gambar";
		$formeditrinci="judul,url,target,publish,tgl,gambar";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		global $filemanager;
		global $db;
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
					$filemanager->delete($value);
				}
				
			}
		} 
		elseif ($act=="hapusmulti") {
			$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete($value);
				}
				
			}
		} 
		elseif ($act=="tambah") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete($value);
				}
				
			}
		} 
		elseif ($act=="tambahrinci") {
			$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
			foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
				if (file_exists($value)){
					$filemanager->delete($value);
				}
				
			}
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