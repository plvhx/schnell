<?php

declare(strict_types=1);

namespace Schnell\Config\Node;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class Block extends AbstractNode
{
    /**
     * {@inheritdoc}
     */
    public function __construct($value, int $col, int $line)
    {
        parent::__construct(NodeTypes::BLOCK, $value, $col, $line);
    }
}
