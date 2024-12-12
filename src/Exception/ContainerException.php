<?php

declare(strict_types=1);

namespace Schnell\Exception;

use Exception;
use Psr\Container\ContainerExceptionInterface;

use function class_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(Exception::class);
class_exists(ContainerExceptionInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class ContainerException extends Exception implements ContainerExceptionInterface
{
}
