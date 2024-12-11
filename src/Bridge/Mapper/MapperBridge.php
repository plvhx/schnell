<?php

declare(strict_types=1);

namespace Schnell\Bridge\Mapper;

use Doctrine\ORM\EntityManagerInterface;
use Schnell\ContainerInterface;
use Schnell\Bridge\AbstractBridge;
use Schnell\Config\ConfigInterface;
use Schnell\Exception\ExtensionException;
use Schnell\Mapper\Mapper;
use Schnell\Mapper\MapperInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class MapperBridge extends AbstractBridge
{
    /**
     * {@inheritdoc}
     */
    public function load(): void
    {
        if (false === $this->getContainer()->has(EntityManagerInterface::class)) {
            throw new ExtensionException(
                sprintf(
                    "Object instance with type '%s' not found.",
                    EntityManagerInterface::class
                )
            );
        }

        $this->getContainer()->registerCallback(
            MapperInterface::class,
            function (
                ContainerInterface $container,
                ConfigInterface $config
            ): MapperInterface {
                return new Mapper(
                    $this->getContainer()->get(EntityManagerInterface::class)
                );
            },
            [$this->getContainer(), $this->getConfig()]
        );

        $this->getContainer()->alias(MapperInterface::class, $this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'mapper';
    }
}
