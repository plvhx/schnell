<?php

declare(strict_types=1);

namespace Schnell\Paginator;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface PageInterface
{
    /**
     * @return int
     */
    public function getTotalCount(): int;

    /**
     * @param int $totalCount
     * @return void
     */
    public function setTotalCount(int $totalCount): void;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @param int $page
     * @return void
     */
    public function setPage(int $page): void;

    /**
     * @return int
     */
    public function getPerPage(): int;

    /**
     * @param int $perPage
     * @return void
     */
    public function setPerPage(int $perPage): void;

    /**
     * @return int
     */
    public function getOffset(): int;

    /**
     * @param int $offset
     * @return void
     */
    public function setOffset(int $offset): void;

    /**
     * @return int
     */
    public function getTotalPage(): int;

    /**
     * @param int $totalPage
     * @return void
     */
    public function setTotalPage(int $totalPage): void;
}
