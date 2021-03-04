<?php


namespace Scrum\Domain\Models\User;


use Scrum\Domain\Models\User\UserId;

/**
 * Class UserPlan
 * @package nrslib\ScrumDomain\Models\User
 */
class User
{
    /** @var UserId */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $email;
    /** @var int */
    private $seq;

    /**
     * User constructor.
     * @param UserId $id
     * @param string $name
     * @param string $email
     * @param int|null $seq
     */
    public function __construct(
        UserId $id,
        string $name,
        string $email,
        int $seq = null)
    {
        if (strlen($plan) == 0) {
            throw new \InvalidArgumentException("plan is empty.");
        }

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->seq = $seq;
    }

    /**
     * なぜにこれだけドメイン？
     * @return UserId
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int|null
     */
    public function getSeq(): ?int
    {
        return $this->seq;
    }
}