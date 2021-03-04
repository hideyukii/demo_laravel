<?php


namespace Scrum\Domain\Models\UserPlans;


class UserPlanId
{
    /** @var string */
    private $value;

    /**
     * UserPlanId constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
