<?php


namespace Scrum\DebugInfrastructure\QueryServices;


use Scrum\Application\Service\BackLog\Query\BackLogQueryServiceInterface;
use Scrum\Application\Service\BackLog\Query\UserInfoSummary;
use Scrum\Application\Service\BackLog\Query\UserPlanSummary;
use Scrum\Application\Service\BackLog\Query\UserStorySummary;
use Scrum\Domain\Models\User\UserContextInterface;
use Authorization\Domain\Users\User;
use Authorization\Domain\Users\UserId;
use Scrum\DebugInfrastructure\Persistence\UserStories\FileUserStoryRepository;
use Scrum\Domain\Models\UserStories\UserStory;
use Scrum\DebugInfrastructure\Persistence\UserPlans\FileUserPlanRepository;
use Scrum\Domain\Models\UserPlans\UserPlan;
use Scrum\Domain\Models\User\UserInfo;

/**
 * Command Query Responsibility Segregationのためのサービス(参照型のみ)
 */
class FileBackLogQueryService implements BackLogQueryServiceInterface
{
    /** @var UserContextInterface */
    private $userContext;
    /** @var FilePlanRepository */
    private $userPlanRepository;
    /** @var FileStoryRepository */
    private $userStoryRepository;

    /**
     * FileBackLogQueryService constructor.
     * @param UserContextInterface $userContext
     * @param FileUserPlanRepository $userPlanRepository
     * @param FileUserStoryRepository $userStoryRepository
     */
    public function __construct(
        UserContextInterface $userContext,
        FileUserPlanRepository $userPlanRepository,
        FileUserStoryRepository $userStoryRepository
    ) {
        $this->userContext = $userContext;
        $this->userPlanRepository = $userPlanRepository;
        $this->userStoryRepository = $userStoryRepository;
    }

    function getAllUserInfo(): array
    {
        $userPlanAll = $this->userPlanRepository->loadAll();
        $userStoryAll = $this->userStoryRepository->loadAll();

        $planSummaries = array_map(function (UserPlan $plan) {
            return new UserPlanSummary(
                $plan->getId()->getValue(),
                $plan->getPlan(),
                $plan->getAuthor()->getValue(),
                $plan->getStart(),
                $plan->getEnd(),
                $plan->getEstimation(),
                $plan->getSeq()
            );
        }, $userPlanAll);

        $storySummaries = array_map(function (UserStory $story) {
            return new UserStorySummary(
                $story->getId()->getValue(),
                $story->getStory(),
                $story->getAuthor()->getValue(),
                $story->getDemo(),
                $story->getEstimation(),
                $story->getSeq()
            );
        }, $userStoryAll);

        // 最新のレコード
        $resentUserStory = end($userStoryAll);
        $resentUserPlan = end($userPlanAll);

        // summaryにして、Domainではなく、ServiceQuery側に置いたほうがいい？（このserviceのみで使用の場合は、ここの方がいいかも）
        // $userInfoSummary =  new UserInfoSummary (
        //     $this->userContext->getId()->getValue(),
        //     $this->userContext->getName()->getValue(),
        //     $resentUserStory->getStory(),
        //     $resentUserPlan->getPlan(),
        //     $resentUserPlan->getStart(),
        //     $resentUserPlan->getEnd(),
        // );

        // こっちはDomain側に置いてみた（service→domain依存はOK、逆はNGの観点）
        $userInfo =  new UserInfo (
            $this->userContext->getId(),
            $this->userContext->getName()->getValue(),
            $resentUserStory->getStory(),
            $resentUserPlan->getPlan(),
            $resentUserPlan->getStart(),
            $resentUserPlan->getEnd(),
        );

        $summaries = [
            'userInfo' => $userInfo,
            'planSummaries' => $planSummaries,
            'storySummaries' => $storySummaries
        ];

        return $summaries;
    }
}
