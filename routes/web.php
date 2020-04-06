<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('citizens')->name('citizens/')->group(static function() {
            Route::get('/',                                             'CitizensController@index')->name('index');
            Route::get('/create',                                       'CitizensController@create')->name('create');
            Route::post('/',                                            'CitizensController@store')->name('store');
            Route::get('/{citizen}/edit',                               'CitizensController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CitizensController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{citizen}',                                   'CitizensController@update')->name('update');
            Route::delete('/{citizen}',                                 'CitizensController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('officers')->name('officers/')->group(static function() {
            Route::get('/',                                             'OfficersController@index')->name('index');
            Route::get('/create',                                       'OfficersController@create')->name('create');
            Route::post('/',                                            'OfficersController@store')->name('store');
            Route::get('/{officer}/edit',                               'OfficersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'OfficersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{officer}',                                   'OfficersController@update')->name('update');
            Route::delete('/{officer}',                                 'OfficersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('reports')->name('reports/')->group(static function() {
            Route::get('/',                                             'ReportsController@index')->name('index');
            Route::get('/create',                                       'ReportsController@create')->name('create');
            Route::post('/',                                            'ReportsController@store')->name('store');
            Route::get('/{report}/edit',                                'ReportsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ReportsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{report}',                                    'ReportsController@update')->name('update');
            Route::delete('/{report}',                                  'ReportsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('replies')->name('replies/')->group(static function() {
            Route::get('/',                                             'RepliesController@index')->name('index');
            Route::get('/create',                                       'RepliesController@create')->name('create');
            Route::post('/',                                            'RepliesController@store')->name('store');
            Route::get('/{reply}/edit',                                 'RepliesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RepliesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{reply}',                                     'RepliesController@update')->name('update');
            Route::delete('/{reply}',                                   'RepliesController@destroy')->name('destroy');
        });
    });
});

Route::prefix('officer')->namespace('Officer\Auth')->group(static function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('officer/login');
    Route::post('/login', 'LoginController@login');
    Route::any('/logout', 'LoginController@logout')->name('officer/logout');
});

Route::middleware(['auth:' . config('officer-auth.defaults.guard'), 'officer'])->group(static function () {
    Route::prefix('officer')->namespace('Officer')->name('officer/')->group(static function () {
        Route::get('/', 'OfficerHomepageController@index');
        Route::get('/profile', 'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile', 'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password', 'ProfileController@editPassword')->name('edit-password');
        Route::post('/password', 'ProfileController@updatePassword')->name('update-password');
    });
});

Route::middleware(['auth:' . config('officer-auth.defaults.guard'), 'officer'])->group(static function () {
    Route::prefix('officer')->namespace('Officer')->name('officer/')->group(static function () {
        Route::prefix('reports')->name('reports/')->group(static function () {
            Route::get('/', 'ReportsController@index')->name('index');
            Route::get('/{report}', 'ReportsController@show')->name('show');
            Route::get('/{report}/edit', 'ReportsController@edit')->name('edit');
            Route::post('/{report}', 'ReportsController@update')->name('update');
        });
    });
});
