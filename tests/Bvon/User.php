<?php

namespace Bvon;

class User
{
    private $name;

    public function __construct(NameValueObject $name)
    {
        $this->name = $name;
    }

    public function getName(): NameValueObject
    {
        return $this->name;
    }
}
