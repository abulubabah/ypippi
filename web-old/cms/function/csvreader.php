<?php
/* 
create on 13 januari 2017
author wahyu
revisi tanggal 14 januari 2017
penambahan autosupport csv dengan delimiter coma,semicolon,colon,pound,pipe 
*/
class CsvReader{
	private $jumlah_baris=0;
	private $nama_file;
	private $pattern;
	private $delimiter;
	private $match;
	
	
	//konstruktor berisi $nama_file dan $pattern
	public function __construct($nama_file,$pattern=array()){
		$this->nama_file=$nama_file;
		$this->pattern=$pattern;
		
		if (!$this->cekFile()){
			trigger_error('File Tidak Tersedia');
			exit;
		}
		
		if (!$this->isValidFile()){
			trigger_error('File Harus Berupa .csv');
			exit;
		}
		
		if (!$this->cekDelim()){
			trigger_error('File csv tidak sesuai format yang di inginkan');
			exit;
		}
		
		if (!$this->match()){
			trigger_error('File csv tidak sesuai format yang di inginkan');
			exit;
		}
	}
	
	private function cekFile(){
		if (file_exists($this->nama_file)){
			return true;
		}
		return false;
	}
	
	private function semiColonDelim(){
		$this->match=false;
		foreach ($this->readData(';') as $data){
			$jum=count($data);
			$jumpattern=count($this->pattern);
			//echo "AAA";
			if ($jum==$jumpattern){
				$this->match=true;
				break;
			}
		}
		return $this->match;
	}
	
	private function comaDelim(){
		$this->match=false;
		foreach ($this->readData(',') as $data){
			$jum=count($data);
			$jumpattern=count($this->pattern);
			if ($jum==$jumpattern){
				$this->match=true;
				
				break;
			}
		}
		
		return $this->match;
	}
	
	private function poundDelim(){
		$this->match=false;
		foreach ($this->readData('#') as $data){
			$jum=count($data);
			$jumpattern=count($this->pattern);
			if ($jum==$jumpattern){
				$this->match=true;
				break;
			}
		}
		
		return $this->match;
	}
	
	private function pipeDelim(){
		$this->match=false;
		foreach ($this->readData('|') as $data){
			$jum=count($data);
			$jumpattern=count($this->pattern);
			if ($jum==$jumpattern){
				$this->match=true;
				
				break;
			}
		}
		
		return $this->match;
	}
	
	private function colonDelim(){
		$this->match=false;
		foreach ($this->readData(':') as $data){
			$jum=count($data);
			$jumpattern=count($this->pattern);
			if ($jum==$jumpattern){
				$this->match=true;
				
				break;
			}
		}

		return $this->match;
	}
	
	private function cekDelim(){
		if ($this->semiColonDelim()){
			$this->delimiter=';';
			return true;
		}
		
		if ($this->comaDelim()){
			$this->delimiter=',';
			return true;
		}
		
		if ($this->colonDelim()){
			$this->delimiter=':';
			return true;
		}
		
		if ($this->pipeDelim()){
			$this->delimiter='|';
			return true;
		}
		
		if ($this->poundDelim()){
			$this->delimiter='#';
			return true;
		}
		return false;
	}
	
	private function match(){
		return $this->match;
	}
	
	public function getNamaFile(){
		return $this->nama_file;
	}
	
	private function cekEkstensi($nama_file){
		$data=explode(".",$nama_file);
		return end($data);
	}
	
	public function getJumlahBaris(){
		return $this->jumlah_baris;
	}
	
	private function isValidFile(){
		if (strtolower($this->cekEkstensi($this->nama_file))=='csv'){
			return true;
		}
		return false;
	}
	
	public function readData($delim){
		$file=fopen($this->nama_file,'r');
		$hasil=array();
		while ($data=fgetcsv($file,0,$delim)){
			$hasil[]=$data;
		}
		fclose($file);
		return $hasil;
	}
	
	public function  proses(){
		$this->jumlah_baris=0;
		$ouput=array();
		foreach ($this->readData($this->delimiter) as $data){
			$jum=count($data);
			$field=array();
			for ($i=0;$i<$jum;$i++){
				$key=trim($this->pattern[$i]);
				$value=trim($data[$i]);
				$field[$this->pattern[$i]]=$value;
			}
			$ouput[]=$field;
			$this->jumlah_baris++;
		}

		return $ouput;
	}
	
}
