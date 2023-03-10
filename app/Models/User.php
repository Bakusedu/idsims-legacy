<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use App\Models\Drug;
use App\Models\Purchase;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','age','phone','picture','priviledges'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';
    // relationships

    public function drugs()
    {
        return $this->hasMany('App\Models\Drug','vendor_id');
    }

    public function customerPurchase()
    {
        return $this->hasMany('App\Models\Purchase','purchasedBy');
    }

    public function vendorSoldDrugs()
    {
        return $this->hasMany('App\Models\Purchase','purchasedFrom','id');
    }

    public function vendors()
    {
        return $this->hasOne('App\Models\Vendor','store_id','id');
    }

}
