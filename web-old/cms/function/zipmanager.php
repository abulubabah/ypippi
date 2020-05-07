<?php
/* dibuat tanggal 1 februari 2017 
	author : wahyu
*/

class ZipManager{
	private $files;
	private $config;
	private $tmp_file;
	
	/* file gambar disimpan dalam array $files 
	$config berisi array assosiatif tmp_file,nama_zip
	*/
	public function __construct($files=array(),$config=array()){
		$this->files=$files;
		$this->config=$config;
		if (!$this->files){
			trigger_error('Masukan File Yang Akan Di Ekspor');
			exit;
		}
		
		if (!$this->config){
			trigger_error('Masukan Configurasi Data File');
			exit;
		}
		
		if (!class_exists('ZipArchive')){
			trigger_error('Extension Zip Harus Diaktifkan Di server Anda');
			exit;
		}
		
		
		$this->prosesFile();
	}
	
	public function downloadZip(){
		# send the file to the browser as a download
		header('Content-disposition: attachment; filename='.$this->config['nama_zip'].'.zip');
		header('Content-type: application/zip');
		readfile($this->tmp_file);
		//unlink($this->config['tmp_file']);
	}
	private function prosesFile(){
		# create new zip opbject
		$zip = new ZipArchive();

		# create a temp file & open it
		$tmp_file =tempnam($this->config['tmp_file'],'sementara');
		
		$zip->open($tmp_file, ZipArchive::CREATE);
		foreach ($this->files as $file){
			# download file
			$download_file = file_get_contents($file);

			#add it to the zip
			$zip->addFromString(basename($file),$download_file);
		}
		$this->tmp_file=$tmp_file;
		# close zip
		$zip->close();
		
	}
	
	
}