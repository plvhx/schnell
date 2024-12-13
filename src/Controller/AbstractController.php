<?php

declare(strict_types=1);

namespace Schnell\Controller;

use Schnell\ContainerInterface;
use Schnell\Hateoas\Hateoas;
use Schnell\Paginator\PageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function class_exists;
use function interface_exists;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(ContainerInterface::class);
class_exists(Hateoas::class);
interface_exists(PageInterface::class);
class_exists(ResponseInterface::class);
// phpcs:enable

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

    /**
     * {@inheritdoc}
     */
    public function hateoas(
        RequestInterface $request,
        ResponseInterface $response,
        PageInterface $page,
        array $data
    ): ResponseInterface {
        return $this->json(
            $response,
            (new Hateoas($data, $page, $request))->generate()
        );
    }
}
