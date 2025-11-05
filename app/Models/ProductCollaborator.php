<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCollaborator extends Model
{
    protected $table = 'product_collaborators';  
    protected $fillable = ['Product_ID', 'User_ID'];

    public function product() 
    {
        return $this->belongsTo(Product::class, 'Product_ID');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'User_ID');
    }
}
