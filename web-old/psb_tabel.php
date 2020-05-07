<?php
session_start ();
$folder="cms";
$domain="www.ypippijkt.localhost/cms";
$subdomain="www.ypippijkt.localhost";
$linksub="www.ypippijkt.localhost";
include ("$folder/conn.php");
include("psb_fungsi.php");
?>
<html>
<head>
<title>TABEL PERINGKAT SEMENTARA</title>
<style type="text/css">
#tabellist { font-family:arial; font-size:14px; text-align:center; color:#333333; border-top:1px solid #333333; border-left:1px solid #333333; }
#tabellist th{ padding:5px; border-bottom:1px solid #333333; border-right:1px solid #333333; background:#FFFFFF; text-transform:capitalize; text-align:center;}
#tabellist td{ padding:5px; border-bottom:1px solid #333333; border-right:1px solid #333333; vertical-align:top; text-align:center; }
</style>
<script type="text/javascript">
	function print_formulir(){ window.print(); } 
</script>
</head>
<body><?php
ppdb_tabelurut($subdomain,$domain); ?>
</body>
</html>