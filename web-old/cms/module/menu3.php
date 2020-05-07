<?php  
if ($tampil==1) {

$datahalaman=Array();
	$ke=0;
	$qhalaman=mysqli_query($koneksi, "SELECT no,judul,link,uphalaman,urutan FROM halaman WHERE publish='1' AND subdomain='$subdomain' ORDER BY uphalaman DESC, urutan ASC LIMIT 0,100");
	$jumhalaman=mysqli_num_rows($qhalaman);
	if ($jumhalaman==0) { }
	else { 
		while ($dhalaman=mysqli_fetch_array($qhalaman)) {
			$halamanno=$dhalaman['no'];			
			$halamanjudul=$dhalaman['judul'];
			$halamanlink=$dhalaman['link'];
			$halamanup=$dhalaman['uphalaman'];	
			$halamanurut=$dhalaman['urutan'];
$datahalaman[$ke++]=$halamanno."#".$halamanjudul."#".$halamanlink."#".$halamanup."#".$halamanurut; 
		} 
	} ?>
	<label for="drop" class="toggle">MENU</label>
	<input type="checkbox" id="drop" />
	<ul class="menu3"><?php
	$no1=1;
	foreach ($datahalaman as $halamandata) {
		$halaman=explode('#',$halamandata);
		$halamanno=$halaman[0];				
		$halamanjudul=$halaman[1];
		$halamanlink=$halaman[2];
		$halamanup=$halaman[3];
		$halamanurut=$halaman[4];
		if ($halamanup==0) { 
			if ($halamanlink=="" or $halamanlink=="home" or $halamanlink=="beranda") { $linkurl="//$linksub/"; } else { $linkurl="//$linksub/$halamanlink/"; } ?>
			<li>
				<label for="drop-<?php echo $no1;?>" class="toggle" ><?php echo $halamanjudul;?></label>
				<a href="<?php echo $linkurl;?>" title="<?php echo $halamanjudul;?>" class><?php echo $halamanjudul;?></a>
				<input type="checkbox" id="drop-<?php echo $no1;?>"/>			
				<ul><?php
				$no2=1;
				foreach ($datahalaman as $halamandata2) {
					$halaman2=explode('#',$halamandata2);
					$halamanno2=$halaman2[0];									
					$halamanjudul2=$halaman2[1];
					$halamanlink2=$halaman2[2];
					$halamanup2=$halaman2[3];	
					$halamanurut2=$halaman2[4];	
					$linkurl2="//$linksub/$halamanlink2/";
					if ($halamanno==$halamanup2) { ?>					
						<li>
							<label for="drop-<?php echo $no1;?>-<?php echo $no2;?>" class="toggle" ><?php echo $halamanjudul2;?></label>
							<a href="<?php echo $linkurl2;?>" title="<?php echo $halamanjudul2;?>"><?php echo $halamanjudul2;?></a>
							<input type="checkbox" id="drop-<?php echo $no1;?>-<?php echo $no2;?>"/>
							<ul><?php
							$no3=1;
							foreach ($datahalaman as $halamandata3) {
								$halaman3=explode('#',$halamandata3);
								$halamanno3=$halaman3[0];									
								$halamanjudul3=$halaman3[1];
								$halamanlink3=$halaman3[2];
								$halamanup3=$halaman3[3];	
								$halamanurut3=$halaman3[4];	
								$linkurl3="//$linksub/$halamanlink3/";
								if ($halamanno2==$halamanup3) { ?>
									<li><a href="<?php echo $linkurl3;?>" title="<?php echo $halamanjudul3;?>"><?php echo $halamanjudul3;?></a></li><?php
								} 
								$no3++;
							} ?>
							</ul>
						</li><?php
					} 
					$no2++;
				}  ?>
				</ul>
			</li>
			<?php
		}
		$no1++;
	}  ?>
	</ul><?php
/*
		$qhalaman=mysqli_query($koneksi, "SELECT no,judul,link FROM halaman WHERE publish='1' AND uphalaman='0' AND subdomain='$subdomain' ORDER BY urutan ASC");
		$jumhalaman=mysqli_num_rows($qhalaman);
		if ($jumhalaman==0) { }
		else { ?>
			<label for="drop" class="toggle">MENU</label>
			<input type="checkbox" id="drop" />
			<ul class="menu3"><?php
			$no1=1;
			while ($dhalaman=mysqli_fetch_array($qhalaman)) {
				$halamanno=$dhalaman['no'];
				$halamanjudul=$dhalaman['judul'];
				$halamanlink=$dhalaman['link'];
				if ($halamanlink=="" or $halamanlink=="home" or $halamanlink=="beranda") { $linkurl="//$linksub/"; } else { $linkurl="//$linksub/$halamanlink/"; }
				$qhalaman1=mysqli_query($koneksi, "SELECT no,judul,link FROM halaman WHERE publish='1' AND uphalaman='$halamanno' AND subdomain='$subdomain' ORDER BY urutan");
				$jhalaman1=mysqli_num_rows($qhalaman1);
				if($jhalaman1==0) { ?><li><a href="<?php echo $linkurl;?>" title="<?php echo $halamanjudul;?>" class><?php echo $halamanjudul;?></a></li><?php } 
				else { ?>
					<li>
						<label for="drop-<?php echo $no1;?>" class="toggle" ><?php echo $halamanjudul;?></label>
						<a href="#"><?php echo $halamanjudul;?></a>
						<input type="checkbox" id="drop-<?php echo $no1;?>"/>
						<ul><?php
						$no2=1;
						while ($dhalaman1=mysqli_fetch_array($qhalaman1)) {
							$halamanno1=$dhalaman1['no'];
							$halamanjudul1=$dhalaman1['judul'];
							$halamanlink1=$dhalaman1['link'];
							$linkurl1="//$linksub/$halamanlink1/";
							$qhalaman2=mysqli_query($koneksi, "SELECT no,judul,link  FROM halaman WHERE uphalaman='$halamanno1' AND subdomain='$subdomain' ORDER BY urutan ");
							$jhalaman2=mysqli_num_rows($qhalaman2);
							if ($jhalaman2=="0"){ ?><li><a href="<?php echo $linkurl1;?>" title="<?php echo $halamanjudul1;?>"><?php echo $halamanjudul1;?></a></li><?php }
							else { ?>
								<li>
									<label for="drop-<?php echo $no1;?>-<?php echo $no2;?>" class="toggle" ><?php echo $halamanjudul1;?></label>
									<a href="#"><?php echo $halamanjudul1;?></a>
									<input type="checkbox" id="drop-<?php echo $no1;?>-<?php echo $no2;?>"/>
									<ul><?php
									$no3=1;
									while ($dhalaman2=mysqli_fetch_array($qhalaman2)){
										$halamanno2=$dhalaman2['no'];
										$halamanjudul2=$dhalaman2['judul'];
										$halamanlink2=$dhalaman2['link'];
										$linkurl2="//$linksub/$halamanlink2/";
										$qhalaman3=mysqli_query($koneksi, "SELECT no,judul,link  FROM halaman WHERE uphalaman='$halamanno2' AND subdomain='$subdomain' ORDER BY urutan ");
										$jhalaman3=mysqli_num_rows($qhalaman3);
										if ($jhalaman3=="0"){ ?><li><a href="<?php echo $linkurl2;?>" title="<?php echo $halamanjudul2;?>"><?php echo $halamanjudul2;?></a></li><?php }
										else {?>
											<li>
												<label for="drop-<?php echo $no1;?>-<?php echo $no2;?>-<?php echo $no3;?>" class="toggle" ><?php echo $halamanjudul2;?></label>
												<a href="#"><?php echo $halamanjudul2;?></a>
												<input type="checkbox" id="drop-<?php echo $no1;?>-<?php echo $no2;?>-<?php echo $no3;?>"/>
												<ul><?php
												while ($dhalaman3=mysqli_fetch_array($qhalaman3)){
													$halamanno3=$dhalaman3['no'];
													$halamanjudul3=$dhalaman3['judul'];
													$halamanlink3=$dhalaman3['link'];
													$linkurl3="//$linksub/$halamanlink3/"; ?>
													<li><a href="<?php echo $linkurl3;?>" title="<?php echo $halamanjudul3;?>"><?php echo $halamanjudul3;?></a></li><?php
												} ?>
												</ul>
											</li><?php
										}
									}?>
									</ul>
								</li><?php
							}
						$no2++;
						} ?>  
						</ul>
					</li><?php 					
				}
				$no1++;
			} ?>
			</ul>
			<?php
		}
*/
/*
	DEFINE('DIR_CACHE',$folder.'/pagecache/');
	include ($folder.'/function/mpdo.php');
	include ($folder.'/function/cache.php');
	DEFINE ('HOSTNAME','localhost');
	DEFINE ('USERNAME','mysch123_umam');
	DEFINE ('PASSWORD','u@&m)#a*^m-db');
	DEFINE ('DATABASE','mysch123_cmsdb');


	Class ModelMenu {
		public $db;
		public $cache;
		public $subdomain;
		
		function __construct($subdomain){
			$this->db=new mPDO (HOSTNAME, USERNAME, PASSWORD, DATABASE, $port = '3306');
			$this->cache= new Cache();
			$this->subdomain=$subdomain;
		}
		
		public function GetHalaman(){
			$halaman=$this->cache->get('halaman.'.$this->subdomain);
			if (!$halaman){
				$query=$this->db->query("SELECT no,judul,link FROM halaman WHERE publish='1' AND uphalaman='0' AND subdomain='$this->subdomain' ORDER BY urutan ASC");
				$halaman=array();
				foreach ($query->rows as $hasil){
					$halaman[]=$hasil;
				}
				$this->cache->set('halaman.'.$this->subdomain,$halaman);
				
			}
			return $halaman;
		}
		
		public function GetUpHalaman($halamanup,$prefix){
			$halaman=$this->cache->get('halaman'.$prefix.'.'.$this->subdomain);
			if (!$halaman){
				$query=$this->db->query("SELECT no,judul,link FROM halaman WHERE publish='1' AND uphalaman='$halamanup' AND subdomain='$this->subdomain' ORDER BY urutan ASC");
				$halaman=array();
				foreach ($query->rows as $hasil){
					$halaman[]=$hasil;
				}
				$this->cache->set('halaman'.$prefix.'.'.$this->subdomain,$halaman);
			}
			return $halaman;
		}
		
	}
	
	$query=new ModelMenu($subdomain);	
	if ($query->GetHalaman()){?>
		<label for="drop" class="toggle">MENU</label>
		<input type="checkbox" id="drop" />
		<ul class="menu3"><?php
		$no1=1;
		foreach  ( $query->GetHalaman() as $dhalaman) {
			$halamanno=$dhalaman['no'];
			$halamanjudul=$dhalaman['judul'];
			$halamanlink=$dhalaman['link'];
			if ($halamanlink=="" or $halamanlink=="home" or $halamanlink=="beranda") { $linkurl="//$linksub/"; } else { $linkurl="//$linksub/$halamanlink/"; }
			$qhalaman1=$query->GetUpHalaman($halamanno,1);
			if(!$qhalaman1) { ?><li><a href="<?php echo $linkurl;?>" title="<?php echo $halamanjudul;?>" class><?php echo $halamanjudul;?></a></li><?php } 
			else { ?>
				<li>
					<label for="drop-<?php echo $no1;?>" class="toggle" ><?php echo $halamanjudul;?></label>
					<a href="#"><?php echo $halamanjudul;?></a>
					<input type="checkbox" id="drop-<?php echo $no1;?>"/>
					<ul><?php
					$no2=1;
					foreach ($qhalaman1 as $dhalaman1) {
						$halamanno1=$dhalaman1['no'];
						$halamanjudul1=$dhalaman1['judul'];
						$halamanlink1=$dhalaman1['link'];
						$linkurl1="//$linksub/$halamanlink1/";
						$qhalaman2=$query->GetUpHalaman($halamanno1,2);
						if (!$qhalaman2){ ?><li><a href="<?php echo $linkurl1;?>" title="<?php echo $halamanjudul1;?>"><?php echo $halamanjudul1;?></a></li><?php }
						else { ?>
							<li>
								<label for="drop-<?php echo $no1;?>-<?php echo $no2;?>" class="toggle" ><?php echo $halamanjudul1;?></label>
								<a href="#"><?php echo $halamanjudul1;?></a>
								<input type="checkbox" id="drop-<?php echo $no1;?>-<?php echo $no2;?>"/>
								<ul><?php
								$no3=1;
								foreach ($qhalaman2 as $dhalaman2){
									$halamanno2=$dhalaman2['no'];
									$halamanjudul2=$dhalaman2['judul'];
									$halamanlink2=$dhalaman2['link'];
									$linkurl2="//$linksub/$halamanlink2/";
									$qhalaman3=$query->GetUpHalaman($halamanno2,3);
									if (!$qhalaman3){ ?><li><a href="<?php echo $linkurl2;?>" title="<?php echo $halamanjudul2;?>"><?php echo $halamanjudul2;?></a></li><?php }
									else {?>
										<li>
											<label for="drop-<?php echo $no1;?>-<?php echo $no2;?>-<?php echo $no3;?>" class="toggle" ><?php echo $halamanjudul2;?></label>
											<a href="#"><?php echo $halamanjudul2;?></a>
											<input type="checkbox" id="drop-<?php echo $no1;?>-<?php echo $no2;?>-<?php echo $no3;?>"/>
											<ul><?php
											foreach ($qhalaman3 as $dhalaman3){
												$halamanno3=$dhalaman3['no'];
												$halamanjudul3=$dhalaman3['judul'];
												$halamanlink3=$dhalaman3['link'];
												$linkurl3="//$linksub/$halamanlink3/"; ?>
												<li><a href="<?php echo $linkurl3;?>" title="<?php echo $halamanjudul3;?>"><?php echo $halamanjudul3;?></a></li><?php
											} ?>
											</ul>
										</li><?php
									}
								}?>
								</ul>
							</li><?php
						}
					$no2++;
					} ?>  
					</ul>
				</li><?php 					
			}
			$no1++;
		} ?>
		</ul><?php
	}
	*/
}
else {
	header("location:index.php"); 
}

?>