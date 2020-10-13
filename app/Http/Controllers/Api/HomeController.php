<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\Slideshow;
use App\Repositories\Contracts\CategoryRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $slideshows       = Slideshow::where( 'status', '=', 1 )->get();
        foreach ($slideshows as $slideshow) {
            $slideshow->image = asset($slideshow->image);
        }
        $latests   = Product::orderby( 'id', 'DESC' )->where('status', 'published')->take( 4 )->get();
        $featureds = Product::where( 'status', 'published' )->take( 4 )->get();
        $populars  = Product::orderby( 'updated_at', 'DESC' )->take( 4 )->get();
        $categories = $this->category->getCategories();
        foreach ($categories as $category) {
            $category->products = route('api.category.products', $category->id);
            if ($category->subCategory->isNotEmpty()) {
                foreach ($category->subCategory as $subCategory) {
                    if ($subCategory->subCategory->isNotEmpty()) {
                        $subCategory->img = $subCategory->subCategory->first()->products->isNotEmpty() && $subCategory->subCategory->first()->products->first()->images->isNotEmpty() ? $subCategory->subCategory->first()->products->first()->images->first()->path->mediumUrl : asset('/front/img/medium-default-product.jpg');
                        unset($subCategory->subCategory->first()->products);
                    }
                    else {
                        $subCategory->img = $subCategory->products->isNotEmpty() && $subCategory->products->first()->images->isNotEmpty() ? $subCategory->products->first()->images->first()->path->mediumUrl : asset('/front/img/medium-default-product.jpg');
                        unset($subCategory->products);
                    }
                    $subCategory->products = route('api.category.products', $subCategory->id);
                    if ($subCategory->subCategory->isNotEmpty()) {
                        foreach ($subCategory->subCategory as $child) {
                            $child->img = $child->products->isNotEmpty() && $child->products->first()->images->isNotEmpty() ? $child->products->first()->images->first()->path->mediumUrl : asset('/front/img/medium-default-product.jpg');
                            unset($child->products);
                            $child->products = route('api.category.products', $child->id);
                        }
                    }
                }
            }
        }

        foreach ($latests as $latestProduct) {
            if($latestProduct->images->isNotEmpty()) {
                foreach ($latestProduct->images as $image)
                {
                    $img[] = $image->path->mediumUrl ? $image->path->mediumUrl : asset('front/img/medium-default-product.jpg');
                }
                $latestProducts[] = array_add($latestProduct, 'imgs', $img);
                unset($img);
                unset($latestProduct->images);
            }
        }

        foreach ($featureds as $featuredProduct) {
            if($featuredProduct->images->isNotEmpty()) {
                foreach ($featuredProduct->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $featuredProducts[] = array_add($featuredProduct, 'imgs', $img);
                unset($img);
                unset($featuredProduct->images);
                }
        }

        foreach ($populars as $popularProduct) {
            if($popularProduct->images->isNotEmpty()) {
                foreach ($popularProduct->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $popularProducts[] = array_add($popularProduct, 'imgs', $img);
                unset($img);
                unset($popularProduct->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_1'))->take(4) as $dealProduct) {
            if($dealProduct->images->isNotEmpty()) {
                foreach ($dealProduct->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $dealProducts[] = array_add($dealProduct, 'imgs', $img);
                unset($img);
                unset($dealProduct->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_2'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_2[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        } 

        foreach (getProductsByCategory(getHome('products_section_3'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_3[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_4'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_4[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_5'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_5[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_6'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_6[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_7'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_7[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        }

        foreach (getProductsByCategory(getHome('products_section_8'))->take(4) as $product) {
            if($product->images->isNotEmpty()) {
                foreach ($product->images as $image)
                {
                    $img[] = $image->path->mediumUrl;
                }
                $products_section_8[] = array_add($product, 'imgs', $img);
                unset($img);
                unset($product->images);
            }
        }

        $data = [
            'data' => [
                'slideshows' => $slideshows,
                'deal_of_the_day' => [
                    'deals_product' => isset($dealProducts) ? $dealProducts : [],
                    'deals_date' => getHome('deals_date'),
                    'category_id' => Category::where('name', getHome('products_section_1'))->first()->id
                ],
                'products' => [
                    'latestProducts' => isset($latestProducts) ? $latestProducts : [],
                    'featuredProducts' => isset($featuredProducts) ? $featuredProducts : [],
                    'recentlyViewedProducts' => isset($popularProducts) ? $popularProducts : [],
                ],
                'categories' => $categories,
                'logo' => asset('storage/' . getConfiguration('site_logo')),
                'products_sections' => [
                    [
                        'products' => isset($products_section_2) ? $products_section_2 : [],
                        'title' => getHome('products_section_2'),
                        'category_id' => Category::where('name', getHome('products_section_2'))->first() ? Category::where('name', getHome('products_section_2'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_2') != null ? url('storage') . '/' .getConfiguration('category_ads_image_2') : '',
                            'link' => getConfiguration('category_ads_link_2') != null ? getConfiguration('category_ads_link_2') : ''
                        ]
                    ],
                    [
                        'products' => isset($products_section_3) ? $products_section_3 : [],
                        'title' => getHome('products_section_3'),
                        'category_id' => Category::where('name', getHome('products_section_3'))->first() ? Category::where('name', getHome('products_section_3'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_3') != null ? url('storage') . '/' .getConfiguration('category_ads_image_3') : '',
                            'link' => getConfiguration('category_ads_link_3') != null ? getConfiguration('category_ads_link_3') : ''
                        ]
                    ],
                    [
                        'products' => isset($products_section_4) ? $products_section_4 : [],
                        'title' => getHome('products_section_4'),
                        'category_id' => Category::where('name', getHome('products_section_4'))->first() ? Category::where('name', getHome('products_section_4'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_4') != null ? url('storage') . '/' .getConfiguration('category_ads_image_4') : '',
                            'link' => getConfiguration('category_ads_link_4') != null ? getConfiguration('category_ads_link_4') : ''
                        ]
                    ],
                    [
                        'products' => isset($products_section_5) ? $products_section_5 : [],
                        'title' => getHome('products_section_5'),
                        'category_id' => Category::where('name', getHome('products_section_5'))->first() ? Category::where('name', getHome('products_section_5'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_5') != null ? url('storage') . '/' .getConfiguration('category_ads_image_5') : '',
                            'link' => getConfiguration('category_ads_link_5') != null ? getConfiguration('category_ads_link_5') : ''
                        ]
                    ],
                    [
                        'products' => isset($products_section_6) ? $products_section_6 : [],
                        'title' => getHome('products_section_6'),
                        'category_id' => Category::where('name', getHome('products_section_6'))->first() ? Category::where('name', getHome('products_section_6'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_6') != null ? url('storage') . '/' .getConfiguration('category_ads_image_6') : '',
                            'link' => getConfiguration('category_ads_link_6') != null ? getConfiguration('category_ads_link_6') : ''
                        ]
                    ],
                    [
                        'products' => isset($products_section_7) ? $products_section_7 : [],
                        'title' => getHome('products_section_7'),
                        'category_id' => Category::where('name', getHome('products_section_7'))->first() ? Category::where('name', getHome('products_section_7'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_7') != null ? url('storage') . '/' .getConfiguration('category_ads_image_7') : '',
                            'link' => getConfiguration('category_ads_link_7') != null ? getConfiguration('category_ads_link_7') : ''
                        ]
                    ],
                    [
                        'products' => isset($products_section_8) ? $products_section_8 : [],
                        'title' => getHome('products_section_8'),
                        'category_id' => Category::where('name', getHome('products_section_8'))->first() ? Category::where('name', getHome('products_section_8'))->first()->id : 0,
                        'ad' => [
                            'image' => getConfiguration('category_ads_image_8') != null ? url('storage') . '/' .getConfiguration('category_ads_image_8') : '',
                            'link' => getConfiguration('category_ads_link_8') != null ? getConfiguration('category_ads_link_8') : ''
                        ]
                    ],
                ]
            ]
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    public function getRecentlyViewedProducts()
    {
        $populars  = Product::orderby( 'updated_at', 'DESC' )->paginate(20);

        foreach ($populars as $popularProduct) {
            if($popularProduct->images->isNotEmpty()) {
                foreach ($popularProduct->images as $image) {
                    $images[] = $image->path;
                }
            }
            else {
                $images = '';
            }

            $popularProduct->href = ['link' => route('api.products.show', $popularProduct->id)];
            $popularProduct->imgs = $images;
            $popularProduct->specifications;
            $popularProduct->features;
            unset($popularProduct->images);
            unset($images);
        }

        $data = [
            'recentlyViewedProducts' => isset($populars) ? $populars : [],
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    public function getYouMayLikeProducts()
    {
        $latests = Product::orderby( 'id', 'DESC' )->where('status', 'published')->paginate(20);

        foreach ($latests as $latestProduct) {

            if($latestProduct->images->isNotEmpty()) {
                foreach ($latestProduct->images as $image) {
                    $images[] = $image->path;
                }
            }
            else {
                $images = '';
            }

            $latestProduct->href = ['link' => route('api.products.show', $latestProduct->id)];
            $latestProduct->imgs = $images;
            $latestProduct->specifications;
            $latestProduct->features;
            unset($latestProduct->images);
            unset($images);
        }

        $data = [
            'youMayLikeProducts' => isset($latests) ? $latests : [],
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
