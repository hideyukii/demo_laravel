<?php


namespace Scrum\Application\Service\BackLog\Query;


/**
 * Class UserPlan
 * @package nrslib\ScrumDomain\Models\User
 */
class UserInfoSummary
{
    /** @var string */
    public $id;
    /** @var string */
    public $name;
    /** @var string */
    public $story;
    /** @var string */
    public $plan;
    /** @var string */
    public $start;
    /** @var string|null */
    public $end;

    /**
     * User constructor.
     * @param string $id
     * @param string $name
     * @param string $story
     * @param string $plan
     * @param string $start
     * @param string|null $end
     */
    public function __construct(
        string $id,
        string $name,
        string $story,
        string $plan,
        string $start,
        string $end = null)
    {
        if (strlen($plan) == 0) {
            throw new \InvalidArgumentException("plan is empty.");
        }

        $this->id = $id;
        $this->name = $name;
        $this->story = $story;
        $this->plan = $plan;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * なぜにこれだけドメイン？
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStory(): string
    {
        return $this->story;
    }

    /**
     * @return string
     */
    public function getPlan(): string
    {
        return $this->plan;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @return int|null
     */
    public function getEnd(): ?string
    {
        return $this->end;
    }
}