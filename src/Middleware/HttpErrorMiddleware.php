<?php

declare(strict_types=1);

namespace Schnell\Middleware;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Schnell\Controller\ControllerPoolInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

use function json_encode;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class HttpErrorMiddleware implements MiddlewareInterface
{
    /**
     * @var Schnell\Controller\ControllerPoolInterface
     */
    private $controllerPool;

    /**
     * @param ControllerPoolInterface $controllerPool
     * @return static
     */
    public function __construct(ControllerPoolInterface $controllerPool)
    {
        $this->setControllerPool($controllerPool);
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
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return $e instanceof HttpNotFoundException
                ? $this->handleHttpNotFound($e)
                : $this->handleException($e);
        }
    }

    /**
     * @param Throwable $e
     * @return Psr\Http\Message\ResponseInterface
     */
    private function handleHttpNotFound(Throwable $e): ResponseInterface
    {
        $response = new Response();
        $responseData = [
            'code' => $e->getCode(),
            'path' => $e->getRequest()->getUri()->getPath(),
            'message' => $e->getMessage()
        ];

        $response->getBody()
            ->write(json_encode($responseData));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($e->getCode(), $e->getMessage());
    }

    /**
     * @param Throwable $e
     * @return Psr\Http\Message\ResponseInterface
     */
    private function handleException(Throwable $e): ResponseInterface
    {
        $response = new Response();
        $responseData = [
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        ];

        $response->getBody()
            ->write(json_encode($responseData));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($e->getCode(), $e->getMessage());
    }
}
