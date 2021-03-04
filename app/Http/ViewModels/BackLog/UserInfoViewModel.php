<?php


namespace App\Http\ViewModels\BackLog;

class UserInfoViewModel
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
     * UserPlanViewModel constructor.
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
        ?string $end)
    {
        $this->id = $id;
        $this->name = $name;
        $this->story = $story;
        $this->plan = $plan;
        $this->start = $start;
        $this->end = $end;
    }
}
