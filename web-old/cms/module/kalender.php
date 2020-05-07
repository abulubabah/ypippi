<?php
if ($tampil==1) {
		if(empty($akses)){
			header("location:index.php"); 
		}
		elseif($akses=="publik" or $akses=="member"){  
			if ($layoutposisi=="main") { 
				if ($haltipe=="kalender") { ?> 
					<h2><a href="//<?php echo $linksub."/".$mod."/".$no."/".$link;?>.html" title="<?php echo $haljudul;?>"><?php echo $haljudul;?></a></h2><?php
					$yearnow=date("Y");
					$akhir=12; ?><h3>Tahun <?php echo $yearnow;?></h3><?php
					for ($awal=1; $awal<=$akhir; $awal++) {
						$monthnow=$awal; 
						$daynow=date("d"); 
						$endDate=date("t",mktime(0,0,0,$monthnow,$daynow,$yearnow));
						$month=$monthnow;
						if ($month=="01") { $bulan="Januari"; } else if ($month=="02") { $bulan="Februari"; } 
						else if ($month=="03") { $bulan="Maret"; } else if ($month=="04") { $bulan="April"; } 
						else if ($month=="05") { $bulan="Mei"; } else if ($month=="06") { $bulan="Juni"; } 
						else if ($month=="07") { $bulan="Juli"; } else if ($month=="08") { $bulan="Agustus"; } 
						else if ($month=="09") { $bulan="September"; } else if ($month=="10") { $bulan="Oktober"; } 
						else if ($month=="11") { $bulan="November"; } else if ($month=="12") { $bulan="Desember"; } ?>
						<div style="display:table; width:100%">
						<h4><b><?php echo $bulan; ?></b></h4>
						<div style="float:left; width:250px">
							<table width="100%" cellpadding="0" cellspacing="0" style="border-left:1px solid #DADADA; border-top:1px solid #DADADA;">
								<tr align="center" height="30" bgcolor="F0F0F0">
									<th width="30" id="minggu" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Mg</th>
									<th width="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Sn</th>
									<th width="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Sl</th>
									<th width="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Rb</th>
									<th width="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Km</th>
									<th width="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Jm</th>
									<th width="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">Sb</th>
								</tr><?php
								$s=date("w", mktime (0,0,0,$month,1,$yearnow));
								for ($ds=1;$ds<=$s;$ds++) { ?><td height="30"></td><?php }
								for ($d=1;$d<=$endDate;$d++) {
									if (date("w",mktime (0,0,0,$month,$d,$yearnow)) == 0) { ?><tr align="center" valign="middle"><?php }
									$fontColor="#000000";
									if (date("D",mktime (0,0,0,$month,$d,$yearnow)) == "Sun") { $color="#FF0000"; } else { $color="#000000";}?>
									<td align="center" height="30" style="border-right:1px solid #DADADA; border-bottom:1px solid #DADADA;">
									<span style="color:<?php echo $color;?>"><?php
										if (date("D",mktime (0,0,0,$month,$d,$yearnow)) == "Sun") { $color="#FF0000"; } else { $color="#000000";}
										if ($d<10) { $dbener="0".$d; } else { $dbener=$d; }
										$waktutgl=mktime(00,00,00, $month,$dbener,$yearnow);
										$tgltgl=$yearnow."-".$month."-".$dbener; 
										$query=mysqli_query($koneksi, "SELECT no,judul,tanggal_mulai,tanggal_selesai,link FROM kalender WHERE subdomain='$subdomain' AND tanggal_mulai<='$tgltgl' AND tanggal_selesai>='$tgltgl' AND  publish='1'");
										$data=mysqli_fetch_array($query);
										$jumlah=mysqli_num_rows($query);
										$nokal=$data['no'];
										$judul=$data['judul'];
										$tanggal_mulai=$data['tanggal_mulai'];
										$tanggal_selesai=$data['tanggal_selesai'];
										$linkhal=$data['link'];
										$linkkalender=$linksub."/kalender/".$nokal."/".$linkhal;
										if ($jumlah==0) { echo $d; }
										else { ?><div style="background:#FFAAAA; padding:3px 0px;">
											<a href="//<?php echo $linkkalender;?>/" title="<?php echo $judul;?>"><?php echo $d;?></a></div><?php 
										} ?>
									</span>  
									</td><?php
									if (date("w",mktime (0,0,0,$month,$d,$yearnow))==6) { ?></tr><?php } 
								} ?>
							</table>
						</div>
							<div style="float:left; margin-left:15px;">
								<b>Kegiatan di Bulan <?php echo $bulan; ?></b>
								<ul style="list-style:square;"><?php
								$monthskrg=$yearnow."-".$month."-";
								$qkeg=mysqli_query($koneksi, "SELECT no,judul,tanggal_mulai,tanggal_selesai,link,DATE_FORMAT(tanggal_mulai,'%d-%m-%Y') as tanggal_mulai,DATE_FORMAT(tanggal_selesai,'%d-%m-%Y') as tanggal_selesai FROM kalender WHERE tanggal_mulai LIKE '$monthskrg%' AND subdomain='$subdomain' AND publish='1'");
								while ($dkeg=mysqli_fetch_array($qkeg)) {
									$nokeg=$dkeg['no'];
									$judulkeg=$dkeg['judul'];
									$linkkeg=$dkeg['link'];
									$tanggal_mulai=$dkeg['tanggal_mulai'];
									$tanggal_selesai=$dkeg['tanggal_selesai'];
									$linkkalender=$linksub."/kalender/".$nokeg."/".$linkkeg; ?>
									<li><a href="//<?php echo $linkkalender;?>/" title="<?php echo $judulkeg;?>"><?php echo $judulkeg;?></a><br/>
										<?php echo $tanggal_mulai." s.d. ".$tanggal_selesai;?></li><?php
								
								} ?>
								</ul>
							</div>
						</div>
						<br/><?php
					}
				}
				else { 
					if (empty ($_GET['no'])) { }
					else {	
						$no=$_GET['no']/1;
						$query=mysqli_query($koneksi, "SELECT no,judul,link,tempat_kegiatan,tanggal_mulai,tanggal_selesai,isi,DATE_FORMAT(tanggal_mulai,'%d-%m-%Y') as tanggal_mulai,DATE_FORMAT(tanggal_selesai,'%d-%m-%Y') as tanggal_selesai FROM kalender WHERE no='$no' AND subdomain='$subdomain' AND publish='1'");
						$data=mysqli_fetch_array($query);
						$no=$data['no']; 
						if ($no=="") { $module->notify("empty"); }
						else {
							$judul=$data['judul'];
							$linkhal=$data['link'];
							$tempat_kegiatan=$data['tempat_kegiatan'];
							$tanggal_mulai=$data['tanggal_mulai'];
							$tanggal_selesai=$data['tanggal_selesai'];							
							$linkkalender=$linksub."/kalender/".$no."/".$linkhal;
							$isi=$data['isi']; ?>
							<h2><a href="//<?php echo $linkkalender;?>/" title="<?php echo $judul;?>"><?php echo $judul;?></a></h2>
							<h4><b>Tempat :</b> &nbsp; <?php echo $tempat_kegiatan;?></h4>
							<h4><b>Waktu :</b> &nbsp;  <?php echo $tanggal_mulai." s/d. ".$tanggal_selesai;?></h4>
							<h4><b>Deskripsi :</b></h4><?php echo $isi; 
						}
					}
				}
			}
			else {  ?>
				<div class="<?php echo $stylepanel;?>"><?php 
					if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
					<div class="<?php echo $styleisi;?>"><?php
						$akhir=1;
						$yearnow=date("Y");
						$monthnow=date("m");
						$daynow=date("d");
						$endDate=date("t",mktime(0,0,0,$monthnow,$daynow,$yearnow));
						$month=$monthnow;
						if ($month=="01") { $bulan="Januari"; } else if ($month=="02") { $bulan="Februari"; } 
						else if ($month=="03") { $bulan="Maret"; } else if ($month=="04") { $bulan="April"; } 
						else if ($month=="05") { $bulan="Mei"; } else if ($month=="06") { $bulan="Juni"; } 
						else if ($month=="07") { $bulan="Juli"; } else if ($month=="08") { $bulan="Agustus"; } 
						else if ($month=="09") { $bulan="September"; } else if ($month=="10") { $bulan="Oktober"; } 
						else if ($month=="11") { $bulan="November"; } else if ($month=="12") { $bulan="Desember"; } ?>
						<div style="display:table; width:100%">
							<h4 style="text-align:center;"><b><?php echo $bulan." ".$yearnow; ?></b></h4>
							<table width="100%" id="kalender" cellpadding="0" cellspacing="0">
									<tr align="center" height="30" bgcolor="F0F0F0">
										<th width="20" id="minggu">Mg</th>
										<th width="20">Sn</th>
										<th width="20">Sl</th>
										<th width="20">Rb</th>
										<th width="20">Km</th>
										<th width="20">Jm</th>
										<th width="20">Sb</th>
									</tr><?php
									$s=date("w", mktime (0,0,0,$month,1,$yearnow));
									for ($ds=1;$ds<=$s;$ds++) { ?><td height="30"></td><?php }
									for ($d=1;$d<=$endDate;$d++) {
										if (date("w",mktime (0,0,0,$month,$d,$yearnow)) == 0) { ?><tr align="center" valign="middle"><?php }
										$fontColor="#000000";
										if (date("D",mktime (0,0,0,$month,$d,$yearnow)) == "Sun") { $color="#FF0000"; } else { $color="#000000";}?>
										<td align="center" height="30">
										<span style="color:<?php echo $color;?>"><?php
											if ($d<10) { $dbener="0".$d; } else { $dbener=$d; }
											$waktutgl=mktime(00,00,00, $month,$dbener,$yearnow);
											$tgltgl=$yearnow."-".$month."-".$dbener; 
											$query=mysqli_query($koneksi, "SELECT no,judul,link,tanggal_mulai,tanggal_selesai FROM kalender WHERE subdomain='$subdomain' AND tanggal_mulai<='$tgltgl' AND tanggal_selesai>='$tgltgl' AND  publish='1'");
											$data=mysqli_fetch_array($query);
											$jumlah=mysqli_num_rows($query);
											$nokal=$data['no'];
											$judul=$data['judul'];
											$linkhal=$data['link'];
											$tanggal_mulai=$data['tanggal_mulai']; 
											$waktumulai=strtotime($tanggal_mulai);
											$tanggal_selesai=$data['tanggal_selesai'];	
											$waktuselesai=strtotime($tanggal_selesai);
											$linkkalender=$linksub."/kalender/".$nokal."/".$linkhal;
											if ($jumlah>=1) {  ?>
												<div style="background:#FFAAAA; padding:3px 0px;"><a href="//<?php echo $linkkalender;?>/" title="<?php echo $judul;?>"><?php echo $d;?></a></div><?php 
											} 
											else { echo $d; }?>
										</span>  
										</td><?php
										if (date("w",mktime (0,0,0,$month,$d,$yearnow))==6) { ?></tr><?php } 
									} ?>
							</table>
						</div>
					</div>
				</div><?php			
			}
		}
		elseif($akses=="admin" or $akses=="super"){

			function tambah_kalender($linksub,$subdomain){
				$admin=new admin();
				$admin->get_variable(); 
				$admin->setLinkSub($linksub);
				$domain=$admin->domain;
				$link=$admin->link;
				$linkmodule=$linksub."/".$link;
				if (empty($_POST['proses'])){?>
				<h2>Tambah Kalender</h2>
						<form action="" method="post" enctype="multipart/form-data" name="judulform">
							<input name="proses" type="hidden" value="tambah"/>
							<table width="100%" cellpadding="0" cellspacing="0" id="tabelview">
							<tr><td width="140" style="text">Nama Kegiatan</td><td style="text-transform:none;"><input type="text"  name="judul" id="judul" style="width:95%; max-width:500px;" value=""/></td></tr>
							<tr><td width="140" style="text">Tempat Kegiatan</td><td style="text-transform:none;"><input type="text"  name="tempat_kegiatan" id="tempat_kegiatan" style="width:95%; max-width:500px;" value=""/></td></tr>
							<tr><td>Tanggal mulai</td>
								<td>
								<select name="tglmulai" style="padding:0px; width:60px;"><?php 
								for($i=1; $i<=31; $i++) {$tg= ($i<10) ? "0$i" : $i;echo"<option value='$tg' style='padding:3px 5px;'>$tg</option>";}?></select> &nbsp; 
								Bulan &nbsp; <select name="blnmulai" style="padding:0px; width:60px;"><?php 
								for($i=1; $i<=12; $i++) {$bl= ($i<10) ? "0$i" : $i;echo "<option value='$bl' style='padding:3px 5px;'>$bl</option>";}?></select> &nbsp; 
								Tahun &nbsp; <select name="thnmulai" style="padding:0px; width:108px;"><?php 
								for ($i=date("Y"); $i<=date("Y")+1; $i++) { echo "<option value='$i' style='padding:3px 5px;'>$i</option>";}?></select>
								</td>
							</tr>
							<tr><td>Tanggal Selesai</td>
								<td>
								<select name="tglselesai" style="padding:0px; width:60px;"><?php 
								for($i=1; $i<=31; $i++) {$tg= ($i<10) ? "0$i" : $i;echo"<option value='$tg' style='padding:3px 5px;'>$tg</option>";}?></select> &nbsp; 
								Bulan &nbsp; <select name="blnselesai" style="padding:0px; width:60px;"><?php 
								for($i=1; $i<=12; $i++) {$bl= ($i<10) ? "0$i" : $i;echo "<option value='$bl' style='padding:3px 5px;'>$bl</option>";}?></select> &nbsp; 
								Tahun &nbsp; <select name="thnselesai" style="padding:0px; width:108px;"><?php 
								for ($i=date("Y"); $i<=date("Y")+1; $i++) { echo "<option value='$i' style='padding:3px 5px;'>$i</option>";}?></select>
								</td>
							</tr>
							<tr><td width="140">Deskripsi</td><td style="text-transform:none;"><textarea name="isi"  id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"></textarea></td></tr>
							<tr><td></td>
							<td>
							<input type="submit" name="submit" value="SIMPAN" onclick="return cekJudul();" class="button"/></td>
						</tr>
					</table>
				</form><?php 
				$randkode=rand(111111111,999999999);
				$_SESSION['kode']=$randkode;
				}
				else if ($_POST['proses']=="tambah"){
					if (empty($_SESSION['kode'])){
						echo"<script>history.go(-1);</script>";
					}
					else { if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
						$judul=mysql_escape_string($_POST['judul']);
							$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1");$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
							$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
							$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
							$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
							$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
							$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21");$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
							$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
							$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
							$linkhasil=strtolower("$gantispasi");
						$blnmulai=$_POST['blnmulai'];
						$tglmulai=$_POST['tglmulai'];
						$thnmulai=$_POST['thnmulai'];
						$tanggalmulai="$thnmulai-$blnmulai-$tglmulai";
						$tempat_kegiatan=mysql_escape_string($_POST['tempat_kegiatan']);
						$tglselesai=$_POST['tglselesai'];
						$blnselesai=$_POST['blnselesai'];
						$thnselesai=$_POST['thnselesai'];			
						$tanggalselesai="$thnselesai-$blnselesai-$tglselesai";
						$isi=mysql_escape_string($_POST['isi']);
						mysqli_query($koneksi, "INSERT INTO kalender (subdomain, judul, link, isi, tempat_kegiatan, tanggal_mulai, tanggal_selesai, tgl)
						Values ('$subdomain', '$judul', '$linkhasil', '$isi', '$tempat_kegiatan', '$tanggalmulai', '$tanggalselesai', now())");
						$admin->notify ($subdomain,$linksub,"save_ok");			
					}
				}	 
			}


			function edit_kalender($linksub,$subdomain){
				$admin=new admin();
				$admin->get_variable(); 
				$admin->setLinkSub($linksub);
				$domain=$admin->domain;
				$link=$admin->link;
				$linkmodule=$linksub."/".$link;
				$no=mysql_escape_string((int)$_GET['no']);
				$cekkalender=mysqli_query($koneksi, "select no,judul,isi,tempat_kegiatan,tanggal_mulai,tanggal_selesai,link from kalender where no='$no'");
				$dkalender=mysqli_fetch_array($cekkalender);
				$judul=$dkalender['judul'];
				$isi=$dkalender['isi'];
				$tempat_kegiatan=$dkalender['tempat_kegiatan'];
				$tanggal_mulai=$dkalender['tanggal_mulai'];
				list ($thnmulai,$blnmulai,$tglmulai)=explode("-",$tanggal_mulai); 
				$tanggal_selesai=$dkalender['tanggal_selesai'];	
				list ($thnselesai,$blnselesai,$tglselesai)=explode("-",$tanggal_selesai);
				if(empty($_POST['proses'])){?>
					<h2>Edit Kalender</h2>
						<form action="" method="post" enctype="multipart/form-data" name="judulform">
							<input name="proses" type="hidden" value="edit"/>
							<input type="hidden" name="no" value="<?php echo $no;?>">
							<table width="100%" cellpadding="0" cellspacing="0" id="tabelview">
								<tr><td width="140" style="text">Nama Kegiatan</td><td style="text-transform:none;"><input type="text"  name="judul" id="judul" style="width:95%; max-width:500px;" value="<?php echo $judul;?>"/></td></tr>
								<tr><td width="140" style="text">tempat kegiatan </td><td style="text-transform:none;"><input type="text"  name="tempat_kegiatan" id="tempat_kegiatan" style="width:95%; max-width:500px;" value="<?php echo $tempat_kegiatan;?>"/></td></tr>
								<tr><td>Tanggal Mulai</td>
									<td>
									<select name="tglmulai" style="padding:0px; width:60px;"><?php 
									for($i=1; $i<=31; $i++) {$tg= ($i<10) ? "0$i" : $i; $sele = ($tg==$tglmulai)? "selected" : ""; echo"<option value='$tg' style='padding:3px 5px;' $sele>$tg</option>";}?></select> &nbsp; 
									Bulan &nbsp; <select name="blnmulai" style="padding:0px; width:60px;"><?php 
									for($i=1; $i<=12; $i++) {$bl= ($i<10) ? "0$i" : $i; $sele = ($bl==$blnmulai)? "selected" : ""; echo "<option value='$bl' style='padding:3px 5px;' $sele>$bl</option>";}?></select> &nbsp; 
									Tahun &nbsp; <select name="thnmulai" style="padding:0px; width:108px;"><?php 
									for ($i=date("Y"); $i<=date("Y")+1; $i++) { $sele = ($i==$thnmulai)? "selected" : ""; echo "<option value='$i' style='padding:3px 5px;' $sele>$i</option>";}?></select>
									</td>
								</tr>
								<tr><td>Tanggal Selesai</td>
									<td>
									<select name="tglselesai" style="padding:0px; width:60px;"><?php 
									for($i=1; $i<=31; $i++) {$tg= ($i<10) ? "0$i" : $i; $sele = ($tg==$tglselesai)? "selected" : "";echo"<option value='$tg' style='padding:3px 5px;' $sele>$tg</option>";}?></select> &nbsp; 
									Bulan &nbsp; <select name="blnselesai" style="padding:0px; width:60px;"><?php 
									for($i=1; $i<=12; $i++) {$bl= ($i<10) ? "0$i" : $i; $sele = ($bl==$blnselesai)? "selected" : "";echo "<option value='$bl' style='padding:3px 5px;' $sele>$bl</option>";}?></select> &nbsp; 
									Tahun &nbsp; <select name="thnselesai" style="padding:0px; width:108px;"><?php 
									for ($i=date("Y"); $i<=date("Y")+1; $i++) { $sele = ($i==$thnselesai)? "selected" : ""; echo "<option value='$i' style='padding:3px 5px;' $sele>$i</option>";}?></select>
									</td>
								</tr>
								<tr><td width="140">Deskripsi</td><td style="text-transform:none;"><textarea name="isi"  id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"><?php echo $isi;?></textarea></td></tr>
								<tr><td></td>
								<td>
								<input type="submit" name="submit" value="SIMPAN" onclick="return cekJudul();" class="button"/></td>
							</tr>
						</table>
					</form><?php
				}
				elseif ($_POST['proses']=="edit"){
					$judul=mysql_escape_string($_POST['judul']);
					$g1=str_replace("#","","$judul");$g2=str_replace("~","","$g1");$g3=str_replace("`","","$g2");$g4=str_replace("!","","$g3");
						$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
						$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
						$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
						$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
						$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21");$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
						$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
						$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");$g31=str_replace("'","&quot;","$g30");$gantispasi=str_replace(" ","-","$g31");
						$linkhasil=strtolower("$gantispasi");
					$tempat_kegiatan=mysql_escape_string($_POST['tempat_kegiatan']);
					$blnmulai=$_POST['blnmulai'];
					$tglmulai=$_POST['tglmulai'];
					$thnmulai=$_POST['thnmulai'];			
					$tanggalmulai="$thnmulai-$blnmulai-$tglmulai";
					$tglselesai=$_POST['tglselesai'];
					$blnselesai=$_POST['blnselesai'];
					$thnselesai=$_POST['thnselesai'];
					$tanggalselesai="$thnselesai-$blnselesai-$tglselesai";
					$isi=mysql_escape_string($_POST['isi']);
					$no=mysql_escape_string((int)$_POST['no']);
					mysqli_query($koneksi, "UPDATE kalender SET judul='$judul', link='$linkhasil', tanggal_mulai='$tanggalmulai', tanggal_selesai='$tanggalselesai', tempat_kegiatan='$tempat_kegiatan', isi='$isi' WHERE no='$no'");
					$admin->notify ($subdomain,$linksub,"save_ok");
				}	
			}
			
			$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
			$dset=mysqli_fetch_array($qset);
			$paket=$dset['paket'];
			$aktif=$dset['aktif'];
			if ($paket=="") { $paket="free"; } 
			if ($paket=="free") { ?>
				<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan Profesional.<?php
			}
			else {
				if ($aktif==0){ ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php
				}
				else{
				
				// VARIABEL MODULE
				// Tabel
				$judulmod="Kalender";
				$tabel="kalender";
				$batas=30;
				$kolom="judul,tanggal_mulai,tanggal_selesai";
				$lebar="100,150,150";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus";
				// Lihat
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="judul,tempat_kegiatan,tanggal_mulai,tanggal_selesai,isi";
				// Delete
				$tipedelete="";
				// Tambah
				$jenisinput="";
				$onclick="cekJudul"; 
				$tipeinput="";
				$forminput="judul,tempat_kegiatan,tanggal_mulai,tanggal_selesai,isi";
				// Tambah & Edit Rinci
				$jenisinputrinci="";
				$onclickrinci="cekJudul";
				$tipeinputrinci="";
				$forminputrinci="judul,tempat_kegiatan,tanggal_mulai,tanggal_selesai,isi,publish";
				$formeditrinci="judul,tempat_kegiatan,tanggal_mulai,tanggal_selesai,isi,publish,tgl";
				// FUNGSI MODULE
				$module=new admin();
				$module->get_variable();
				$module->setLinkSub($linksub);
				$act=$module->act;
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
					tambah_kalender($linksub,$subdomain);
				} 
				elseif ($act=="tambahrinci") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
				} 
				elseif ($act=="ubah") {
					edit_kalender($linksub,$subdomain);
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