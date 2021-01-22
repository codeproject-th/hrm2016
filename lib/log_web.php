<?php
class log_web{
	
	public function log_web($txt){
		$file = "./log_web/".date("Ymd").".txt";
		$f = fopen($file, 'w');
  		fwrite($f,$txt);
  		fclose($sf);
	}
	
}

?>