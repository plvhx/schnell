<?php

declare(strict_types=1);

namespace Schnell\Entity;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface EntityInterface
{
    /**
     * @return string
     */
    public function getQueryBuilderAlias(): string;
}
