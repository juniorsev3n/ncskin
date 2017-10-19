<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public static function getParentMenus() {
        $menus = Menu::select('*')
            ->where('parent',0)
            ->where('is_display',1)
            ->OrderBy('sort_order', 'ASC')
            ->get();
        return $menus;
    }
    
    public static function getChildMenus($parent_id) {
        $menus = Menu::select('*')
            ->where('parent',$parent_id)
            ->where('is_display',1)
            ->OrderBy('sort_order', 'ASC')
            ->get();
        return $menus;
    }
    
    public static function getMenuByID($id) {
        $menu = Menu::select('*')
            ->where('id',$id)
            ->first();
        return $menu;
    }
}
