<?php 
function detail($linksub,$subdomain){
    global $resize;
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$no=(int)$_GET['no']/1;
	$qcekdata=mysqli_query($koneksi, "select * from siswa where subdomain='$subdomain' And no='$no'");
	$data=mysqli_fetch_array($qcekdata);
	$gambar=$data['gambar']; if ($gambar==""){ $gambar="siswa.jpg"; } else { $gambar=$gambar;}
	$nama=$data['nama']; $nisn=$data['nisn'];
	$no_kelas=$data['no_kelas'];
        $qkelas=mysqli_query($koneksi, "select * from kelas where no='$no_kelas'");
	$dkelas=mysqli_fetch_array($qkelas); $namakelas=$dkelas['nama'];
	$jk=$data['kelamin_jenis'];
	if ($jk=="L"){ $jenis_kelamin=$jk; } else { $jenis_kelamin="Perempuan";} $jenis_kelamin=$jk;
	$agama=$data['agama'];
	$tempat_lahir=$data['tempat_lahir'];
	$tanggal_lahir=$data['tanggal_lahir'];
	$alamat=$data['alamat'];
	list($tahun,$bulan,$tanggal)=explode("-",$tanggal_lahir);
	$kota=$data['kota'];
	$kodepos=$data['kodepos'];
	$kelas=$data['kelas'];
	if ($subdomain=='smkn1simanindo.sch.id'){
		$kelas=$dkelas['nama'];
	}
	$nis=$data['nis'];
	$rombel=$data['rombel'];
	$jurusan=$data['jurusan'];
	if ($subdomain=='smkn1simanindo.sch.id'){
		$jurusan=$dkelas['jurusan'];
	}
	
	?>
	<h2>Detail Siswa</h2>
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr valign="top">
		<td width="160"><img data-src="<?php echo $resize->ubah($gambar,180,180);?>" class="gambar_member" alt="gambar"/></td>
		<td></td><td style="padding-left:5px;">
			<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
				<tr><td width="140">Nama</td><td width="15">:</td><td><?php echo $nama;?></td></tr>
				<tr><td width="140">N I S N</td><td width="15">:</td><td><?php echo $nisn;?></td></tr>
				<tr><td width="140">No Induk Sekolah</td><td width="15">:</td><td><?php echo $nis;?></td></tr>
				<tr><td width="140">Kelas</td><td width="15">:</td><td><?php echo $namakelas;?></td></tr>
				<tr><td width="140">Jenis Kelamin</td><td width="15">:</td><td><?php echo $jenis_kelamin;?></td></tr>
				<tr><td width="140">TTL </td><td width="15">:</td><td><?php echo $tempat_lahir. "$tanggal-$bulan-$tahun";?></td></tr>
				<tr><td width="140">Alamat</td><td width="15">:</td><td><?php echo $alamat;?></td></tr>
				<tr><td width="140">Kota</td><td width="15">:</td><td><?php echo $kota;?></td></tr>
				<tr><td width="140">Kodepos</td><td width="15">:</td><td><?php echo $kodepos;?></td></tr>
				<tr><td width="140">Jurusan</td><td width="15">:</td><td><?php echo $jurusan;?></td></tr>
			</table>
		</td>
	</tr>
	</table>
	<br/>
	<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/>	<?php
	
}

function tampil_siswa($linksub,$subdomain) {
	$publik=new publik();
	$publik->get_variable(); 
	$domain=$publik->domain;
	$link=$publik->link;
	$linkmodule=$linksub."/".$link;
	$batas=20;
	$kategori="";
	if (empty($_GET['page'])) { $page=1; } else { $page=(int)$_GET['page']; }
	if (empty($page)) { $posisi=0; $page=1; } else { $posisi=($page-1)*$batas; }
	?>
	<h2>Data Siswa</h2>
	<table width="100%" cellpadding="0" cellspacing="0" id="tabellist" >
		<tr>
			<th width="20"  style="text-align:center">No</th>
			<th width="100" style="text-align:center">Nama</th>
			<th width="100" style="text-align:center">Alamat</th>
			<th width="60" style="text-align:center">Detail</th>
		</tr><?php
		$jumlahdata=mysqli_num_rows(mysqli_query($koneksi, "select no from siswa where subdomain='$subdomain'"));
		$query=mysqli_query($koneksi, "select no,nama,nisn,link,alamat from siswa where subdomain='$subdomain' LIMIT $posisi,$batas");
		$uri=function(){
			$url=substr($_SERVER['REQUEST_URI'],1);
			$url=explode('?',$url);
			if ($url){
				$query_string=$url[1];
				if ($query_string){
					$jumdata=explode('=',$query_string);
					if ($jumdata){
						$data=$jumdata[1];
						if ($data){
							return $data;
						}
					}
				}
				
			}	
		};
		if ((int) $uri()){
			$nomor=(int) $uri();
		}
		else {
			$nomor=0;
		}
		$y=0;
		$noarr=array();
		while ($data=mysqli_fetch_array($query)){
			$noarr[]=$nomor;
			$no=$data['no'];
			$nama=$data['nama'];
			$linkhal=$data['link'];
			if (!$linkhal){
				
				$g1=str_replace("#","",$nama);$g2=str_replace("~","","$g1");
				$g3=str_replace("'","","$g2");$g4=str_replace("!","","$g3");
				$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");
				$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
				$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");
				$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
				$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");
				$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
				$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");
				$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
				$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21");
				$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
				$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");
				$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
				$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");
				$g31=str_replace('"',' ',$g30);
				$linkhal=str_replace(' ','-',$g31);
				
				
			}
			$alamat=$data['alamat'];
			$nomor++;
			$y++;
			if ($y%2==0) { $latar="#F8F8F8"; } else { $latar="#FFFFFF"; }?>
			<tr bgcolor="<?php echo $latar;?>">
			<td><?php echo $nomor;?></td>
			<td><?php echo $nama;?></td>
			<td><?php echo $alamat;?></td>
			<td><a href="//<?php echo $linkmodule;?>/<?php echo $no;?>/<?php echo $linkhal;?>/detail">Detail</a></td>
			</tr><?php
			
		}
		?>
	</table>
	<?php
	$jumhal=ceil($jumlahdata/$batas);
	$linkhal=$linkmodule."/page";?>
	<div style="display:table; width:100%;">
		<div style="float:left; width:200px"><?php
			if ($page<=1) { } else { $prev=$page-1; ?><h6><a href="//<?php echo $linkhal."/".$prev;?>/?inis=<?php echo $noarr[0]-$batas;?>" title="Sebelumnya">Sebelumnya</a></h6><?php } ?>
		</div>
		<div style="float:right; text-align:right; width:200px"><?php
			if ($page>=$jumhal){ } else { $next=$page+1; ?><h6><a href="//<?php echo $linkhal."/".$next;?>/?inis=<?php echo end($noarr)+1;?>" title="Selanjutnya">Selanjutnya</a></h6><?php } ?>
		</div>
	</div><?php
}
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php"); 
	} 
	elseif($akses=="publik" or $akses=="member"){
		$publik=new publik();
		$publik->get_variable(); 
		$domain=$publik->domain;
		$act=$publik->act;
		if (empty ($act)) {
				tampil_siswa($linksub,$subdomain);
			}
			elseif ($act=="detail"){
				detail($linksub,$subdomain);
			}
			else {
				tampil_siswa($linksub,$subdomain);
			}	
	}
	elseif($akses=="admin" or $akses=="super"){  
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket'];
		$aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free" or $paket=="basic") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket Profesional.<?php
		}
		else {
			if ($aktif==0){
				?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
			}
			else {
				$judulmod="Siswa";
				$tabel="siswa";
				$batas=30;
				$kolom="nama,nisn,no_kelas,jurusan";
				$lebar="200,100,100,100";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				$jumdetail="multi";
				$tipedetail="table-pict";
				$isidetail="nama,nisn,nis,no_kelas,no_jurusan,tempat_lahir,tanggal_lahir,agama,kelamin_jenis,alamat,kota,kodepos";
				$tipedelete="gambar";
				$jenisinput="gambar";
				$onclick="cekJudul";
				$tipeinput="gambar";
				$forminput="nama,nisn,nis,no_kelas,jurusan,alamat,kota,gambar";
				$jenisinputrinci="gambar";
				$onclickrinci="cekJudul";
				$tipeinputrinci="gambar";
				$forminputrinci="nama,nisn,nis,no_kelas,jurusan,tempat_lahir,tanggal_lahir,agama,kelamin_jenis,alamat,kota,kodepos,gambar";
				$formeditrinci="nama,nisn,nis,no_kelas,jurusan,tempat_lahir,tanggal_lahir,agama,kelamin_jenis,alamat,kota,kodepos,gambar,publish";
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
				elseif ($act=="tambahrinci") {		$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
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