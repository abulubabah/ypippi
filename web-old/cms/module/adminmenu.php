<?php     
if ($tampil==1) {

	//hapus cache 
	global $filemanager;
	global $resize;
	global $uploader;
	//print_r($filemanager->listData(DIR_CACHE.$subdomain.'/'));
	foreach ($filemanager->listData(DIR_CACHE.$subdomain.'/') as $key=>$value){
		$filemanager->hapus($value);
	}
	$linkadm=$linksub."/".$adm;
	$admin=new admin();
	$admin->setLinkSub($linksub);
	$linkticket=$admin->getHttp()."://".$linkadm."/konsultasi";
	//cek apakah sudah terdaftar di whmcs? jika sudah autologin
	$qset=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='".$subdomain."' ");
	$dset=mysqli_fetch_assoc($qset);
	$target="_self";
	if(!empty($dset['whmcs'])){
	    $cekemail=mysqli_query($koneksi, "SELECT email FROM user WHERE username='".$_SESSION['uname']."'");
    	$demail=mysqli_fetch_assoc($cekemail);
    	$email=$demail['email'];
    	$timestamp = time(); # Get current timestamp
        $goto = "submitticket.php?step=2&deptid=1";
         
        $hash = sha1($email.$timestamp.AUTH); 
        # Generate AutoAuth URL & Redirect
        $linkticket = URL_AUTH."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
        $target="_blank";
	}
	?>
	
	<nav id='menu'>
	<input type='checkbox'/>
	<label>&#8801;<span>Navigation</span></label>
	<ul>
		<li id="sembunyi"><a href="#" title="Close"><span class="menupict" >X</span>Close</a></li>
		<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/" title="Home"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/home.png" class="menupict" align="left" alt="Home"/>Home</a></li>
		<li><a href="#" class="prett" title="Konten"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/konten.png" class="menupict" align="left" alt="Konten"/>Konten</a>
			<ul class="menus">
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/sambutan/" title="Sambutan">Sambutan</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/halaman/" title="Menu">Menu</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/berita/" title="Berita">Berita</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/berita/act/kategori/" title="Kategori">Kategori Berita</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/komentar/" title="Komentar">Komentar</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/kontak/" title="Kontak">Kontak</a></li>				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/galeri/" title="Foto">Foto</a><li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/galeri/act/kategori/" title="Album Foto">Album Foto</a><li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/video/" title="Video">Video</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/polling/" title="Polling">Polling</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/link/" title="Link">Link</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/file/" title="File Download">File Download</a></li>
			</ul>
		</li>
		<li><a href="#" class="prett" title="Akademik"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/akademik.png" class="menupict" align="left" alt="Akademik"/>Akademik</a>
			<ul class="menus">
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/matapelajaran/" title="Mata Pelajaran">Mata Pelajaran</a></li>			
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/silabus/" title="Silabus">Silabus</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/materi/" title="Materi">Materi</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/kalender/" title="Kalender Akademik">Kalender Akademik</a></li>
				<!--<li><a href="//<?php echo $linkadm;?>/jadwal/" title="Jadwal Ujian">Jadwal Ujian</a></li>-->
			</ul>
		</li>
		<li><a href="#" class="prett" title="Data"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/data.png" class="menupict" align="left" alt="Data"/>Data</a>
			<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/guru/" title="Guru">Guru</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/staff/" title="Staff">Staff</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/kelas/" title="Kelas">Kelas</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/siswa/" title="Siswa">Siswa</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/alumni/" title="Alumni">Alumni</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/import_guru/" title="Import Data Guru">Import Data Guru</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/import_siswa/" title="Import Data Siswa">Import Data Siswa</a></li>
			</ul>
		</li>
		<li><a href="#" class="prett" title="PPDB"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/data.png" class="menupict" align="left" alt="PPDB"/>PPDB</a>
			<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_member/" title="Calon Siswa">Calon Siswa</a></li>
				<?php if ($subdomain=="smansadompu.sch.id" or $subdomain=="manende.sch.id" or $subdomain=="smanwpringgabaya.sch.id" or $subdomain=="man1sungaipenuh.sch.id") { ?><li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_tabel/" title="Data Jurnal Sementara">Data Jurnal Sementara</a></li><?php } ?>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_dokumen/" title="Dokumen Pendukung">Dokumen Pendukung</a></li>				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_pengumuman/" title="Pengumuman">Pengumuman</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_alur/" title="Alur Pendaftaran">Alur Pendaftaran</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_syarat/" title="Syarat Pendaftaran">Syarat Pendaftaran</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_panduan/" title="Panduan Pendaftaran">Panduan Pendaftaran</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_jadwal/" title="Rangkaian Kegiatan">Rangkaian Kegiatan</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_faq/" title="F A Q">F A Q</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_pesan/" title="Pesan">Pesan</a></li>					
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_banner/" title="Banner">Banner</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_download/" title="Brosur">Brosur</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_file/" title="File Dokumen">File Dokumen</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/psb_pengaturan/" title="Pengaturan Kop">Pengaturan Kop</a></li>	
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linksub;?>/ppdb_excel.php" target="_blank" title="Download Peserta">Download Peserta Ppdb</a></li>
			</ul>
		</li><?php
		 ?>
		<li><a href="#" class="prett" title="Simpen"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/data.png" class="menupict" align="left" alt="Simpen"/>Simpen</a>
			<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/simpen_siswa/" title="Daftar Siswa">Daftar Siswa</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/simpen_sambutan/" title="Sambutan">Sambutan Kepsek</a></li>				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/simpen_panduan/" title="Panduan Simpen">Panduan Simpen</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/simpen_tentang/" title="Tentang Simpen">Tentang Simpen</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/simpen_pengaturan/" title="Pengaturan">Pengaturan</a></li>					
			</ul>
		</li><?php
		?>
		<li><a href="#" class="prett" title="Desain"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/desain.png" class="menupict" align="left" alt="Desain"/>Desain</a>
			<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/tataletak/" title="Tata Letak">Tata Letak</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/tema/" title="Tema Desain">Tema Desain</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/kolom/" title="Kolom">Kolom</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/slideshow/" title="Slideshow">Slideshow</a></li>
				<?php if ($subdomain=="sman10kotatangerang.sch.id" or $subdomain=="manende.sch.id") { ?>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/headbawah/" title="Running Teks">Running Teks</a></li><?php } ?>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/logo/" title="Logo">Logo</a></li>				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/favicon/" title="Favicon">Favicon</a></li>
			</ul>
		</li>
		<li><a href="#" class="prett" title="Pengaturan"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/setting.png" class="menupict" align="left" alt="Pengaturan"/>Pengaturan</a>
			<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/meta/" title="Meta Tag">Meta Tag</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/kode_tambahan/" title="Untuk Menambahkan Custom Javascript">Kode Tambahan</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/profil/" title="Profil Admin">Profil Admin</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/password/" title="Password Admin">Password Admin</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/upgrade/" title="Upgrade">Upgrade</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/konfirmasi/" title="Konfirmasi">Konfirmasi</a></li>
				
			</ul>
		</li>
		<?php 
		if ($_SESSION['kat']=="super") {  ?>
			<li><a href="#" class="prett" title="Klien"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/data.png" class="menupict" align="left" alt="Klien"/>Klien</a>
			<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/klien/" title="Semua">Semua</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/klien/act/premium/" title="Premium">Premium</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/klien/act/free/" title="Free">Free</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/upgrade/" title="Upgrade">Upgrade</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/konfirmasi/" title="Konfirmasi">Konfirmasi</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/testimoni/" title="Testimoni">Testimoni</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/email/" title="Email">Email</a></li>

			</ul>
		</li>
			<?php
		}
		?>
		<li><a href="#" class="prett" title="Konsultasi"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/chat.png" class="menupict" align="left" alt="Konsultasi"/>Konsultasi</a>
		<?php
		if ($_SESSION['kat']=="super") {  ?>
		<ul class="menus">				
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/konsultasi/act/open/" title="Open">Open</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/konsultasi/act/closed/" title="Closed">Closed</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/konsultasi/act/answered/" title="Answered">Answered</a></li>
				<li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/konsultasi/act/reply/" title="Reply">Reply</a></li>
		</ul>
		<?php }
			  else	{?>
			  <ul class="menus">	
				  <li><a href="<?php echo $linkticket;?>" target="<?php echo $target;?>" title="Konsultasi">Konsultasi</a></li>
				  <li><a href="<?php echo $admin->getHttp();?>://<?php echo $linkadm;?>/testimoni/" title="Testimoni">Testimoni</a></li>
			 </ul><?php
			  }	?>
		</li><?php
		if ($linksub=="mysch.id/admin") { ?><li><a href="//<?php echo $subdomain;?>.mysch.id/" title="Lihat Web" target="_blank" onclick="return confirm ('Lihat Web ?')"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/view.png" class="menupict" align="left" alt="Lihat Web"/>Lihat Web</a></li><?php }
		else {  
			if ($_SESSION['kat']=="super") { } 
			else { ?><li><a href="<?php echo $admin->getHttp();?>://<?php echo $linksub;?>/" title="Lihat Web" target="_blank" onclick="return confirm ('Lihat Web ?')"><img src="<?php echo $admin->getHttp();?>://<?php echo $domain;?>/image/view.png" class="menupict" align="left" alt="Lihat Web"/>Lihat Web</a></li><?php }
		} ?>
		</ul>
	</nav>
	<script type='text/javascript'>
		var nav = $('#menu > ul > li');
		nav.find('li').hide();
		nav.click(function () {
		    nav.not(this).find('li').hide();
		    $(this).find('li').slideToggle();
		});
		$(function() {
				$('#menu input').click(function () {
				$('#menu ul').slideToggle();
			});
		});
		$(document).ready(function() {
			$("#sembunyi").css('display','none');
			$("#menu").hover(function() {
			  var lebar = $(document).width();
				if (lebar > 768){
					$("#sembunyi").css('display','none');
					
				}
				if (lebar <=768) {
					$("#sembunyi").css('display','block');			
					
				}
			});
		});
	</script><?php
}
else {
	header("location:index.php"); 
}
?>