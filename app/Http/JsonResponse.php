<?php

namespace App\Http;

use Slim\Http\Response;
use Slim\Http\StatusCode;

class JsonResponse extends Response
{
    public function __construct(array $data = [], $status = StatusCode::HTTP_OK)
    {
        parent::__construct($status);
        $this->getBody()->write(json_encode($data));
        $this->headers['Content-Type'] = 'application/json';
    }
}
