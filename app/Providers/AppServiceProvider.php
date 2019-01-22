<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Request;
use Route;

use App\Models\GeneralConfig;
use App\Models\Product;
use App\Models\ProdukCategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // favicon
            $favicon = GeneralConfig::find(1);
            view()->share('favicon', $favicon);
        // favicon
        // name
            $name = GeneralConfig::find(3);
            view()->share('name', $name);
        // name
            
        if(!Request::is('admin/*') || Request::is('admin/news/*')){
            // logo
                $logo = GeneralConfig::find(2);
                view()->share('logo', $logo);
            // logo

            // logo
                $logoPutih = GeneralConfig::find(14);
                view()->share('logoPutih', $logoPutih);
            // logo
            // address
                $address = GeneralConfig::find(4);
                view()->share('address', $address);
            // address
            // phone
                $phone = GeneralConfig::find(5);
                view()->share('phone', $phone);
            // phone
            // fax
                $fax = GeneralConfig::find(6);
                view()->share('fax', $fax);
            // fax
            // email
                $email = GeneralConfig::find(7);
                view()->share('email', $email);
            // email
            // solutions
                $solutions  = GeneralConfig::find(12);
                view()->share('solutions', $solutions);
            // solutions
            // distribution
                $distribution  = GeneralConfig::find(13);
                view()->share('distribution', $distribution);
            // map
            // product-category
                $ProdukCategory = ProdukCategory::where('flug_publish', 'Y')->get();
                view()->share('ProdukCategory', $ProdukCategory);
            // product-category
            // product
                $product = Product::where('flug_publish', 'Y')->get();
                view()->share('product', $product);
            // product

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
