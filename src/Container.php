<?php

declare(strict_types=1);

namespace Schnell;

use DI\Container as CoreContainer;
use Schnell\Exception\NotFoundException;

use function array_key_exists;
use function call_user_func_array;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $instances = [];

    /**
     * @var array
     */
    private $aliasMap = [];

    /**
     * @var DI\Container
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function __construct(CoreContainer $container = null)
    {
        $this->container = $container ?? new CoreContainer();
    }

    /**
     * @param string $class
     * @param callable $fn
     * @param array $fnParam
     * @return void
     */
    public function registerCallback(
        string $class,
        callable $fn,
        array $fnParam
    ): void {
        $this->instances[$class] = call_user_func_array($fn, $fnParam);
    }

    /**
     * @param string $class
     * @return void
     */
    public function autowire(string $class)
    {
        $this->instances[$class] = $this->container->get($class);
    }

    /**
     * @param string $class
     * @param string $alias
     * @return void
     */
    public function alias(string $class, string $alias)
    {
        $this->aliasMap[$alias] = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $id): bool
    {
        $class = array_key_exists($id, $this->aliasMap)
            ? $this->aliasMap[$id]
            : $id;

        return array_key_exists($class, $this->instances);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf("Object with identifier '%s' not found.", $id)
            );
        }

        $className = isset($this->aliasMap[$id])
            ? $this->aliasMap[$id]
            : $id;

        return $this->instances[$className];
    }
}
