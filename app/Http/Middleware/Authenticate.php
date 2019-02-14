<?php

namespace App\Http\Middleware;

use App\Repositories\AccessTokenRepository;

class Authenticate
{
    /**
     * Middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $accessTokenRepository = new AccessTokenRepository();
        $publicKeyPath = STORAGE_PATH . '/oauth-public.key';

        $server = new \League\OAuth2\Server\ResourceServer(
            $accessTokenRepository,
            $publicKeyPath
        );

        $middleware = new \League\OAuth2\Server\Middleware\ResourceServerMiddleware($server);
        return $middleware->__invoke($request, $response, $next);
    }
}
