<?php

namespace BojanGles\lib\util;

/**
 * Description of Gdp
 *
 * @author bseirovski
 */
class CountryClass  extends Base {


    public function lookup($name = null){
            $getCountrySql = 'select * from countrycode';

            $cnameLong = strlen($name);
            $param = array();
            if(isset($name)){
                if($cnameLong ==2)
                    $getCountrySqlname= ' where iso2=:cn ;';
                if($cnameLong ==3)
                    $getCountrySqlname= ' where iso3=:cn ;';


                $param = array(":cn"=>$name);

                if($cnameLong>3){
                    $getCountrySqlname= ' where country like :cn ;';
                    $param = array(":cn"=>'%'.$name.'%');
                }

                $getCountrySql .= $getCountrySqlname;

            }
            $toReturn = array();
            foreach( $this->db->runQuery( $getCountrySql,$param,true) as $onec){
                if(isset($name)){
                    $borders = $this->callApi(array('country'=>$onec['country']));
                    $onec['borders'] = $borders[0]['borders'];
                }

                $toReturn[]=$onec;
            }

            return $toReturn;

    }


}
