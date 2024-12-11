<?php

declare(strict_types=1);

namespace Schnell\Attribute;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface AttributeInterface
{
    /**
     * @return string
     */
    public function getIdentifier(): string;
}
