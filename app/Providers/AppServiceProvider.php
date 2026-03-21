<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SocialLink;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $wishlistCount = 0;

            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }

            $cartCount = 0;
            if (Auth::check() && Auth::user()->role === 'student') {
                $cartCount = Cart::where('user_id', Auth::id())->count();
            }

            $view->with([
                'sliders' => Slider::where('status', '0')->get(),
                'setting' => Setting::first(),
                'socialLinks' => SocialLink::where('status', true)->get(),
                'categories' => Category::all(),
                'wishlistCount' => $wishlistCount,
                'cartCount' => $cartCount,
            ]);
        });
    }
}
