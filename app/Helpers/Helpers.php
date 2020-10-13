<?php

use App\Helpers\Image\LocalImageFile;
use App\Model\Category;
use App\Model\Configuration;
use App\Model\Deal;
use App\Model\Home;
use App\Model\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function getProductSlug( $id ) {
	$product = Product::findOrFail( $id );

	return isset( $product->slug ) ? $product->slug : Str::slug( $product->product_name );
}

function getProductImage( $id, $size = null ) {
	$product = DB::table( 'products' )
	             ->leftJoin( 'product_images', 'products.id', '=', 'product_images.product_id' )
	             ->where( 'product_images.is_main_image', '=', 1 )
	             ->where( 'products.id', '=', $id )
	             ->select( 'product_images.path' )
	             ->first();

	if ( null === $product || empty( $product ) ) {
		$defaultPath = "/img/default-product.jpg";
		$localImage  = new LocalImageFile( $defaultPath );
	} else {
		$localImage = new LocalImageFile( $product->path );
	}

	switch ( $size ) {
		case "small":
			$imageUrl = $localImage->smallUrl;
			break;
		case "medium":
			$imageUrl = $localImage->mediumUrl;
			break;
		case "large":
			$imageUrl = $localImage->largeUrl;
			break;
		case "full":
			$imageUrl = $localImage->url;
			break;
		default:
			$imageUrl = $localImage->mediumUrl;
	}

	return $imageUrl;
}

function getUserAddress( $user ) {
	return $user->addresses->first->toArray();
}

function isValidTimestamp( $timestamp ) {
	if ( preg_match( "/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $timestamp, $matches ) ) {
		if ( checkdate( $matches[2], $matches[3], $matches[1] ) ) {
			return true;
		}
	}

	return false;
}

function humanizeDate( Carbon $date ) {
	return $date->diffForHumans();
}

function excerpt( $content, $length = 30 ) {
	return strip_tags( Str::words( $content, $length ) );
}

function getOrderStatusClass( $status ) {
	switch ( $status ) {
	    case 'approved':
			$statusClass = "primary";
			break;
		case 'pending':
			$statusClass = "warning";
			break;
		case 'delivered':
			$statusClass = "success";
			break;
		case 'received':
			$statusClass = "info";
			break;
		case 'cancelled':
			$statusClass = "danger";
			break;
		case 'review':
			$statusClass = "info";
			break;
		case 'dispatched':
			$statusClass = "info";
			break;
		case 'completed':
			$statusClass = "success";
			break;
		default:
			$statusClass = "info";
	}

	return $statusClass;
}

function getOrderReturnStatusClass( $status ) {
    switch ( $status ) {
        case 'Pending':
            $statusClass = "warning";
            break;
        case 'Approved':
            $statusClass = "success";
            break;
        case 'Received':
            $statusClass = "primary";
            break;
        case 'Unapproved':
            $statusClass = "danger";
            break;
        default:
            $statusClass = "info";
    }

    return $statusClass;
}

function seperator($depth)
{
    $space = '';
    for ($i = 1; $i < $depth; $i++) {
        $space .= '-';
    }
    return $space;
}

function getConfiguration( $key ) {
	$config = Configuration::where( 'configuration_key', '=', $key )->first();
	if ( $config != null ) {
		return $config->configuration_value;
	}

	return null;
}

function getHome( $key ) {
	$config = Home::where( 'home_key', '=', $key )->first();
	if ( $config != null ) {
		return $config->home_value;
	}
	return null;
}

function getProductsByCategory( $category ) {
	$deals = Deal::where('name', $category)->pluck('name')->first();
		switch ( $category ) {
		case 'Latest':
			$products = Product::where( 'status', '=', 'published' )
                ->where('approved',1)->orderby( 'id', 'DESC' )->take( 10 )->get();
			break;
		case 'Featured':
			$products = Product::where( 'is_featured', 1 )->where( 'status', '=', 'published' )
                ->where('approved',1)->orderby( 'id', 'DESC' )->take( 10 )->get();
			break;
		case $deals:
			$deal = Deal::where( 'name', $deals )->firstOrFail();
			$products = $deal->products->where( 'status', '=', 'published' )
                ->where('approved',1)->take(10);
			break;
		default:
			$categories = Category::where( 'name', $category )->get();
			$categories = addRelation( $categories );
			$category_ids = array();
			foreach ($categories as $category) {
				$category_ids[] = $category->id;
				if($category->subCategory->isNotEmpty()){
					foreach ($category->subCategory as $sub) {
						$category_ids[] = $sub->id;
						if($sub->subCategory->isNotEmpty()){
							foreach ($sub->subCategory as $child) {
								$category_ids[] = $child->id;
								if($child->subCategory->isNotEmpty()){
									foreach ($child->subCategory as $cat) {
										$category_ids[] = $cat->id;
									}
								}
							}
						}
					}
				}
			}
			$product_ids = DB::table('category_product')->whereIn('category_id', $category_ids)->pluck('product_id')->toArray();
			$products = Product::whereIn('id', $product_ids)->where( 'status', '=', 'published' )->orderby( 'id', 'DESC' )->take(15)->get();
	}

	return $products;
}

function selectChild( $id ) {
	$categories = Category::where( 'parent_id', $id )->get(); //rooney

	$categories = addRelation( $categories );

	return $categories;

}

function addRelation( $categories ) {

	$categories->map( function ( $item, $key ) {

		$sub = selectChild( $item->id );

		return $item = array_add( $item, 'subCategory', $sub );

	} );

	return $categories;
}

function getRatings($id) {

    $product = Product::where('id', $id)->first();
    if($product->reviews->isNotEmpty())
    {
        $total = $product->reviews->count();
        $five = $product->reviews->where('stars', 5)->count();
        $four = $product->reviews->where('stars', 4)->count();
        $three = $product->reviews->where('stars', 3)->count();
        $two = $product->reviews->where('stars', 2)->count();
        $one = $product->reviews->where('stars', 1)->count();
        $average = (($product->reviews->where('stars', 5)->count() * 5) +
                    ($product->reviews->where('stars', 4)->count() * 4) +
                    ($product->reviews->where('stars', 3)->count() * 3) +
                    ($product->reviews->where('stars', 2)->count() * 2) +
                    ($product->reviews->where('stars', 1)->count() * 1)) / $total;
    }

    $product_reviews = [
    	'average' => isset($average) ? $average : 0,
    	'one' => isset($one) ? $one : 0,
    	'two' => isset($two) ? $two : 0,
    	'three' => isset($three) ? $three : 0,
    	'four' => isset($four) ? $four : 0,
    	'five' => isset($five) ? $five : 0,
    	'total' => isset($total) ? $total : 0 
    ];

    return $product_reviews;
}

function onesignalNotification($sendData)
{
		
	$content = array(
	   "en" => $sendData['body']
	   );
	
	$headings = array(
	   "en" => $sendData['title']
	   );
	
	$big_picture = array(
	   "id1" => $sendData['image']
	   );
	
	$fields = array(
	   'app_id' => 'e07a73e5-4a92-4869-ba94-37742d81db71',
	   // 'include_player_ids' => array($device_id),
	   'included_segments' => array('All'),
	   'contents' => $content,
	   'headings'=>$headings,
	   'big_picture'=>$sendData['image'],
	   'large_icon' => 'https://files.readme.io/3477f0a-small-favicon-32x32.png',
	   'data' => ['product_id' => $sendData['id']],
	);

	$fields = json_encode($fields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			   'Authorization: Basic NWI1ZTJiMjUtNDYzNC00ZDc3LTlhMmUtZWQwMjIzMWUwNDg0'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$result = curl_exec($ch);
	$data = json_decode($result);
	curl_close($ch);
	
	if(!empty($data->recipients) and $data->recipients >= 1){
		$response = '1';
	}else{
		$response = '0';	
	}	
	
	return $response;
	
}

function onesignalNotificationToSpecificUser($sendData)
{
		
	$content = array(
	   "en" => $sendData['body']
	   );
	
	$headings = array(
	   "en" => $sendData['title']
	   );
	
	$big_picture = array(
	   "id1" => $sendData['image']
	   );
	
	$fields = array(
	   'app_id' => 'e07a73e5-4a92-4869-ba94-37742d81db71',
	   'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => 1)),
	   'contents' => $content,
	   'headings'=>$headings,
	   'big_picture'=>$sendData['image'],
	   'large_icon' => 'https://files.readme.io/3477f0a-small-favicon-32x32.png'
	);

	$fields = json_encode($fields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			   'Authorization: Basic NWI1ZTJiMjUtNDYzNC00ZDc3LTlhMmUtZWQwMjIzMWUwNDg0'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$result = curl_exec($ch);
	$data = json_decode($result);
	curl_close($ch);
	
	if(!empty($data->recipients) and $data->recipients >= 1){
		$response = '1';
	}else{
		$response = '0';	
	}	
	
	return $response;
	
}

function orderbyStatus($status){
    switch ($status) {
        case 'pending':

            $id = 1;
            break;
        case 'approved':
            $id = 2;
            break;
        case 'received':
            $id =3;
            break;
        case 'delivered':
            $id = 4;
            break;
        case 'cancelled':
            $id = 5;
            break;
        case 'review':
            $id = 6;
            break;
        case 'dispatched':
            $id = 7;
            break;
        case 'completed':
            $id =8;
            break;
        case 'pack':
            $id =10;
            break;
        case 'unpack':
            $id =11;
            break;
        case 'all':

            $id = null;

            break;
    }

    return $id;
}
