<?php

namespace Schnell\Entity\Hydrator;

use ReflectionClass;
use ReflectionProperty;
use Schnell\Entity\EntityInterface;

use function sprintf;
use function ucfirst;

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
