<?php
namespace BojanGles\Resources;

/**
 * compare
 *
 * @author bseirovski
 */
class compare extends \BojanGles\lib\AppResource{

	public function get($request=null){

        $this->response = array('success' => false ,'ErrorMessage'=>'Empty request.');
	    $data = json_decode($request->post(),true);
		$expectedParams = array('country','key');

		if(!$request->valid($expectedParams, $data)){
			$this->response = array('success' => false ,'ErrorMessage'=>'Invalid request.');
		}
		else{
            if(is_array($data['country'])){
                foreach($data['country'] as $onec){

                }
            }


		}
		return $this->response;
	}
}
