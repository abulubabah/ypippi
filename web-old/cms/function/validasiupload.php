<?php
/* 
Dibuat tanggal 26-10-2016
author wahyu
*/
class ValidasiUpload {
	public $allowed;
	public $not_allowed;
	public $nama_file;
	public $file;
	public $mime;
	public $hasil_mime;
	public $gambar_type;
	
	function __construct($file,$nama_file){
		$this->mime=array(
			'image/jpeg',
			'image/pjpeg',
			'image/png',
			'image/x-png',
			'image/gif'
		);
		
		$this->allowed=array(
			'jpg',
			'jpeg',
			'gif',
			'png'
		);
		
		$this->not_allowed=array(
			'php',
			'php4',
			'php5',
			'php6',
			'php7',
			'phps',
			'phtml',
			'tpl'
		);
		$this->hasil_mime=false;
		$this->file=$file;
		$this->nama_file=$nama_file;
	}
	/* memberikan nilai true jika is variabel $filename ada dalam array $allowed */
	public function isAllowedFile($allowed=array(),$filename){
		if (in_array(strtolower(substr(strrchr($filename,'.') , 1)),$allowed)){
			return true;
		}
		return false;
	}
	/* memberikan nilai true jika is variabel $filename ada dalam array $not_allowed */
	public function notAllowedFile ($not_allowed=array(),$filename){
		if (in_array(strtolower(substr(strrchr($filename,'.'),1)),$not_allowed)){
			return true;
		}
		return false;
	}
	public function putGambarType($gambar_type){
		$this->gambar_type=$gambar_type;
	}
	/* cek mime file return true jika mime valid*/
	public function cekMimeGambar($mime,$gambar_type){
		if (in_array($gambar_type,$mime)){
			return true;
		}
		return false;
	}
	/* cek file yang dimasukan melalui tamper data */
	public function hashPhpCode($file){
		$content = file_get_contents($file);
		if (preg_match('/\<\?php/i', $content)) {
			return true;
		}
		return false;
	}
	/* zero day exploit yang di temukan oleh nikolas ermiskin. pada program imagic */
	public function hashImagicTrick($file){
		$content = file_get_contents($file);
		if (preg_match("/fill 'url/", $content)) {
			return true;
		} else if (preg_match('/fill "url/', $content)) {
			return true;
		}
		return false;
	}
	
	public function validGambar(){
		
		if (!$this->isAllowedFile($this->allowed,$this->nama_file)){
			return false;
		}
		if (!$this->cekMimeGambar($this->mime,$this->gambar_type)){
			return false;
		} 
		if ($this->hashPhpCode($this->file)){
			return false;
		} 

		if ($this->hashImagicTrick($this->file)){
			return false;
		}
		
		return true;
	}
	
	public function validFile(){
		
		if (!$this->notAllowedFile($this->not_allowed,$this->nama_file)){
			return false;
		} 
		
		if ($this->hashPhpCode($this->file)){
			return false;
		} 
		
		if ($this->hashImagicTrick($this->file)){
			return false;
		}
		
		return true;
	}
}
