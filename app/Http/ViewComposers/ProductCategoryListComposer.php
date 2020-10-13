<?php

namespace App\Http\ViewComposers;

// use App\Helpers\PaginationHelper;
use App\Model\Category;
use App\Model\PaymentMethod;
use App\Repositories\Contracts\CategoryRepository;
use Illuminate\View\View;

class ProductCategoryListComposer {
	// use PaginationHelper;
	/**
	 * @var CategoryRepository
	 */
	private $category;

	public function __construct( CategoryRepository $category ) {
		$this->category = $category;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$categories = $this->category->getCategories()->take(10);
		$payments = PaymentMethod::all();
		$view->with( 'productCategories', $categories )
        ->with( 'payments', $payments );
	}
}