<?php

declare(strict_types=1);

namespace Schnell\Entity;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function getQueryBuilderAlias(): string;
}
