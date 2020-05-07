<?php
class Random {
    public $string="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    public $string_number="0123456789";
    
    public function string($length=32){
        $max = strlen($this->string) - 1;
       // echo $this->string;
    	$token = '';
    	
    	for ($i = 0; $i < $length; $i++) {
    		$token .= $this->string[mt_rand(0, $max)];
    	}	
    	return $token;
    }
    
    public function number($length=12){
        $max = strlen($this->string_number) - 1;
    	$token = '';
    	for ($i = 0; $i < $length; $i++) {
    		$token .= $this->string_number[mt_rand(0, $max)];
    	}	
    	
    	return $token;
    }
}