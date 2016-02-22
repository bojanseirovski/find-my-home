<?php
namespace BojanGles\lib;
/**
 * Description of Request
 *
 * @author bseirovski
 */
class Request {

	protected $post = array() , $get = array() , $getKeys = array(), $postKeys = array();

	public function __construct() {
		if(isset($_GET) && count($_GET)>0){
			foreach ($_GET as $key=>$oneGet){
				$this->get[$key] = stripslashes(strip_tags(trim($oneGet)));
				$this->getKeys[] = $key;
			}
		}
		if(isset($_POST)){
			foreach ($_POST as $key=>$onePost){
				$this->post[$key] = stripslashes(strip_tags(trim($onePost)));
				$this->postKeys[] = $key;
			}
		}
		$inputStr = file_get_contents('php://input');
		if($inputStr){
		    $this->post=null;
		    $this->postKeys=array();
		    $this->postKeys[]=$inputStr;
		}
	}

	public function get($param = null){

        $toReturn = isset($this->getKeys[0])?$this->getKeys[0]:null;

		if(isset($param) && isset($this->get[$param])){
			$toReturn = $this->get[$param];
		}

		return $toReturn;
	}

	public function post($param = null){

		$toReturn = isset($this->postKeys[0])?$this->postKeys[0]:null;

		if(isset($param) && isset($this->post[$param])){
			$toReturn = $this->post[$param];
		}

		return $toReturn;
	}

	public function valid($expected, $data){
		$isValid = true;
		if(count($data)==0){
			$isValid = false;
		}
		else{
			$receivedParams = array();
			foreach ($data as $dataKey=>$dataValue){
				$receivedParams[]=$dataKey;
			}

			foreach($receivedParams as $key=>$param){
				if(in_array($param,$expected)){
					$isValid = $isValid&&true;
				}
				else{
					$isValid = $isValid&&false;
				}
			}
		}

		return $isValid;
	}

}
