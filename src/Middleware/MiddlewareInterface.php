<?php

declare(strict_types=1);

namespace Schnell\Middleware;

use Schnell\Controller\ControllerPoolInterface;
use Psr\Http\Server\MiddlewareInterface as PsrMiddlewareInterface;

use function class_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(ControllerPoolInterface::class);
class_exists(PsrMiddlewareInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface MiddlewareInterface extends PsrMiddlewareInterface
{
    /**
     * @return Schnell\Controller\ControllerPoolInterface
     */
    public function getControllerPool(): ControllerPoolInterface;

    /**
     * @param Schnell\Controller\ControllerPoolInterface $controllerPool
     * @return void
     */
    public function setControllerPool(
        ControllerPoolInterface $controllerPool
    ): void;
}
