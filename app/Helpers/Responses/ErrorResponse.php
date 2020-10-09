<?php

namespace App\Helpers\Responses;

class ErrorResponse
{
    protected $code;
    protected $messages;

    function __construct($code, $messages)
    {
        $this->code = $code;
        $this->messages = $messages;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}