<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\PageRequest;
use App\Page;
use App\Repositories\Contracts\PageRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller {
	/**
	 * @var PageRepository
	 */
	private $page;

	public function __construct( PageRepository $page ) {
		$this->page = $page;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$pagesCount = $this->page->getAll()->count();

		return view( 'admin.pages.index', compact( 'pagesCount' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$pages     = array( '' => 'Select Parent Page' ) + Page::pluck( 'name', 'id' )->toArray();
		$templates = $this->getTemplates();

		return view( 'admin.pages.create', compact( 'pages', 'templates' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param PageRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function store( PageRequest $request ) {
		try {

			$this->page->create( $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving page: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Page successfully created!!' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$page  = $this->page->getById( $id );
		$pages = array( '' => 'Select Parent Page' ) + Page::pluck( 'name', 'id' )->toArray();

		return view( 'admin.pages.edit' )
			->with( [
				'page'      => $page,
				'pages'     => array_except( $pages, $page->id ),
				'templates' => $this->getTemplates()
			] );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param PageRequest|Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function update( PageRequest $request, $id ) {
		try {

			$this->page->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating page: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Page successfully updated!' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function destroy( $id ) {
		try {

			$this->page->delete( $id );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating page: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Page successfully deleted!' );
	}

	public function getPagesJson( Request $request ) {
		$pages = $this->page->getAll();

		foreach ( $pages as $page ) {
			$page->author         = $page->user->full_name;
			$image                = null !== $page->getImage() ? $page->getImage()->smallUrl : $page->getDefaultImage()->smallUrl;
			$page->featured_image = $image;
		}

		return datatables( $pages )->toJson();
	}

	protected function getTemplates() {
		$templates  = scandir( resource_path( 'views/pages/templates' ) );
		$withoutExt = [];
		foreach ( $templates as $template ) {
			if ( $template != '.' && $template != '..' && $template != 'default.blade.php' ) {
				$withoutExt[ basename( $template, '.blade.php' ) ] = ucfirst( basename( $template, '.blade.php' ) );
			}
		}

		return array( 'default' => 'Default' ) + $withoutExt;
	}
}
