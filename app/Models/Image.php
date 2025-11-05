<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';  

    protected $fillable = ['Product_ID', 'Images_URL'];

    public function product() 
    {
        return $this->belongsTo(Product::class, 'Product_ID');
    }
}
