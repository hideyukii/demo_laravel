<?php


namespace Scrum\EloquentInfrastructure\Persistence\UserStories;


use Scrum\Domain\Models\User\UserId;
use Scrum\Domain\Models\UserPlans\UserPlan;
use Scrum\Domain\Models\UserPlans\UserPlanId;
use Scrum\Domain\Models\UserPlans\UserPlanRepositoryInterface;
use Scrum\EloquentInfrastructure\Models\UserPlanDataModel;

class EloquentUserPlanRepository implements UserPlanRepositoryInterface
{
    public function find(UserPlanId $id): ?UserPlan
    {
        $data = UserPlanDataModel::where("id", $id->getValue())
            ->first();

        if (is_null($data)) {
            return null;
        }

        return new UserPlan(
            new UserPlanId($data->id),
            $data->plan,
            new UserId($data->author),
            $data->start,
            $data->end,
            $data->estimation,
            $data->seq
        );
    }

    public function save(UserPlan $userPlan): void
    {
        UserPlanDataModel::updateOrCreate(
            ["id" => $userPlan->getId()->getValue()],
            [
                "plan" => $userPlan->getPlan(),
                "author" => $userPlan->getAuthor()->getValue(),
                "start" => $userPlan->getStart(),
                "end" => $userPlan->getEnd(),
                "estimation" => $userPlan->getEstimation(),
                "seq" => $userPlan->getSeq()
            ]
        );
    }
}
