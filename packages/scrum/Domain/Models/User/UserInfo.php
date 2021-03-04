<?php


namespace Scrum\Domain\Models\User;


use Scrum\Domain\Models\User\UserId;
use Scrum\Domain\Models\User\UserName;

/**
 * Class UserPlan
 * @package nrslib\ScrumDomain\Models\User
 */
class UserInfo
{
    /** @var UserId */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $story;
    /** @var string */
    private $plan;
    /** @var string */
    private $start;
    /** @var string|null */
    private $end;

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
        UserId $id,
        string $name,
        string $story,
        string $plan,
        string $start,
        string $end = null)
    {
        if (strlen($name) == 0) {
            throw new \InvalidArgumentException("userInfo is empty.");
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
    public function getId(): UserId
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