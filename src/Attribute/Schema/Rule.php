<?php

declare(strict_types=1);

use Attribute;
use Schnell\Attribute\AttributeInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class Rule implements AttributeInterface
{
    /**
     * @var bool
     */
    private bool $required;

    /**
     * @param bool $required
     * @return static
     */
    public function __construct(bool $required)
    {
        $this->required = $required;
    }

    /**
     * @return bool
     */
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return void
     */
    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentifier(): string
    {
        return 'schema.rule';
    }
}
