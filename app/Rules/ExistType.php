<?php

namespace App\Rules;

use App\Constants\InviteTypes;
use Illuminate\Contracts\Validation\Rule;
use ReflectionClass;

class ExistType implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \ReflectionException
     */
    public function passes($attribute, $value): bool
    {
        $types = (new ReflectionClass(InviteTypes::class))->getConstants();

        return in_array($value, $types);
    }

    public function message(): string
    {
        return 'This type does not exist.';
    }
}
