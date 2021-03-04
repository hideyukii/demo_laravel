<?php


namespace Scrum\Application\Service\BackLog;


class AddUserPlanCommand
{
    /** @var string */
    private $plan;
    /** @var string */
    private $start;
    /** @var string|null */
    private $end;

    /**
     * AddUserPlanCommand constructor.
     * @param string $plan
     * @param string|null $end
     */
    public function __construct(
        string $plan,
        string $month
    )
    {
        $this->plan = $plan;
        $this->start = now()->startofmonth();
        $this->end = $month != 0 ? now()->startofmonth()->addMonths($month - 1)->endofmonth() : null;
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
     * @return string
     */
    public function getEnd(): ?string
    {
        return $this->end;
    }
}
