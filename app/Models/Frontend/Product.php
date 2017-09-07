<?php

namespace App\Models\Frontend;

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
