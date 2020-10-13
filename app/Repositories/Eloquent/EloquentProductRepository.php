<?php

namespace App\Repositories\Eloquent;

use App\Model\Category;
use App\Model\Product;
use App\Model\ProductImage;
use App\Model\ProductRelation;
use App\Repositories\Contracts\ProductRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentProductRepository extends AbstractRepository implements ProductRepository
{
    public function entity()
    {
        return Product::class;
    }

    public function store(array $attributes)
    {
        
        
        // dd($attributes);
        
        
        // $commission  = $commission/100;
        // dd($commission *  $attributes['sale_price']);
        
        // if(getConfiguration('productcommissinactive') == 1){
        //     if($attributes['sale_price'] > 0  || $attributes['sale_price'] != null){
        //         $attributes['sale_price'] = $attributes['sale_price'] + getConfiguration('productcommissinprice');
        //     }
           
        //     $attributes['product_price'] = $attributes['product_price'] + getConfiguration('productcommissinprice'); 
        // }
        
        
                

    
    if(isset($attributes['additionals'])){
         $quantitys = isset($attributes['additionals']['quantity']) ? $attributes['additionals']['quantity'] : '';

              $quantitiesKey = array_keys($quantitys);
                $totalquantity= 0;
              foreach ($quantitiesKey as $quantity) {
                  if($quantitys[$quantity]){
                    $totalquantity += $quantitys[$quantity];
                  }
              }
              if($totalquantity > 0){
                  $attributes['stock_quantity'] = $totalquantity;
              }
               
    }
        
        
        // $attribute = 
        $attributes['user_id'] = auth()->id();
        if(isset($attributes['prebooking'])) {
          if ($attributes['prebooking'] == 1 && ($attributes['stock_quantity'] == null || $attributes['stock_quantity'] == 0)) {
            $attributes['stock'] = 0;
          }
        } 
        if(($attributes['stock_quantity'] == null || $attributes['stock_quantity'] == 0) && $attributes['stock'] == 1) {
          $attributes['stock'] = 0;
        }
        $product = $this->entity->create($attributes);
        
        if($product->sku == null){
            
            $cropname = substr($attributes['name'], 0, 3);

        $getCategory = Category::where('id', $attributes['category_id'])->first();
        
        $cropCategory = substr($getCategory->name, 0, 3);
        $generatedSKU = strtolower($cropname.'-'.$cropCategory.'-'.$attributes['brand_id']);
            //  $attributes['sku'] = $generatedSKU;
             
             $product->sku = $generatedSKU.'-'.$product->id;
             $product->update();
             
             
        }

       if($product){
           if (isset($attributes['category_id'])) {
               $product->categories()->attach($attributes['category_id']);

               /*
                $category_main = Category::findorfail($attributes['category_id']);

             if ($category_main) {
                  $product->categories()->attach($category_main->parent->id);
                  $category_sub = Category::findorfail($category_main->parent->id);
                  if ($category_sub) {
                      $product->categories()->attach($category_sub->parent->id);
                  }
              }*/
           }
           if (isset($attributes['image']) && null !== $attributes['image']) {
               foreach ($attributes['image'] as $key => $data) {
                   ProductImage::create($data + ['product_id' => $product->id]);
               }
           }


            

           if (isset($attributes['faqs'])) {
               $question = isset($attributes['faqs']['question']) ? $attributes['faqs']['question'] : '';
               $answer = isset($attributes['faqs']['answer']) ? $attributes['faqs']['answer'] : '';

               $faqsKeys = array_keys($question);

               // Create faq
               foreach ($faqsKeys as $faq) {
                  $product->faqs()->create([
                       'product_id' => $product->id,
                       'question' => $question[$faq],
                       'answer' => $answer[$faq],
                  ]);
               }
           }
           if (isset($attributes['additionals'])) {

               $quantity = isset($attributes['additionals']['quantity']) ? $attributes['additionals']['quantity'] : '';
               $sizes = isset($attributes['additionals']['size']) ? $attributes['additionals']['size'] : '';

               $additionalsKey = array_keys($quantity);

               // Create specification
               foreach ($additionalsKey as $specification) {
                   if($quantity[$specification] && $sizes[$specification]){
                   $product->additionals()->create([
                       'product_id' => $product->id,
                       'quantity' => $quantity[$specification],
                       'size' => trim(strtoupper($sizes[$specification])),
                   ]);
                   }
               }
           }

           if (isset($attributes['meta_keyword'])) {
               // create seos
               $product->seos()->create([
                   'meta_keyword' => $attributes['meta_keyword'],
                   'meta_description' => $attributes['meta_description'],
               ]);
           }

           // create specification
           if (isset($attributes['specifications'])) {

               $titles = isset($attributes['specifications']['title']) ? $attributes['specifications']['title'] : '';
               $descriptions = isset($attributes['specifications']['description']) ? $attributes['specifications']['description'] : '';

               $specificationsKeys = array_keys($titles);

               // Create specification
               foreach ($specificationsKeys as $specification) {
                   if($titles[$specification] && $descriptions[$specification]){
                   $product->specifications()->create([
                       'product_id' => $product->id,
                       'title' => $titles[$specification],
                       'description' => $descriptions[$specification],
                   ]);
                   }
               }
           }
           if (isset($attributes['features'])) {
               $feature_titles = isset($attributes['features']['feature']) ? $attributes['features']['feature'] : '';

               $featuresKeys = array_keys($feature_titles);

               // Create specification
               foreach ($featuresKeys as $feature) {
                   $product->features()->create([
                       'product_id' => $product->id,
                       'feature' => $feature_titles[$feature],
                   ]);
               }
           }
       }
       return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->entity->find($id);
        $product->categories()->detach();
        $product->faqs()->delete();
        $product->specifications()->delete();
        $product->features()->delete();
        $product->seos()->delete();
        $product->additionals()->delete();
        $product->images()->delete();
        if($product->main == 1)
        {
          $relation = ProductRelation::where('product_id', $product->main)->where('relation_id', '!=', $product->main)->first();
          Product::where('id', $relation->relation_id)->update(['main' => 1]);
          ProductRelation::where('product_id', $product->main)->update(['product_id' => $relation->relation_id]);
        }
        $product->relation()->delete();
        $product->delete();
    }

    public function getAll()
    {
        $products = $this->entity->all();
        $products->features()->all();
    }

    public function editProducts($id)
    {
        $this->entity->find($id);
    }

    public function updateProducts($id, array $attributes)
    {
        
        // dd($attributes);
        $product = $this->entity->findOrFail($id);
        if(isset($attributes['prebooking'])) {
          if ($attributes['prebooking'] == 1 && ($attributes['stock_quantity'] == null || $attributes['stock_quantity'] == 0)) {
            $attributes['stock'] = 0;
          }
        } 
        if($product->prebooking == 1 && !isset($attributes['prebooking'])) {
          $attributes['prebooking'] = 0;
        }
        if(($attributes['stock_quantity'] == null || $attributes['stock_quantity'] == 0) && $attributes['stock'] == 1) {
          $attributes['stock'] = 0;
        }

        if (isset($attributes['category'])) {
            $product->categories()->sync($attributes['category']);
        }

        //Product Images
        if (isset($attributes['image']) && null !== $attributes['image']) {
            $exitingIds = $product->images()->get()->pluck('id')->toArray();
            foreach ($attributes['image'] as $key => $data) {
                if (is_int($key)) {
                    if (($findKey = array_search($key, $exitingIds)) !== false) {
                        $productImage = ProductImage::findOrFail($key);
                        $productImage->update($data);
                        unset($exitingIds[$findKey]);
                    }
                    continue;
                }
                ProductImage::create($data + ['product_id' => $product->id]);
            }
            if (count($exitingIds) > 0) {
                ProductImage::destroy($exitingIds);
            }

        }

        if (isset($attributes['faqs'])) {
            $question = isset($attributes['faqs']['question']) ? $attributes['faqs']['question'] : '';
            $answer = isset($attributes['faqs']['answer']) ? $attributes['faqs']['answer'] : '';

            $faqsKeys = array_keys($question);

            // Create faq
            foreach ($faqsKeys as $faq) {
                $product->faqs()->updateOrCreate([
                    'id' => $faq], [
                    'product_id' => $product->id,
                    'question' => $question[$faq],
                    'answer' => $answer[$faq],
                ]);
            }

        }
        if (isset($attributes['additionals'])) {

            $quantity = isset($attributes['additionals']['quantity']) ? $attributes['additionals']['quantity'] : '';
            $sizes = isset($attributes['additionals']['size']) ? $attributes['additionals']['size'] : '';

            $additionalsKey = array_keys($quantity);

            // Create specification
            foreach ($additionalsKey as $specification) {
                if($quantity[$specification] && $sizes[$specification] ){
                $product->additionals()->updateOrCreate([
                    'id' => $specification], [
                    'product_id' => $product->id,
                    'quantity' => $quantity[$specification],
                    'size' => trim(strtoupper($sizes[$specification])),
                    // 'color' => trim(strtolower($color[$specification])),

                ]);
                }
            }
        }

        if (isset($attributes['meta_keyword'])) {
            // create seos
            $product->seos()->updateOrCreate([
                'meta_keyword' => $attributes['meta_keyword'],
                'meta_description' => $attributes['meta_description'],
            ]);
        }

        // create specification
        if (isset($attributes['specifications'])) {
            $titles = isset($attributes['specifications']['title']) ? $attributes['specifications']['title'] : '';
            $descriptions = isset($attributes['specifications']['description']) ? $attributes['specifications']['description'] : '';

            $specificationsKeys = array_keys($titles);

            // Create specification
            foreach ($specificationsKeys as $specification) {
                if($titles[$specification] && $descriptions[$specification] ){
                $product->specifications()->updateOrCreate([
                    'id' => $specification], [
                    'product_id' => $product->id,
                    'title' => $titles[$specification],
                    'description' => $descriptions[$specification],
                ]);
                }
            }
        }


        if (isset($attributes['features'])) {
            $feature_titles = isset($attributes['features']['feature']) ? $attributes['features']['feature'] : '';

            $featuresKeys = array_keys($feature_titles);

            // Create specification
            foreach ($featuresKeys as $feature) {
                $product->features()->updateOrCreate([
                    'id' => $feature], [
                    'product_id' => $product->id,
                    'feature' => $feature_titles[$feature],
                ]);
            }
        }

        $product->update($attributes);

        return $product;
    }
}
