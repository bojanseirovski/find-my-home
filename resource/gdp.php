<?php
namespace BojanGles\Resources;

/**
 * gdp
 *
 * @author bseirovski
 */
 use BojanGles\lib\util\GdpClass;
class gdp extends \BojanGles\lib\AppResource{

	public function get($request=null){
	    $this->response = array('success' => false ,'ErrorMessage'=>'Empty request.');
        $data = json_decode($request->post(),true);
		$expectedParams = array('country','key');

		if(!$request->valid($expectedParams, $data)){
			$this->response = array('success' => false ,'ErrorMessage'=>'Invalid request.');
		}
		else{
	        $gdpData = new GdpClass('gdp',$this->config);
    	    $allgdpData = $gdpData->callApi($data);
            if(count($allgdpData)){
        	    $avg=0;
        	    $avgCount=0;
        	    $total = $allgdpData[0]['total'];
        	    $yearFrom = $allgdpData[1][$total-1]['date'];
        	    $yearTo = $allgdpData[1][0]['date'];
        	    $yearToValue = isset( $allgdpData[1][0]['value'])?$allgdpData[1][0]['value']:$allgdpData[1][1]['value'];
        	    $yearFromValue = $allgdpData[1][$total-1]['value'];
        	    foreach($allgdpData[1] as $oneSource){
        	        $avg += $oneSource['value'];
        	        $avgCount++;
        	    }
        	    $avg = $avg/$avgCount;
                $this->response = array(
                    'success'=>true,
                    'data'=>array(
                        'year_from'=>$yearFrom,
                        'year_from_val'=>$yearFromValue,
                        'year_to'=>$yearTo,
                        'year_to_val'=>$yearToValue,
                        'average'=> $avg,
                        'number_of_sources'=>$avgCount,
                        'info'=>'GDP (current US$)')) ;

            }
            else{
                	$this->response = array('success'=>true,'data'=>'') ;
            }

		}
		return $this->response;
	}
}
