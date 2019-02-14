<?php

namespace Tests\Functional;

use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * @var App $app
     */
    protected $app;

    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    public function setUp()
    {
        defined('BASE_PATH') OR define('BASE_PATH', realpath(__DIR__ . '/../../'));
        defined('STORAGE_PATH') OR define('STORAGE_PATH', realpath(__DIR__ . '/../../storage'));

        $settings = require __DIR__ . '/../../app/settings.php';

        // Instantiate the application
        $this->app = $app = new App($settings);

        // Set up dependencies
        require __DIR__ . '/../../app/dependencies.php';

        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../../app/middleware.php';
        }

        // Register routes
        require __DIR__ . '/../../app/routes.php';
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @param string|null $accessToken
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     * @return ResponseInterface
     */
    public function runApp($requestMethod, $requestUri, $requestData = null, $accessToken = null)
    {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri,
                'HTTP_ACCEPT' => 'application/json',
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $request = Request::createFromEnvironment($environment);
        if($accessToken) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $accessToken);
        }

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $response = new Response();
        $response = $this->app->process($request, $response);

        return $response;
    }
}
