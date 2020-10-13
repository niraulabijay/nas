<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Repositories\Contracts\CategoryRepository;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = Category::where('parent_id',0)->get();
        $categories = $this->addRelation( $categories );

        return view('admin.category.category-list',compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCategoryJson(){
        $category=$this->categoryRepository->all();

        foreach ( $category as $categoryKey => $categoryValue ) {
            $parent_id=Category::where('id',$categoryValue->parent_id)->first();
            $category[ $categoryKey ]['parent_name'] = isset( $parent_id->name ) ? $parent_id->name : '-';
            $category[ $categoryKey ]['category_image'] = $categoryValue->image?asset($categoryValue->image):asset('front/img/medium-default-product.jpg');

        }
        return datatables($category)->toJson();

    }


    public function addRelation( $categories ) {

        $categories->map( function ( $item, $key ) {

            $sub = $this->selectChild( $item->id );

            return $item = array_add( $item, 'subCategory', $sub );

        } );

        return $categories;
    }

    public function selectChild( $id ) {
        $categories = Category::where( 'parent_id', $id )->get(); //rooney

        $categories = $this->addRelation( $categories );

        return $categories;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate( $request, [
            'name' => 'required'
        ] );

        try {
            $this->categoryRepository->create($request->all());
        }
        catch (Exception $e) {
            throw new Exception( 'Error in saving category: ' . $e->getMessage() );
        }
        $categories = Category::where('parent_id', 0)->get();
        $categories = $this->addRelation($categories);
        return response()->json($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorye = Category::where('id',$id)->first();
        $categories = Category::where( 'parent_id', 0 )->get();
        $categories = $this->addRelation( $categories );
        return view('admin.category.category-edit',compact('categorye','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate( $request, [
            'name' => 'required'
        ] );

        try {
            $this->categoryRepository->update($request->id,$request->all());
        } catch ( Exception $e ) {

            throw new Exception( 'Error in updating category: ' . $e->getMessage() );
        }
        return response()->json('Category Sucessfullly Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryRepository->delete($id);
        return response()->json('Category Sucessfullly Deleted');
    }
}
