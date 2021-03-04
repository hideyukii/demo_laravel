<?php


namespace App\Http\ViewModels\BackLog;

class BackLogIndexViewModel
{
    /** @var UserInfoViewModel */
    public $userInfo;
    /** @var UserPlanViewModel[] */
    public $userPlans;
    /** @var UserStoryViewModel[] */
    public $userStories;

    /**
     * BackLogIndexViewModel constructor.
     * @param UserInfoViewModel $userInfo
     * @param UserPlanViewModel[] $userPlans
     * @param UserStoryViewModel[] $userStories
     */
    public function __construct(UserInfoViewModel $userInfo, array $userPlans, array $userStories)
    {
        $this->userInfo = $userInfo;
        $this->userPlans = $userPlans;
        $this->userStories = $userStories;
    }
}
