<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Repositories\Contracts\CategoryRepository;
use Harimayco\Menu\Models\MenuItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
	private $category;

	public function __construct(CategoryRepository $category)
	{
		$this->category = $category;
	}

    public function index()
    {
    	return view('admin.menu.index');
    }

    public function addmenu( Request $request ) {
		if ( ! $request->has( 'data' ) ) {
			return response()->json( [
				'success' => false,
				'message' => 'Something went wrong!'
			] );
		}

		foreach ( $request->data as $data ) {
			DB::table( 'menu_items' )->insert( [
				'label' => $data['labelmenu'],
				'link'  => $data['linkmenu'],
				// 'menu'  => $data['idmenu'],
			] );
		}

		return response()->json( [
			'success' => true,
			'message' => 'Menu successfully added!'
		] );
	}

	public function show()
	{
		$menulist = MenuItems::where('parent', 0)->orderBy('id','ASC')->get();
		return view('admin.menu.menulist', compact('menulist'));
	}
}
