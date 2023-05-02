<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function getListingsCountAttribute()
    {
        return $this->listings()->where('is_active', true)->count();
    }
}
