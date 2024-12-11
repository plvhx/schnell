<?php

declare(strict_types=1);

namespace Schnell\Controller;

use Schnell\Attribute\Route;
use Schnell\Controller\ControllerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Middleware\BodyParsingMiddleware;
use Slim\Middleware\ErrorMiddleware;
use Slim\Middleware\RoutingMiddleware;

use function is_a;
use function is_array;
use function sprintf;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class ControllerResolver implements ControllerResolverInterface
{
    /**
     * @var Schnell\Controller\ControllerPoolInterface
     */
    private $controllerPool;

    /**
     * @var Slim\Interfaces\RouteCollectorProxyInterface
     */
    private $routeCollectorProxy;

    /**
     * @param Schnell\Controller\ControllerPoolInterface $controllerPool
     * @param Slim\Interfaces\RouteCollectorProxyInterface $routeCollectorProxy
     * @return static
     */
    public function __construct(
        ControllerPoolInterface $controllerPool,
        RouteCollectorProxyInterface $routeCollectorProxy
    ) {
        $this->setControllerPool($controllerPool);
        $this->setRouteCollectorProxy($routeCollectorProxy);
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerPool(): ControllerPoolInterface
    {
        return $this->controllerPool;
    }

    /**
     * {@inheritdoc}
     */
    public function setControllerPool(
        ControllerPoolInterface $controllerPool
    ): void {
        $this->controllerPool = $controllerPool;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollectorProxy(): RouteCollectorProxyInterface
    {
        return $this->routeCollectorProxy;
    }

    /**
     * {@inheritdoc}
     */
    public function setRouteCollectorProxy(
        RouteCollectorProxyInterface $routeCollectorProxy
    ): void {
        $this->routeCollectorProxy = $routeCollectorProxy;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(ServerRequestInterface $request): void
    {
        foreach ($this->getControllerPool()->getPool() as $key)
            $this->resolveSingle(
                $this->getControllerPool()->getPoolAt($key),
                $request
            );
    }

    /**
     * {@inheritdoc}
     */
    public function add(MiddlewareInterface $middleware): void
    {
        $this->getRouteCollectorProxy()->add($middleware);
    }

    /**
     * @param array $value
     * @param Psr\Http\Message\ServerRequestInterface $request
     * @return void
     */
    private function resolveSingle(
        array $value,
        ServerRequestInterface $request
    ): void {
        if (!isset($value['route']) || !is_a($value['route'], Route::class))
            throw new ControllerResolverException(
                sprintf(
                    "Route object is undefined or not an " .
                    "instance of '%s'.",
                    Route::class
                )
            );

        if (!isset($value['controller']) ||
            !is_a($value['controller'], ControllerInterface::class))
            throw new ControllerResolverException(
                sprintf(
                    "Controller object is undefined or not an " .
                    "instance of '%s'.",
                    ControllerInterface::class
                )
            );

        $this->getRouteCollectorProxy()->map(
            is_array($value['route']->getMethod())
                ? $value['route']->getMethod()
                : [$value['route']->getMethod()],
            $value['route']->getUrl(),
            [$value['controller'], $value['method']]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function run(?ServerRequestInterface $request = null): void
    {
        $this->getRouteCollectorProxy()->run($request);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->getRouteCollectorProxy()->handle($request);
    }

    /**
     * {@inheritdoc}
     */
    public function addRoutingMiddleware(): RoutingMiddleware
    {
        return $this->getRouteCollectorProxy()->addRoutingMiddleware();
    }

    /**
     * {@inheritdoc}
     */
    public function addBodyParsingMiddleware(
        array $bodyParsers = []
    ): BodyParsingMiddleware {
        return $this->getRouteCollectorProxy()
            ->addBodyParsingMiddleware($bodyParsers);
    }

    /**
     * {@inheritdoc}
     */
    public function addErrorMiddleware(
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ): ErrorMiddleware {
        return $this->getRouteCollectorProxy()->addErrorMiddleware(
            $displayErrorDetails,
            $logErrors,
            $logErrorDetails,
            $logger
        );
    }
}
