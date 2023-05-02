<?php

namespace App\Models;

use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'ico',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class)->orderBy('is_highlighted', 'DESC');
    }

    public function unlocked_listings(): BelongsToMany
    {
        return $this->belongsToMany(Listing::class);
    }

    public function credit(): HasOne
    {
        return $this->hasOne(Credit::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getCreditAmountAttribute()
    {
        return $this->credit->amount;
    }

    public function getCreditExpirationAttribute()
    {
        return $this->credit->expiration;
    }

    public function hasUnlocked($listing)
    {
        return $listing->user->id === $this->id || $this->unlocked_listings->where('id', $listing->id)->count() > 0;
    }

    public function getShortNameAttribute()
    {
        $name = $this->name;

        if (strpos($name, ' ') === false) {
            return $name;
        }

        $boom = explode(' ', $name);
        return $boom[0] . ' ' . $boom[1][0] . '.';
    }

    public function getActiveListingsAttribute()
    {
        return $this->listings()->where('is_active', 1)->get();
    }

    public function getListingsForApprovalAttribute()
    {
        return $this->listings()->where([
            ['is_approved', '=', 0],
            ['is_removed', '=', 0],
        ])->get();
    }

    public function trackers()
    {
        return $this->hasMany(Tracker::class);
    }

    public function getHistoryAttribute()
    {
        return $this->trackers()->orderBy('created_at', 'DESC')->get();
    }

    public function getCreditHistoryAttribute()
    {
        return $this->trackers()->where('action', 'spent credit')->orderBy('created_at', 'DESC')->get();
    }

    public function getTotalPaidAttribute()
    {
        $plans = [];
        $sum = 0;
        $payments = $this->payments()->where('status', 'success')->get();
        foreach ($payments as $payment) {
            if (!isset($plans[$payment->plan_id])) {
                $plans[$payment->plan_id] = 1;
            } else {
                $plans[$payment->plan_id]++;
            }
        }

        foreach ($plans as $id => $amount) {
            $plan = Plan::find($id);
            $sum += $plan->price * $amount;
        }


        return $sum;
    }

    public function getTotalPaidFormattedAttribute()
    {
        return number_format($this->total_paid, 0, ',', ' ') . ' Kč';
    }
}
