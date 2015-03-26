<?php
namespace MistirioModules;

class Helper{
	/**
	 * Generates a random string
	 * @param  integer $length
	 * @return string
	 */
	public function randomString($length = 42){
		// We'll check if the user has OpenSSL installed with PHP. If they do
		// we'll use a better method of getting a random string. Otherwise, we'll
		// fallback to a reasonably reliable method.
		if (function_exists('openssl_random_pseudo_bytes')){
			// We generate twice as many bytes here because we want to ensure we have
			// enough after we base64 encode it to get the length we need because we
			// take out the "/", "+", and "=" characters.
			$bytes = openssl_random_pseudo_bytes($length * 2);

			// We want to stop execution if the key fails because, well, that is bad.
			if ($bytes === false){
				throw new \RuntimeException('Unable to generate random string.');
			}
			return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
		}
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	}
	// add the http:// scheme
	function addScheme($url, $scheme = 'http://'){
	  return parse_url($url, PHP_URL_SCHEME) === null ?
	    $scheme . $url : $url;
	}
	// Retrieves the path provided using cURL
	private function loadPath($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$retValue = curl_exec($ch);			 
		curl_close($ch);
		return $retValue;
	}
	// Gets content using loadPath and caches the content.
	public function getContent($file,$url,$hours = 12,$fn = '',$fn_args = '') {
		//vars
		$current_time = time(); $expire_time = $hours * 60 * 60; $file_time = @filemtime($file);
		//decisions, decisions
		if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
			//echo 'returning from cached file';
			return file_get_contents($file);
		}
		else {
			$content = static::loadPath($url);
			if($fn) { $content = $fn($content,$fn_args); }
			$content.= '<!-- cached:  '.time().'-->';
			file_put_contents($file,$content);
			//echo 'retrieved fresh from '.$url.':: '.$content;
			return $content;
		}
	}
	public function isEmail($input){
		if(filter_var($input, FILTER_VALIDATE_EMAIL)){
			return true;
		}else{
			return false;
		}
	}
	public function stripInlineCss($text){
        $text = strip_tags($text,"<style>");

		$substring = substr($text,strpos($text,"<style"),strpos($text,"</style>"));

		$text = str_replace($substring,"",$text);
		$text = str_replace(array("\t","\r","\n"),"",$text);
		$text = trim($text);

        
        return $text; 
    } 
}