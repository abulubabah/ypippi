<?php

class Validasi {
	
	public function clean($param=''){
		$g1=str_replace("#","",$param);$g2=str_replace("~","",$g1);$g3=str_replace("`","",$g2);$g4=str_replace("!","",$g3);
		$g5=str_replace("@","",$g4);$g6=str_replace("#","",$g5);$g7=str_replace("$","",$g6);$g8=str_replace("%","",$g7);
		$g9=str_replace("^","",$g8);$g10=str_replace("&","",$g9);$g11=str_replace("*","",$g10);$g12=str_replace("(","",$g11);
		$g13=str_replace("","",$g12);$g14=str_replace("_","",$g13);$g15=str_replace("+","",$g14);$g16=str_replace("=","",$g15);
		$g17=str_replace("|","",$g16);$g18=str_replace("{","",$g17);$g19=str_replace("}","",$g18);$g20=str_replace("[","",$g19);
		$g21=str_replace("]","",$g20);$g22=str_replace(":","",$g21);$g23=str_replace(";","",$g22);$g24=str_replace("'","",$g23);
		$g25=str_replace(">","",$g24);$g26=str_replace("<","",$g25);$g27=str_replace("?","",$g26);$g28=str_replace(",","",$g27);
		$g29=str_replace(".","",$g28);$g30=str_replace("/","",$g29);$g31=str_replace(")","",$g30);
		return $g31;
	}
	
	public function gantiSpasi($param=''){
		return str_replace (' ','-',$param);
	}
	
	public function htmlEncode($str) {
		$str = htmlentities($str, ENT_QUOTES, 'UTF-8');
		return $str;
	}
	
	public function htmlDecode($str){
		return html_entity_decode($str, ENT_QUOTES, 'UTF-8');
	}
	
	public function fixUrl($url) {
		if (substr($url, 0, 7) == 'http://') { return $url; }
		if (substr($url, 0, 8) == 'https://') { return $url; }
		return 'http://'. $url;
	}
	
	private function _make_url_clickable_cb($matches) {
		$ret = '';
		$url = $matches[2];
		if ( empty($url) )
			return $matches[0];
		// removed trailing [.,;:] from URL
		if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
			$ret = substr($url, -1);
			$url = substr($url, 0, strlen($url)-1);
		}
		return $matches[1] . "<a href=\"$url\" rel=\"nofollow\" target=\"_blank\">$url</a>" . $ret;
	} 
	
	private function _make_web_ftp_clickable_cb($matches) {
		$ret = '';
		$dest = $matches[2];
		$dest = 'http://' . $dest;
	 
		if ( empty($dest) )
			return $matches[0];
		// removed trailing [,;:] from URL
		if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
			$ret = substr($dest, -1);
			$dest = substr($dest, 0, strlen($dest)-1);
		}
		return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\" target=\"_blank\">$dest</a>" . $ret;
	}
	 
	private function _make_email_clickable_cb($matches) {
		$email = $matches[2] . '@' . $matches[3];
		return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
	}
	
	public function makeClickAble($ret) {
		$ret = ' ' . $ret;
		// in testing, using arrays here was found to be faster
		$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is',array(&$this, '_make_url_clickable_cb'), $ret);
		$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is',array(&$this, '_make_web_ftp_clickable_cb'), $ret);
		$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i',array(&$this,'_make_email_clickable_cb'), $ret);
	 
		// this one is not in an array because we need it to run last, for cleanup of accidental links within links
		
		 $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret); 
		$ret = trim($ret);
		return $ret;
	}

	//function used to fetch youtube video id from youtube url
	public function getYoutubeId($url){
		$parse = parse_url($url);
		if(!empty($parse['query'])) {
		  preg_match("/v=([^&]+)/i", $url, $matches);
		  return $matches[1];
		} else {
		  //to get basename
		  $info = pathinfo($url);
		  return $info['basename'];
		}
	}
	
	public function hashPhpCode($file){
		$content = file_get_contents($file);
		if (preg_match('/\<\?php/i', $content)) {
			return true;
		}
		return false;
	}
	
	public function hashMagicTrick($file){
		$content = file_get_contents($file);
		if (preg_match("/fill 'url/", $content)) {
			return true;
		}
		
		if (preg_match('/fill "url/', $content)) {
			return true;
		}
		return false;
	}
	
	public function isEmail($email){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return true;
		}
		return false;
	}
	
	public function jam($jam){
		$data=explode(':',$jam);
		return $data[0].':'.$data[1];
	}
	
	public function indoDate($tanggal){
		$data=explode ('-',$tanggal);
		return $data[2] .'/'.$data[1].'/'.$data[0];
	}
	
	public function interDate($tanggal){
		$data=explode ('/',$tanggal);
		return $data[2] .'-'.$data[1].'-'.$data[0];
	}
	//return array(tanggal,jam)
	public function indoDateTime($datetime){
		$data=explode (' ',$datetime);
		$tanggal=$data[0];
		$waktu=$data[1];
		$cektgl=explode('-',$tanggal);
		return array('tanggal'=>$cektgl[2] .'/'.$cektgl[1].'/'.$cektgl[0],'jam'=>$waktu);
	}
	
	public function sizeFilter( $bytes ){
		$label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
		return( round( $bytes, 2 ) . " " . $label[$i] );
	}
}