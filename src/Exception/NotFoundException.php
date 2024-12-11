<?php

declare(strict_types=1);

namespace Schnell\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class NotFoundException extends Exception
                        implements NotFoundExceptionInterface
{
}
