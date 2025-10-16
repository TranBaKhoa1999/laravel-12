<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    protected $lang = null;
    public $api = null;
    public $controllerName = null;
    public $actionName = null;
    public $request = null;

    public $_params = null;

    public function __construct(Request $request) {

        $this->request = $request;
        $this->_params = $this->request->all();
        $this->setLanguage();

    }

    //
    public function setLanguage($lang = NULL) {
        
        $this->lang = $lang;
        if($lang == NULL){
            $this->lang = $this->_params['lang'] ?? 'vi';
        }
        
        if (!in_array($this->lang, array('vi', 'en'))) {
            $this->lang = 'vi';
        }
    }
}
