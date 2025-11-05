<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';  

    protected $fillable = ['product_id', 'video_url'];

    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}