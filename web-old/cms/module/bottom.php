<?php
if ($tampil==1) {  
    if($subdomain=='tasywiqulquran.sch.id'){
        //error_reporting(E_ALL);
    }
	$jumbot=0;
	$qlayout=mysqli_query($koneksi, "SELECT no,judul,tipe,idtipe,tampilan_tipe,hal,posisi,tampilkan_judul FROM module WHERE subdomain='$subdomain' AND posisi='bottom' AND publish='1' ORDER BY urutan");
	while($dlayout=mysqli_fetch_array($qlayout)){
		$layoutno=$dlayout['no'];
		$layoutjudul=$dlayout['judul'];
		$layouttipe=$dlayout['tipe'];
		$layoutidtipe=$dlayout['idtipe'];
		$layouttampilan=$dlayout['tampilan_tipe'];
		$layouthal=$dlayout['hal'];
		$layoutposisi=$dlayout['posisi'];
		$layouttampiljudul=$dlayout['tampilkan_judul'];
		$stylepanel="panelbottom"; $stylejudul="panelbottom_judul"; $styleisi="panelbottom_isi";
		if($layouthal=="home") {
			if (empty($link)) { 
				if($jumbot%4==0){ ?><div class="spasi"></div><?php }
				if($jumbot==3){ $stylebottom="style=\"margin-right:0px;\""; } 
				else { $stylebottom="style=\"margin-right:1.3%;\""; } ?>
				<div class="bottom_isi" <?php echo $stylebottom;?>><?php include("$folder/module/$layouttipe.php"); ?></div><?php 
				$jumbot++;
			}
			elseif ($link=="home" or $link=="beranda") { 
				if($jumbot%4==0){ ?><div class="spasi"></div><?php }
				if($jumbot==3){ $stylebottom="style=\"margin-right:0px;\""; } 
				else { $stylebottom="style=\"margin-right:1.3%;\""; } ?>
				<div class="bottom_isi" <?php echo $stylebottom;?>><?php include("$folder/module/$layouttipe.php"); ?></div><?php 
				$jumbot++;
			}
		}
		else {
			if($jumbot%4==0){ ?><div class="spasi"></div><?php }
			if($jumbot==3){ $stylebottom="style=\"margin-right:0px;\""; } 
			else { $stylebottom="style=\"margin-right:1.3%;\""; } ?>
			<div class="bottom_isi" <?php echo $stylebottom;?>><?php include("$folder/module/$layouttipe.php"); ?></div><?php
			$jumbot++;
		}
	}	
}
else { 
	header("location:../"); 
}
?>