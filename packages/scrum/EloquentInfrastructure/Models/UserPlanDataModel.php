<?php


namespace Scrum\EloquentInfrastructure\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPlanDataModel
 * @package Scrum\EloquentInfrastructure\Models
 *
 * @property integer $id
 * @property string $plan
 * @property string $start
 * @property string $author
 * @property string|null $end
 * @property integer|null $estimation
 * @property integer|null $seq
 */
class UserPlanDataModel extends Model
{
    protected $table = "user_plans";
    public $incrementing = false;
    protected $keyType = "string";

    public $guarded = [];
}
