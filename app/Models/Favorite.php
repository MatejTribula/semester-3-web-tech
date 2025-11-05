<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';  
    protected $fillable = ['product_id', 'user_id', 'starred_date'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
