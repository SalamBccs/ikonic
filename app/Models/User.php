<?php

namespace App\Models;

use App\Models\Offers\Offers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function user_offers()
    {
        return $this->hasMany(Offers::class, 'user_id', 'id');
    }

    // public function scoplePlayer($q)
    // {
    //     return $q->where(Offers::class, 'user_id', 'id');
    // }

    public function matched_offers()
    {
        return $this->hasMany(MatchedOffers::class, 'buyer_id', 'id');
    }

    public function plateforms()
    {
        return $this->hasMany(UserPlateform::class, 'user_id', 'id');
    }

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


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user_methods()
    {
        return $this->belongsToMany(method::class, 'user_method', 'user_id', 'method_id')->withPivot('fields');
    }

    public function order_user()
    {
        return $this->belongsTo(orderBy::class, 'user_id', 'id');
    }


    public function transferOptions()
    {
        return $this->hasMany(TransferOption::class);
    }

    public function buy_offers()
    {
        return $this->hasMany(MatchedOffers::class, 'buyer_id', 'id');
    }
    public function sell_offers()
    {
        return $this->hasMany(MatchedOffers::class, 'seller_id', 'id');
    }
}
