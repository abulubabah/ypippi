<?php 
if ($tampil==1) { ?> 
	<div class="topleft">
		<h2>Kini Buat Website Sekolah<br/>Semakin Mudah !</h2><br/> 
		Tidak perlu repot lagi mencari tutorial cara membuat website sekolah, atau mencari jasa pembuatan website sekolah. Anda bisa membuat website sekolah sendiri. Gratis! Dalam waktu kurang dari 1 menit, Website Sekolah Anda langsung online. Klik "Buat Sekarang" untuk membuat website sekolah sekarang juga!<br/><br/>
		<a href="//buat.mysch.id/?id=<?php echo $_SESSION['referral'];?>" title="Buat Sekarang" style="background:#FFFFFF; padding:10px 30px; font-size:18px;">Buat Sekarang !</a> &nbsp; 
		<a href="//demo.mysch.id" target="_blank" title="Lihat Demo" style="background:#004488; color:#FFFFFF; padding:10px 30px; font-size:18px;">Lihat Demo</a>
	</div>
	<div class="topright">
		<img src="//<?php echo $domain;?>/image/monitor.png" alt="monitor" width="100%;"/>
	</div><?php 
}
else { 
	header("location:index.php"); 
}
?>