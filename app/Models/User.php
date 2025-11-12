<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable =
        [
            'nickname',
            'email',
            'password',
            'avatar_url',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden =
        [
            'password',
            'remember_token',
        ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts =
        [
            'email_verified_at' => 'datetime',
        ];

    // public function getAuthPassword()
    // {
    //     return $this->Password_Hash;
    // }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')
            ->withTimestamps()
            ->withPivot('starred_date');
    }

    public function collaborations()
    {
        return $this->belongsToMany(Product::class, 'product_collaborators', 'user_id', 'product_id');
    }
}
