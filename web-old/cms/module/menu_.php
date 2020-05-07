<?php 
if ($tampil==1) {   ?>
	<div class="menu"> 
		<ul>			
			<li><a href="//demo.mysch.id" title="Demo">Demo</a></li>
			<li><a href="//<?php echo $linksub;?>/member/" title="Login">Login</a></li>
			<li><a href="//<?php echo $linksub;?>/affiliate/" title="Affiliate">Affiliate</a></li>
			<li><a href="//<?php echo $linksub;?>/faq/" title="FAQ">FAQ</a></li>
			<li><a href="//<?php echo $linksub;?>/paket/" title="Paket">Paket</a></li>
			<li><a href="//<?php echo $linksub;?>/fitur/" title="Fitur">Fitur</a></li>
			<li><a href="//<?php echo $linksub;?>/" title="Home">Home</a></li>
		</ul>
	</div>
	<div class="menu2">
		<ul class="mnav">
		<li><a href="#" title="#"><img src="//<?php echo $domain;?>/image/menu2.png" alt="menu" align="right" border="0"/></a>
			<div>
				<div class="mnav-column"><a href="//<?php echo $linksub;?>/" title="Home">Home</a></div>
				<div class="mnav-column"><a href="//<?php echo $linksub;?>/fitur/" title="Fitur">Fitur</a></div>
				<div class="mnav-column"><a href="//<?php echo $linksub;?>/paket/" title="Paket">Paket</a></div>
				<div class="mnav-column"><a href="//<?php echo $linksub;?>/faq/" title="FAQ">FAQ</a></div>
				<div class="mnav-column"><a href="//<?php echo $linksub;?>/affiliate/" title="Affiliate">Affiliate</a></div>
				<div class="mnav-column"><a href="//<?php echo $linksub;?>/login/" title="Login">Login</a></div>
				<div class="mnav-column"><a href="//demo.mysch.id" title="Demo">Demo</a></div>
			</div>
		</li>
	</ul>
	</div><?php
}
else { 
	header("location:index.php"); 
}
?>