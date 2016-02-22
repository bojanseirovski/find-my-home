<?php

namespace BojanGles\lib\util;

/**
 * Description of Base
 *
 * @author bseirovski
 */

class Base {

    protected $apiUrl, $config, $db;

    public function __construct($name, $config, $db = null) {
        $this->apiUrl= $config[$name.'_api'];
        $this->config= $config;
        $this->db= $db;

    }

    public function callApi($params ){

        foreach($params as $paramName => $oneParam){
            $this->apiUrl = str_replace("%%".$paramName."%%",$oneParam,$this->apiUrl);
        }
        return $this->fetchApiResponse();
    }


    protected function fetchApiResponse(){
        $toReturn = false;
        $output = file_get_contents($this->apiUrl);
        if (isset($output)) {
            $toReturn = json_decode($output, true);
        }

        return $toReturn;
    }

}
