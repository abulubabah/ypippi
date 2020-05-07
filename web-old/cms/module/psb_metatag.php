<?php  
if ($tampil==1) {  
	if ($akses=="admin")  {
		if ($link=="") { $judulweb="Halaman Admin"; }
		else {
			$qhalaman=mysqli_query($koneksi, "SELECT judul FROM halamanadmin WHERE module='$link'"); 
			$dhalaman=mysqli_fetch_array($qhalaman); 
			if (empty($act)) {	$judulweb="Manajemen ".$dhalaman['judul']; } else { $judulweb=$act." ".$dhalaman['judul']; }
		}	
	}
	else {		
		if($link==""){ $judulweb="PPDB Online ".$judulweb;  }
		elseif ($link=="alur")  { $judulweb="Alur Pendaftaran"; }
		elseif ($link=="jadwal")  { $judulweb="Rangkaian Kegiatan"; }
		elseif ($link=="syarat")  { $judulweb="Syarat Pendaftaran"; }
		elseif ($link=="panduan")  { $judulweb="Panduan Pendaftaran"; } 
		elseif ($link=="faq")  { $judulweb="F A Q"; }
		elseif ($link=="download")  { $judulweb="Download Brosur"; }
		elseif ($link=="pengumuman")  { $judulweb="Pengumuman"; }
		elseif ($link=="login")  { $judulweb="Login"; }
		elseif ($link=="daftar")  { $judulweb="Daftar"; }
		elseif ($link=="lupapassword")  { $judulweb="Lupa Password"; }
		elseif ($link=="pesan")  { $judulweb="Kirim Pesan"; }
		elseif ($link=="formulir")  { $judulweb="Formulir Pendaftaran"; }
		elseif ($link=="dokumen")  { $judulweb="Upload Dokumen"; } 
		elseif ($link=="file")  { $judulweb="Download Dokumen"; }
		else {			
			$qhalamantipe=mysqli_query($koneksi, "SELECT no,judul FROM halaman WHERE link='$link' AND subdomain='$subdomain'");
			$jhalamantipe=mysqli_num_rows($qhalamantipe);
			if ($jhalamantipe==0) {    
				$qhaltipe=mysqli_query($koneksi, "SELECT tipe FROM halamantipe WHERE tipe='$link'");
				$jhaltipe=mysqli_num_rows($qhaltipe);
				$dhaltipe=mysqli_fetch_array($qhaltipe);
				$haltipe=$dhaltipe['tipe'];
				if ($jhaltipe>=1) { 
					if ($haltipe=="halaman") {						
						$qhalaman=mysqli_query($koneksi, "SELECT judul,tipe,idtipe,isi,kata_kunci FROM halaman WHERE no='$no' AND subdomain='$subdomain'");
						$dhalaman=mysqli_fetch_array($qhalaman);
						$judulweb=$dhalaman['judul'];
						$haltipe=$dhalaman['tipe'];
						$halidtipe=$dhalaman['idtipe'];
						$halisi=$dhalaman['isi'];
						if ($haltipe=="tulis") { 
							$haldesk=strip_tags($halisi); $haldesk=strtok($haldesk,"  ");
							$kata_kunci=$dhalaman['kata_kunci'];
						}
						elseif ($haltipe=="berita") {
							$qartikel=mysqli_query($koneksi, "SELECT isi,kata_kunci FROM berita WHERE no='$halidtipe' AND subdomain='$subdomain'");
							$dartikel=mysqli_fetch_array($qartikel);
							$artikelisi=$dartikel['isi'];
							$haldesk=strip_tags($artikelisi); $haldesk=strtok($haldesk,"  ");
							$kata_kunci=$dartikel['kata_kunci'];
						}
						else { }
					}
					elseif ($haltipe=="berita") {
						if (empty($no)) { $judulweb="404 Not Found";  }
						else {
							$qartikel=mysqli_query($koneksi, "SELECT judul,isi,kata_kunci FROM berita WHERE no='$no' AND subdomain='$subdomain'");
							$dartikel=mysqli_fetch_array($qartikel);
							$judulweb=$dartikel['judul'];
							$artikelisi=$dartikel['isi'];
							$haldesk=strip_tags($artikelisi); $haldesk=strtok($haldesk,"  ");
							$kata_kunci=$dartikel['kata_kunci'];
						}
					}
					elseif ($link=="kategori" or $link=="album") { 
						if (empty($no)) {  }
						else {
							if ($link=="kategori") { $tabel="berita_kategori"; } 
							elseif ($link=="album") { $tabel="galeri_kategori"; }  
							else { $tabel=$link; }
							$qmodule=mysqli_query($koneksi, "SELECT judul FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
							$dmodule=mysqli_fetch_array($qmodule);
							$judulweb=$dmodule['judul'];
						} 
					}
					else { $judulweb="404 Not Found";   }				
				} 
				else { $judulweb="404 Not Found";  }
			}
			else {
				$dhalamantipe=mysqli_fetch_array($qhalamantipe); 
				if ($link=="home" or $link=="beranda" or $link=="depan" or $link=="lupapwordadmin") {  }
				elseif ($link=="cari") { 
					if (empty($link)) { $judulweb="Pencarian";  } 
					else {	$linkbaru=str_replace("-"," ","$link");	$judulweb=$linkbaru; }
				}
				elseif ($link=="kategori" or $link=="album") { 
					if (empty($no)) {  }
					else {
						if ($link=="kategori") { $tabel="berita_kategori"; } 
						elseif ($link=="album") { $tabel="galeri_kategori"; }  
						else { $tabel=$link; }
						$qmodule=mysqli_query($koneksi, "SELECT judul FROM $tabel WHERE no='$no' AND subdomain='$subdomain'");
						$dmodule=mysqli_fetch_array($qmodule);
						$judulweb=$dmodule['judul'];
					} 
				}
				else {		
					if (empty($no)) { $judulweb=$dhalamantipe['judul']; }
					else {						
						if ($link=="halaman") {						
							$qhalaman=mysqli_query($koneksi, "SELECT judul,tipe,idtipe,isi,kata_kunci FROM halaman WHERE no='$no' AND subdomain='$subdomain'");
							$dhalaman=mysqli_fetch_array($qhalaman);
							$judulweb=$dhalaman['judul'];
							$haltipe=$dhalaman['tipe'];
							$halidtipe=$dhalaman['idtipe'];
							$halisi=$dhalaman['isi'];
							if ($haltipe=="tulis") { 
								$haldesk=strip_tags($halisi); $haldesk=strtok($haldesk,"  ");
								$kata_kunci=$dhalaman['kata_kunci'];
							}
							elseif ($haltipe=="berita") {
								$qartikel=mysqli_query($koneksi, "SELECT isi,kata_kunci FROM berita WHERE no='$halidtipe' AND subdomain='$subdomain'");
								$dartikel=mysqli_fetch_array($qartikel);
								$artikelisi=$dartikel['isi'];
								$haldesk=strip_tags($artikelisi); $haldesk=strtok($haldesk,"  ");
								$kata_kunci=$dartikel['kata_kunci'];
							}
							else { }
						}
						elseif ($link=="berita") {
							if (empty($no)) {  }
							else {
								$qartikel=mysqli_query($koneksi, "SELECT judul,isi,kata_kunci FROM $link WHERE no='$no' AND subdomain='$subdomain'");
								$dartikel=mysqli_fetch_array($qartikel);
								$judulweb=$dartikel['judul'];
								$artikelisi=$dartikel['isi'];
								$haldesk=strip_tags($artikelisi); $haldesk=strtok($haldesk,"  ");
								$kata_kunci=$dartikel['kata_kunci'];
							}
						}
						else { }
					}	
				}
			}
		}
	}
}
else { 
	header("location:index.php"); 
}
?>