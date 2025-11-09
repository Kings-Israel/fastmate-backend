<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['user_id', 'time', 'days', 'enabled'];

    protected $casts = [
        'days' => 'array',
        'enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
