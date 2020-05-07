<?php  
if ($tampil==1) { 
	if(empty($akses)){ 
		header("location:index.php"); 
	}
	elseif($akses=="publik" or $akses=="member"){ ?> 
		<div class="<?php echo $stylepanel;?>"><?php 
			if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
			<div class="<?php echo $styleisi;?>"><?php
				$query=mysqli_query($koneksi, "SELECT no,nama,komentar,id_halaman,id_berita FROM komentar WHERE publish='1' AND subdomain='$subdomain' AND no_komentar='0' ORDER BY tgl DESC LIMIT 0,10");
				while($data=mysqli_fetch_array($query)) {
					$nokom=$data['no'];
					$namakom=$data['nama'];
					$komentar=$data['komentar'];
					$idhal=$data['id_halaman'];
					$idart=$data['id_berita'];
					if ($idhal==0) { 
						$qasal=mysqli_query($koneksi, "SELECT no,link FROM berita WHERE no='$idart'");
						$dasal=mysqli_fetch_array($qasal);
						$asalno=$dasal['no'];
						$asallink=$dasal['link'];
						$linkkomentar="//".$linksub."/berita/".$asalno."/".$asallink;
					} 
					else { 
						$qasal=mysqli_query($koneksi, "SELECT no,link FROM halaman WHERE no='$idhal'");
						$dasal=mysqli_fetch_array($qasal);
						$asalno=$dasal['no'];
						$asallink=$dasal['link'];
						$linkkomentar="//".$linksub."/".$asallink;
					} ?>
					<li><a href="<?php echo $linkkomentar;?>/#<?php echo $nokom;?>" title="<?php echo $namakom;?>"><?php 
						$lindungi_isi=strip_tags($komentar); $kalimat=strtok($lindungi_isi,"  ");
						for ($i=1; $i<=4; $i++) { echo ($kalimat); echo ("  "); $kalimat=strtok ("  "); } ?>...
						</a>
					</li><?php
				} ?>
			</div>
		</div><?php
	}
	elseif($akses=="admin" or $akses=="super"){
		function komentar_balas ($subdomain,$linksub) {
			$module=new admin ();
			$module->get_variable();
			$module->setLinkSub($linksub);
			$domain=$module->domain;
			$mod=$module->mod;
			$adm=$module->adm;
			$act=$module->act;
			$no=$module->no;
			$linkhalaman=$linksub."/".$adm."/".$mod;
			if (empty ($no)) { $module->notify("empty"); }
			else {
				$no=$no/1;
				$query=mysqli_query($koneksi, "SELECT no,nama,telepon,email,komentar,id_halaman,id_berita,publish FROM komentar WHERE subdomain='$subdomain' AND no='$no'");
				$data=mysqli_fetch_array($query);
				if ($data['no']=="") { $module->notify("empty"); }
				else {
					if(empty($_POST['proses'])){ 
						$nama=$data['nama'];
						$telepon=$data['telepon'];
						$email=$data['email'];
						$komentar=$data['komentar'];
						$idhal=$data['id_halaman'];
						$idber=$data['id_berita'];
						$publish=$data['publish'];
						if ($idhal==0) { 
							$qasal=mysqli_query($koneksi, "SELECT judul FROM berita WHERE no='$idber'");
							$dasal=mysqli_fetch_array($qasal);
							$asaljudul=$dasal['judul'];
						} 
						else { 
							$qasal=mysqli_query($koneksi, "SELECT judul FROM halaman WHERE no='$idhal'");
							$dasal=mysqli_fetch_array($qasal);
							$asaljudul=$dasal['judul'];
						} ?>
						<form action="" method="post">
							<input type="hidden" name="id_komentar" value="<?php echo $no;?>" />
							<input type="hidden" name="proses" value="balas" />
							<h2>Balas Komentar</h2>
							<table width="100%" cellpadding="0" cellspacing="0" id="tabelview" >
								<tr><td width="150">Nama</td><td width="15">:</td><td><?php echo $nama;?></td></tr>
								<tr><td>Telepon</td><td>:</td><td><?php echo $telepon;?></td></tr>
								<tr><td>Email</td><td>:</td><td><?php echo $email;?></td></tr>
								<tr><td>Komentar Pada</td><td>:</td><td><?php echo $asaljudul;?></td></tr>
								<tr><td>Isi Komentar</td><td>:</td><td><?php echo $komentar;?></td></tr>
								<tr><td>Balas Komentar</td><td>:</td><td><textarea name="balasan" id="balasan" style="width:95%;max-width:500px;height:120px"></textarea></td></tr>
								<tr><td>Tampilkan</td><td>:</td>
									<td>
									<select name="publish" style="width:96%;max-width:510px;"><?php
										if ($publish=="0") { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
										else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
									</select>
									</td></tr>
								<tr><td></td><td></td>
									<td>
										<input type="submit" value="SIMPAN" class="button" onclick="return cekbalasan();" style="margin-bottom:5px;"/> &nbsp;
										<input type="button" value="KEMBALI" class="button_back"  onclick="self.history.back();" /> 
									</td></tr>
							</table>
						</form><?php
						$randkode=rand(111111,999999); 
						$_SESSION['kode']=$randkode;
					}
					elseif($_POST['proses']=="balas"){
						$uname=$_SESSION['uname'];
						$namaadmin=$_SESSION['nama'];
						$id_komentar=strip_tags($_POST['id_komentar']);
						$balasan=strip_tags($_POST['balasan']);
						$publish=strip_tags($_POST['publish']);
						if(empty($_SESSION['kode'])){ $module->notify($linksub,"nosession"); }
						else { 
							if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
							mysqli_query($koneksi, "UPDATE komentar SET publish='$publish' WHERE no='$id_komentar'");
							mysqli_query($koneksi, "INSERT INTO komentar (subdomain, no_komentar, nama, email, komentar, tgl, publish) 
								VALUES ('$subdomain', '$id_komentar', '$namaadmin', '$uname', '$balasan', sysdate(), '1')"); ?>
							<h3>Komentar Berhasil Dibalas</h3>Selamat, Balasan Komentar Berhasil Disimpan<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkhalaman;?>/" title="Kembali">Kembali</a><?php
						}
					}
				}
			}
		}

		$judulmod="Komentar";
		$tabel="komentar";
		$batas=30;
		$kolom="nama,komentar";
		$lebar="200,600";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="balas,lihat,hapus";
		$jumdetail="multi";
		$tipedetail="table";
		$isidetail="nama,telepon,email,komentar,id_berita,id_halaman,no_komentar";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekNama";
		$tipeinput="";
		$forminput="nama,telepon,email,komentar";
		$jenisinputrinci="";
		$onclickrinci="cekNama";
		$tipeinputrinci=""; 
		$forminputrinci="nama,telepon,email,komentar";
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
			$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
		} 
		elseif ($act=="balas") {
			komentar_balas($subdomain,$linksub);
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