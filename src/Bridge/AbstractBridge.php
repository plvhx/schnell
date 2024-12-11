<?php

declare(strict_types=1);

namespace Schnell\Bridge;

use Schnell\ContainerInterface;
use Schnell\Config\ConfigInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
abstract class AbstractBridge implements BridgeInterface
{
    /**
     * @var Schnell\Config\ConfigInterface|null
     */
    private $config;

    /**
     * @var Schnell\ContainerInterface|null
     */
    private $container;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @param Schnell\Config\ConfigInterface|null $config
     * @param Schnell\ContainerInterface|null $container
     * @param string $basePath
     * @return static
     */
    public function __construct(
        ConfigInterface|null $config = null,
        ContainerInterface|null $container = null,
        string $basePath = null,
    ) {
        $this->setConfig($config);
        $this->setContainer($container);
        $this->setBasePath($basePath);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): ConfigInterface|null
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(ConfigInterface|null $config): void
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer(): ContainerInterface|null
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface|null $container): void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getBasePath(): string|null
    {
        return $this->basePath;
    }

    /**
     * {@inheritdoc}
     */
    public function setBasePath(string|null $basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function load(): void;

    /**
     * {@inheritdoc}
     */
    abstract public function getAlias(): string;
}
