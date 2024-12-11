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
    public const BLOCK = 1;

    /**
     * @var int
     */
    public const PROPERTY = 2;

    /**
     * @var int
     */
    public const ROOT = 255;
}
