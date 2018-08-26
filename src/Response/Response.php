<?php

namespace app\Response;


class Response
{
    const BAD_REQUEST = 404;
    const OK = 200;
    const CODES = [
        201 => 'HTTP/1.1 201 OK',
        404 => 'HTTP/1.1 404 Not Found'
    ];

    private $content = [];
    private $headers = [];
    private $code = 200;


    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setCode($code)
    {

        $this->code = $code;

        return $this;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;

        return $this;
    }

    public function send()
    {
        foreach ($this->headers as $header) {
            Header($header);
        }

        if (isset(self::CODES[$this->code])) {
            header(self::CODES[$this->code], true, $this->code);
        } else {
            header(self::CODES[404], true, $this->code);
        }

        echo json_encode($this->content);

        exit;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getContent()
    {
        return $this->content;
    }
}