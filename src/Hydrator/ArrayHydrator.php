<?php

namespace Schnell\Hydrator;

use ReflectionClass;
use ReflectionProperty;
use Schnell\Entity\EntityInterface;

use function class_exists;
use function sprintf;
use function ucfirst;

// help opcache.preload discover always-needed symbols
// phpcs:disable
class_exists(ReflectionClass::class);
class_exists(ReflectionProperty::class);
// phpcs:enable

class ArrayHydrator implements HydratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate($value)
    {
        $ret = [];

        foreach ($value as $data) {
            $ret[] = $this->hydrateSingle($data);
        }

        return $ret;
    }

    /**
     * @param Schnell\Entity\EntityInterface $entity
     * @return array
     */
    private function hydrateSingle(EntityInterface $entity): array
    {
        $hydrated = [];
        $reflection = new ReflectionClass($entity);
        $fields = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

        foreach ($fields as $field) {
            $hydrated[$field->getName()] = call_user_func(
                [$entity, sprintf('get%s', ucfirst($field->getName()))]
            );
        }

        return $hydrated;
    }
}
