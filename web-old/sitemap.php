<?php
function special_chars($str) {
	$str = htmlentities($str, ENT_QUOTES, 'UTF-8');
	
	return $str;
}
$folder="cms";
include ("$folder/conn.php");
include ("$folder/function/response.php");
$domain='www.ypippijkt.localhost/cms';
$response=new response();
	$output  = '<?xml version="1.0" encoding="UTF-8"?>';
	$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
	$qcekhalaman=mysqli_query($koneksi, "select subdomain,link from halaman where publish='1' AND subdomain='www.ypippijkt.localhost'");
	while ($data=mysqli_fetch_array($qcekhalaman)){
		$subdomain=$data['subdomain'];
		$link=$data['link'];
		$qcekpaket=mysqli_query($koneksi, "select paket from setting where subdomain='$subdomain'");
		$dpaket=mysqli_fetch_array($qcekpaket);
		$paket=$dpaket['paket'];
		if ($paket!="free"){
			$linksub= $subdomain;
		}
		else {
			$linksub=$subdomain.".mysch.id";
			
		}
		
		$output .= '<url>';
		$output .= '<loc>https://www.' . $linksub.'/'.urlrlencode($link) . '</loc>';
		$output .= '<changefreq>weekly</changefreq>';
		$output .= '<priority>0.7</priority>';
		$output .= '</url>';
	}
	//mengindex galeri
	$qcekgaleri=mysqli_query($koneksi, "select gambar,judul from galeri where subdomain='www.ypippijkt.localhost'");
	while ($dgaleri=mysqli_fetch_array($qcekgaleri)){
		$gambar=$dgaleri['gambar'];
		$judul=$dgaleri['judul'];
		$output .= '<url>';
		$output .= '<loc>https://www.'.$domain.'/picture/'.$gambar.'</loc>';
		$output .= '<changefreq>weekly</changefreq>';
		$output .= '<priority>1.0</priority>';
		$output .= '<image:image>';
		$output .= '<image:loc>https://'.$domain.'/picture/'.$gambar.'</image:loc>';
		$output .= '<image:caption>' . urlencode($link) . '</image:caption>';
		$output .= '<image:title>' . urlencode($link) . '</image:title>';
		$output .= '</image:image>';
		$output .= '</url>';
	}
	
	//mengindex berita
	$qcekberita=mysqli_query($koneksi, "select no,subdomain,gambar,judul,link from berita where subdomain='www.ypippijkt.localhost'");
	while ($dberita=mysqli_fetch_array($qcekberita)){
		$gambar=$dberita['gambar'];
		$judul=$dberita['judul'];
		$link=$dberita['link'];
		$subdomain=$dberita['subdomain'];
		$no=$dberita['no'];
		$linksub= $subdomain;
		$output .= '<url>';
		$output .= '<loc>https://www.' . $linksub.'/berita/'.$no.'/'.urlencode($link) . '</loc>';
		$output .= '<changefreq>weekly</changefreq>';
		$output .= '<priority>1.0</priority>';
		$output .= '<image:image>';
		$output .= '<image:loc>https://'.$domain.'/picture/'.$gambar.'</image:loc>';
		$output .= '<image:caption>' . urlencode($link) . '</image:caption>';
		$output .= '<image:title>' . urlencode($link) . '</image:title>';
		$output .= '</image:image>';
		$output .= '</url>';
	}
	
	
	$output .= '</urlset>';
	$response->addHeader('Content-Type: application/xml');
	$response->setOutput($output);
	$response->output();
	//echo $output ;
?>