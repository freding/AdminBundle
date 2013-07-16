<?php

namespace Fredb\AdminBundle\Services;


class ToolBox {
	
	
	const ACTIVATED		= 2;
	const ACTIVATED_NOT	= 3;

	const MODE_CREATE	= 1;
	const MODE_MODIFY	= 2;
	
	static $aModes			= array( self::MODE_CREATE => "Create" , self::MODE_MODIFY => "Modify" );
	
        const DEFAULT_SELECT_VALUE = "none";
	
	public static function resizeImage($source, $destination, $width, $height) {
            
		$thumb = \PhpThumbFactory::create($source);
		$thumb->resize($width, $height);
		$thumb->save($destination);
	}
	
	public static function cropImage($source, $destination, $width, $height) {
		$thumb = \PhpThumbFactory::create($source);
		//$thumb->cropFromCenter($width, $height);
		$thumb->adaptiveResize($width, $height);
		$thumb->save($destination);
	}
        
	public static function normaliza($string){
		$string = self::nonaccent($string);
		$entree = array('#[áàâäã]#','#[ÁÀÂÄÃ]#','#[éèêë]#','#[ÉÈÊË]#','#[íìîï]#','#[ÍÌÎÏ]#','#[óòôöõ]#','#[ÓÒÔÖÕ]#','#[úùûü]#','#[ÚÙÛÜ]#','#ÿ#','#Ÿ#','#ç#','#Ç#','# #','#[^.a-zA-Z0-9_-]#');
		$sortie = array('a','a','e','e','i','i','o','o','u','u','y','y','c','c','-','');
		$str = preg_replace($entree,$sortie,$string);
		return strtolower($str);
	}
	
	public static function nonaccent($string){
	    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyrr';
	    $string = str_replace("'","",$string);
	    $string = str_replace("\\","",$string);
	    $string = str_replace(" ","-",$string);
	    $string = str_replace(".","-",$string); 	
	    $string = utf8_decode($string);    
	    $string = strtr($string, utf8_decode($a), $b);
	    $string = strtolower($string);
	    $string = stripslashes($string);    
	    return utf8_encode($string);
	}


	public static function timestampToDisplayFull($timestamp){
		return date("d/m/Y - H:i:s", $timestamp);
	}	
	
	public static function timestampToDateHourMin($timestamp){
		return date("d/m/Y - H:i", $timestamp);
	}		
	
	public static function timestampToDate($timestamp){
		return date("d/m/Y", $timestamp);
	}
	
	public static function PickerTimeToTimestamp($date){
		  list($day, $month, $year) = explode('/', $date);
		  $timestamp = mktime(0, 0, 0, $month, $day, $year);
		  return $timestamp;

	}	
	
	
	public static function TimestampToPickerTime($timestamp){
		return date("d/m/Y", $timestamp);
	}
	
        
	public static function VerifyAdresseMail($adresse) 
	{ 
	   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
	   if(preg_match($Syntaxe,$adresse)) 
	      return true; 
	   else 
	     return false; 
	}
	
	
	public static function customHash($chars = 8, $items = 'abcdefghijklmnpqrstuvwxyz0123456789-[]_!'){
		$output 	= '';
		$chars 		= (int)$chars;
		$nbr		= strlen($items);
		if($chars > 0 && $nbr > 0){
			for($i = 0; $i < $chars; $i++){
				$output	.= $items[mt_rand(0,($nbr-1))];
			}
		}
		return $output;
	}
	
	
	
	
	public static function makeTinyURL($url)   
	{   
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($curl,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);   
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,7);   
		$ret = curl_exec($curl);   
		curl_close($curl);   
		return $ret;   
	} 
	
	
	public static function limitSizeStrMb($str,$size){
		if(strlen($str)>$size){
			return mb_substr($str,0,$size,'UTF-8')."...";
		}else{ 
			return $str;
		}	
	
	}
	
	
	
	
	
	
	
	
	
	
}

?>
