<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';  

    protected $fillable = ['Product_ID', 'Tag_Value'];

    public function product() 
    {
        return $this->belongsTo(Product::class, 'Product_ID');
    }
}
