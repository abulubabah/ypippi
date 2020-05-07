<?php 
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="admin" or $akses=="super"){ 		
		$judulmod="Klien";
		$tabel="setting"; 
		$batas=30;
		$kolom="judul,paket,telepon,email,followup";
		$lebar="200,100,100,150";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="tampilkan,sembunyikan,downgrade,followup";
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
		function publish ($tabel) {
		$module=new admin();
		$module->get_variable();
		$no=$module->no;
		if (empty ($no)) { echo "Nomor Kosong"; }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT no,paket,publish FROM $tabel WHERE no='$no'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			$paket=$data['paket'];
			if ($no=="") { echo "Nomor Kosong"; }
			else { 
				
					if($data['publish']==1) { mysqli_query($koneksi, "UPDATE $tabel SET publish='0' WHERE no='$no'");  } 
					elseif ($data['publish']==0) { mysqli_query($koneksi, "UPDATE $tabel SET publish='1' WHERE no='$no'"); } 
					else { mysqli_query($koneksi, "UPDATE $tabel SET publish='1' WHERE no='$no'"); }	
				}
			}
		}
		
		if (empty ($act)) {
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		} 
		elseif($act=="semua"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="urut"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="cari"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="premium"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"WHERE paket!='free'");
		}
		elseif($act=="free"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"WHERE paket='free'");
		}
		elseif ($act=="tampilkan"){
			publish ($tabel);
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="sembunyikan"){
			publish ($tabel);
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		else if ($act=="downgrade"){
			if (empty($_POST['proses'])){?>
			<h2>Downgrade</h2>
				<form method="post" action="">
					<input type="hidden" name="proses" value="simpan">
					<input type="hidden" name="no" value="<?php echo $module->no;?>">
						<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
							<tr><td width="140">Pilih Paket</td><td width="15">:</td><td><select name="paket"><option value="basic">Basic</option><option value="free">Free</option></td></tr>
						</table>
						<br/>
						<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/>&nbsp;&nbsp;
						<input type="submit" name="Downgrade"  value="DOWNGRADE"  class="button_back"/>&nbsp;&nbsp;
					</form><?php
			}
			else if ($_POST['proses']=="simpan"){
				$no=mysql_escape_string($_POST['no']);
				$paket=mysql_escape_string($_POST['paket']);
				$query=mysqli_query($koneksi, "select no,paket from setting where no='$no'");
				$data=mysqli_fetch_array($query);
				if (mysqli_num_rows($query)<1){ }
				else {
					if ($data['paket']!='free'){
						mysqli_query($koneksi, "update setting set paket='$paket' WHERE no='$no'");
					}
					
				}?>
				<h3>Downgrade Berhasil Dilakukan</h3>
				<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/><?php
				
			}
			
		}
		elseif ($act=="followup"){
			if (empty($_POST['proses'])){
			$qcekfolloup=mysqli_query($koneksi, "select followup from setting where no='" . $module->no ."'");
			$data=mysqli_fetch_array($qcekfolloup);
			$followup=$data['followup'];?>
			<h2>Followup</h2>
				<form method="post" action="">
					<input type="hidden" name="proses" value="simpan">
					<input type="hidden" name="no" value="<?php echo $module->no;?>">
						<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
							<tr><td width="140">Keterangan</td><td style="text-transform:none;"><textarea name="followup" id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $followup;?></textarea></td></tr>
						</table>
						<br/>
						<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/>&nbsp;&nbsp;
						<input type="submit" name="Simpan"  value="Simpan"  class="button_back"/>&nbsp;&nbsp;
					</form><?php
			}
			else if ($_POST['proses']=="simpan"){
				$no=mysql_escape_string($_POST['no']);
				$followup=mysql_escape_string($_POST['followup']);
				$qcekno=mysqli_query($koneksi, "select no from setting where no='$no'");
				if (mysqli_num_rows($qcekno)<1){ }
				else {
					mysqli_query($koneksi, "update setting set followup='$followup' WHERE no='$no'");
				}?>
				<h3>Data Berhasil Disimpan</h3>
				<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/><?php
				
			}
		}
		else {
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
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