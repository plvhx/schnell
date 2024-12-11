<?php

declare(strict_types=1);

namespace Schnell\Config;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
interface ConfigFactoryInterface
{
    /**
     * @param string $filename
     * @return void
     * @throws Schnell\Exception\ConfigException
     */
    public function import(string $filename): void;

    /**
     * @param array $filenames
     * @return void
     * @throws Schnell\Exception\ConfigException
     */
    public function importBulk(array $filenames): void;

    /**
     * @return Schnell\Config\ConfigInterface
     */
    public function getConfig(): ConfigInterface;
}
