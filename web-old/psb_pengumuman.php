<?php
session_start();
$folder="cms";
$subdomain="www.ypippijkt.localhost";
$domain="www.ypippijkt.localhost/cms";
$linksub="www.ypippijkt.localhost";
include ("$folder/conn.php");
$qsetting=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");	
$dsetting=mysqli_fetch_array($qsetting);
$namaweb=$dsetting['judul'];
$qsett=mysqli_query($koneksi, "SELECT * FROM simpen_setting WHERE subdomain='$subdomain'");
$dsett=mysqli_fetch_array($qsett);
$head1=$dsett['head1'];
$head2=$dsett['head2'];
$head3=$dsett['head3'];
$alamat=$dsett['alamat'];
$tingkat=$dsett['tingkat'];
$tahun_ajaran=$dsett['tahun_ajaran'];
$logo=$dsett['logo'];
$logo2=$dsett['logo2'];		
$tempat_keputusan=$dsett['tempat_keputusan'];
$tanggal_keputusan=$dsett['tanggal_keputusan'];
$nama_kepsek=$dsett['nama_kepsek'];
$nip_kepsek=$dsett['nip_kepsek'];
$ttd_kepsek=$dsett['ttd_kepsek'];
$stempel=$dsett['stempel'];	
$nisn=$_SESSION['nisn'];
$query=mysqli_query($koneksi, "SELECT nama,keputusan FROM psb_member WHERE nisn='$nisn' AND subdomain='$subdomain'");
$data=mysqli_fetch_array($query);
$nama=$data['nama'];
$keputusan=$data['keputusan']; ?>
<html>
<head>
<title>CETAK PENGUMUMAN</title>
<link  rel="stylesheet" type="text/css" href="//<?php echo $domain;?>/theme/circle/style.css"/>
<link  rel="stylesheet" type="text/css" href="//storage.googleapis.com/s.mysch.id/font/font.css"/>
<style type="text/css">
#tabellist { text-align:center; color:#333333; border-top:1px solid #333333; border-left:1px solid #333333; }
#tabellist th{ padding:3px 5px; border-bottom:1px solid #333333; border-right:1px solid #333333; background:#FFFFFF; text-transform:capitalize; text-align:center;}
#tabellist td{ padding:3px 5px; border-bottom:1px solid #333333; border-right:1px solid #333333; vertical-align:top; text-align:center; }
</style>
<script type="text/javascript">
	function print_formulir(){ window.print(); } 
</script>
</head>
<body onload="print_formulir()">
    <center>
    <div style="width:100%; max-width:800px;">
    	<div style="display:table; width:100%; text-align:center;border-bottom:3px solid #333333;font-size:15px; font-weight:bold; line-height:22px;">
    		<img src="//<?php echo $domain."/picture/".$logo;?>" align="left" height="90" alt="Logo1"/>
    		<img src="//<?php echo $domain."/picture/".$logo2;?>" align="right" height="90" alt="Logo2"/>
    		<?php echo $head1;?><br/>
    		<?php echo $head2;?><br/>
    		<?php echo $head3;?><br/>
    		<h5><i><?php echo $alamat;?></i></h5>
    	</div>
    	<br/>
    	<h3><b><u>PENGUMUMAN PENERIMAAN</u></b></h3>
    	<br/>
    	<div style="text-align:left;">
    		Yang bertanda tangan dibawah ini Kepala Sekolah <?php echo $namaweb;?> menerangkan bahwa :
    		<table width="100%" style="font-weight:bold;margin-left:25px;">
    			<tr><td width="100">Nama</td><td width="10">:</td><td><?php echo $nama;?></td></tr>
    			<tr><td width="100">Nisn</td><td width="10">:</td><td><?php echo $nisn;?></td></tr>
    		</table>
    		telah mengikuti seleksi PPDB <?php echo $namaweb;?> tahun ajaran <?php echo $tahun_ajaran;?> dan dinyatakan <b><u><?php echo $keputusan;?></u></b>.
    	</div>
    	<br/>
    	<div style="float:left; width:60%; display:table; text-align:right;">
    	<br/><br/><img src="//<?php echo $domain."/picture/".$stempel;?>" align="right" height="100" alt="Stempel"/>
    	</div>
    	<div style="float:left; width:40%; display:table; text-align:left;">
    		<?php echo $tempat_keputusan.", ".$tanggal_keputusan;?><br/>
    		Kepala Sekolah,<br/>
    		<img src="//<?php echo $domain."/picture/".$ttd_kepsek;?>" height="80" alt="ttd_kepsek"/><br/>
    		<b><u><?php echo $nama_kepsek;?></u><br/>NIP. <?php echo $nip_kepsek;?></b>
    	</div>
    	<br/>
    </div>
</center>
</body>
</html>
