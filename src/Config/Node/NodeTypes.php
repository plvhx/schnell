<?php

declare(strict_types=1);

namespace Schnell\Config\Node;

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
    public const IDENTIFIER = 2;

    /**
     * @var int
     */
    public const INTEGER = 4;

    /**
     * @var int
     */
    public const STRING = 8;

    /**
     * @var int
     */
    public const ASSIGN = 16;

    /**
     * @var int
     */
    public const ARRAY = 32;

    /**
     * @var int
     */
    public const BOOLEAN = 64;
}
