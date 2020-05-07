<style type="text/css">
p { text-align:left; }
.toggle, [id^=drop] { display: none; }
nav {  margin:0;   z-index:1009; }
nav:after { content:""; display:table; clear:both; }
nav ul { float:right; padding:0; margin:0; list-style:none; position:relative; margin-top:15px; }
nav ul li { margin:0px; display:inline-block; float:left; padding:0px 8px; color:#333333; font-weight:bold; font-size:18px; text-transform:uppercase; }
nav ul li a:link, nav ul li a:visited { color:#333333; }
nav ul li a:hover { color:#0000CC;  }
nav a { display:block; text-decoration:none; }
nav ul li ul li:hover {  }
nav a:hover {  }
nav ul ul { display:none; position:absolute; top:12px; font-weight:normal; }
nav ul li:hover > ul { display:inherit; padding-left:-16px; }
nav ul ul li { width:200px; float:none; display:list-item; position:relative;  padding-left:15px; font-weight:normal; font-size:18px; text-align:left; padding:2px 8px; border-top:none; z-index:999999; background:#CCCCCC; text-transform:none; }
nav ul ul ul li { position:relative; top:-30px; left:183px;  z-index:999999;  }
li > a:after { content:''; }
li > a:only-child:after { content:''; }
@media all and (max-width :480px) {
	nav { margin:0; padding:2px 0px; }
	.toggle + a, .menu { display:none;  }
	.toggle { display:block; padding:0px 0px; color:#333333; text-decoration:none; border:none; text-align:left; font-weight:bold; }
	.toggle:hover { color:#333333;  }
	[id^=drop]:checked + ul { display:block; }
	nav ul li { display:block; padding:2px 8px; text-align:left; text-transform:uppercase;  }
	nav ul ul .toggle, nav ul ul a {  }
	nav ul ul ul a { padding:2px 10px;  }
	nav a:hover, nav ul ul ul a { }
	nav ul li ul li .toggle, nav ul ul a {   }
	nav ul ul { float:none; position:static; color:#444444; right:none; }
	nav ul ul li:hover > ul,
	nav ul li:hover > ul { display:none; }
	nav ul ul li { display:block; text-align:left; }
	nav ul ul ul li { position:static; } 
}
@media all and (max-width :480px) {
	nav ul li { display:block; width:94%; }
}
</style>
<?php    
// echo $subdomain;
if ($tampil == 1) {   ?>
	<nav style="float:right;display:table;width:100%;"> 
		<label for="drop" class="toggle"><img src="//<?php echo $domain."/image/menu3.png";?>" align="left" style="margin:4px 6px 0px 6px;" alt="MENU">MENU</label>
		<input type="checkbox" id="drop" />
		<ul class="menu"> 
			<li><a href="//<?php echo $linksub;?>/" title="Home">Home</a></li>
			<li><a href="//<?php echo $linksub;?>/" title="Halaman Utama">Halaman Utama</a></li>
			<li>
				<label for="drop-1-1" class="toggle">Pedaftaran</label>
				<a href="#">Pedaftaran</a>
				<input type="checkbox" id="drop-1-1"/>
				<ul>
					<li><a href="//<?php echo $linksub;?>/alur/" title="Alur Pendaftaran">Alur Pendaftaran</a></li>
					<li><a href="//<?php echo $linksub;?>/syarat/" title="Syarat Pendaftaran">Syarat Pendaftaran</a></li>
					<li><a href="//<?php echo $linksub;?>/panduan/" title="Panduan Pendaftaran">Panduan Pendaftaran</a></li>
					<li><a href="//<?php echo $linksub;?>/faq/" title="F A Q">F A Q</a></li>
					<li><a href="//<?php echo $linksub;?>/jadwal/" title="Rangkaian Kegiatan">Rangkaian Kegiatan</a></li>
					<li><a href="//<?php echo $linksub;?>/download/" title="Download Brosur">Download Brosur</a></li>
					<li><a href="//<?php echo $linksub;?>/file/" title="Download Dokumen">Download Dokumen</a></li>	
				</ul>
			</li>
			<li><a href="//<?php echo $linksub;?>/pengumuman/" title="Pengumuman">Pengumuman</a></li><?php
			//$_SESSION['uname']="admin";
			//$_SESSION['pword']="admin";
			if (empty($_SESSION['uname']) and empty($_SESSION['pword'])) {	
			    if ($subdomain != "smkpenda2kra.sch.id") {
			       ?>			
    				<li><a href="//<?php echo $linksub;?>/daftar/" title="Daftar">Daftar</a></li>						
    				<li><a href="//<?php echo $linksub;?>/login/" title="Login">Login</a></li>
    				<?php   
			    }
			}
			else {
				$uname=$_SESSION['uname'];?>
				<li><a href="//<?php echo $linksub;?>/logout/" title="Keluar" onclick="return confirm ('Yakin Mau Keluar ?')">Keluar</a></li><?php			
			}?>
		</ul>
	</nav><?php
}
else {
	header("location:index.php"); 
}
?>