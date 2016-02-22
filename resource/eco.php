<?php
namespace BojanGles\Resources;

/**
 * eco
 *
 * @author bseirovski
 */

use BojanGles\lib\util\EcoClass;
use BojanGles\lib\util\CountryClass;

class eco extends \BojanGles\lib\AppResource{

	public function get($request=null){
	    $this->response = array('success' => false ,'ErrorMessage'=>'Empty request.');
        $data = json_decode($request->post(),true);
		$expectedParams = array('country','key');
        $yearFrom = 1920;
        $yearTo = 1939;
        $derivedEcoData = array();
        $theresponse = array();


		if(!$request->valid($expectedParams, $data)){
			$this->response = array('success' => false ,'ErrorMessage'=>'Invalid request.');
		}
		else{

    	        $ecoData = new EcoClass('eco',$this->config);
    	        $countryData = new CountryClass('country',$this->config, $this->db);


                $cname = $countryData->lookup($data['country'])[0];

                $data['country'] = urlencode($cname['country']);
        	    $allEcoData = $ecoData->callApi($data)[0];

                if(count($allEcoData)){

            	    $avg=0;
            	    $avgCount=0;
                    foreach($allEcoData['carbon'] as $once){
                        $avg +=$once;
                        $avgCount++;
                    }
                    $avg = $avg/$avgCount;
                    $theresponse = array(
                            'carbon'=>$allEcoData['carbon'],
                            'average_carbon'=> $avg,
                            'info'=>'http://carma.org/'
                    ) ;

                }
		    $this->response = array('success'=>true,'data'=>$theresponse) ;

		}
		return $this->response;
	}
}
