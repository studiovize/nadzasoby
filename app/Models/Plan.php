<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'credits';
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class);
    }

    public function getTotalCreditsAttribute()
    {
        return $this->credits + $this->extra;
    }

    public function getPriceFormattedAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' Kč';
    }
}
