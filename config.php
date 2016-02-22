<?php

$baseDir =dirname(__FILE__).DIRECTORY_SEPARATOR;

$config = array(
	'log_file'=>$baseDir .'log'.DIRECTORY_SEPARATOR.'application.log',
	'secret'=>'NwvprhfBkGuPJnjJp77UPJWJUpgC7mLz',
	'gdp_api'=>'http://api.worldbank.org/countries/%%country%%/indicators/NY.GDP.MKTP.CD?format=json&per_page=100',
	'eco_api'=>'http://carma.org/api/1.1/searchLocations?name=%%country%%',
	'country_api'=>'https://restcountries.eu/rest/v1/name/%%country%%',
);

$db = array(
	'dsn'=> 'mysql:charset=UTF8;host=ubks59ec4c49.bojanseirovski.koding.io;dbname=qliving',
	'dsn'=> 'mysql:charset=UTF8;host=localhost;dbname=qliving',
	'username'=>'root',
	'password'=>'rim521641'
);