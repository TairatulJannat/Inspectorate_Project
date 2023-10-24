<?php

use App\Http\Controllers\Admin\AdminDashboarController;
use App\dynamic_route;
use App\Http\Controllers\website\WebsiteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/clear_cache', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'Clear Cache';
});


Route::group(['prefix'=>'admin'],function () {
    Auth::routes(['register' => false]);
});



Route::post('/admin_logout', [AdminDashboarController::class, 'admin_logout'])->name('admin_logout');

Route::middleware(['auth', 'routeprifix'])->prefix('{roleBased}')->group(function () {
    Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
        foreach (dynamic_route::where('route_status', 1)->get() as $value) {
            if ($value->method == 'get') {
                Route::get($value->url . '/' . $value->parameter, $value->controller_action . '@' . $value->function_name)->name($value->url);
            } else {
                Route::Post($value->url . '/' . $value->parameter, $value->controller_action . '@' . $value->function_name)->name($value->url);
            }
        }
    });
});



