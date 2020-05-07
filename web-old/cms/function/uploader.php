<?php
class Uploader {
	private $dirpict="../../cms/picture/";
	private $dirfile="../../cms/file/";
	private $bucket="s.mysch.id";
	
	public function setDirPict($dir){
	    $this->dirpict=$dir;
	}
	
	public function setDirFile($dir){
	    $this->dirfile=$dir;
	}
	
	public function uploadPicture($nama_picture){
		exec('gsutil -h "Cache-Control:public,max-age=2628000" cp -Z -a public-read '.$this->dirpict.$nama_picture.' gs://'.$this->bucket.'/picture/'.$nama_picture);
	}
	
	public function uploadPictureCache($nama_picture){
		exec('gsutil -h "Cache-Control:public,max-age=2628000" cp -Z -a public-read '.$this->dirpict.$nama_picture.' gs://'.$this->bucket.'/imagecache/'.$nama_picture);
	}
	
	public function uploadFile($nama_file){
		exec('gsutil -h "Cache-Control:public,max-age=2628000" cp -Z -a public-read '.$this->dirfile.$nama_file.' gs://'.$this->bucket.'/file/'.$nama_file);
	}
	
	public function deletePicture($nama_picture){
		exec('gsutil rm  gs://'.$this->bucket.'/picture/'.$nama_picture);
	}
	
	public function deleteFile($nama_file){
		exec('gsutil rm  gs://'.$this->bucket.'/file/'.$nama_file);
	}
	
	public function move($asal,$target){
		exec('gsutil mv gs://'.$this->bucket.'/'.$asal.' gs://'.$this->bucket.'/'.$target);
	}
	
	public function copy($asal,$target){
		exec('gsutil cp gs://'.$this->bucket.'/'.$asal.' gs://'.$this->bucket.'/'.$target);
	}
	
	public function stat($nama_file){
	    exec('gsutil stat gs://'.$this->bucket.'/'.$nama_file);
	}
	
}

