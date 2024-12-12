<?php

declare(strict_types=1);

namespace Schnell\Config\Ast;

use Schnell\Config\Ast\Visitor\VisitorInterface;

use function class_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(VisitorInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface AstInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value): void;

    /**
     * @return Schnell\Config\Ast\Visitor\VisitorInterface|null
     */
    public function getVisitor(): VisitorInterface|null;

    /**
     * @param Schnell\Config\Ast\Visitor\VisitorInterface|null $visitor
     * @return void
     */
    public function setVisitor(VisitorInterface|null $visitor): void;

    /**
     * @return array
     */
    public function getChilds(): array;

    /**
     * @param array $childs
     * @return void
     */
    public function setChilds(array $childs): void;

    /**
     * @param Schnell\Config\Ast\AstInterface $child
     * @return void
     */
    public function addChild(AstInterface $child): void;

    /**
     * @param int $index
     * @return Schnell\Config\Ast\AstInterface|null
     */
    public function getChildAt(int $index): AstInterface|null;

    /**
     * @return Schnell\Config\Ast\AstInterface|null
     */
    public function getLastChild(): AstInterface|null;

    /**
     * @return mixed
     */
    public function visit();
}
