<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TimeLogs extends Model
{
    use AuthorizesRequests;
    protected $fillable = ['project_id', 'start_time', 'end_time', 'description', 'hour', 'user_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}