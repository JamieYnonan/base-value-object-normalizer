<?php

namespace Bvon;

use BaseValueObject\Scalar\ValueObject;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BasicValueObjectNormalizer implements
    NormalizerInterface,
    DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$object instanceof ValueObject) {
            throw new InvalidArgumentException(
                sprintf(
                    'The object must implement the "%s".',
                    ValueObject::class
                )
            );
        }

        return $object->value();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ValueObject;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(
        $data,
        $class,
        $format = null,
        array $context = []
    ) {
        return new $class($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return (new \ReflectionClass($type))
            ->implementsInterface(ValueObject::class);
    }
}
