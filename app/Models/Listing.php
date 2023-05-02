<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'images' => 'json',
        'is_negotiable' => 'bool',
        'is_price_in_content' => 'bool',
        'is_approved' => 'bool',
        'is_active' => 'bool',
        'is_removed' => 'bool',
        'is_highlighted' => 'bool',
        'tax_included' => 'bool',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function getThumbAttribute(): string
    {
        return (isset($this->thumbnail) && $this->thumbnail !== '') ? asset("uploads/$this->thumbnail") : false;
    }

    public function getTypeForHumansAttribute(): string
    {
        return $this->type === 'sell' ? 'Nabídka' : 'Poptávka';
    }

    public function getPriceForHumansAttribute(): string
    {
        if ($this->is_negotiable) return 'Cena dohodou';
        if ($this->is_price_in_content) return 'Cena v textu';

        $int_price = (int)$this->price;

        if ((string)$int_price === $this->price) {
            return number_format($int_price, 0, ',', ' ') . ' Kč';
        }

        return (string)$this->price;
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->content), 100, '...');
    }

    public function getAmountForHumansAttribute(): string
    {
        $amount = $this->amount;
        $unit = $this->unit;

        if ($unit) {
            if ($unit->name_short === 'palety') {
                if ($amount === 1) {
                    $col = 'name_one';
                } else if ($amount > 1 && $amount < 5) {
                    $col = 'name_few';
                } else {
                    $col = 'name_many';
                }
                return $amount . " " . $unit->{$col};
            } else {
                return $amount . " " . $unit->name_short;
            }

        }

        return $amount;
    }

    public function getIsWaitingForApprovalAttribute()
    {
        return !$this->is_approved && !$this->is_removed;
    }

    public function getBelongsToCurrentUserAttribute()
    {
        return Auth::check() && Auth::user()->id === $this->user_id;
    }

    public function getIsUnlockedAttribute()
    {
        return Auth::check() && Auth::user()->hasUnlocked($this);
    }

    public function getShowPriceAttribute()
    {
        return !$this->is_negotiable && !$this->is_price_in_content;
    }

    public function getStatusAttribute()
    {
        if ($this->is_removed) {
            return 'Zamítnutý';
        }

        if ($this->is_approved) {
            return 'Schválený';
        }

        return 'Čeká na schválení';
    }
}
