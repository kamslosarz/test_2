<?php

namespace app\Request;


class Request
{
    private $get;
    private $post;
    private $requestUri;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->requestUri = $_SERVER['REQUEST_URI'];
    }

    public function getGet()
    {
        return $this->get;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

}