<?php  
if ($tampil==1) {  ?> 
	<style type="text/css"> 
	.cari { } 
	.cari input { background:#F5F5F5; border:1px solid #E4E4E4; padding:6px; color:#333333; width:75%; max-width:200px; }
	.cari #tombol { background:#CCCCCC url(//<?php echo $domain;?>/image/search.png) no-repeat center; border:none; padding:6px; width:25%; max-width:30px; padding-left:23px; }
	</style>
	<div class="<?php echo $stylepanel;?>"><?php 
		if($layouttampiljudul==1){ ?><div class="<?php echo $stylejudul;?>"><span><?php echo $layoutjudul;?></span></div><?php } else {  } ?>
		 <div class="<?php echo $styleisi;?>"> 
			 <div class="cari">
				<form action="//<?php echo $linksub;?>/cari/" method="post">
					<input type="text" name="keyword" id="keyword" value="Search" maxlength="40" onblur="if (this.value=='') this.value='Search';" onfocus="if (this.value=='Search') this.value='';"/>
					<input name="cari" type="submit" value="" onClick="return cekKeyword();" id="tombol" style="cursor:pointer"/>
				</form>
			</div>
		</div>
	</div><?php 
} 
else { 
	header("location:index.php"); 
}
?>