<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	public function childs()
	{
		return $this->hasMany(App\Models\Frontend\Category::class, 'parent_id', 'id');
	}
}
