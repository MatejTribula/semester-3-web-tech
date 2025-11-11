<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'upload_date',
        'approval_date',
        'visibility_setting',
        'file_url',
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'product_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'product_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id')->withTimestamps()->withPivot('starred_date');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'product_collaborators', 'product_id', 'user_id');
    }
}
