<?php


namespace Scrum\DebugInfrastructure\Persistence\UserPlans;


use App\Lib\RepositorySupports\FileRepository;
use Scrum\Domain\Models\UserPlans\UserPlan;
use Scrum\Domain\Models\UserPlans\UserPlanId;
use Scrum\Domain\Models\UserPlans\UserPlanRepositoryInterface;

class FileUserPlanRepository implements UserPlanRepositoryInterface
{
    use FileRepository;

    public function find(UserPlanId $id): ?UserPlan
    {
        $plan = $this->load($id->getValue());
        if (is_null($plan)) {
            return null;
        } else {
            return $plan;
        }
    }

    public function save(UserPlan $userPlan): void
    {
        $rawId = $userPlan->getId()->getValue();
        $this->store($rawId, $userPlan);
    }
}
