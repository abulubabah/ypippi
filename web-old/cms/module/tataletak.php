<script type="text/javascript">   
	function allselections() {   
		var e = document.getElementById('selections');
			e.disabled = true;
		var i = 0;
		var n = e.options.length;
		for (i = 0; i < n; i++) { e.options[i].disabled = true;	e.options[i].selected = true; }
	}
	function disableselections() {
		var e = document.getElementById('selections');
			e.disabled = true;
		var i = 0;
		var n = e.options.length;
		for (i = 0; i < n; i++) { e.options[i].disabled = true; e.options[i].selected = false; }
	}
	function enableselections() {
		var e = document.getElementById('selections');
			e.disabled = false;
		var i = 0;
		var n = e.options.length;
		for (i = 0; i < n; i++) { e.options[i].disabled = false; }
	}
</script>
<?php 
if($subdomain=='smansatupontang.sch.id'){
   // error_reporting(E_ALL);
}
function tataletak ($subdomain,$linksub) {
	$module=new admin();
	$module->get_variable(); 
	$module->setLinkSub($linksub);
	$domain=$module->domain; 
	$mod=$module->mod; 
	$adm=$module->adm; 
	$linkmod=$linksub."/".$adm."/".$mod;
	$qset=mysqli_query($koneksi, "SELECT judul,logo,footer,kolom FROM setting WHERE subdomain='$subdomain'");
	$dset=mysqli_fetch_array($qset);
	$judulweb=$dset['judul'];
	$logoweb=$dset['logo'];
	$footer=$dset['footer'];
	$kolom=$dset['kolom'];
	$action="ubah,hapus,naik,turun,tampilkan"; ?>
	<style type="text/css">
		#tataletak { background:#EAEAEA; padding:8px; margin:10px 0px; }
		.tataletak_module { padding:4px 0px; margin-top:5px; background:#FFFFFF; border:1px solid #BBBBBB; display:table; width:100%; }
		.tataletak_act { float:left; text-transform:capitalize; margin-left:5px; color:#555555; }
		.tataletak_act a:link, .tataletak_act a:visited { text-decoration:none; color:#555555; }
		.tataletak_act a:hover { text-decoration:underline; color:#000000; }
		.tataletak_judul { display:table; margin-left:5px; }
	</style>
	<div style="display:table;width:100%;">
		<h2 style="float:left;">Tata Letak</h2>
		<a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm;?>/kolom" style="float:right;" title="Pilih Kolom Tampilan">Ganti Kolom Tampilan</a>
	</div>
	<!-- TOP-->
	<div id="tataletak">
		<b>HEADER</b>
		<div class="tataletak_module">
			<span class="tataletak_judul">Header</span>
			<h6 class="tataletak_act"><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/header/";?>" title="Ubah">Ubah</a></h6>
		</div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
				<td width="50%">
				<div class="tataletak_posisi" style="border:none; margin-right:6px;">
					<div class="tataletak_module">
						<span class="tataletak_judul">Header Logo</span>
						<h6 class="tataletak_act"><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/logo/";?>" title="Ubah">Ubah</a></h6>
					</div>
				</div>
				</td>
				<td width="50%">
				<div class="tataletak_posisi" style="border:none; margin-left:6px;">
					<div class="tataletak_module">
						<span class="tataletak_judul">Header Kanan</span>
						<h6 class="tataletak_act"><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/headkanan/";?>" title="Ubah">Ubah</a></h6>
					</div>
				</div>
				</td>
			</tr>
		</table>
	</div>
	<div id="tataletak">
		<b>MENU</b>
		<div class="tataletak_module">
			<span class="tataletak_judul"><?php
			$qhal=mysqli_query($koneksi, "SELECT judul FROM halaman WHERE uphalaman='0' AND subdomain='$subdomain' ORDER BY urutan LIMIT 0,6");
			while ($dhal=mysqli_fetch_array($qhal)) { echo $dhal['judul']." &nbsp;-&nbsp; ";	} ?>...
			</span>
			<h6 class="tataletak_act"><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/halaman/";?>" title="Ubah">Ubah</a>

</h6>
		</div>
	</div>
	<div id="tataletak">
		<b>SLIDESHOW</b>
		<div class="tataletak_module">
			<span class="tataletak_judul">Slideshow</span>
			<h6 class="tataletak_act"><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/slideshow/";?>" title="Ubah">Ubah</a> &nbsp; 

<a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/slidetipe/";?>" title="Tipe">Tipe</a> </h6>
		</div>
	</div>
	<div id="tataletak"><?php
		if ($kolom=="2") { ?>
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
				<tr valign="top">
				<td width="35%">
					<b>SIDE BAR</b>
					<div class="tataletak_posisi"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE (posisi='side' OR posisi='left' OR posisi='right') AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/side/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="65%">
					<b style="margin-left:12px;">MAIN BAR</b>
					<div class="tataletak_posisi" style="margin-left:12px;"><?php
						$qmain=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='main' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dmain=mysqli_fetch_array($qmain)) {
							$nomain=$dmain['no'];
							$judulmain=$dmain['judul'];
							$tipemain=$dmain['tipe'];
							$urutanmain=$dmain['urutan'];
							$halmain=$dmain['hal'];
							$pubmain=$dmain['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulmain;?><br/>
								<font color="#888"><?php echo $urutanmain." - ".$tipemain." - ".$halmain;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$nomain,$pubmain,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/main/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				</tr>
			</table><?php			
		}
		elseif ($kolom=="3") { ?>
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
				<tr valign="top">
				<td width="25%">
					<b>LEFT BAR</b>
					<div class="tataletak_posisi"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE (posisi='left' OR posisi='side') AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/left/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="50%">
					<b style="margin:0px 10px;">MAIN BAR</b>
					<div class="tataletak_posisi" style="margin:0px 10px;"><?php
						$qmain=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='main' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dmain=mysqli_fetch_array($qmain)) {
							$nomain=$dmain['no'];
							$judulmain=$dmain['judul'];
							$tipemain=$dmain['tipe'];
							$urutanmain=$dmain['urutan'];
							$halmain=$dmain['hal'];
							$pubmain=$dmain['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulmain;?><br/>
								<font color="#888"><?php echo $urutanmain." - ".$tipemain." - ".$halmain;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$nomain,$pubmain,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/main/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="25%">
					<b>RIGHT BAR</b>
					<div class="tataletak_posisi"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='right' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/right/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				</tr>
			</table><?php	
		}
		elseif ($kolom=="4") {  ?>
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
				<tr valign="top">				
				<td width="50%">
					<b>MAIN BAR</b>
					<div class="tataletak_posisi" style="margin-right:10px;"><?php
						$qmain=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='main' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dmain=mysqli_fetch_array($qmain)) {
							$nomain=$dmain['no'];
							$judulmain=$dmain['judul'];
							$tipemain=$dmain['tipe'];
							$urutanmain=$dmain['urutan'];
							$halmain=$dmain['hal'];
							$pubmain=$dmain['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulmain;?><br/>
								<font color="#888"><?php echo $urutanmain." - ".$tipemain." - ".$halmain;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$nomain,$pubmain,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/main/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="25%">
					<b>LEFT BAR</b>
					<div class="tataletak_posisi" style="margin-right:10px;"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE (posisi='left' OR posisi='side') AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/left/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="25%">
					<b>RIGHT BAR</b>
					<div class="tataletak_posisi"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='right' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/right/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				</tr>
			</table><?php
		}
		elseif ($kolom=="5") { ?>
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
				<tr valign="top">							
				<td width="25%">
					<b>LEFT BAR</b>
					<div class="tataletak_posisi" style="margin-right:10px;"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE (posisi='left' OR posisi='side') AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/left/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="25%">
					<b>RIGHT BAR</b>
					<div class="tataletak_posisi" style="margin-right:10px;"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='right' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/right/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="50%">
					<b>MAIN BAR</b>
					<div class="tataletak_posisi" style="margin-right:10px;"><?php
						$qmain=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='main' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dmain=mysqli_fetch_array($qmain)) {
							$nomain=$dmain['no'];
							$judulmain=$dmain['judul'];
							$tipemain=$dmain['tipe'];
							$urutanmain=$dmain['urutan'];
							$halmain=$dmain['hal'];
							$pubmain=$dmain['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulmain;?><br/>
								<font color="#888"><?php echo $urutanmain." - ".$tipemain." - ".$halmain;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$nomain,$pubmain,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/main/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				</tr>
			</table><?php
		}
		else { ?>		
			<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:6px;">
				<tr valign="top">
				<td width="65%">
					<b>MAIN BAR</b>
					<div class="tataletak_posisi" style="margin-right:12px;"><?php
						$qmain=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='main' AND subdomain='$subdomain' ORDER BY urutan");
						while ($dmain=mysqli_fetch_array($qmain)) {
							$nomain=$dmain['no'];
							$judulmain=$dmain['judul'];
							$tipemain=$dmain['tipe'];
							$urutanmain=$dmain['urutan'];
							$halmain=$dmain['hal'];
							$pubmain=$dmain['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulmain;?><br/>
								<font color="#888"><?php echo $urutanmain." - ".$tipemain." - ".$halmain;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$nomain,$pubmain,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/main/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				<td width="35%">
					<b>SIDE BAR</b>
					<div class="tataletak_posisi"><?php
						$qside=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE (posisi='side' OR posisi='left' OR posisi='right') AND subdomain='$subdomain' ORDER BY urutan");
						while ($dside=mysqli_fetch_array($qside)) {
							$noside=$dside['no'];
							$judulside=$dside['judul'];
							$tipeside=$dside['tipe'];
							$urutanside=$dside['urutan'];
							$halside=$dside['hal'];
							$pubside=$dside['publish'];?>
							<div class="tataletak_module">
								<span class="tataletak_judul"><?php echo $judulside;?><br/>
								<font color="#888"><?php echo $urutanside." - ".$tipeside." - ".$halside;?></font></span><?php
								$act=explode(",",$action);
								$jumact=count($act);
								for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$noside,$pubside,$module->getHttp()); } ?>
							</div><?php 
						} ?>
						<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB;">
							<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/side/ok/" title="Tambah Module">Tambah Module</a></h5>
						</div>
					</div>
				</td>
				</tr>
			</table><?php
		} ?>
		<b>BOTTOM BAR</b>
		<div style="display:table; width:100%;"><?php
			$jumbot=0;
			$qbottom=mysqli_query($koneksi, "SELECT no,judul,tipe,urutan,hal,publish FROM module WHERE posisi='bottom' AND subdomain='$subdomain' ORDER BY urutan");
			while ($dbottom=mysqli_fetch_array($qbottom)) {
				$nobottom=$dbottom['no'];
				$judulbottom=$dbottom['judul'];
				$tipebottom=$dbottom['tipe'];
				$urutanbottom=$dbottom['urutan'];
				$halbottom=$dbottom['hal'];
				$pubbottom=$dbottom['publish']; 
				if($jumbot%4==0){ ?><div class="spasi"></div><?php }
				if($jumbot==3){ $marginright=0; } else {  $marginright=10; }?>
				<div class="tataletak_module" style="float:left; width:23%; margin-right:<?php echo $marginright;?>px;">
					<span class="tataletak_judul"><?php echo $judulbottom;?><br/>
					<font color="#888"><?php echo $urutanbottom." - ".$tipebottom." - ".$halbottom;?></font></span><?php
					$act=explode(",",$action);
					$jumact=count($act); 
					for($i=0;$i<$jumact;$i++){ tombolact($linkmod,$act[$i],$nobottom,$pubbottom,$module->getHttp()); } ?>
				</div><?php
				$jumbot++;
			} ?>
			<div class="tataletak_module" style="background:#D5D5D5; border:1px dashed #BBBBBB; float:left; width:180px; height:53px;">
				<h5 class="tataletak_judul"><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/bottom/ok/" title="Tambah Module">Tambah Module</a></h5>
			</div>
		</div>
	</div>
	<div id="tataletak">
		<b>FOOTER</b>
		<div class="tataletak_module">
			<span class="tataletak_judul"><?php echo $footer; ?></span>
			<h6 class="tataletak_act"><a href="<?php echo $module->getHttp();?>://<?php echo $linksub."/".$adm."/meta/";?>" title="Ubah">Ubah</a></h6>
		</div>
	</div><?php
}


function tataletak_tambah ($subdomain,$linksub,$folder) { 
	$module=new admin ();
	$module->get_variable();
	$module->setLinkSub($linksub);
	$domain=$module->domain; 
	$mod=$module->mod; 
	$adm=$module->adm; 
	$order=$module->order; 
	global $resize;
	global $uploader;
	$linkmod=$linksub."/".$adm."/".$mod;?>
	<h2>Tambah Module</h2><?php
	if (empty ($_POST['proses'])) {?>
		<h3>STEP 1 : PILIH TIPE MODULE</h3><?php
		$qsetting=mysqli_query($koneksi, "SELECT paket FROM setting WHERE subdomain='$subdomain'");
		$dsetting=mysqli_fetch_array($qsetting);
		$paketset=$dsetting['paket'];
		if ($order=="") { $posisicek="side"; $posisi="side"; } elseif ($order=="left" or $order=="right") { $posisicek="side"; $posisi=$order; } else { $posisicek=$order; $posisi=$order; } 
		$qmodkat=mysqli_query($koneksi, "SELECT no,judul FROM modulekategori WHERE publish='1' ORDER BY judul ASC");
		while($dmodkat=mysqli_fetch_array($qmodkat)){ 
			$idmodkat=$dmodkat['no'];
			$judulmodkat=$dmodkat['judul'];
			$qmod=mysqli_query($koneksi, "SELECT no,judul,deskripsi,tipe FROM moduletipe WHERE publish='1' AND id_modulekategori='$idmodkat' AND posisi LIKE '%$posisicek,%' AND kategori='basic' ORDER BY judul ASC"); 
			$qmodpaket=mysqli_query($koneksi, "SELECT no,judul,deskripsi,tipe FROM moduletipe WHERE publish='1' AND id_modulekategori='$idmodkat' AND posisi LIKE '%$posisicek,%' AND kategori='paket' AND paket LIKE '%$paketset%' ORDER BY judul ASC"); 
			$qmodadd=mysqli_query($koneksi, "SELECT no,judul,deskripsi,tipe FROM moduletipe WHERE publish='1' AND id_modulekategori='$idmodkat' AND posisi LIKE '%$posisicek,%' AND kategori='addon' ORDER BY judul ASC"); 
			$jummod=mysqli_num_rows($qmod);
			if ($jummod==0) { }
			else { ?>
				<div style="display:table; width:98%; padding:1%; margin-bottom:10px; background:#FBFBFB; border:1px solid #F0F0F0;">
					<div style="padding:5px 0px;"><h3 style="text-transform:uppercase"><?php echo $judulmodkat;?></h3></div><?php
				while($dmod=mysqli_fetch_array($qmod) or $dmod=mysqli_fetch_array($qmodpaket) or $dmod=mysqli_fetch_array($qmodadd)){ 
					$judul=$dmod['judul'];
					$deskripsi=$dmod['deskripsi'];
					$tipe=$dmod['tipe']; ?>
					<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" method="post">
						<input name="proses" type="hidden" value="tipe"/>
						<div style="display:table; width:100%; padding:1% 0%; border-top:1px solid #F0F0F0;" >
							<div style="float:left;"><b><?php echo $judul;?></b><br/><?php echo $deskripsi;?></div>
							<div style="float:right;">
								<input name="tipe" type="hidden" value="<?php echo $tipe; ?>"/>
								<input name="posisi" type="hidden" value="<?php echo $posisi; ?>"/>
								<input type="image" src="//<?php echo $domain;?>/image/next.png" value="LANJUT" align="right" style="border:none; background:none;" title="LANJUT"/>
							</div>
						</div>
					</form><?php 
				} ?>
				</div><?php
			}
		}
	}
	elseif ($_POST['proses']=="tipe") {
		$tipe=strip_tags($_POST['tipe']);
		$posisi=strip_tags($_POST['posisi']);
		$qmod=mysqli_query($koneksi, "SELECT judul,relasi,kolom,jenis_file,tampilan_tipe,relasi_tabel,lanjut FROM moduletipe WHERE tipe='$tipe' AND publish='1'");
		$dmod=mysqli_fetch_array($qmod);
		$judulmod=$dmod['judul'];
		$relasimod=$dmod['relasi'];
		$kolommod=$dmod['kolom'];
		$jenis_file=$dmod['jenis_file'];
		$tipe_tampilan=$dmod['tampilan_tipe'];
		$relasi_tabel=$dmod['relasi_tabel'];
		$lanjut=$dmod['lanjut'];  ?>
		<h3 style="text-transform:uppercase">STEP 2 : ISI DETAIL MODULE <?php echo $judulmod;?></h3>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="proses" value="simpan"/>
			<input type="hidden" name="mode" value="sederhana"/>
            <input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
			<input type="hidden" name="posisi" value="<?php echo $posisi;?>"/>
			<input type="hidden" name="relasi" value="<?php echo $relasimod;?>"/>
			<input type="hidden" name="kolom" value="<?php echo $kolommod;?>"/>
			<input type="hidden" name="jenis_file" value="<?php echo $jenis_file;?>"/>
			<input type="hidden" name="urutan" value="10"/>
			<input type="hidden" name="tampilkan_judul" value="1"/>
			<input type="hidden" name="hal" value="semua"/>
			<input type="hidden" name="lanjut" value="<?php echo $lanjut;?>"/>
			<table width="100%" cellpadding="0" cellspacing="0" id="tabelview">
				<tr><td width="140">Judul Module</td><td><input type="text" name="judul" id="judul" style="width:95%; max-width:500px;"/></td></tr><?php
				$value="";
				if ($relasimod==0) { }
				else { 
					$kolom=explode(",",$kolommod);
					$jumkolom=count($kolom);
					for($j=0;$j<$jumkolom;$j++){ $module->form($subdomain,$linksub,$kolom[$j],"input",$value,""); }
				}
				if ($tipe_tampilan=="") { ?><input type="hidden" name="tampilan_tipe" value=""/><?php }
				else { 
					$tipetam=explode(",",$tipe_tampilan);
					$jumtipetam=count($tipetam); ?>
					<tr><td width="140">Tipe Tampilan</td><td>
						<select name="tampilan_tipe" style="width:96%; max-width:510px;"><?php 
							for($s=0;$s<$jumtipetam;$s++){ ?><option value="<?php echo $tipetam[$s];?>"><?php echo $tipetam[$s];?></option><?php } ?>
						</select>
						</td></tr><?php
				}
				if ($relasi_tabel=="") { ?><input type="hidden" name="idtipe" value=""/><?php }
				else { 
					$relasitabel=str_replace("_"," ",$relasi_tabel);?>
					<tr><td width="140">Pilih <?php echo $relasitabel;?></td><td>
						<select name="idtipe" style="width:96%; max-width:510px;"><?php 						
						$qreltabel=mysqli_query($koneksi, "SELECT no,judul FROM $relasi_tabel WHERE publish='1' AND subdomain='$subdomain'");
						while ($dreltabel=mysqli_fetch_array($qreltabel)) { ?>
							<option value="<?php echo $dreltabel['no'];?>"><?php echo $dreltabel['judul'];?></option><?php 
						} ?>
						</select>
						</td></tr><?php
				} ?>
				<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekJudul();" class="button"/></td></tr>
			</table>
		</form>
		<div style="float:right; text-align:right">
			<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" method="post">
				<input name="proses" type="hidden" value="tiperinci"/>
				<input name="tipe" type="hidden" value="<?php echo $tipe; ?>"/>
				<input name="posisi" type="hidden" value="<?php echo $posisi; ?>"/>
				<input type="submit" value="Mode Rinci" style="cursor:pointer; border:none; padding:0px;"/>
			</form>
		</div><?php
		$randkode=rand(111111,888888); 
		$_SESSION['kode']=$randkode;
	}
	elseif ($_POST['proses']=="tiperinci") {
		$tipe=strip_tags($_POST['tipe']);
		$posisi=strip_tags($_POST['posisi']);
		$qmod=mysqli_query($koneksi, "SELECT judul,relasi,kolom,jenis_file,tampilan_tipe,relasi_tabel,lanjut  FROM moduletipe WHERE tipe='$tipe' AND publish='1'");
		$dmod=mysqli_fetch_array($qmod);
		$judulmod=$dmod['judul'];
		$relasimod=$dmod['relasi'];
		$kolommod=$dmod['kolom'];
		$jenis_file=$dmod['jenis_file'];
		$tipe_tampilan=$dmod['tampilan_tipe'];
		$relasi_tabel=$dmod['relasi_tabel']; 
		$lanjut=$dmod['lanjut']; ?>
		<h3 style="text-transform:uppercase">STEP 2 : ISI DETAIL MODULE <?php echo $judulmod;?></h3>
		<form action="" method="post" enctype="multipart/form-data">
			<input name="proses" type="hidden" value="simpan"/>
			<input type="hidden" name="mode" value="rinci"/>
            <input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
			<input type="hidden" name="posisi" value="<?php echo $posisi;?>"/>
			<input type="hidden" name="relasi" value="<?php echo $relasimod;?>"/>
			<input type="hidden" name="kolom" value="<?php echo $kolommod;?>"/>
			<input type="hidden" name="jenis_file" value="<?php echo $jenis_file;?>"/>
			<input type="hidden" name="lanjut" value="<?php echo $lanjut;?>"/>
			<table width="100%" cellpadding="0" cellspacing="0" id="tabelview">
				<tr><td width="140">Judul Module</td><td><input type="text" name="judul" id="judul" style="width:95%; max-width:500px;"/></td></tr>
				<tr><td>Urutan</td>
					<td>
						<select name="urutan" style="width:96%; max-width:510px;"><?php $ii=1; 
						do{ ?><option value="<?php echo $ii;?>"><?php echo $ii;?></option><?php $ii++; } while($ii<=10); ?>
						</select>
					</td>
				</tr>
				<tr><td>Tampilkan Judul</td>
					<td><select name="tampilkan_judul" style="width:96%; max-width:510px;"><option value="1">Tampilkan</option><option value="0">Sembunyikan</option></select></td></tr>
				<tr><td>Tampilkan Module</td>
					<td><select name="hal" style="width:96%; max-width:510px;"><option value="semua">Di Semua Halaman</option><option value="home">Hanya di Halaman Depan / Home</option></select></td></tr><?php
				$value="";
				if ($relasimod==0) { }
				else { 
					$kolom=explode(",",$kolommod);
					$jumkolom=count($kolom);
					for($j=0;$j<$jumkolom;$j++){ $module->form($subdomain,$linksub,$kolom[$j],"input",$value,""); }
				} 
				if ($tipe_tampilan=="") { ?><input type="hidden" name="tampilan_tipe" value=""/><?php }
				else { 
					$tipetam=explode(",",$tipe_tampilan);
					$jumtipetam=count($tipetam); ?>
					<tr><td width="140">Tipe Tampilan</td><td>
						<select name="tampilan_tipe" style="width:96%; max-width:510px;"><?php 
							for($s=0;$s<$jumtipetam;$s++){ ?><option value="<?php echo $tipetam[$s];?>"><?php echo $tipetam[$s];?></option><?php } ?>
						</select>
						</td></tr><?php
				}
				if ($relasi_tabel=="") { ?><input type="hidden" name="idtipe" value=""/><?php }
				else { 
					$relasitabel=str_replace("_"," ",$relasi_tabel);?>
					<tr><td width="140">Pilih <?php echo $relasitabel;?></td><td>
						<select name="idtipe" style="width:96%; max-width:510px;"><?php 
						$qreltabel=mysqli_query($koneksi, "SELECT no,judul FROM $relasi_tabel WHERE publish='1' AND subdomain='$subdomain'");
						while ($dreltabel=mysqli_fetch_array($qreltabel)) { ?>
							<option value="<?php echo $dreltabel['no'];?>"><?php echo $dreltabel['judul'];?></option><?php 
						} ?>
						</select>
						</td></tr><?php
				} ?>
				<tr><td></td><td><input type="submit" name="submit" value="SIMPAN" onclick="return cekJudul();" class="button"/></td></tr>
			</table>
		</form>
		<div style="float:right; text-align:right">
			<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/act/tambah/" method="post">
				<input name="proses" type="hidden" value="tipe"/>
				<input name="tipe" type="hidden" value="<?php echo $tipe; ?>"/>
				<input name="posisi" type="hidden" value="<?php echo $posisi; ?>"/>
				<input type="submit" value="Mode Sederhana" style="cursor:pointer; border:none; padding:0px;"/>
			</form>
		</div><?php
		$randkode=rand(111111,888888); 
		$_SESSION['kode']=$randkode;
	}
	elseif ($_POST['proses']=="simpan") {
		$mode=strip_tags($_POST['mode']);
		$tipe=strip_tags($_POST['tipe']);
		$posisi=strip_tags($_POST['posisi']);
		$judul=strip_tags($_POST['judul']);
			$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1"); $g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
			$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5"); $g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
			$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9"); $g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
			$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13"); $g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
			$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17"); $g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
			$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21"); $g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
			$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25"); $g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
			$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29"); $g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
			$linkhasil=strtolower("$gantispasi");
		$urutan=strip_tags($_POST['urutan']);
		$relasi=strip_tags($_POST['relasi']);
		$kolom=strip_tags($_POST['kolom']);
		if ($mode=="sederhana") { $hal="semua"; } else { $hal=strip_tags($_POST['hal']); }  
		$jenis_file=strip_tags($_POST['jenis_file']);
		$tampilkan_judul=strip_tags($_POST['tampilkan_judul']);
		$idtipe=strip_tags($_POST['idtipe']);
		$tampilan_tipe=strip_tags($_POST['tampilan_tipe']);
		$lanjut=strip_tags($_POST['lanjut']);
		if (empty ($_SESSION['kode'])) { $module->notify($subdomain,$linksub,"save_ok"); }
		else { 
			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
			mysqli_query($koneksi, "INSERT INTO module (subdomain,judul,link,posisi,tipe,idtipe,tampilan_tipe,hal,tampilkan_judul,urutan,tgl)
				VALUE ('$subdomain','$judul','$linkhasil','$posisi','$tipe','$idtipe','$tampilan_tipe','$hal','$tampilkan_judul','$urutan',sysdate())");
			if ($relasi==0) { ?>
				<h3>Module Berhasil Dibuat</h3>Selamat, Module Berhasil Dibuat<br/><a href="//<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
			}
			else {				
				//revisi kode dalam pengambilan no terakhir dari query database menjadi mysqli_insert_id()
				$id_module=mysqli_insert_id();
				if ($jenis_file=="gambar") {
					if ($_FILES['gambar']['tmp_name']=="") { 
						if ($relasi==2) {
							$module->action_edit($kolom,"");
							$ubah=$module->actionubah;
							mysqli_query($koneksi, "UPDATE setting SET $ubah tgl=sysdate() WHERE subdomain='$subdomain'");
						}
						else { 
							$module->action_input($kolom,"");
							$kolomtabel=$module->actionkolom;
							$isitabel=$module->actionisian;
							mysqli_query($koneksi, "INSERT INTO $tipe (subdomain,id_module,judul,link,$kolomtabel tgl) VALUES ('$subdomain','$id_module','$judul','$linkhasil',$isitabel sysdate())");
						} ?>
						<h3>Module Berhasil Dibuat</h3>Selamat, Module Berhasil Dibuat<br/><a href="//<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
					}
					else {
						$gambar=$_FILES['gambar']['tmp_name'];
						$gambar_name=$_FILES['gambar']['name'];
						$gambar_size=$_FILES['gambar']['size'];
						$gambar_type=$_FILES['gambar']['type'];
						$acak=rand(00000000,88888899);
						$judul_baru=$acak.$gambar_name;
						$judul_baru=str_replace(" ","",$judul_baru);
						$gambar_dimensi=getimagesize($gambar);
						if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ $module->notify($subdomain,$linksub,"img_format"); }
						elseif ($gambar_dimensi['0']>"1000" or $gambar_dimensi['1']>"1000") { $module->notify($subdomain,$linksub,"image_dimention"); } 
						elseif ($gambar_size>"1000000") { $module->notify($subdomain,$linksub,"image_size"); } 
						else {
							include($folder.'/function/validasiupload.php');
							$image=new ValidasiUpload($gambar,$judul_baru);
							$image->putGambarType($gambar_type);
							if (!$image->validGambar()){
								$module->notify($subdomain,$linksub,"img_format"); 
								exit;
							}
							
							if ($relasi==2) {
								$module->action_edit($kolom,$judul_baru);
								$ubah=$module->actionubah;
								mysqli_query($koneksi, "UPDATE setting SET $ubah tgl=sysdate() WHERE subdomain='$subdomain'");
							}
							else { 
								$module->action_input($kolom,$judul_baru);
								$kolomtabel=$module->actionkolom;
								$isitabel=$module->actionisian;
								mysqli_query($koneksi, "INSERT INTO $tipe (subdomain,id_module,judul,link,$kolomtabel tgl) VALUES ('$subdomain','$id_module','$judul','$linkhasil',$isitabel sysdate())");
								
							}
							copy ($gambar, "$folder/picture/".$judul_baru);
							$uploader->uploadPicture($judul_baru);?>
							<h3>Module Berhasil Dibuat</h3>Selamat, Module Berhasil Dibuat<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
						}
					}
				}
				else {
					if ($relasi==2) {
						$module->action_edit($kolom,"");
						$ubah=$module->actionubah;
						mysqli_query($koneksi, "UPDATE setting SET $ubah tgl=sysdate()  WHERE subdomain='$subdomain'"); 
					}
					else { 
						$module->action_input($kolom,"");
						$kolomtabel=$module->actionkolom;
						$isitabel=$module->actionisian;
						mysqli_query($koneksi, "INSERT INTO $tipe (subdomain,id_module,judul,link,$kolomtabel tgl) VALUES ('$subdomain','$id_module','$judul','$linkhasil',$isitabel sysdate())");
						if ($subdomain=='demo'){
							//echo str_replace("'",'"',$isitabel);
							//print_r($isitabel);
							//echo "INSERT INTO $tipe (subdomain,id_module,judul,link,$kolomtabel tgl) VALUES ('$subdomain','$id_module','$judul','$linkhasil',$isitabel sysdate())";
						}
						
					} ?>
					<h3>Module Berhasil Dibuat</h3>Selamat, Module Berhasil Dibuat<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
				}
			}
		}
	}
}


function tataletak_ubah ($subdomain,$linksub,$folder) {
	$module=new admin ();
	$module->get_variable();
	$module->setLinkSub($linksub);
	$domain=$module->domain; 
	$mod=$module->mod; 
	$adm=$module->adm; 
	$no=$module->no;
	global $resize;
	global $uploader;
	$linkmod=$linksub."/".$adm."/".$mod;
	$qset=mysqli_query($koneksi, "SELECT kolom FROM setting WHERE subdomain='$subdomain'");
	$dset=mysqli_fetch_array($qset);
	$jumkolomsisi=$dset['kolom'];
	if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
	else {
		$no=strip_tags($no)/1;
		$query=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,posisi,tampilan_tipe,tampilkan_judul,hal,urutan
		 FROM module WHERE no='$no' AND subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$no=$data['no'];
		if ($no=="") { $module->notify($subdomain,$linksub,"empty"); }
		else { ?>
			<h2>Ubah Tata Letak</h2><?php
			if (empty ($_POST['proses'])) {
				$judul=$data['judul'];
				$tipe=$data['tipe'];
				$idtipe=$data['idtipe'];
				$posisi=$data['posisi'];
				$tipe_tampilan_id=$data['tampilan_tipe'];
				$tampilkan_judul=$data['tampilkan_judul'];
				$hal=$data['hal'];
				$urutan=$data['urutan'];
				$qmod=mysqli_query($koneksi, "SELECT judul,tampilan_tipe,relasi_tabel,relasi,kolom,jenis_file,lanjut FROM moduletipe WHERE tipe='$tipe' AND publish='1'");
				$dmod=mysqli_fetch_array($qmod);
				$judulmod=$dmod['judul'];
				$tipe_tampilan=$dmod['tampilan_tipe'];
				$relasi_tabel=$dmod['relasi_tabel']; 
				$relasimod=$dmod['relasi'];
				$kolommod=$dmod['kolom'];
				$jenis_file=$dmod['jenis_file']; 
				$lanjut=$dmod['lanjut']; ?>
				<h3 style="text-transform:uppercase">EDIT MODULE <?php echo $judulmod;?></h3>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="proses" value="edit"/>
					<input type="hidden" name="mode" value="sederhana"/>
					<input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
					<input type="hidden" name="relasi" value="<?php echo $relasimod;?>"/>
					<input type="hidden" name="kolom" value="<?php echo $kolommod;?>"/>
					<input type="hidden" name="jenis_file" value="<?php echo $jenis_file;?>"/>
					<input type="hidden" name="posisi" value="<?php echo $posisi;?>"/>
					<input type="hidden" name="urutan" value="<?php echo $urutan;?>"/>
					<input type="hidden" name="tampilkan_judul" value="<?php echo $tampilkan_judul;?>"/>
					<input type="hidden" name="lanjut" value="<?php echo $lanjut;?>"/>
					<table width="100%" cellpadding="0" cellspacing="0" id="tabelview">
						<tr><td width="140">Judul Module</td><td><input type="text" name="judul" id="judul" style="width:95%;max-width:500px;" value="<?php echo $judul;?>"/></td></tr><?php
						$value="";
						if ($relasimod==0) { }
						elseif ($relasimod==2) {
							$qisimod=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
							$disimod=mysqli_fetch_array($qisimod);
							$kolom=explode(",",$kolommod);
							$jumkolom=count($kolom);
							for($j=0;$j<$jumkolom;$j++){ $module->form($subdomain,$linksub,$kolom[$j],"edit",$disimod[$kolom[$j]],"");	}
						}
						else {  
							$qisimod=mysqli_query($koneksi, "SELECT * FROM $tipe WHERE id_module='$no' AND subdomain='$subdomain'");
							$disimod=mysqli_fetch_array($qisimod);
							$kolom=explode(",",$kolommod);
							$jumkolom=count($kolom);
							for($j=0;$j<$jumkolom;$j++){ $module->form($subdomain,$linksub,$kolom[$j],"edit",$disimod[$kolom[$j]],"");	}
						} 
						if ($tipe_tampilan=="") { ?><input type="hidden" name="tampilan_tipe" value=""/><?php }
						else { 
							$tipetam=explode(",",$tipe_tampilan);
							$jumtipetam=count($tipetam); ?>
							<tr><td width="140">Tipe Tampilan</td><td>
								<select name="tampilan_tipe" style="width:96%;max-width:510px;">
									<option value="<?php echo $tipe_tampilan_id;?>"><?php echo $tipe_tampilan_id;?></option><?php 
									for($s=0;$s<$jumtipetam;$s++){ ?><option value="<?php echo $tipetam[$s];?>"><?php echo $tipetam[$s];?></option><?php } ?>
								</select>
								</td></tr><?php
						}
						if ($relasi_tabel=="") { ?><input type="hidden" name="idtipe" value=""/><?php }
						else { 
							$relasitabel=str_replace("_"," ",$relasi_tabel);?>
							<tr><td width="140">Pilih <?php echo $relasitabel;?></td><td>
								<select name="idtipe" style="width:96%;max-width:510px;"><?php 
								$qreltabelid=mysqli_query($koneksi, "SELECT no,judul FROM $relasi_tabel WHERE no='$idtipe' AND subdomain='$subdomain'");
								$dreltabelid=mysqli_fetch_array($qreltabelid); ?>
								<option value="<?php echo $dreltabelid['no'];?>"><?php echo $dreltabelid['judul'];?></option><?php
								$qreltabel=mysqli_query($koneksi, "SELECT no,judul FROM $relasi_tabel WHERE  publish='1' AND subdomain='$subdomain'");
								while ($dreltabel=mysqli_fetch_array($qreltabel)) { ?>
									<option value="<?php echo $dreltabel['no'];?>"><?php echo $dreltabel['judul'];?></option><?php 
								} ?>
								</select>
								</td></tr><?php
						} ?>
						<tr><td></td>
							<td>
								<input type="submit" name="submit" value="SIMPAN" onclick="return cekJudul();" class="button" style="margin-bottom:5px;"/>
								<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/>
							</td>
						</tr>
					</table>
				</form>
				<div style="float:right; text-align:right">
					<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod."/act/ubah/".$no;?>/" method="post">
						<input name="proses" type="hidden" value="tiperinci"/>
						<input type="submit" value="Mode Rinci" style="cursor:pointer; border:none; padding:0px;"/>
					</form>
				</div><?php
				$randkode=rand(111111,888888); 
				$_SESSION['kode']=$randkode;
			}
			elseif ($_POST['proses']=="tiperinci") {
				$judul=$data['judul'];
				$tipe=$data['tipe'];
				$idtipe=$data['idtipe'];
				$posisi=$data['posisi'];
				$tipe_tampilan_id=$data['tampilan_tipe'];
				$tampilkan_judul=$data['tampilkan_judul'];
				$hal=$data['hal'];
				$urutan=$data['urutan'];
				$qmod=mysqli_query($koneksi, "SELECT judul,posisi,tampilan_tipe,relasi_tabel,relasi,kolom,jenis_file,lanjut  FROM moduletipe WHERE tipe='$tipe' AND publish='1'");
				$dmod=mysqli_fetch_array($qmod);
				$judulmod=$dmod['judul'];
				$posisimod=$dmod['posisi'];
				$tipe_tampilan=$dmod['tampilan_tipe'];
				$relasi_tabel=$dmod['relasi_tabel']; 
				$relasimod=$dmod['relasi'];
				$kolommod=$dmod['kolom'];
				$jenis_file=$dmod['jenis_file']; 
				$lanjut=$dmod['lanjut']; ?>
				<h3 style="text-transform:uppercase">EDIT MODULE <?php echo $judulmod;?></h3>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="proses" value="edit"/>
					<input type="hidden" name="mode" value="rinci"/>
					<input type="hidden" name="tipe" value="<?php echo $tipe;?>"/>
					<input type="hidden" name="relasi" value="<?php echo $relasimod;?>"/>
					<input type="hidden" name="kolom" value="<?php echo $kolommod;?>"/>
					<input type="hidden" name="jenis_file" value="<?php echo $jenis_file;?>"/>
					<input type="hidden" name="lanjut" value="<?php echo $lanjut;?>"/>
					<table width="100%" cellpadding="0" cellspacing="0" id="tabelview">
						<tr><td width="140">Judul Module</td><td><input type="text" name="judul" id="judul" style="width:95%;max-width:500px;" value="<?php echo $judul;?>"/></td></tr>
						<tr><td>Posisi</td>
							<td>
								<select name="posisi" style="width:96%;max-width:510px;">
									<option value="<?php echo $posisi;?>"><?php echo $posisi;?></option><?php
									$posmod=explode(",",$posisimod); $jumposmod=count($posmod)-1;
									for($k=0;$k<$jumposmod;$k++){ 
										if ($posmod[$k]=="side") {
											if ($jumkolomsisi==3) { ?><option value="left">Left</option><option value="right">Right</option><?php }
											else { ?><option value="side">Side</option><?php }
										} 
										else { ?><option value="<?php echo $posmod[$k];?>"><?php echo $posmod[$k];?></option><?php }
									} ?>
								</select>
							</td>
						</tr>
						<tr><td>Urutan</td>
							<td>
								<select name="urutan" style="width:96%;max-width:510px;">
									<option value="<?php echo $urutan;?>"><?php echo $urutan;?></option><?php $ii=1; 
									do{ ?><option value="<?php echo $ii;?>"><?php echo $ii;?></option><?php $ii++; } while($ii<=10); ?>
								</select>
							</td>
						</tr>
						<tr><td>Tampilkan Judul</td>
							<td>
								<select name="tampilkan_judul" style="width:96%;max-width:510px;"><?php
									if ($tampilkan_judul==0) { ?><option value="0">Sembunyikan</option><option value="1">Tampilkan</option><?php }
									else { ?><option value="1">Tampilkan</option><option value="0">Sembunyikan</option><?php } ?>
								</select>
							</td>
						</tr>
						<tr><td>Tampilkan Module</td>
							<td>
								<select name="hal" style="width:96%;max-width:510px;"><?php
									if ($hal=="home") { ?><option value="home">Hanya di Halaman Depan / Home</option><option value="semua">Di Semua Halaman</option><?php }
									else { ?><option value="semua">Di Semua Halaman</option><option value="home">Hanya di Halaman Depan / Home</option><?php } ?>
								</select>
							</td>
						</tr><?php
						$value="";
						if ($relasimod==0) { }
						elseif ($relasimod==2) {
							$qisimod=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
							$disimod=mysqli_fetch_array($qisimod);
							$kolom=explode(",",$kolommod);
							$jumkolom=count($kolom);
							for($j=0;$j<$jumkolom;$j++){ $module->form($subdomain,$linksub,$kolom[$j],"edit",$disimod[$kolom[$j]],"");	}
						}
						else { 
							$qisimod=mysqli_query($koneksi, "SELECT * FROM $tipe WHERE id_module='$no' AND subdomain='$subdomain'");
							$disimod=mysqli_fetch_array($qisimod);
							$kolom=explode(",",$kolommod);
							$jumkolom=count($kolom);
							for($j=0;$j<$jumkolom;$j++){ $module->form($subdomain,$linksub,$kolom[$j],"edit",$disimod[$kolom[$j]],"");	}
						} 
						if ($tipe_tampilan=="") { ?><input type="hidden" name="tampilan_tipe" value=""/><?php }
						else { 
							$tipetam=explode(",",$tipe_tampilan);
							$jumtipetam=count($tipetam); ?>
							<tr><td width="140">Tipe Tampilan</td><td>
								<select name="tampilan_tipe" style="width:96%;max-width:510px;">
									<option value="<?php echo $tipe_tampilan_id;?>"><?php echo $tipe_tampilan_id;?></option><?php 
									for($s=0;$s<$jumtipetam;$s++){ ?><option value="<?php echo $tipetam[$s];?>"><?php echo $tipetam[$s];?></option><?php } ?>
								</select>
								</td></tr><?php
						}
						if ($relasi_tabel=="") { ?><input type="hidden" name="idtipe" value=""/><?php }
						else { 
							$relasitabel=str_replace("_"," ",$relasi_tabel);?>
							<tr><td width="140">Pilih <?php echo $relasitabel;?></td><td>
								<select name="idtipe" style="width:96%;max-width:510px;"><?php 
								$qreltabelid=mysqli_query($koneksi, "SELECT no,judul FROM $relasi_tabel WHERE no='$idtipe' AND subdomain='$subdomain'");
								$dreltabelid=mysqli_fetch_array($qreltabelid); ?>
								<option value="<?php echo $dreltabelid['no'];?>"><?php echo $dreltabelid['judul'];?></option><?php
								$qreltabel=mysqli_query($koneksi, "SELECT no,judul FROM $relasi_tabel WHERE  publish='1' AND subdomain='$subdomain'");
								while ($dreltabel=mysqli_fetch_array($qreltabel)) { ?>
									<option value="<?php echo $dreltabel['no'];?>"><?php echo $dreltabel['judul'];?></option><?php 
								} ?>
								</select>
								</td></tr><?php
						} ?>
						<tr><td></td>
							<td>
								<input type="submit" name="submit" value="SIMPAN" onclick="return cekJudul();" class="button" style="margin-bottom:5px;"/>
								<input type="button" name="back" value="KEMBALI" onclick="self.history.back();" class="button_back"/>
							</td>
						</tr>
					</table>
				</form>
				<div style="float:right; text-align:right">
					<form action="<?php echo $module->getHttp();?>://<?php echo $linkmod."/act/ubah/".$no;?>/" method="post">
						<input type="submit" value="Mode Sederhana" style="cursor:pointer; border:none; padding:0px;"/>
					</form>
				</div><?php
			}
			elseif($_POST['proses']=="edit"){
				$mode=strip_tags($_POST['mode']);
				$tipe=strip_tags($_POST['tipe']);
				$idtipe=strip_tags($_POST['idtipe']);
				$judul=strip_tags($_POST['judul']);
					$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1"); $g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
					$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5"); $g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
					$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9"); $g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
					$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13"); $g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
					$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17"); $g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
					$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21"); $g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
					$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25"); $g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
					$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29"); $g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
					$linkhasil=strtolower("$gantispasi");
				$tampilan_tipe=strip_tags($_POST['tampilan_tipe']);
				$posisi=strip_tags($_POST['posisi']);
				$urutan=strip_tags($_POST['urutan']);
				$relasi=strip_tags($_POST['relasi']);
				$kolom=strip_tags($_POST['kolom']);
				$jenis_file=strip_tags($_POST['jenis_file']);
				$tampilkan_judul=strip_tags($_POST['tampilkan_judul']);
				$lanjut=strip_tags($_POST['lanjut']);
				//hapus cache relasi modul
				global $filemanager;
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.'.$tipe.'.'.$no);
				if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
				if ($mode=="sederhana") { 
					mysqli_query($koneksi, "UPDATE module SET judul='$judul', link='$linkhasil', tampilan_tipe='$tampilan_tipe', idtipe='$idtipe' WHERE no='$no' AND subdomain='$subdomain'");
					
				}
				else {
					$hal=strip_tags($_POST['hal']);
					mysqli_query($koneksi, "UPDATE module SET judul='$judul', link='$linkhasil', posisi='$posisi', hal='$hal', tampilkan_judul='$tampilkan_judul',
						urutan='$urutan', tampilan_tipe='$tampilan_tipe', idtipe='$idtipe' WHERE no='$no'  AND subdomain='$subdomain'");
				}
				if ($relasi==0) { ?>
					<h3>Module Berhasil Diubah</h3>Selamat, Module Berhasil Diubah<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
				}
				else {
					if ($jenis_file=="gambar") {
						if ($_FILES['gambar']['tmp_name']=="") { 
							if ($relasi==2) {
								$module->action_edit($kolom,$_POST['gambarlama']);
								$ubah=$module->actionubah;
								mysqli_query($koneksi, "UPDATE setting SET $ubah tgl=sysdate() WHERE subdomain='$subdomain'");
							}
							else { 
								$module->action_edit($kolom,$_POST['gambarlama']);
								$ubah=$module->actionubah;
								mysqli_query($koneksi, "UPDATE $tipe SET judul='$judul',link='$linkhasil', $ubah tgl=sysdate() WHERE id_module='$no' AND subdomain='$subdomain'"); 
							} ?>
							<h3>Module Berhasil Diubah</h3>Selamat, Module Berhasil Diubah<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
						}
						else {
							$gambar=$_FILES['gambar']['tmp_name'];
							$gambar_name=$_FILES['gambar']['name'];
							$gambar_size=$_FILES['gambar']['size'];
							$gambar_type=$_FILES['gambar']['type'];
							$acak=rand(00000000,88888899);
							$judul_baru=$acak.$gambar_name;
							$judul_baru=str_replace(" ","",$judul_baru);
							$gambar_dimensi=getimagesize($gambar);
							if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ $module->notify($subdomain,$linksub,"img_format"); }
							elseif ($gambar_dimensi['0']>"1000" or $gambar_dimensi['1']>"1000") { $module->notify($subdomain,$linksub,"image_dimention"); } 
							elseif ($gambar_size>"1000000") { $module->notify($subdomain,$linksub,"image_size"); } 
							else {
								include ($folder.'/function/validasiupload.php');
								$image=new ValidasiUpload($gambar,$judul_baru);
								$image->putGambarType($gambar_type);
								if (!$image->validGambar()){
									$module->notify($subdomain,$linksub,"img_format"); 
									exit;
								}
								if ($relasi==2) {
									$module->action_edit($kolom,$judul_baru);
									$ubah=$module->actionubah;
									mysqli_query($koneksi, "UPDATE setting SET $ubah tgl=sysdate() WHERE subdomain='$subdomain'");
								}
								else { 
									$module->action_edit($kolom,$judul_baru);
									$ubah=$module->actionubah;
									mysqli_query($koneksi, "UPDATE $tipe SET judul='$judul',link='$linkhasil', $ubah tgl=sysdate() WHERE id_module='$no'  AND subdomain='$subdomain'");
								}
								copy ($gambar, "$folder/picture/".$judul_baru);
								$uploader->uploadPicture($judul_baru);
								if($_POST['gambarlama']==""){ } else { /*unlink("$folder/picture/".$_POST['gambarlama']); */} ?>
								<h3>Module Berhasil Diubah</h3>Selamat, Module Berhasil Diubah<br/><a href="<?php echo $module->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
							}
						}
					}
					else {
						if ($relasi==2) {
							$module->action_edit($kolom,"");
							$ubah=$module->actionubah;
							mysqli_query($koneksi, "UPDATE setting SET $ubah tgl=sysdate() WHERE subdomain='$subdomain'");
						}
						else { 
							$module->action_edit($kolom,"");
							$ubah=$module->actionubah;
							mysqli_query($koneksi, "UPDATE $tipe SET judul='$judul',link='$linkhasil', $ubah tgl=sysdate() WHERE id_module='$no' AND subdomain='$subdomain'");
						} ?>
						<h3>Module Berhasil Diubah</h3>Selamat, Module Berhasil Diubah<br/><a href="<?php echo$module->getHttp();?>://<?php echo $linkmod;?>/" title="Kembali">Kembali</a><?php
					}
				}
			}
		}
	}
}


function tombolact ($linkhal,$aksi,$no,$pub,$http='http') { 
	if ($aksi=="hapus") { $onclick="onclick=\"return confirm('Apakah Anda yakin akan menghapus data ini ?');\""; } else { $onclick=""; } 
	if ($aksi=="tampilkan") { if ($pub=="1") { $label="sembunyikan"; $title=$label; } else { $label="<font color=#FF0000>tampilkan</font>"; $title="Tampilkan"; } } 
	else { $label=$aksi; $title=$label; }
	if ($aksi=="naik" or $aksi=="turun") { $act="urutan"; } else { $act=$aksi; }
	$linkact=$linkhal."/act/".$act."/".$no;
	if ($aksi=="naik") { $linkact=$linkact."/minus"; } elseif ($aksi=="turun") { $linkact=$linkact."/plus"; } else { $linkact=$linkact; } ?>
	<h6 class="tataletak_act"><a href="<?php echo $http;?>://<?php echo $linkact;?>/" title="<?php echo $title;?>" <?php echo $onclick;?> ><?php echo $label;?></a></h6><?php
}


if ($tampil==1) {
	if(empty($akses)){ 
		header("location:index.php");
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$module=new admin ();
		$module->get_variable();
		$judulmod="Tata Letak";
		global $db;
		global $filemanager;
		if (empty($act)) { 
			tataletak($subdomain,$linksub);
		}
		elseif ($act=="tambah") {
			tataletak_tambah($subdomain,$linksub,$folder);
			
			
		}
		elseif ($act=="ubah") {
			tataletak_ubah($subdomain,$linksub,$folder);
			
		}
		elseif ($act=="tampilkan" or $act=="sembunyikan") {
			$tabel="module";
			$module->publish($subdomain,$linksub,$tabel); 
			tataletak($subdomain,$linksub);
		}
		elseif ($act=="hapus") {
			$tabel="module";
			$tipedelete="";			
			//revisi on 24 january 2017 penambahan penghapusan modul yang berkaitan.
			//sebelumnya jika menghapus modul banner data yang tabel banner tidak terhapus
			
			$no=(int) $_GET['no'];
			$qmod=$db->query("SELECT modul.no,modtipe.tipe,modtipe.relasi FROM module modul, moduletipe modtipe WHERE modul.tipe=modtipe.tipe AND modul.subdomain='".$db->escape($subdomain)."' AND modul.no='".$no."'");			
			$tipe=$qmod->row['tipe'];
			$relasi=$qmod->row['relasi'];
			if ($relasi==1){
				$db->query("DELETE FROM ".$tipe." WHERE id_module='".$no."' AND subdomain='".$db->escape($subdomain)."'");
				//hapus cache module
				$filemanager->hapus(DIR_CACHE.$subdomain.'/cache.'.$tipe.'.'.$no);
				
				if ($tipe=='banner'){
					$qban=$db->query("SELECT gambar from banner WHERE id_module='".$no."' AND subdomain='".$db->escape($subdomain)."'");
					$gambar=$qban->row['gambar'];
					if (file_exists($folder.'/picture/'.$gambar)){
						unlink($folder.'/picture/'.$gambar);
					}
				}
			}
			
			$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
		}
		elseif ($act=="urutan") {
			$tabel="module";
			$module->urutan($subdomain,$linksub,$tabel);
			tataletak($subdomain,$linksub);
		}
		else {
			tataletak($subdomain,$linksub);
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