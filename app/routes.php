<?php

$app->group('/v1', function () {
    $this->get('/', '\App\Http\Controllers\WelcomeController:index');
});
