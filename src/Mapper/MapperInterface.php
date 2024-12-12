<?php

declare(strict_types=1);

namespace Schnell\Mapper;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\RequestInterface;
use Schnell\Hydrator\HydratorInterface;

use function class_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(AbstractQuery::class);
class_exists(EntityManagerInterface::class);
class_exists(RequestInterface::class);
class_exists(HydratorInterface::class);
// phpcs:enable

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
     * @return Schnell\Hydrator\HydratorInterface
     */
    public function getHydrator(): HydratorInterface;

    /**
     * @param Schnell\Hydrator\HydratorInterface $hydrator
     * @return void
     */
    public function setHydrator(HydratorInterface $hydrator): void;

    /**
     * @param Schnell\Hydrator\HydratorInterface $hydrator
     * @return Schnell\Mapper\MapperInterface
     */
    public function withHydrator(HydratorInterface $hydrator): MapperInterface;

    /**
     * @param string $entityClass
     * @return array
     */
    public function all(string $entityClass): array;
}
