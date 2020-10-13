<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller {
	// protected $pageTemplate = 'pages.templates.';

	public function getPage( $slug = null ) 
	{
		$page = Page::where( 'slug', $slug );
		$page = $page->firstOrFail();

        return view('pages.templates.default')
			->with( [
				'page' => $page,
			] );
	}

	public function getMission()
	{
		return view('front.pages.mission');
	}

	public function getPayments()
	{
		return view('front.pages.payments');
	}

	public function getShipping()
	{
		return view('front.pages.shipping');
	}

	public function getReturnPolicy()
	{
		return view('front.pages.return_policy');
	}

	public function getPrivacyPolicy()
	{
		return view('front.pages.privacy_policy');
	}

	public function getTermsConditions()
	{
		return view('front.pages.terms_conditions');
	}

	public function getCancellation()
	{
		return view('front.pages.cancellation');
	}
}