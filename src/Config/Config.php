<?php

declare(strict_types=1);

namespace Schnell\Config;

use Schnell\Config\Ast\AstInterface;
use Schnell\Config\Ast\Node\NodeTypes as AstNodeTypes;

use const PREG_SPLIT_NO_EMPTY;

use function array_merge_recursive;
use function preg_split;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
final class Config implements ConfigInterface
{
    /**
     * @var Schnell\Config\Ast\AstInterface
     */
    private $ast;

    /**
     * @var array
     */
    private $map;

    /**
     * @var string|null
     */
    private $key;

    /**
     * @param Schnell\Config\Ast\AstInterface $ast
     * @return static
     */
    public function __construct(AstInterface $ast)
    {
        $this->initialize($ast, [], null);
    }

    /**
     * @param Schnell\Config\Ast\AstInterface $ast
     * @param array $map
     * @param string|null $key
     * @return void
     */
    private function initialize(
        AstInterface $ast,
        array $map,
        string|null $key
    ): void {
        $this->setAst($ast);
        $this->setMap($map);
        $this->setKey($key);
        $this->traverseAst();
    }

    /**
     * {@inheritdoc}
     */
    public function getAst(): AstInterface
    {
        return $this->ast;
    }

    /**
     * {@inheritdoc}
     */
    public function setAst(AstInterface $ast): void
    {
        $this->ast = $ast;
    }

    /**
     * {@inheritdoc}
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * {@inheritdoc}
     */
    public function setMap(array $map): void
    {
        $this->map = $map;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string|null
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function setKey(string|null $key): void
    {
        $this->key = $key;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->getProperty(
            preg_split('/[\.]+/', $name, -1, PREG_SPLIT_NO_EMPTY)
        );
    }

    /**
     * @param array $names
     * @return mixed
     */
    private function getProperty(array $names)
    {
        $map = $this->getMap();

        foreach ($names as $key => $name) {
            if (!isset($map[$name])) {
                return null;
            }

            $map = $map[$name];
        }

        return $map;
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getMapAt(string $key)
    {
        if (!isset($this->map[$key])) {
            return null;
        }

        return $this->map[$key];
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return void
     */
    private function setMapAt(string $key, $val): void
    {
        $this->map[$key] = $val;
    }

    /**
     * @return void
     */
    private function traverseAst(): void
    {
        $type = $this->getAst()
            ->getValue()
            ->getType();

        if ($type === AstNodeTypes::ROOT) {
            $this->traverseAstChilds($this->getAst()->getChilds());
        }

        $this->setKey(null);
    }

    /**
     * @param array $childs
     * @return void
     */
    private function traverseAstChilds(array $childs): void
    {
        foreach ($childs as $key => $el) {
            if ($el->getValue()->getType() === AstNodeTypes::BLOCK) {
                $this->setKey($el->visit());
                $this->setMapAt($this->getKey(), []);
                $this->traverseAstChilds($el->getChilds());
                continue;
            }

            $obj = $this->getMapAt($this->getKey());

            $this->setMapAt(
                $this->getKey(),
                array_merge_recursive($obj, $el->visit())
            );
        }
    }
}
