<?php


namespace Authorization\Domain\Users;


interface UserFactoryInterface
{
    function create(
        string $email,
        string $password,
        string $name
    ): User;
}
