<?php


namespace Scrum\EloquentInfrastructure\QueryServices;


use Scrum\Application\Service\BackLog\Query\BackLogQueryServiceInterface;
use Scrum\Application\Service\BackLog\Query\UserStorySummary;

use Scrum\Domain\Models\User\UserContextInterface;
use Scrum\EloquentInfrastructure\Models\UserStoryDataModel;

class EloquentBackLogQueryService implements BackLogQueryServiceInterface
{
    /** @var UserContextInterface */
    private $userContext;

    /**
     * EloquentBackLogQueryService constructor.
     * @param UserContextInterface $userContext
     */
    public function __construct(UserContextInterface $userContext)
    {
        $this->userContext = $userContext;
    }

    function getAllUserStory(): array
    {
        $stories = UserStoryDataModel::all()
            ->map(function (UserStoryDataModel $x) {
                return new UserStorySummary(
                    $x->id,
                    $x->story,
                    $x->author,
                    $x->demo,
                    $x->estimation,
                    $x->seq
                );
            })
            ->sort(function (UserStorySummary $l, UserStorySummary $r) {
                $lIsNull = is_null($l->seq);
                $rIsNull = is_null($r->seq);

                if ($lIsNull && $rIsNull) {
                    return 0;
                }
                if ($lIsNull) {
                    return -1;
                }
                if ($rIsNull) {
                    return 1;
                }

                return $l->seq - $r->seq;
            })
            ->all();

        $plans = UserPlanDataModel::all()
            ->map(function (UserPlanDataModel $x) {
                return new UserPlanSummary(
                    $x->id,
                    $x->plan,
                    $x->author,
                    $x->demo,
                    $x->estimation,
                    $x->seq
                );
            })
            ->sort(function (UserPlanSummary $l, UserPlanSummary $r) {
                $lIsNull = is_null($l->seq);
                $rIsNull = is_null($r->seq);

                if ($lIsNull && $rIsNull) {
                    return 0;
                }
                if ($lIsNull) {
                    return -1;
                }
                if ($rIsNull) {
                    return 1;
                }

                return $l->seq - $r->seq;
            })
            ->all();

            $userInfo = $userContext->select(
                'name as user_name',
                'email as user_email',
                'p.plan',
                'p.start',
                'p.end',
                's.story'
            )->leftJoin('plans as p', function ($join) {
                $join->on('users.id', '=', 'plans.user_id')
                     ->max('id')
                     ->groupBy('user_id');
            })->leftJoin('stories as s', function ($join) {
                $join->on('users.id', '=', 'stories.user_id')
                     ->max('id')
                     ->groupBy('user_id');
            });

        $summaries = [
            'planSummaries' => $stories,
            'storySummaries' => $plans
        ];

        return $summaries;
    }
}
