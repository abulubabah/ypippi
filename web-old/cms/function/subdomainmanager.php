<?php
/*
author : wahyu
create on 26 december 2016
*/
class SubdomainManager{
	private $config;
	private $header;
	private $cocket;
	/*array config berisi array assosiatif
	username,password,tema,subdomain,rootdomain,foldersubdomain,host,port */
	public function __construct($config=array()){
		$this->config=$config;
		if (!$this->config){
			die("masukan configurasi cpanel");
		}
	}
	public function getUsername(){
		return $this->config['username'];
	}
	
	public function getPassword(){
		return $this->config['password'];
	}
	
	public function getTema(){
		return $this->config['tema'];
	}
	
	public function getSubdomain(){
		return $this->config['subdomain'];
	}
	
	public function getRootDomain(){
		return $this->config['rootdomain'];
	}
	
	public function getFolderDomain(){
		return $this->config['folderdomain'].$this->getRootDomain().'/';
	}
	
	public function getHost(){
		return $this->config['host'];
	}	
	
	public function getPort(){
		return $this->config['port'];
	}
	
	private function linkAdd(){
		return "frontend/".$this->getTema()."/subdomain/doadddomain.html";
	}	
	
	private function getSocket(){
		return $this->socket;
	}	
	
	private function linkDelete(){
		return "frontend/".$this->getTema()."/subdomain/dodeldomain.html";
	}
	
	private function openSocket(){
		$open=fsockopen($this->getHost(),$this->getPort());
		if (!$open){
			return false;
		}
		
		$this->socket=$open;
		return true;
	}
	
	/* $param berisi query string tambah domain atau hapus domain
	example: ?domain=
	*/
	private function addHeader($param){
		
		$authString = $this->getUsername() . ":" . $this->getPassword();
      $authPass = base64_encode($authString);
      $buildHeaders  = "GET " . $param ."\r\n";
      $buildHeaders .= "HTTP/1.0\r\n";
      $buildHeaders .= "Host:localhost\r\n";
      $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
      $buildHeaders .= "\r\n";
      $this->header= $buildHeaders;
	}
	
	
	private function getHeader(){
		return $this->header;
	}
	
	private function readSocket(){
		fputs($this->getSocket(),$this->getHeader());
		while(!feof($this->getSocket())){
			fgets($this->getSocket(),128);
		}
		if (fclose($this->getSocket())){
			return true;
		}
		
		return false;
	}
	
	public function createSubdomain(){
		$link=$this->linkAdd().'?rootdomain='.$this->getRootDomain().'&domain='.$this->getSubdomain().'&dir='.$this->getFolderDomain().$this->getSubdomain().'&go=Create';
		echo $link;
		$this->addHeader($link);
		$this->openSocket();
		$this->readSocket();

	}
	
	public function deleteSubdomain(){
		$link=$this->linkDelete().'?domain='.$this->getSubdomain().'_'.$this->getRootDomain();
		$this->addHeader($link);
		$this->openSocket();
		$this->readSocket();
		$passToShell = "rm -rf /home/" . $this->getUsername().'/' . $this->getFolderDomain(). $this->getSubdomain();
		$chmod= "chmod 755 /home/".$this->getUsername().'/' . $this->getFolderDomain(). $this->getSubdomain();
		system($chmod);
      system($passToShell);

	}
}
