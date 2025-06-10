<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'description', 'client_id', 'status', 'deadline', 'user_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLogs::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}