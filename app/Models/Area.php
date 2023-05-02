<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function subareas()
    {
        return $this->hasMany(Area::class);
    }

    public function parent()
    {
        if (!$this->area_id) return null;
        return Area::where('id', $this->area_id)->first();
    }

    public function subareasListings()
    {
        return $this->hasManyThrough(Listing::class, Area::class, 'area_id');
    }

    public function getListingsCountAttribute()
    {
        return $this->listings()->where('is_active', true)->count() + $this->subareasListings()->where('is_active', true)->count();
    }

//    public function parent(): BelongsTo
//    {
//        return $this->belongsTo('App\Models\Area','parent_id')->where('parent_id',0)->with('parent');
//    }
//
//    public function children(): HasMany
//    {
//        return $this->hasMany('App\Models\Area','parent_id')->with('children');
//    }
}
