<?php
Class Uri{
	function __construct(){
		$this->url=substr($_SERVER['REQUEST_URI'],1); 
	}
	public function get($key){
		
		$url=explode('?',$this->url);
		if (!empty($url)){
			$get=$url[1];
			if (isset($get)){
				$arr=array();
				$part=explode('&',$get);
				$jum=count($part);
				for ($i=0; $i<$jum;$i++){
					$data=explode('=',$part[$i]);
					if ($data[0] && $data[1]){
						$arr[$data[0]]=$data[1];
					}
				}
				if (isset($arr[$key])){
					return $arr[$key];
				}
				else {
					return '';
				}
			}
			else {
				return '';
			}
		} else {
			return ;
		}
	}
	
	public function segment($param=0){
		$url=explode('/',$this->url);
		if (empty($url[$param])){
			return false;
		}
		else{
			return $url[$param];
		}
		
	}
}