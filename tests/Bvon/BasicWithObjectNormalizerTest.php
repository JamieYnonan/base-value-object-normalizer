<?php

namespace Bvon;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BasicWithObjectNormalizerTest extends TestCase
{
    /**
     * @var Serializer
     */
    private $serializer;

    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = new User(new NameValueObject('UserName'));
        $this->serializer = new Serializer(
            [new BasicValueObjectNormalizer(), new ObjectNormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @test
     */
    public function normalize(): void
    {
        $this->assertEquals(
            ['name' => 'UserName'],
            $this->serializer->normalize($this->user)
        );
    }

    /**
     * @test
     */
    public function denormalize(): void
    {
        $denormalize = $this->serializer->denormalize(
            ['name' => 'UserName'],
            User::class
        );

        $this->assertInstanceOf(User::class, $denormalize);
        $this->assertEquals('UserName', $denormalize->getName());
    }
}
