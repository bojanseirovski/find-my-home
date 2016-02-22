<?php
header("Access-Control-Allow-Origin: *");
/**
 * Backend framework
 *
 * Bojan Seirovski - bojan@seirovski.com
 */
require_once 'config.php';
try {
	$lib = $baseDir . "lib" . DIRECTORY_SEPARATOR;
	$lib2Util = $baseDir . "lib" . DIRECTORY_SEPARATOR. "util" . DIRECTORY_SEPARATOR;
	$res = $baseDir . "resource" . DIRECTORY_SEPARATOR;

	if (is_dir($lib)) {
		foreach (glob($lib . "*.php") as $filename) {
			require_once $filename;
		}
	}
	if (is_dir($lib2Util)) {
		foreach (glob($lib2Util . "*.php") as $filename) {
			require_once $filename;
		}
	}
	if (is_dir($res)) {
		foreach (glob($res . "*.php") as $filename) {
			require_once $filename;
		}
	}

	$log = new \BojanGles\lib\Log($config['log_file']);

	$log->info('Creating objects');

	$dbase = new \BojanGles\lib\DB($db['dsn'], $db['username'], $db['password']);
	$request = new \BojanGles\lib\Request();
	$response = new \BojanGles\lib\Response();

	$log->info('Objects created');

	$controllerName = $request->get('controller');
	if (isset($controllerName) && ('favicon.ico'!=$controllerName)) {
		$log->info('Controller to be loaded :' . $controllerName);
		$log->info("POST Request: ".var_export($_POST,true));
		$theControllerPath = '\\' . "BojanGles\\Resources\\" . $controllerName;
		$theController = new $theControllerPath($config, $dbase);
		try {
		    $key = json_decode($request->post(),true)['key'];
		    if($key==$config['secret']){
		        			//	process request
    		    $do = $theController->get($request);
    			//	output
    		    $response->out($do);
    		    $log->info('Response for ' . $controllerName . ' :' . json_encode($do));
		    }
		    else{
		        $response->out(array('success' => false, 'ErrorMessage' => 'Bad request : wrong key.'));
		    }
		}
		catch (\Exception $e) {
			$log->error($e->getMessage());
		}
	}
	else {
		$response->out(array('success' => false, 'ErrorMessage' => 'Bad request : unknown route.'));
	}
}
catch (\Exception $e) {
	error_log($e->getMessage());
	$error = array('success' => false, 'ErrorMessage' => 'System error.');

	echo json_encode($error);
}