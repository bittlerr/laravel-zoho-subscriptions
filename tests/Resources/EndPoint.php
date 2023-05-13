<?php

namespace ZohoSubscriptions\Tests\Resources;

class EndPoint
{
    protected $clientId = '';
    protected $clientSecret = '';

    protected $endPoints = [
        'methods' => [
            'find' => [],
            'get' => [],
            'post' => [],
            'put' => [],
            'patch' => [],
            'delete' => [],
        ],
    ];

    public function authenticate($token)
    {
    }

    public function processEndPoint($method, $endPoint)
    {
        if ($this->hasEndPoint($method, $endPoint)) {
            $this->retreieveData($method, $endPoint);
        }
    }

    public function hasEndPoint(string $method, string $endPoint)
    {
        if (isset($this->endPoints[$method]) && isset($this->endPoints[$method][$endPoint])) {
            return true;
        }

        return false;
    }

    public function retreieveData($method, $endPoint)
    {
        $function = $this->endPoints[$method][$endPoint];

        return $this->$function();
    }
}
