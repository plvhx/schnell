<?php

declare(strict_types=1);

namespace Schnell\Attribute\Routing;

use Attribute;
use Schnell\Attribute\AttributeInterface;

/**
 * @author Paulus Gandung Prakosa <gandung@infradead.org>
 */
#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class Route implements AttributeInterface
{
    /**
     * @var string|null
     */
    private $url;

    /**
     * @var array|string
     */
    private $method;

    /**
     * @param string|null $url
     * @param array|string $method
     * @return static
     */
    public function __construct(
        string|null $url,
        array|string $method
    ) {
        $this->setUrl($url);
        $this->setMethod($method);
    }

    /**
     * @return string|null
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return void
     */
    public function setUrl(string|null $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array|string
     */
    public function getMethod(): array|string
    {
        return $this->method;
    }

    /**
     * @param array|string $method
     * @return void
     */
    public function setMethod(array|string $method): void
    {
        $this->method = $method;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentifier(): string
    {
        return 'routing.route';
    }
}
