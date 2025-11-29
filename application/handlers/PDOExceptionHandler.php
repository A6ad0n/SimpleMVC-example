<?php
namespace application\handlers;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Interfaces\ExceptionHandlerInterface;

/**
 * Пример пользовательского класса для перехвата исключений
 */
class PDOExceptionHandler implements ExceptionHandlerInterface
{
    public function handleException(\Exception $exception): void
    {
        $this->displayException($exception);
    }

    public function displayException($exception)
    {   
        $route = "PDOError/";
        $Router = Config::getObject('core.router.class');
        $Router->callControllerAction($route, $exception);        
    }
}