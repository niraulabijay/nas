<?php

namespace App\Http\ViewComposers;

use Harimayco\Menu\Facades\Menu;
use Illuminate\View\View;

class MenuListComposer {
	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$menuList = Menu::list(1);
		$categoryMenuList = Menu::list(2);

		$view->with( [
			'menuList' => $menuList,
			'categoryMenuList' => $categoryMenuList
		] );
	}
}