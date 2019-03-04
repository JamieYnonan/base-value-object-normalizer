<?php

namespace Bvon;

use BaseValueObject\Scalar\BaseString;

class NameValueObject extends BaseString
{
    protected function setValue(string $value): void
    {
        $this->value = $value;
    }
}
