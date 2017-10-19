<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';

    public function rating()
    {
    	return $this->hasMany(\App\Models\Frontend\Rating::class,'id', 'rating_id');
    }
}
