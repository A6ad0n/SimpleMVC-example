<?php

namespace application\controllers;
use ItForFree\SimpleMVC\Config;

class AuthController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public function indexAction() 
    {
        $jsonInput = file_get_contents('php://input');
        $data = json_decode($jsonInput, true);
        $route = $data['route'];
        $User = Config::getObject('core.user.class');
        $preparedData = $User->isAllowed($route);
         if ($this->isApiRequested()) {
            $this->sendApiResponse([$preparedData]);
         }
    }
}
