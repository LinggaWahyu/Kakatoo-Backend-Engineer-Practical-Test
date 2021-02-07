<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'startdate' => 'datetime:Y-m-d H:m:s',
        'enddate' => 'datetime:Y-m-d H:m:s',
        'participans' => 'array'
    ];

    protected $fillable = [
        'skill_id', 'title', 'description', 'startdate', 'enddate', 'participans'
    ];

    public function skill() {
        return $this->belongsTo(Skill::class, 'skill_id', 'id');
    }
}
