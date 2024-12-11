<?php

declare(strict_types=1);

namespace Schnell\Entity\Hydrator;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface HydratorInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function hydrate($value);
}
