<?php
session_start ();
$folder="cms";
$domain="www.ypippijkt.localhost/cms";
$subdomain="www.ypippijkt.localhost";
$linksub="www.ypippijkt.localhost";
include ("$folder/conn.php");
include("simpen_fungsi.php");
?>
<html>
<head>
<title>CETAK HASIL UJIAN</title>
<link  rel="stylesheet" type="text/css" href="//<?php echo $domain;?>/theme/circle/style.css"/>
<link  rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/font/font.css"/>
<style type="text/css">
#tabellist { text-align:center; color:#333333; border-top:1px solid #333333; border-left:1px solid #333333; }
#tabellist th{ padding:3px 5px; border-bottom:1px solid #333333; border-right:1px solid #333333; background:#FFFFFF; text-transform:capitalize; text-align:center;}
#tabellist td{ padding:3px 5px; border-bottom:1px solid #333333; border-right:1px solid #333333; vertical-align:top; text-align:center; }
</style>
<script type="text/javascript">
	function print_hasil(){ window.print(); } 
</script>
</head>
<body onload="print_hasil()">
<?php 
$uname=$_SESSION['uname'];
$nisn=$_SESSION['uname'];
simpen_hasil($subdomain,$domain,$nisn,$uname); ?>
</body>
</html>