<?php

declare(strict_types=1);

namespace Schnell\Exception;

use Psr\Container\ContainerExceptionInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class ContainerException extends Exception
                         implements ContainerExceptionInterface
{
}
