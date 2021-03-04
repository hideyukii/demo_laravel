<?php


namespace Scrum\Domain\Models\User;


use Basic\DomainSupport\ValueObjects\StringValueObject;

class UserName extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
