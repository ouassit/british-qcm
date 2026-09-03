<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'telephone',
        'company',
        'password',
        'expire_date',
        'logo',
        'export_test',
        'super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'expire_date' => 'date',
        'export_test' => 'boolean',
        'super_admin' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
    ];

    public function getLogoUrlAttribute()
    {
        if ($this->logo && file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }

        return asset('images/logo-0.png');
    }

    public function getLogoFileAttribute()
    {
        if ($this->logo && file_exists(public_path($this->logo))) {
            return public_path($this->logo);
        }

        return public_path('images/logo-0.png');
    }
}
