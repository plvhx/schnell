<?php

declare(strict_types=1);

namespace Schnell\Mapper;

use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface MapperInterface
{
    /**
     * @return Doctrine\ORM\EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;

    /**
     * @param Doctrine\ORM\EntityManagerInterface $entityManager
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void;
}
