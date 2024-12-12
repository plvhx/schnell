<?php

declare(strict_types=1);

namespace Schnell;

use Psr\Container\ContainerInterface as PsrContainerInterface;

use function interface_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
interface_exists(PsrContainerInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface ContainerInterface extends PsrContainerInterface
{
}
