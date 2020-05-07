<?php  
if ($tampil==1) {
	if (!is_dir(DIR_CACHE.$subdomain)){
		mkdir(DIR_CACHE.$subdomain,0755);
	}
	$datahalaman=array();
	if (file_exists(DIR_CACHE.$subdomain.'/cache.menu')){
		$datahalaman=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.menu'),true);
	}
	
	if (empty($datahalaman)){
		$qhalaman=$db->query("SELECT no,judul,link FROM halaman WHERE publish='1' AND uphalaman='0' AND subdomain='$subdomain' ORDER BY urutan ASC");
                $hasil=array();
                foreach ($qhalaman->rows as $dhalaman) {
                    $halamanno=$dhalaman['no'];
                    $halamanjudul=$dhalaman['judul'];
                    $halamanlink=$dhalaman['link'];
                    $qhalaman1=$db->query("SELECT no,judul,link FROM halaman WHERE publish='1' AND uphalaman='$halamanno' AND subdomain='$subdomain' ORDER BY urutan");
                    $hasil1=array();
                    foreach ($qhalaman1->rows as $dhalaman1) {
                        $halamanno1=$dhalaman1['no'];
                        $halamanjudul1=$dhalaman1['judul'];
                        $halamanlink1=$dhalaman1['link'];
                        $qhalaman2=$db->query("SELECT no,judul,link  FROM halaman WHERE uphalaman='$halamanno1' AND subdomain='$subdomain' ORDER BY urutan ");
                        $hasil2=array();
                        foreach ($qhalaman2->rows as $dhalaman2){
                            $halamanno2=$dhalaman2['no'];
                            $halamanjudul2=$dhalaman2['judul'];
                            $halamanlink2=$dhalaman2['link'];
                            $qhalaman3=$db->query("SELECT no,judul,link  FROM halaman WHERE uphalaman='$halamanno2' AND subdomain='$subdomain' ORDER BY urutan ");
                            $halaman3=$qhalaman3->rows;
                            $hasil2[$halamanno2]=array_merge($dhalaman2,array(
                                'subhalaman'=>$halaman3
                            ));
                        }
                        $hasil1[$halamanno1]=array_merge($dhalaman1,array(
                            'subhalaman'=>$hasil2
                        ));
                    }					
                    $hasil[$halamanno]= array_merge($dhalaman,array(
                        'subhalaman'=>$hasil1
                    ));
                }
                $datahalaman=$hasil;
                unset($hasil);
		$filemanager->set(DIR_CACHE.$subdomain.'/cache.menu',json_encode($datahalaman));
	}
	
	?>
            <label for="drop" class="toggle">MENU</label>
            <input type="checkbox" id="drop" />
            <ul class="menu3"><?php
            $no1=1;
            foreach ($datahalaman as $dhalaman) {
                    
                    $halamanno=$dhalaman['no'];
                    $halamanjudul=$dhalaman['judul'];
                    $halamanlink=$dhalaman['link'];
                    if ($halamanlink=="" or $halamanlink=="home" or $halamanlink=="beranda") { 
                        $linksub = 'www.old.ypippijkt.sch.id';
                        $linkurl="//$linksub/"; } else { $linkurl="//$linksub/$halamanlink/"; }
                    $qhalaman1=$dhalaman['subhalaman'];
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
                                            $qhalaman2=$dhalaman1['subhalaman'];
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
                                                                    $qhalaman3=$dhalaman2['subhalaman'];
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
            </ul>
            <?php
	
}
else {
	header("location:index.php"); 
}

?>

