<?php


namespace Scrum\Domain\Models\UserPlans;


interface UserPlanRepositoryInterface
{
    public function find(UserPlanId $id): ?UserPlan;

    public function save(UserPlan $userPlan): void;
}
