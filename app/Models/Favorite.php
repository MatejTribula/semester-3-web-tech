<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';  
    protected $fillable = ['Product_ID', 'User_ID', 'Starred_Date'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_ID');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'User_ID');
    }
}
