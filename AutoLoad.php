<?php
define ('CONTROLLERS_PATH', APP_DIR. "Controller" . DIRECTORY_SEPARATOR);
define('MODULES_PATH', APP_DIR . "Module" . DIRECTORY_SEPARATOR);
define ('MODELS_PATH', APP_DIR. "Model" . DIRECTORY_SEPARATOR);
define ('HELPERS_PATH', APP_DIR. "Helpers" . DIRECTORY_SEPARATOR);
define('CONSTANTS_PATH', APP_DIR . "Constants" . DIRECTORY_SEPARATOR);
define ('WRONG_API_HIT', "Wrong API Hit");
require_once HELPERS_PATH. 'Common.php';

class AutoLoad {
  
  public function __construct() {
    Common::loadClass(CONSTANTS_PATH);
    Common::loadClass(HELPERS_PATH);
  }

  private function wrongAPiHit() {
    echo WRONG_API_HIT;
    die();
  }
  
  public function apiHandling() {
    //check for api server
    $controllerName = empty($_POST['control_type']) ? empty($_GET['control_type']) ? "" : $_GET['control_type'] : $_POST['control_type'];
    $apiRequest = empty($_POST['api_name']) ? empty($_GET['api_name']) ? "" : $_GET['api_name'] : $_POST['api_name'];
    $controllerName = ucwords($controllerName)."_Controller";
    if ($_SERVER['SERVER_NAME'] == Constants::MAIN_SERVER_URL && !empty($controllerName) && !empty($apiRequest)) {
      Common::loadClass(CONTROLLERS_PATH);
      if(file_exists(CONTROLLERS_PATH.$controllerName.".php") && method_exists($controllerName, $apiRequest)){
        $classobj = new $controllerName();
        call_user_func([$classobj, $apiRequest]);
      } else {
        $this->wrongAPiHit();
      }
    } else {
      $this->wrongAPiHit();
    }
  }
}