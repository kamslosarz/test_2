<?php


namespace app;

use app\Context\Context;

class Application
{
    public function __invoke()
    {
        $context = new Context();
        $context->execute();

        return $context->getResponse();
    }
}