<?php
namespace BojanGles\lib;
/**
 * Description of Log
 *
 * @author bseirovski
 */
class Log {

	private $logpath;
	
	public function __construct($logpath = null) {
		$this->setLogPath($logpath);
	}

	public function setLogPath($path = null){
		$set = false;
		if(isset($path)){
			if(!is_file($path)){
				file_put_contents($path, 'Initiating log file - '.date('Y-m-d h:i:s')." \r\n");
			}
			$this->logpath = $path;
			$set = true;
		}

		return $set;		
	}

	public function debug($message){
		file_put_contents($this->logpath, '{{ DEBUG - '.date('Y-m-d h:i:s').' }} '.$message." \r\n",FILE_APPEND);
	}

	public function error($message){
		file_put_contents($this->logpath, '{{ ERROR - '.date('Y-m-d h:i:s').' }} '.$message." \r\n",FILE_APPEND);		
	}

	public function info($message){
		file_put_contents($this->logpath, '{{ INFO - '.date('Y-m-d h:i:s').' }} '.$message." \r\n",FILE_APPEND);		
		
	}
		
}
