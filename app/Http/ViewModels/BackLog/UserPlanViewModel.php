<?php


namespace App\Http\ViewModels\BackLog;


class UserPlanViewModel
{
    /** @var string */
    public $id;
    /** @var string */
    public $plan;
    /** @var string */
    public $start;
    /** @var string|null */
    public $end;
    /** @var int|null */
    public $estimation;
    /** @var string */
    public $authorId;

    /**
     * UserPlanViewModel constructor.
     * @param string $id
     * @param string $plan
     * @param string $authorId
     * @param string $start
     * @param string|null $end
     * @param int|null $estimation
     */
    public function __construct(
        string $id,
        string $plan,
        string $authorId,
        string $start,
        ?string $end,
        ?int $estimation)
    {
        $this->id = $id;
        $this->plan = $plan;
        $this->authorId = $authorId;
        $this->start = $start;
        $this->end = $end;
        $this->estimation = $estimation;
    }
}
