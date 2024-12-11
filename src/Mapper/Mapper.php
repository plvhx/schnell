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
final class Mapper implements MapperInterface
{
    /**
     * @var Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Psr\Http\Message\RequestInterface
     */
    private $request;

    /**
     * @var Doctrine\ORM\AbstractQuery
     */
    private $dql;

    /**
     * @var Schnell\Hydrator\HydratorInterface
     */
    private $hydrator;

    /**
     * @param Doctrine\ORM\EntityManagerInterface $entityManager
     * @return static
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->setDql(null);
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

    /**
     * {@inheritdoc}
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function withRequest(RequestInterface $request): MapperInterface
    {
        $ret = clone $this;
        $ret->setRequest($request);
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function getDql(): AbstractQuery|null
    {
        return $this->dql;
    }

    /**
     * {@inheritdoc}
     */
    public function setDql(AbstractQuery|null $dql): void
    {
        $this->dql = $dql;
    }

    /**
     * {@inheritdoc}
     */
    public function withDql(AbstractQuery|null $dql): MapperInterface
    {
        $ret = clone $this;
        $ret->setDql($dql);
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function runDql()
    {
        return $this->getDql()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * {@inheritdoc}
     */
    public function setHydrator(HydratorInterface $hydrator): void
    {
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritdoc}
     */
    public function withHydrator(HydratorInterface $hydrator): MapperInterface
    {
        $ret = clone $this;
        $ret->setHydrator($hydrator);
        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function all(string $entityClass): array
    {
        $hydrator = $this->getHydrator();
        $result = $this->getEntityManager()
            ->getRepository($entityClass)
            ->findAll();

        return $hydrator === null
            ? $result
            : $hydrator->hydrate($result);
    }
}
