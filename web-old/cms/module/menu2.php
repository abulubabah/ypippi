<?php  
if ($tampil==1) {   ?>
	<div class="menu2">
		<ul class="mnav">
		<li><a href="#" title="#"><img src="//<?php echo $domain;?>/image/menu2.png" align="right" alt="Menu" border="0" style="margin:10px 0px;"/></a>
			<div><?php
				$qhalaman=mysqli_query($koneksi, "SELECT no,judul,link FROM halaman WHERE publish='1' AND subdomain='$subdomain' ORDER BY urutan ASC");
				while ($dhalaman=mysqli_fetch_array($qhalaman)) {
					$halamanno=$dhalaman['no'];
					$halamanjudul=$dhalaman['judul'];
					$halamanlink=$dhalaman['link'];
					if ($halamanlink=="" or $halamanlink=="home" or $halamanlink=="beranda") { $linkurl="//$linksub/"; } else { $linkurl="//$linksub/$halamanlink/"; } ?>
					<div class="mnav-column"><a href="<?php echo $linkurl;?>" title="<?php echo $halamanjudul;?>"><?php echo $halamanjudul;?></a></div><?php
				}
				?>
			</div>
		</li>
	</ul>
	</div><?php
}
else { 
	header("location:index.php"); 
}
?>