<?php


namespace Scrum\Application\Service\BackLog\Query;


class UserStorySummary
{
    /** @var string */
    public $id;
    /** @var string */
    public $story;
    /** @var string */
    public $author;
    /** @var string|null */
    public $demo;
    /** @var int|null */
    public $estimation;
    /** @var int|null */
    public $seq;

    /**
     * UserStorySummary constructor.
     * @param string $id
     * @param string $story
     * @param string $author
     * @param string|null $demo
     * @param int|null $estimation
     * @param int|null $seq
     */
    public function __construct(
        string $id, 
        string $story, 
        string $author, 
        ?string $demo, 
        ?int $estimation, 
        ?int $seq)
    {
        $this->id = $id;
        $this->story = $story;
        $this->author = $author;
        $this->demo = $demo;
        $this->estimation = $estimation;
        $this->seq = $seq;
    }
}
