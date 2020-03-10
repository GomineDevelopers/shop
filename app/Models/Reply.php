<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['good_id', 'user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}