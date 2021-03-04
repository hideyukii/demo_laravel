<?php


namespace Scrum\Application\Service\BackLog\Query;


interface BackLogQueryServiceInterface
{
    /**
     * @return UserInfoSummary[]
     */
    function getAllUserInfo(): array;
}
