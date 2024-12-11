<?php

declare(strict_types=1);

namespace Schnell\Config\Node;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface NodeInterface
{
    /**
     * @return int
     */
    public function getType(): int;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return int
     */
    public function getLineNumber(): int;

    /**
     * @return int
     */
    public function getColumnNumber(): int;

    /**
     * @return string
     */
    //public function getValueAsString(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
