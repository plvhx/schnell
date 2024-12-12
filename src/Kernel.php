<?php

declare(strict_types=1);

namespace Schnell;

use Schnell\ContainerInterface;
use Schnell\Bridge\BridgeInterface;
use Schnell\Config\ConfigInterface;
use Schnell\Controller\ControllerResolverInterface;
use Psr\Http\Message\RequestInterface;

use function interface_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
interface_exists(ContainerInterface::class);
interface_exists(BridgeInterface::class);
interface_exists(ConfigInterface::class);
interface_exists(ControllerResolverInterface::class);
interface_exists(RequestInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
final class Kernel implements KernelInterface
{
    /**
     * @var Schnell\Config\ConfigInterface
     */
    private $config;

    /**
     * @var Schnell\ContainerInterface
     */
    private $container;

    /**
     * @var Schnell\Controller\ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * @var array
     */
    private $extensions = [];

    /**
     * @param Schnell\Config\ConfigInterface $config
     * @param Schnell\ContainerInterface $container
     * @param Schnell\Controller\ControllerResolverInterface $resolver
     * @return static
     */
    public function __construct(
        ConfigInterface $config,
        ContainerInterface $container,
        ControllerResolverInterface $controllerResolver
    ) {
        $this->setConfig($config);
        $this->setContainer($container);
        $this->setControllerResolver($controllerResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(ConfigInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerResolver(): ControllerResolverInterface
    {
        return $this->controllerResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function setControllerResolver(
        ControllerResolverInterface $controllerResolver
    ): void {
        $this->controllerResolver = $controllerResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request): void
    {
        $this->getControllerResolver()->run($request);
    }

    /**
     * {@inheritdoc}
     */
    public function addExtension(
        BridgeInterface $extension,
        string|null $basePath = null
    ): KernelInterface {
        $extension->setConfig($this->getConfig());
        $extension->setContainer($this->getContainer());
        $extension->setBasePath($basePath);

        $this->extensions[] = $extension;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load(): void
    {
        foreach ($this->extensions as $extension) {
            $extension->load();
        }
    }
}
