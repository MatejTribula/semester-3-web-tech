<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

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

    //solo games are also 'collaborations', just with only one user.
    public function collaborations()
    {
        return $this->belongsToMany(Product::class, 'product_collaborators', 'user_id', 'product_id');
    }

    // If avatar_url in DB stores a relative path (e.g. "avatars/xxx.jpg"),
    // this accessor returns a full URL. If it already contains http(s) it is returned as-is.
    public function getAvatarUrlAttribute(?string $value): string
    {
        if (empty($value)) {
            return asset('images/grey.png');
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        return asset('storage/' . ltrim($value, '/'));
    }
}