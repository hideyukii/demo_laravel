<?php

namespace Scrum\Application\Service\BackLog;

use Basic\Exception\NotFoundException;
use Basic\Transaction\Transaction;
use Scrum\Domain\Models\User\UserContextInterface;
use Scrum\Domain\Models\UserStories\UserStory;
use Scrum\Domain\Models\UserStories\UserStoryId;
use Scrum\Domain\Models\UserStories\UserStoryRepositoryInterface;
use Scrum\Domain\Models\UserPlans\UserPlan;
use Scrum\Domain\Models\UserPlans\UserPlanId;
use Scrum\Domain\Models\UserPlans\UserPlanRepositoryInterface;

class BackLogApplicationService
{
    /** @var Transaction */
    private $transaction;
    /** @var UserContextInterface */
    private $userContext;
    /** @var UserStoryRepositoryInterface */
    private $userStoryRepository;
    /** @var UserPlanRepositoryInterface */
    private $userPlanRepositor;

    /**
     * BackLogApplicationService constructor.
     * @param UserStoryRepositoryInterface $userStoryRepository
     * @param Transaction $transaction
     * @param UserContextInterface $userContext
     */
    public function __construct(
        Transaction $transaction,
        UserContextInterface $userContext,
        UserStoryRepositoryInterface $userStoryRepository,
        UserPlanRepositoryInterface $userPlanRepository)
    {
        $this->transaction = $transaction;
        $this->userContext = $userContext;
        $this->userStoryRepository = $userStoryRepository;
        $this->userPlanRepository = $userPlanRepository;
    }

    /**
     * UserStoryのデータを取得
     */
    public function getUserStory(string $aId): ?UserStory
    {
        // ドメインモデル
        $id = new UserStoryId($aId);
        // レポジトリから、データを取得　※ドメインではない
        return $this->userStoryRepository->find($id);
    }

    public function addUserStory(AddUserStoryCommand $command): void
    {
        // トランザクション
        $this->transaction->scope(function () use ($command) {
            // 唯一のIDを生成
            $id = new UserStoryId(uniqid());
            // ドメイン化
            $story = new UserStory(
                $id, // これだけクラス？
                $command->getStory(),
                $this->userContext->getId(),
                $command->getDemo()
            );
            $this->userStoryRepository->save($story);
        });
    }

    /**
     * UserPlanのデータを取得
     */
    public function getUserPlan(string $aId): ?UserPlan
    {
        // ドメインモデル
        $id = new UserPlanId($aId);
        // レポジトリから、データを取得　※ドメインではない
        return $this->userPlanRepository->find($id);
    }

    public function addUserPlan(AddUserPlanCommand $command): void
    {
        // トランザクション
        $this->transaction->scope(function () use ($command) {
            // 唯一のIDを生成
            $id = new UserPlanId(uniqid());
            // ドメイン化
            $plan = new UserPlan(
                $id, // これだけクラス？
                $command->getPlan(),
                $this->userContext->getId(),
                $command->getStart(),
                $command->getEnd()
            );
            $this->userPlanRepository->save($plan);
        });
    }

    public function estimateUserStory(string $aId, int $estimation): void
    {
        $this->transaction->scope(function () use ($aId, $estimation) {
            $id = new UserStoryId($aId);
            $story = $this->userStoryRepository->find($id);
            if (is_null($story)) {
                throw new NotFoundException($aId . " not found.");
            }

            $story->estimate($estimation);
            $this->userStoryRepository->save($story);
        });
    }
}
