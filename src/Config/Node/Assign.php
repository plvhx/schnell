<?php

declare(strict_types=1);

namespace Schnell\Config\Node;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class Assign extends AbstractNode
{
    /**
     * {@inheritdoc}
     */
    public function __construct($value, int $col, int $line)
    {
        parent::__construct(NodeTypes::ASSIGN, $value, $col, $line);
    }
}
