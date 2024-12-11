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
    const BLOCK = 1;

    /**
     * @var int
     */
    const IDENTIFIER = 2;

    /**
     * @var int
     */
    const INTEGER = 4;

    /**
     * @var int
     */
    const STRING = 8;

    /**
     * @var int
     */
    const ASSIGN = 16;

    /**
     * @var int
     */
    const ARRAY = 32;

    /**
     * @var int
     */
    const BOOLEAN = 64;
}
