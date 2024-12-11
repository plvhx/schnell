<?php

declare(strict_types=1);

namespace Schnell\Config\Ast\Node;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface NodeTypes
{
    /**
     * @var int
     */
    const BLOCK = 1;

    /**
     * @var int
     */
    const PROPERTY = 2;

    /**
     * @var int
     */
    const ROOT = 255;
}
