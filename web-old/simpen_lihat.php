<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="member"){ 
		include("simpen_fungsi.php");
		$uname=$_SESSION['uname'];
		$nisn=$_SESSION['uname'];
		simpen_hasil($subdomain,$domain,$nisn,$uname);
	}	
	else {
		header("location:index.php"); 
	}
}
else {
	header("location:index.php"); 
}
?>