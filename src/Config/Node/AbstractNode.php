<?php

declare(strict_types=1);

namespace Schnell\Config\Node;

use function get_class;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
abstract class AbstractNode implements NodeInterface
{
    /**
     * @var int
     */
    private $type;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var int
     */
    private $column;

    /**
     * @var int
     */
    private $line;

    /**
     * {@inheritdoc}
     */
    public function __construct(int $type, $value, int $column, int $line)
    {
        $this->type = $type;
        $this->value = $value;
        $this->column = $column;
        $this->line = $line;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getLineNumber(): int
    {
        return $this->line;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnNumber(): int
    {
        return $this->column;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return sprintf(
            "%s(%d, %s, %d, %d)",
            get_class($this),
            $this->getType(),
            $this->getValueAsString(),
            $this->getColumnNumber(),
            $this->getLineNumber()
        );
    }
}
