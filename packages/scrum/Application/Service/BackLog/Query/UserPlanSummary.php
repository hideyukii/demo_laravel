<?php


namespace Scrum\Application\Service\BackLog\Query;


class UserPlanSummary
{
    /** @var string */
    public $id;
    /** @var string */
    public $story;
    /** @var string */
    public $author;
    /** @var string */
    public $start;
    /** @var string|null */
    public $end;
    /** @var int|null */
    public $estimation;
    /** @var int|null */
    public $seq;

    /**
     * UserStorySummary constructor.
     * @param string $id
     * @param string $story
     * @param string $author
     * @param string $start
     * @param string|null $end
     * @param int|null $estimation
     * @param int|null $seq
     */
    public function __construct(
        string $id, 
        string $story, 
        string $author, 
        string $start,
        ?string $end,
        ?int $estimation, 
        ?int $seq)
    {
        $this->id = $id;
        $this->story = $story;
        $this->author = $author;
        $this->start = $start;
        $this->end = $end;
        $this->estimation = $estimation;
        $this->seq = $seq;
    }
}
