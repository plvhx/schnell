<?php

declare(strict_types=1);

namespace Schnell\Mapper;

use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
final class Mapper implements MapperInterface
{
    /**
     * @var Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param Doctrine\ORM\EntityManagerInterface $entityManager
     * @return static
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * @return Doctrine\ORM\EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param Doctrine\ORM\EntityManagerInterface $entityManager
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
