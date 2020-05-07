<?php 
$sumber=$_GET['gambar'];
$gambar=$_SERVER['DOCUMENT_ROOT'].implode("/",(explode('/',$_SERVER['PHP_SELF'],-1)))."/picture/".$sumber;
$gambarproperties=getimagesize($gambar);
$tipe=$gambarproperties["mime"];
if($tipe=="image/jpeg") {
	header('Content-type:image/jpeg');
	$image=imagecreatefromjpeg($gambar);
} 
elseif($tipe=="image/jpg") {
	header('Content-type:image/jpg');
	$image=imagecreatefromjpeg($gambar);
} 
elseif($tipe=="image/png") {
	header('Content-type:image/png');
	$image=imagecreatefrompng($gambar);
} 
elseif($tipe=="image/gif") {
	header('Content-type:image/gif');
	$image=imagecreatefromgif($gambar);
} 
else {
	return false;
}
$image=imagecreatefromjpeg($gambar);
list($lebarasli,$tinggiasli)=getimagesize($gambar);
$lebarbaru=100;
$tinggibaru=75;
$kecil=imagecreatetruecolor($lebarbaru,$tinggibaru);
imagecopyresized($kecil,$image,0,0,0,0,$lebarbaru,$tinggibaru,$lebarasli,$tinggiasli);
if($tipe=="image/jpeg") { imagejpeg($kecil,NULL,75); } 
elseif($tipe=="image/jpg") { imagejpeg($kecil,NULL,75); } 
elseif($tipe=="image/png") { imagepng($kecil,NULL,75); } 
elseif($tipe=="image/gif") {  imagegif($kecil,NULL,75); } 
else { return false; }
imagedestroy($kecil);
?>