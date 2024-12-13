<?php

declare(strict_types=1);

namespace Schnell\Controller;

use Schnell\ContainerInterface;
use Schnell\Paginator\PageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function class_exists;
use function interface_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(ContainerInterface::class);
interface_exists(PageInterface::class);
class_exists(ResponseInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface ControllerInterface
{
    /**
     * @return Schnell\ContainerInterface
     */
    public function getContainer(): ContainerInterface;

    /**
     * @param Schnell\ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container): void;

    /**
     * @param Psr\Http\Message\ResponseInterface $response
     * @param array $data
     * @return Psr\Http\Message\ResponseInterface
     */
    public function json(
        ResponseInterface $response,
        array $data
    ): ResponseInterface;

    /**
     * @param Psr\Http\Message\RequestInterface $request
     * @param Psr\Http\Message\ResponseInterface $response
     * @param Schnell\Paginator\PageInterface $page
     * @param array $data
     * @return Psr\Http\Message\ResponseInterface
     */
    public function hateoas(
        RequestInterface $request,
        ResponseInterface $response,
        PageInterface $page,
        array $data
    ): ResponseInterface;
}
