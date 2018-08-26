<?php

namespace app\Dispatcher;


use app\Controller\Controller;
use app\Request\Request;

class Dispatcher
{

    public function dispatch(Request $request)
    {
        $controller = new Controller($request);
        $action = preg_replace("/[^a-z]/", '', $request->getRequestUri());

        if(method_exists($controller, $action)){
            return $controller->{$action}();
        }

        throw new \Exception('Invalid controller action');
    }

}