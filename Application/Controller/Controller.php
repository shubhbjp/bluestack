<?php
class Controller {    
    
    public function __construct()  {
      Common::loadClass(MODELS_PATH);
      Common::loadClass(MODULES_PATH);
    }
    
    public function apiCheck() {
        
    }
}