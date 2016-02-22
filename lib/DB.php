<?php
namespace BojanGles\lib;
/**
 * Description of DB
 *
 * @author bseirovski
 */
class DB {

	private $con;

	public function __construct($dsn, $user, $password) {

		if(isset($dsn) && isset($user) && isset($password)){

			$this->con=new \PDO($dsn, $user, $password);

		}
	}


	public function runQuery($query,$args=null, $returnResult = false){

	    $return = null;

		$stmt=$this->con->prepare($query);
		if(isset($args)){
			$stmt->execute($args);
		}
		else{
			$stmt->execute();
		}
		if($returnResult){
		    $return=$stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

	    return $return;
	}


}
