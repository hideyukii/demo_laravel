<?php


namespace Scrum\Domain\Models\UserPlans;


use Scrum\Domain\Models\User\UserId;

/**
 * Class UserPlan
 * @package nrslib\ScrumDomain\Models\UserStories
 */
class UserPlan
{
    /** @var UserPlanId */
    private $id;
    /** @var string */
    private $plan;
    /** @var UserId */
    private $author;
    /** @var string */
    private $start;
    /** @var string|null */
    private $end;
    /** @var int|null */
    private $estimation;
    /** @var int|null */
    private $seq;

    /**
     * UserPlan constructor.
     * @param UserPlanId $id
     * @param string $plan
     * @param UserId $author
     * @param string $start
     * @param string|null $end
     * @param int|null $estimation
     * @param int|null $seq
     */
    public function __construct(
        UserPlanId $id,
        string $plan,
        UserId $author,
        string $start,
        string $end = null,
        int $estimation = null,
        int $seq = null)
    {
        if (strlen($plan) == 0) {
            throw new \InvalidArgumentException("plan is empty.");
        }

        $this->id = $id;
        $this->plan = $plan;
        $this->author = $author;
        $this->start = $start;
        $this->end = $end;
        $this->estimation = $estimation;
        $this->seq = $seq;
    }

    /**
     * なぜにこれだけドメイン？
     * @return UserPlanId
     */
    public function getId(): UserPlanId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPlan(): string
    {
        return $this->plan;
    }

    /**
     * なぜに、やっぱりIdはドメイン？
     * @return UserId
     */
    public function getAuthor(): UserId
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @return string|null
     */
    public function getEnd(): ?string
    {
        return $this->end;
    }

    /**
     * @return int|null
     */
    public function getEstimation(): ?int
    {
        return $this->estimation;
    }

    /**
     * @return int|null
     */
    public function getSeq(): ?int
    {
        return $this->seq;
    }

    /**
     * セットするほう
     */
    public function estimate(int $estimation)
    {
        $this->estimation = $estimation;
    }
}