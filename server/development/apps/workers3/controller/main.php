<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 * @throws \Exception
 */
namespace Controller;
class Main
{
	use \Library\Shared;

	private $model;

	public function exec():?array {
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e');
		$path = explode('/', $url);
		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php';
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) {
					$details = $methods[$path[2]];
					$request = [];
					$patternsFile = ROOT.'model/config/patterns.php';
					if(file_exists($patternsFile)){
						include $patternsFile;
						foreach ($details['params'] as $param) {
							$var = $this->getVar($param['name'], $param['source']);
							$required = $param['required'];

							if(isset($var)){
								if(preg_match($patterns[$param['name']], $var)){
									if($param['name'] == 'phone' && strlen($var)<13){
										$var = substr("+380",0,13-strlen($var)).$var;
										if(!preg_match($patterns[$param['name']], $var)){
											throw new \Exception('Parameter \''. $param['name'].'\' doesn\'t match pattern!', 2);
										}
									}
									$request[$param['name']] = $var;
								}else{
									throw new \Exception('Parameter \''. $param['name'].'\' doesn\'t match pattern!', 2);
								}
							}
							else{
								if($required){
									throw new \Exception('Parameter '. $param['name'].' is required!', 2);
								}else{
									$defaultValue = $param['default'];
									if(isset($defaultValue)){
										$request[$param['name']] = $defaultValue;
									}else{
										throw new \Exception('Parameter \''. $param['name'].'\' was not setted and has no default value!', 6);
									}
									
								}
							}

						}
						if (method_exists($this->model, $path[1] . $path[2])) {
							try{
								$method = [$this->model, $path[1] . $path[2]];
								$result = $method($request);
							}catch(Exception $e){
								throw new \Exception($e->getMessage(),$e->getCode());
							}
						}
					}
				}
			}
		}

		return $result;
	}

	public function __construct() {
		// CORS configuration
		$origin = $this -> getVar('HTTP_ORIGIN', 'e');
		$control = $this -> getVar('FRONT', 'e');
		foreach([$control] as $allowed)
			if ( $origin == "https://$allowed") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}

}