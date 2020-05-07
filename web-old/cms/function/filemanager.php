<?php
/*
author : wahyu
create on 26 december 2016
*/
class FileManager {
	
	//return array
	public function listData($dir,$patternawal='*',$patternakhir='*'){
		if (is_dir($dir)){
			return glob($dir.$patternawal.'.'.$patternakhir);
		}
		
		return array();
	}

	public function get($file) {
		
		$handle = fopen($file, 'r');

		flock($handle, LOCK_SH);

		$data = fread($handle, filesize($file));

		flock($handle, LOCK_UN);

		fclose($handle);

		return $data;

	}

	public function set($file, $isi) {

		$handle = fopen($file, 'w');

		flock($handle, LOCK_EX);

		fwrite($handle,$isi);

		fflush($handle);

		flock($handle, LOCK_UN);

		fclose($handle);
	}

	public function hapus($file) {

		if (file_exists($file)) {
			 unlink($file);
		}
	}
	
}