<?php

namespace app\Context;


use app\Dispatcher\Dispatcher;
use app\Request\Request;
use app\Response\Response;

class Context
{
    private $request;
    private $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function execute()
    {
        try{
            $dispatcher = new Dispatcher();
            $results = $dispatcher->dispatch($this->request);
            $this->response->setCode($results[0]);
            $this->response->setContent($results[1]);

            return true;

        } catch (\Exception $e){
            $this->response->setCode('404');
            $this->response->setContent(['error'=>$e->getTraceAsString()]);

            return false;
        }
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

}