<?php

namespace App\Providers;
use App\Models\Phone;
use App\Models\User;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['comments.fields'], function ($view) {
            $phoneItems = Phone::pluck('number','id')->toArray();
            $view->with('phoneItems', $phoneItems);
        });
        View::composer(['comments.fields','phones.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
    }
}
