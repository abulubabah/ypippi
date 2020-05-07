<?php 
if($subdomain=='smkkesehatan1sukra.sch.id'){
    //error_reporting(E_ALL);
}
if ($tampil==1) {
	if(empty($akses)){ 
		header("location:index.php");  
	}
	elseif($akses=="publik"){ ?>
		<div class="content">
			<h2><a href="//<?php echo $linksub."/".$link;?>/" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2>
			<ul style="list-style:square;"><?php
			$dfile=array();
			if(!is_dir(DIR_CACHE.$subdomain)){
				mkdir(DIR_CACHE.$subdomain,0755);
			}
			
			if (file_exists(DIR_CACHE.$subdomain.'/cache.file')){
				$dfile=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.file'),true);
			}
			
			if (empty($dfile)){
				$query=$db->query("SELECT judul,deskripsi,file,lokasi,url FROM file WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC");
				$dfile=$query->rows;
				$filemanager->set(DIR_CACHE.$subdomain.'/cache.file',json_encode($dfile));
			}
			
			foreach($dfile as $data) {
				$judul=$data['judul'];
				$file=$data['file']; 
				$deskripsi=$data['deskripsi']; 
				$lokasi=$data['lokasi']; 
				$url=$data['url']; 
				if ($lokasi=="out") { $urlfile=$url; } else { $urlfile=$domain."/file/".$file; }	?>
				<li>
				<h3><a href="//<?php echo $urlfile;?>" title="<?php echo $judul;?>" target="_blank"><?php echo $judul;?></a></h3><?php
				echo $deskripsi; ?>
				</li><?php
			} ?>
			</ul>
		</div><?php
	}
	elseif($akses=="admin" or $akses=="super"){
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket']; $aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan profesional.<?php
		}
		else {
			if ($aktif==0) { ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php }
			else {
				$judulmod="File";
				$tabel="file";
				$batas=30;
				$kolom="judul";
				$lebar="200";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="judul,deskripsi";
				$tipedelete="file";
				$jenisinput="file";
				$onclick="cekJudul";
				$tipeinput="";
				$forminput="judul,deskripsi,file";
				$jenisinputrinci="file";
				$onclickrinci="cekJudul";
				$tipeinputrinci="judul,deskripsi";
				$forminputrinci="judul,deskripsi,file,publish";
				$formeditrinci="judul,deskripsi,file,publish,tgl";
				$module=new admin();
				$module->get_variable();
				$module->setLinkSub($linksub);
				$act=$module->act;
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
					$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.file');
				} 
				elseif ($act=="hapusmulti") {
					$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
					$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.file');
				} 
				elseif ($act=="tambah") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
					$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.file');
				} 
				elseif ($act=="tambahrinci") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
					$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.file');
				} 
				elseif ($act=="ubah") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
					$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.file');
				} 
				elseif ($act=="ubahrinci") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
					$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.file');
				} 
				else {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
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