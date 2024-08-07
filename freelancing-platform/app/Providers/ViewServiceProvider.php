<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using view composer to share data across multiple views
        View::composer('*', function ($view) {
            $user = Auth::user();
            $unreadNotifications = $user ? $user->notifications()->where('is_read', false)->count() : 0;
            $notifications = $user ? $user->notifications()->latest()->take(5)->get() : collect([]);
            $view->with('unreadNotifications', $unreadNotifications)
                 ->with('notifications', $notifications);
        });
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
