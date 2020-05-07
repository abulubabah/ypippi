<script type="text/javascript">
$(document).ready(function(){
var first = 0;
var speed = 400;
var pause = 3000;
function removeFirst(){
	first = $('ul#listticker li:first').html();
	$('ul#listticker li:first')
	.animate({opacity: 0}, speed)
	.fadeOut('slow', function() {$(this).remove();});
	addLast(first);
}
function addLast(first){
	last = '<li style="display:none">'+first+'</li>';
	$('ul#listticker').append(last)
	$('ul#listticker li:last')
	.animate({opacity: 1}, speed)
	.fadeIn('slow')
}
interval = setInterval(removeFirst, pause);
});
</script>
<style type="text/css">
#listticker{ float:left; height:30px; overflow:hidden;}
#listticker li{ border:0; margin:0; padding:0; list-style:none;	 }
#listticker a:link, #listticker a:visited {  text-decoration:none;  }
#listticker a:hover { text-decoration:none; color:#0000CC; }
</style>
<?php 
if ($tampil==1) { 
	if(empty($akses)){  
		header("location:index.php");
	}
	elseif($akses=="publik" or $akses=="member" ){
		if ($layoutposisi=="main") { 
			if ($layouttampilan=="ketik") {  }
			else { 
				?>
				<div style="display:table; width:100%"><?php
				if($layouttampiljudul==1){ echo "<div style=float:left><b>".$layoutjudul." &raquo; &nbsp; </b></div>"; } else {  } ?>
				<ul id="listticker"><?php
				$dflash=array();
				if (!is_dir(DIR_CACHE.$subdomain)){
					mkdir(DIR_CACHE.$subdomain,0755);
				}
				
				if (file_exists(DIR_CACHE.$subdomain.'/cache.berita_flash')){
					$dflash=json_decode($filemanager->get(DIR_CACHE.$subdomain.'/cache.berita_flash'),true);
				}
				
				if(empty($dflash)){
				    $query=$db->query("SELECT no,judul,link FROM berita WHERE subdomain='$subdomain' AND publish='1' ORDER BY tgl DESC LIMIT 0,10");
				    $dflash=$query->rows;
				    $filemanager->set(DIR_CACHE.$subdomain.'/cache.berita_flash',json_encode($dflash));
				}
				
				foreach ($dflash as $data) { 
					$noart=$data['no'];
					$judulart=$data['judul'];
					$linkart=$data['link'];
					$linkartikel=$linksub."/berita/".$noart."/".$linkart;?>	
					<li><a href="//<?php echo $linkartikel;?>/" title="<?php echo $judulart;?>"><?php echo $judulart;?></a></li><?php
				} ?>
				</ul> 
				</div><?php
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