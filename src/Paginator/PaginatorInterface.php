<?php

declare(strict_types=1);

namespace Schnell\Paginator;

use Psr\Http\Message\RequestInterface;

use function interface_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
interface_exists(RequestInterface::class);
// phpcs:enable

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface PaginatorInterface
{
    /**
     * @return int
     */
    public function getTotalRows(): int;

    /**
     * @param int $totalRows
     * @return void
     */
    public function setTotalRows(int $totalRows): void;

    /**
     * @param Psr\Http\Message\RequestInterface $request
     * @return Schnell\Pagination\PageInterface
     */
    public function getMetadata(RequestInterface $request): PageInterface;
}
