<?php

declare(strict_types=1);

namespace Schnell\Config\Ast\Visitor;

use Schnell\Config\Ast\AstInterface;

use function class_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(AstInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
abstract class AbstractVisitor implements VisitorInterface
{
    /**
     * @var Schnell\Config\Ast\AstInterface
     */
    protected $ast;

    /**
     * @param Schnell\Config\Ast\AstInterface $ast
     * @return static
     */
    public function __construct(AstInterface $ast)
    {
        $this->ast = $ast;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}
