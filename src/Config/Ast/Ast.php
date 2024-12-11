<?php

declare(strict_types=1);

namespace Schnell\Config\Ast;

use Schnell\Config\Ast\Visitor\VisitorInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class Ast implements AstInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var Schnell\Config\Ast\Visitor\VisitorInterface
     */
    private $visitor;

    /**
     * @var array
     */
    private $childs;

    /**
     * @param mixed $value
     * @param Schnell\Config\Ast\Visitor\VisitorInterface|null $visitor
     * @return static
     */
    public function __construct($value, VisitorInterface|null $visitor)
    {
        $this->initialize($value, $visitor);
    }

    /**
     * @param mixed $value
     * @param Schnell\Config\Ast\Visitor\VisitorInterface|null $visitor
     */
    private function initialize($value, VisitorInterface|null $visitor): void
    {
        $this->setValue($value);
        $this->setVisitor($visitor);
        $this->setChilds([]);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisitor(): VisitorInterface|null
    {
        return $this->visitor;
    }

    /**
     * {@inheritdoc}
     */
    public function setVisitor(VisitorInterface|null $visitor): void
    {
        $this->visitor = $visitor;
    }

    /**
     * {@inheritdoc}
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * {@inheritdoc}
     */
    public function setChilds(array $childs): void
    {
        $this->childs = $childs;
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(AstInterface $child): void
    {
        $this->childs[] = $child;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildAt(int $index): AstInterface|null
    {
        if (!isset($this->childs[$index])) {
            return null;
        }

        return $this->childs[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function getLastChild(): AstInterface|null
    {
        return $this->getChildAt(sizeof($this->childs) - 1);
    }

    /**
     * {@inheritdoc}
     */
    public function visit()
    {
        if ($this->getVisitor() === null) {
            return null;
        }

        return $this->getVisitor()->resolve();
    }
}
