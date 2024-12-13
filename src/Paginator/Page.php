<?php

declare(strict_types=1);

namespace Schnell\Paginator;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
final class Page implements PageInterface
{
    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $totalPage;

    /**
     * {@inheritdoc}
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotalCount(int $totalCount): void
    {
        $this->totalCount = $totalCount;
    }

    /**
     * {@inheritdoc}
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * {@inheritdoc}
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalPage(): int
    {
        return $this->totalPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotalPage(int $totalPage): void
    {
        $this->totalPage = $totalPage;
    }
}
