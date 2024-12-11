<?php

declare(strict_types=1);

namespace Schnell\Controller;

use Schnell\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
abstract class AbstractController implements ControllerInterface
{
    /**
     * @var Schnell\ContainerInterface
     */
    private $container;

    /**
     * @param Schnell\ContainerInterface $container
     * @return static
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function json(
        ResponseInterface $response,
        array $data
    ): ResponseInterface {
        $response->getBody()
            ->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
