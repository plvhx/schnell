<?php

declare(strict_types=1);

namespace Schnell\Bridge\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Schnell\ContainerInterface;
use Schnell\Bridge\AbstractBridge;
use Schnell\Config\ConfigInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

use function array_map;
use function sprintf;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
class DoctrineBridge extends AbstractBridge
{
    /**
     * {@inheritdoc}
     */
    public function load(): void
    {
        $this->getContainer()->registerCallback(
            EntityManagerInterface::class,
            function(
                ContainerInterface $container,
                ConfigInterface $config
            ): EntityManagerInterface {
                $cacheDir = sprintf(
                    "%s%s%s",
                    $this->getBasePath(),
                    DIRECTORY_SEPARATOR,
                    $config->get('doctrine.cache_dir')
                );

                $cache = $config->get('doctrine.dev_mode')
                    ? new ArrayAdapter()
                    : new FilesystemAdapter(
                        directory: $cacheDir
                      );

                $metadataFn = function(string $path): string {
                    return sprintf(
                        "%s%s%s",
                        $this->getBasePath(),
                        DIRECTORY_SEPARATOR,
                        $path
                    );
                };

                $ormConf = ORMSetup::createAttributeMetadataConfiguration(
                    array_map($metadataFn, $config->get('doctrine.metadata_dirs')),
                    $config->get('doctrine.dev_mode'),
                    null,
                    $cache
                );

                $options = [
                    'driver' => $config->get('database.driver'),
                    'host' => $config->get('database.host'),
                    'port' => $config->get('database.port'),
                    'dbname' => $config->get('database.schema'),
                    'user' => $config->get('database.user'),
                    'password' => $config->get('database.password'),
                    'charset' => $config->get('database.charset')
                ];

                return new EntityManager(
                    DriverManager::getConnection($options),
                    $ormConf
                );
            },
            [$this->getContainer(), $this->getConfig()]
        );

        $this->getContainer()->alias(
            EntityManagerInterface::class,
            $this->getAlias()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'entity-manager';
    }
}
