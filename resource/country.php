<?php
namespace BojanGles\Resources;

/**
 * country
 *
 * @author bseirovski
 */
 use BojanGles\lib\util\CountryClass;

class country extends \BojanGles\lib\AppResource{

	public function get($request=null){

        $this->response = array('success' => false ,'ErrorMessage'=>'Empty request.');

	    $data = json_decode($request->post(),true);

        $countryData = new CountryClass('country',$this->config, $this->db);

        $lis = $countryData->lookup($data['country']);

        $this->response = array('success' => true ,'data'=>$lis);


		return $this->response;
	}
}
