<?php

declare(strict_types=1);

namespace Schnell\Attribute\Entity;

use Attribute;
use Throwable;
use Schnell\Attribute\AttributeInterface;
use Schnell\Entity\EntityInterface;
use Schnell\Mapper\Query\Error as QueryError;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS)]
class GeneratedError implements AttributeInterface
{
    use GeneratedErrorTrait;

    /**
     * @var string|null
     */
    private ?string $targetColumn;

    /**
     * @var \Schnell\Entity\EntityInterface|null
     */
    private ?EntityInterface $entity;

    /**
     * @var string
     */
    private string $sqlState;

    /**
     * @var string
     */
    private string $sqlStatePrefix;

    /**
     * @param string $sqlStatePrefix
     * @param string|null $targetColumn
     * @param \Schnell\Entity\EntityInterface|null $entity
     * @param string $sqlState
     * @return static
     */
    public function __construct(
        string $sqlStatePrefix,
        ?string $targetColumn = null,
        ?EntityInterface $entity = null,
        string $sqlState = ''
    ) {
        $this->targetColumn = $targetColumn;
        $this->entity = $entity;
        $this->sqlState = $sqlState;
        $this->sqlStatePrefix = $sqlStatePrefix;
    }

    /**
     * @return string|null
     */
    public function getTargetColumn(): ?string
    {
        return $this->targetColumn;
    }

    /**
     * @param string|null $targetColumn
     * @return void
     */
    public function setTargetColumn(?string $targetColumn): void
    {
        $this->targetColumn = $targetColumn;
    }

    /**
     * @return \Schnell\Entity\EntityInterface|null
     */
    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    /**
     * @param \Schnell\Entity\EntityInterface|null $entity
     * @return void
     */
    public function setEntity(?EntityInterface $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getSqlState(): string
    {
        return $this->sqlState;
    }

    /**
     * @param string $sqlState
     * @return void
     */
    public function setSqlState(string $sqlState): void
    {
        $this->sqlState = $sqlState;
    }

    /**
     * @return string
     */
    public function getSqlStatePrefix(): string
    {
        return $this->sqlStatePrefix;
    }

    /**
     * @param string $sqlStatePrefix
     * @return void
     */
    public function setSqlStatePrefix(string $sqlStatePrefix): void
    {
        $this->sqlStatePrefix = $sqlStatePrefix;
    }

    /**
     * @return bool
     */
    public function checkSqlState(): bool
    {
        return substr($this->getSqlState(), 0, 2) === $this->getSqlStatePrefix();
    }

    /**
     * @return \Throwable|null
     */
    public function generateException(): ?Throwable
    {
        if (false === $this->checkSqlState()) {
            return null;
        }

        switch ($this->getSqlStatePrefix()) {
            case QueryError::SQLSTATE_PREF27:
                return $this->handleIntegrityConstraintViolation();
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentifier(): string
    {
        return 'entity.generatedError';
    }
}
