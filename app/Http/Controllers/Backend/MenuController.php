<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Datatables;

class MenuController extends Controller
{
    public function index(){
    	return view('backend.menu.index');
    }

    public function getData(){
    	$menus = Menu::selectRaw("id, title, path, parent");
        return Datatables::eloquent($menus)
            ->addColumn('action', function ($menus) {
                return '
                <a href="javascript:view('.$menus->id.')" class="btn btn-md btn-success"><i class="fa fa-view"></i> View</a>
                <a href="javascript:edit('.$menus->id.')" class="btn btn-md btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="javascript:delete('.$menus->id.')" class="btn btn-md btn-danger"><i class="fa fa-delete"></i> Delete</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getAdd(){
        return view('backend.menu.add');
    }

    public function postAdd(Request $request){
        $this->validate($request,
            [
                'name' => 'required',
                'path' => 'required',
            ]);

        try{
            $menu = new Menu;
            $menu->title = $request->name;
            $menu->path = $request->path;
            $menu->description = isset($request->description) ? : '';
            $menu->parent = isset($request->parent) ? : 0;
            $menu->sort_order = 0;
            $menu->is_display = $request->active;
            $menu->save();

            return redirect('admin/menu')->with('status', 'Menu telah ditambahkan!');
        }catch(\Exception $e){
            return redirect('admin/menu')->with('error', $e->getMessage());
        }

    }
}
