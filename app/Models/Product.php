<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'Title',
        'Description',
        'Upload_Date',
        'Approval_Date',
        'Visibility_Setting',
        'File_Url',
    ];

    public function images() 
    {
        return $this->hasMany(Image::class, 'Product_ID');
    }

    public function videos() 
    {
        return $this->hasMany(Video::class, 'Product_ID');
    }

    public function tags() 
    {
        return $this->hasMany(Tag::class, 'Product_ID');
    }

    public function favorites() 
    {
        return $this->belongsToMany(User::class, 'favorites', 'Product_ID', 'User_ID')->withTimestamps()->withPivot('Starred_Date');
    }

    public function collaborators() 
    {
        return $this->belongsToMany(User::class, 'product_collaborators', 'Product_ID', 'User_ID');
    }

}
