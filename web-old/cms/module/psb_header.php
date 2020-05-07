<style type="text/css">
p { text-align:left; }
.toggle, [id^=drop] { display: none; }
nav {  margin:0;   z-index:1009; }
nav:after { content:""; display:table; clear:both; }
nav ul { float:right; padding:0px; margin:0; list-style:none; position:relative; margin-top:15px; }
nav ul li { margin:0px; padding:0px 0px;; display:inline-block; float:left; color:#333333; font-weight:bold; font-size:18px; text-transform:uppercase; }
nav ul li a:link, nav ul li a:visited { color:#333333; }
nav ul li a:hover { color:#0000CC;  }
nav a { display:block; text-decoration:none; }
nav ul li ul li:hover {  }
nav a:hover {  }
nav ul ul { display:none; position:absolute; top:20px; font-weight:normal; }
nav ul li:hover > ul { display:inherit; padding-left:-16px; }
nav ul ul li { float:none; display:list-item; position:relative; font-weight:normal; font-size:18px; text-align:left; padding:0px 0px; border-top:none; z-index:999999; background:#CCCCCC; text-transform:none; }
nav ul ul ul li { position:relative; top:-30px; left:183px;  z-index:999999;  }
li > a:after { content:''; }
li > a:only-child:after { content:''; }
@media all and (max-width :480px) {
	nav { margin:0; padding:0px 0px; }
	.toggle+ a, .menu3 { display:none;  }
	.toggle{ display:block; padding:0px 15px; color:#333333; text-decoration:none; border:none; text-align:left; font-weight:bold; }
	.toggle:hover { color:#333333;  }
	[id^=drop]:checked + ul { display:block; }
	nav ul li { display:block; padding:0px 0px; text-align:left; text-transform:uppercase;    }
	nav ul ul .toggle, nav ul ul a {   }
	nav ul ul ul a { padding:0px 0px; }
	nav a:hover, nav ul ul ul a {  }
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
</style><?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik" or $akses=="member"){ ?>
		<div class="headleft">
			<a href="//<?php echo $linksub;?>">
			<img src="//<?php echo $domain."/picture/".$logo;?>" height="60" alt="Logo" align="left" style="margin-right:15px;">
			<h1>PPDB Online</h1>
			<span style="font-size:18px;"><?php echo $namaweb;?></span>
			</a>
		</div>
		<div class="headright">
			<nav style="float:right;display:table;width:100%;"> 
				<label for="drop" class="toggle"><img src="//<?php echo $domain."/image/menu3.png";?>" align="left" style="margin:10px 6px 0px 6px;" alt="MENU">MENU</label>
				<input type="checkbox" id="drop" />
				<ul class="menu3">
				    <li><a href="//<?php echo "www.".$subdomain;?>/" title="Ke Halaman Utama">&laquo;</a></li>
					<li><a href="//<?php echo $linksub;?>/" title="Home">Home</a></li>	
					<li>
						<label for="drop-1-1" class="toggle">Pendaftaran</label>
						<a href="#">Pendaftaran</a>
						<input type="checkbox" id="drop-1-1"/>
						<ul>
							<li><a href="//<?php echo $linksub;?>/alur/" title="Alur Pendaftaran">Alur Pendaftaran</a></li>
							<li><a href="//<?php echo $linksub;?>/syarat/" title="Syarat Pendaftaran">Syarat Pendaftaran</a></li>
							<li><a href="//<?php echo $linksub;?>/panduan/" title="Panduan Pendaftaran">Panduan Pendaftaran</a></li>
							<?php
        					if ($subdomain == "sman1lebong.sch.id") {
        					    ?>
        					    <li><a href="//<?php echo $linksub;?>/syarat-daftar-ulang/" title="Syarat Daftar Ulang">Syarat Daftar Ulang</a></li>
        					    <?php
        					}
        					?>
							<li><a href="//<?php echo $linksub;?>/jadwal/" title="Rangkaian Kegiatan">Rangkaian Kegiatan</a></li>
							<li><a href="//<?php echo $linksub;?>/faq/" title="F A Q">F A Q</a></li>
							<li><a href="//<?php echo $linksub;?>/download/" title="Download Brosur">Download Brosur</a></li>
							<li><a href="//<?php echo $linksub;?>/file/" title="Download Dokumen">Download Dokumen</a></li>
						</ul>
					</li>
					<?php
					if ($subdomain == "sman1lebong.sch.id") {
					    ?>
					    <li><a href="//<?php echo $linksub;?>/pendaftar/" title="Pendaftar Sementara">Pendaftar Sementara</a></li>
					    <?php
					}
					?>
					<li><a href="//<?php echo $linksub;?>/pengumuman/" title="Pengumuman">Pengumuman</a></li><?php
					//$_SESSION['uname']="admin";
					//$_SESSION['pword']="admin";
					if (empty($_SESSION['uname']) and empty($_SESSION['pword'])) {	
                        if ($subdomain != "smkpenda2kra.sch.id") {
                            if ($subdomain == "sman1empang.sch.id") {
                                ?>
                                <li><a href="http://btikp.dikbud.ntbprov.go.id/ppdb/" target="_blank" title="Daftar">Daftar</a></li>						
                                <li><a href="http://btikp.dikbud.ntbprov.go.id/ppdb/" target="_blank" title="Login">Login</a></li>
                                <?php
                            } elseif ($subdomain == "sman1tgt.sch.id") {
                                ?>
                                <li><a href="https://www.psbsman1tgt.online/halaman-utama.php" target="_blank" title="Daftar">Daftar</a></li>						
                                <li><a href="https://www.psbsman1tgt.online/halaman-utama.php" target="_blank" title="Login">Login</a></li>
                                <?php
                            } elseif ($subdomain == "smkn2tangerang.sch.id") {
                                ?>			
                                <li><a href="//<?php echo $linksub;?>/login/" title="Login">Login</a></li>
                                <?php
                            } else {
                                ?>			
                                <li><a href="//<?php echo $linksub;?>/daftar/" title="Daftar">Daftar</a></li>						
                                <li><a href="//<?php echo $linksub;?>/login/" title="Login">Login</a></li>
                                <?php
                            }
                        } 
					}
					else {
						$uname=$_SESSION['uname'];?>
						<li><a href="//<?php echo $linksub;?>/logout/" title="Keluar" onclick="return confirm ('Yakin Mau Keluar ?')">Keluar</a></li><?php			
					}?>
				</ul>
			</nav>
		</div><?php
	}	
}
else {
	header("location:index.php"); 
}
?>