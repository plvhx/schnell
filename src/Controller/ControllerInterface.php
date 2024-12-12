<?php

declare(strict_types=1);

namespace Schnell\Controller;

use Schnell\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

use function class_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(ContainerInterface::class);
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
}
