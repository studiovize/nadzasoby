<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Credit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'expiration_date',
        'updated_at',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getExpirationAttribute()
    {
        return $this->expiration_date->format('d.m.Y');
    }
}
