<?php

declare(strict_types=1);

namespace Schnell\Attribute\Schema;

use Attribute;
use Schnell\Attribute\AttributeInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class Enum implements AttributeInterface
{
    /**
     * @var array
     */
    private array $value;

    /**
     * @param array $value
     * @return static
     */
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * @param array $value
     * @return void
     */
    public function setValue(array $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'schema.enum';
    }
}
