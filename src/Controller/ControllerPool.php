<?php

declare(strict_types=1);

namespace Schnell\Controller;

use ReflectionClass;
use SplObjectStorage;
use Schnell\Attribute\Route;
use Schnell\Container;
use Schnell\Config\ConfigInterface;

use function array_map;
use function class_exists;
use function basename;
use function glob;
use function preg_match;
use function sprintf;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(ReflectionClass::class);
class_exists(SplObjectStorage::class);
class_exists(Route::class);
class_exists(Container::class);
class_exists(ConfigInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class ControllerPool implements ControllerPoolInterface
{
    /**
     * @var Schnell\Container
     */
    private $container;

    /**
     * @var SplObjectStorage
     */
    private $pool;

    /**
     * @var Schnell\Config\ConfigInterface
     */
    private $config;

    /**
     * @param Schnell\Container $container
     * @param Schnell\Config\ConfigInterface $config
     * @param SplObjectStorage $pool
     * @return static
     */
    public function __construct(
        Container $container,
        ConfigInterface $config,
        SplObjectStorage $pool
    ) {
        $this->setContainer($container);
        $this->setConfig($config);
        $this->setPool($pool);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getPool(): SplObjectStorage
    {
        return $this->pool;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoolAt(object $key)
    {
        return $this->pool[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function setPool(SplObjectStorage $pool): void
    {
        $this->pool = $pool;
    }

    /**
     * {@inheritdoc}
     */
    public function addPoolAt(object $key, $value): void
    {
        $this->pool[$key] = $value;
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
    public function collect(): void
    {
        $globPattern = sprintf(
            "%s%s*.php",
            $this->getConfig()->get('controller.path'),
            DIRECTORY_SEPARATOR
        );

        $controllerFiles = glob($globPattern);

        if (false === $controllerFiles) {
            return;
        }

        $controllerClassFn = function (string $el) {
            $ret = preg_match(
                '/(.*)(?:.php)/',
                basename($el),
                $matches
            );

            if (false === $ret) {
                return [];
            }

            return sprintf(
                "%s\\%s",
                $this->getConfig()->get('controller.namespace'),
                $matches[1]
            );
        };

        $controllerClasses = array_map($controllerClassFn, $controllerFiles);

        foreach ($controllerClasses as $controllerClass) {
            $this->resolveControllerClass($controllerClass);
        }
    }

    /**
     * @param string $name
     * @return void
     */
    private function resolveControllerClass(string $name): void
    {
        $reflection = new ReflectionClass($name);
        $ctrlInstance = $reflection->newInstance($this->getContainer());
        $classMethods = $reflection->getMethods();

        if (sizeof($classMethods) === 0) {
            return;
        }

        $routeAttr = null;

        foreach ($classMethods as $classMethod) {
            $attributes = $classMethod->getAttributes();

            if (sizeof($attributes) === 0) {
                continue;
            }

            $attrObjs = [
                'controller' => $ctrlInstance,
                'method' => $classMethod->getName()
            ];

            foreach ($attributes as $attribute) {
                if ($attribute->getName() === Route::class) {
                    $routeAttr = $attribute->newInstance();
                    $attrObjs[$routeAttr->getIdentifier()] = $routeAttr;
                    continue;
                }

                $attrObj = $attribute->newInstance();
                $attrObjs[$attrObj->getIdentifier()] = $attrObj;
            }

            $this->addPoolAt($routeAttr, $attrObjs);
        }
    }
}
