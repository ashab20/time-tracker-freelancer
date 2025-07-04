<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'city', 'state', 'zip', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}