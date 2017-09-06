<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	public function childs()
	{
		return $this->hasMany(App\Models\Frontend\Category::class, 'parent_id', 'id');
	}
}
