<?php


namespace Scrum\Domain\Models\User;


interface UserRepositoryInterface
{
    public function find(UserId $id): ?User;
}
