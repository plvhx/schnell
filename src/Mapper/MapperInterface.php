<?php

declare(strict_types=1);

namespace Schnell\Mapper;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\RequestInterface;
use Schnell\Entity\Hydrator\HydratorInterface;

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

    /**
     * @return Psr\Http\Message\RequestInterface
     */
    public function getRequest(): RequestInterface;

    /**
     * @param Psr\Http\Message\RequestInterface $request
     * @return void
     */
    public function setRequest(RequestInterface $request): void;

    /**
     * @param Psr\Http\Message\RequestInterface $request
     * @return Schnell\Mapper\MapperInterface
     */
    public function withRequest(RequestInterface $request): MapperInterface;

    /**
     * @return Doctrine\ORM\AbstractQuery|null
     */
    public function getDql(): AbstractQuery|null;

    /**
     * @param Doctrine\ORM\AbstractQuery|null $dql
     * @return void
     */
    public function setDql(AbstractQuery|null $dql): void;

    /**
     * @param Doctrine\ORM\AbstractQuery|null $dql
     * @return Schnell\Mapper\MapperInterface
     */
    public function withDql(AbstractQuery|null $dql): MapperInterface;

    /**
     * @return mixed
     */
    public function runDql();

    /**
     * @return Schnell\Entity\Hydrator\HydratorInterface
     */
    public function getHydrator(): HydratorInterface;

    /**
     * @param Schnell\Entity\Hydrator\HydratorInterface $hydrator
     * @return void
     */
    public function setHydrator(HydratorInterface $hydrator): void;

    /**
     * @param Schnell\Entity\Hydrator\HydratorInterface $hydrator
     * @return Schnell\Mapper\MapperInterface
     */
    public function withHydrator(HydratorInterface $hydrator): MapperInterface;

    /**
     * @param string $entityClass
     * @return array
     */
    public function all(string $entityClass): array;
}
