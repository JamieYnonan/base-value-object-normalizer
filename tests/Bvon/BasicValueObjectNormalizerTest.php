<?php

namespace Bvon;

use BaseValueObject\Scalar\ValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class BasicValueObjectNormalizerTest extends TestCase
{
    /**
     * @var ValueObject
     */
    private $stringValueObject;

    private $notValueObject;

    /**
     * @var Serializer
     */
    private $serializer;

    public function setUp()
    {
        parent::setUp();
        $this->stringValueObject = new NameValueObject('example');
        $this->notValueObject = new \stdClass();
        $this->notValueObject->name = 'name';
        $this->serializer = new Serializer(
            [new BasicValueObjectNormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @test
     */
    public function validSupportsNormalization(): void
    {
        $this->assertTrue(
            $this->serializer->supportsNormalization($this->stringValueObject)
        );
    }

    /**
     * @test
     */
    public function invalidSupportsNormalization(): void
    {
        $this->assertFalse(
            $this->serializer->supportsNormalization($this->notValueObject)
        );
    }

    /**
     * @test
     */
    public function normalize(): void
    {
        $this->assertEquals(
            $this->stringValueObject->value(),
            $this->serializer->normalize($this->stringValueObject)
        );
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Serializer\Exception\InvalidArgumentException
     * @expectedExceptionMessage The object must implement the "BaseValueObject\Scalar\ValueObject".
     */
    public function invalidNormalize(): void
    {
        $normalizer = new BasicValueObjectNormalizer();
        $normalizer->normalize($this->notValueObject);
    }

    /**
     * @test
     */
    public function denormalize(): void
    {
        $denormalize = $this->serializer->denormalize(
            'name',
            NameValueObject::class
        );

        $this->assertInstanceOf(NameValueObject::class, $denormalize);
    }
}
