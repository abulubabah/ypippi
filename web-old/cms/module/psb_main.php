<?php    
if ($tampil==1) {  
	if($link==""){ $tipemodule="psb_home"; }
	elseif ($link=="home" or $link=="beranda") { $tipemodule="psb_home"; }
	elseif ($link=="alur" or $link=="syarat" or $link=="panduan" or $link=="faq") { $tipemodule="psb_halaman"; }  
	elseif ($link=="download") { $tipemodule="psb_download"; } 
	elseif ($link=="pengumuman") { $tipemodule="psb_pengumuman"; } 
	elseif ($link=="daftar") { $tipemodule="psb_daftar"; } 
	elseif ($link=="lupapassword") { $tipemodule="psb_lupapassword"; } 
	elseif ($link=="login") { $tipemodule="psb_login"; } 
	elseif ($link=="jadwal") { $tipemodule="psb_jadwal"; } 
	elseif ($link=="formulir") { $tipemodule="psb_member"; } 
	elseif ($link=="dokumen") { $tipemodule="psb_dokumen"; } 
	elseif ($link=="pesan") { $tipemodule="psb_pesan"; } 
	elseif ($link=="file") { $tipemodule="psb_file"; }
	elseif ($link=="pendaftar") { $tipemodule="psb_pendaftar"; } 
	else {	 $tipemodule="psb_home"; } 
	if ($akses=="publik") {	?>
		<div style="text-align:left"><?php
		if ($link=="daftar" or $link=="lupapassword" or $link=="formulir") { include("$tipemodule.php"); }
		else { include("$folder/module/$tipemodule.php"); } ?>
		</div><?php
	}
	elseif ($akses=="member") {
	    ?>
		<div class="mainbar2"><?php
			if ($link=="daftar" or $link=="lupapassword" or $link=="formulir") { include("$tipemodule.php"); }
		else { include("$folder/module/$tipemodule.php"); } ?>		
		</div>
		<div class="sidebar2">
			<div class="panel">
			<ul class="panel_isi">
				<li><a href="//<?php echo $linksub;?>/formulir/" title="Formulir Pendaftaran">Formulir Pendaftaran</a></li>
                
                <?php if ($subdomain=='smansalebra.sch.id' || $subdomain=='sman1lebong.sch.id'){ ?>
                <li><a href="//<?php echo $linksub;?>/psb_cetak.php" title="Print Form Pendaftaran">Print Form Pendaftaran</a></li>
                <li><a href="//<?php echo $linksub;?>/psb_cetak_kartu.php" title="Print Kartu Peserta">Print Kartu Peserta</a></li>
                <li><a href="//<?php echo $linksub;?>/psb_pengumuman.php" title="Print Pengmuman">Print Pengumuman</a></li>
                <?php }  
                
                else {?>
                <li><a href="//<?php echo $subdomain;?>/psb_cetak.php" title="Print Form Pendaftaran">Print Form Pendaftaran Ulang</a></li>
                <li><a href="//<?php echo $subdomain;?>/psb_cetak_kartu.php" title="Print Kartu Peserta">Print Kartu Peserta Ulang</a></li>
                <li><a href="//<?php echo $subdomain;?>/psb_pengumuman.php" title="Print Pengmuman">Print Pengumuman</a></li>
                <?php } ?>
                
				<li><a href="//<?php echo $linksub;?>/dokumen/" title="Upload Dokumen">Upload Dokumen</a></li>
				<li><a href="//<?php echo $linksub;?>/jadwal/" title="Rangkaian Kegiatan">Rangkaian Kegiatan</a></li>
				<li><a href="//<?php echo $linksub;?>/pesan/" title="Kirim Pesan">Kirim Pesan</a></li>
				<li><a href="//<?php echo $linksub;?>/logout/" title="Keluar" onclick="return confirm ('Yakin Mau Keluar ?')">Keluar</a></li>
			</ul>
			</div>
		</div><?php
}
}
else {
	header("location:index.php"); 
}
?>