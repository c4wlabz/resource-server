<?php

namespace App\Http\Controllers;

use App\Http\JsonResponse;

class WelcomeController
{
    public function index()
    {
        return new JsonResponse(['hello' => 'world']);
    }
}
