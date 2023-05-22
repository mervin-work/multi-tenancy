<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\Promo\PromoController;
use App\Http\Controllers\Index\DashboardController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::GET('/admin/auth/login', [AuthController::class, 'index'])->name('auth.index');
    Route::POST('/admin/auth/login', [AuthController::class, 'loginUser'])->name('auth.login');

    /**AUTH ROUTES**/
    Route::group(['middleware' => ['auth:sanctum', 'throttle:custom_rate_limiter']], function() {
        Route::group([
            'prefix' => 'admin',
            'as' => 'admin.',
        ], function() {
            /** DASHBOARD ROUTES **/
            Route::get('/', [DashboardController::class, 'index'])->name('index');

            /** USER ROUTES **/
            Route::resource('users', UserController::class);

            /** CATALOG ROUTES **/
            Route::resource('catalogs', CatalogController::class);

            /** PROMO ROUTES **/
            Route::resource('promos', PromoController::class);
        });
    });

    // Route::get('/', function () {
    //     // dd(\App\Models\User::all());
    //     // return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');



    // });
});
