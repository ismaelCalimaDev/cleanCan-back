<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'setupintent_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function locations() {
        return $this->hasMany(Location::class);
    }
    public function cars() {
        return $this->hasMany(Car::class);
    }

    public function canAccessFilament(): bool
    {
        return $this->email === 'cleancan@admin.com';
    }

    protected static function booted()
    {
        static::created(function ($user) {
            $stripeCustomer = $user->createAsStripeCustomer();
        });
        static::updated(function ($user) {
            if ($user->hasStripeId()) {
                $user->syncStripeCustomerDetails();
            }
        });
    }
}
