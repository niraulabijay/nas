<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Configuration;
use Illuminate\Http\Request;
use File;
use Storage;

class ConfigurationController extends Controller
{
    public function getConfiguration()
    {
        return view('admin.settings.index');
    }

    public function postConfiguration(Request $request)
    {
        $inputs = $request->only(
            'site_title',
            'site_description',
            'site_primary_email',
            'site_secondary_email',
            'site_primary_phone',
            'site_secondary_phone',
            'site_address',
            'order_email',
            'site_logo',
            'site_favicon',
            'enable_tax',
            'tax_percentage',
            'who_we_are',
            'our_mission',
            'payments',
            'shipping',
            'return_policy',
            'privacy_policy',
            'terms_conditions',
            'cancellation',
            'facebook_link',
            'twitter_link',
            'instagram_link',
            'youtube_link',
            'footer_logo',
            'payments_logo',
            'copyright',
            'ad',
            'keywords',
            'description',
            'referal',
            'active',
            'productcommissinactive',
            'productcommissinprice',
            'about_content',
            'category_ads_1',
            'category_ads_link_1',
            'category_ads_image_1',
            'category_ads_2',
            'category_ads_link_2',
            'category_ads_image_2',
            'category_ads_3',
            'category_ads_link_3',
            'category_ads_image_3',
            'category_ads_4',
            'category_ads_link_4',
            'category_ads_image_4',
            'category_ads_4',
            'category_ads_link_4',
            'category_ads_image_4',
            'category_ads_5',
            'category_ads_link_5',
            'category_ads_image_5',
            'category_ads_6',
            'category_ads_link_6',
            'category_ads_image_6',
            'category_ads_7',
            'category_ads_link_7',
            'category_ads_image_7',
            'category_ads_8',
            'category_ads_link_8',
            'category_ads_image_8'
        );

        foreach ($inputs as $inputKey => $inputValue) {
            if ($inputKey == 'site_logo' || $inputKey == 'site_favicon' || $inputKey == 'footer_logo' || $inputKey == 'payments_logo' || $inputKey == 'ad' || $inputKey == 'category_ads_image_1' || $inputKey == 'category_ads_image_2' || $inputKey == 'category_ads_image_3' || $inputKey == 'category_ads_image_4' || $inputKey == 'category_ads_image_5' || $inputKey == 'category_ads_image_6' || $inputKey == 'category_ads_image_7' || $inputKey == 'category_ads_image_8') {
                $file = $inputValue;
                // Delete old file
                $this->deleteFile($inputKey);
                // Upload file & get store file name
                $fileName = $this->uploadFile($file);
                $inputValue = 'settings/' . $fileName;
            }
            Configuration::updateOrCreate(['configuration_key' => $inputKey], ['configuration_value' => $inputValue]);
        }

        // Update tax
        $enableTax = !array_key_exists("enable_tax", $inputs) ? 0 : 1;
        Configuration::updateOrCreate(['configuration_key' => 'enable_tax'], ['configuration_value' => $enableTax]);

        return redirect()->back()->with('success', 'Settings successfully updated!!');
    }

    protected function uploadFile($file)
    {
        // Store file
        $path = Storage::disk('public')->put('storage/settings', $file, 'public');
        // Get stored file name
        $fileName = explode('storage/settings/', $path);

        // File name
        return $fileName[1];
    }

    protected function deleteFile($inputKey)
    {
        $configuration = Configuration::where('configuration_key', '=', $inputKey)->first();
        // Check if configuration exists
        if (null !== $configuration && $configuration->exists()) {
            $fullPath = storage_path('app/public') . '/' . $configuration->configuration_value;
            if (File::exists($fullPath)) {
                // File exists
                File::delete($fullPath);
            }
        }
    }

    public function getAdsCreate()
    {
        return view('admin.settings.tab-category');
    }

    public function removeAds(Request $request){
        if($request->ajax()){
            $inputKey= $request->input('key');

            $configuration = Configuration::where('configuration_key', '=', $inputKey)->first();
            // Check if configuration exists
            if (isset($configuration) && $configuration->exists()) {

                if (file_exists(public_path('storage/'.$configuration->configuration_value))) {
                    unlink(public_path('storage/'.$configuration->configuration_value));
                    $configuration->configuration_value=null;
                    $configuration->save();
                     return response('success',200);
                }
            }
        }
    }
}
