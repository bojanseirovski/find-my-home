<?php
namespace BojanGles\lib;
/**
 * AppResource
 *
 * @author bseirovski
 */

class AppResource {

	protected $log, $db , $config, $response = array();


	public function __construct($config, $db = null) {
		$this->log = new Log($config['log_file']);
		if(isset($db)){
		    $this->db = $db;
		}
		$this->config = $config;
	}
}
