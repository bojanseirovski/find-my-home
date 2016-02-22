<?php
namespace BojanGles\lib;
/**
 * Response class
 *
 * @author bseirovski
 */

use BojanGles\lib\BException;

class Response {
	
	
	public function out($dataArray = null){
		if(!is_array($dataArray) || !isset($dataArray)){
			throw new BException("The passed data is not an array", 001);
		}
		header('Content-Type: application/json');
		echo json_encode($dataArray);
	}
}
