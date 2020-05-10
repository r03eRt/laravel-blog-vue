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


// para ver llamadas a base de datos de eloquent
//DB::listen(function($query) {
//    var_dump($query->sql);
//});




// FRONT ROUTES

Route::get('/', 'PagesController@inicio')->name('pages.inicio');
Route::get('about', 'PagesController@nosotros')->name('pages.nosotros');
Route::get('archive', 'PagesController@archivo')->name('pages.archivo');
Route::get('contact', 'PagesController@contacto')->name('pages.contacto');

Route::get('blog/{post}', 'PostsController@show')->name('posts.show');
Route::get('categorias/{category}', 'CategoriesController@show')->name('categories.show');
Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');


Route::get('posts', function() {
    return App\Post::all();
});

//activa todas las rutas de auth
//Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');






// DASHBOARD ROUTES

// Con grupos y con prefix y namespace no tenemos que poner las rutas completas ni el namespace a todas las subrutas
// ni el middleware auth
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::get('/', 'AdminController@index')->name('admin');
    //Crea rutas auromaticas para login
    //Route::auth();

    //Si queremos utilizar toda las llamadas rest podemos usar Resource
    //Route::resource('posts', 'PostsController', ['except' => 'show', 'as' => 'admin']);

    //sin grupo
    //Route::get('admin/posts', 'Admin\PostsController@index')->middleware('auth');
    //con grupo
    Route::get('posts', 'PostsController@index')->name('admin.posts.index');
    Route::post('posts', 'PostsController@store')->name('admin.posts.store');
    Route::get('posts/create', 'PostsController@create')->name('admin.posts.create');
    Route::get('posts/{post}', 'PostsController@edit')->name('admin.posts.edit');
    Route::put('posts/{post}', 'PostsController@update')->name('admin.posts.update');
    Route::post('posts/{post}', 'PostsController@store2')->name('admin.posts.create2');
    Route::post('posts/{post}/photos', 'PhotosController@store')->name('admin.photos.store');
    Route::delete('posts/{post}', 'PostsController@destroy')->name('admin.posts.destroy');
    Route::delete('photos/{photo}', 'PhotosController@destroy')->name('admin.photos.destroy');

    Route::resource('users', 'UsersController', ['as' => 'admin']);
    Route::resource('roles', 'RolesController', ['except' => 'show', 'as' => 'admin']);
    Route::resource('permissions', 'PermissionsController', ['only' => ['index', 'edit', 'update'], 'as' => 'admin']);





    //    Esta forma es antes de de usar los middleware para acceder a rutas,
    //    // Ruta para actualizar roles
    //    Route::put('users/{user}/roles', 'UsersRolesController@update')->name('admin.users.roles.update');
    //    //Ruta para actulizar permisos
    //    Route::put('users/{user}/permissions', 'UsersPermissionsController@update')->name('admin.users.permissions.update');

    //     Para utilizar middleware con roles y permisos vamos al fichero y añadimos en el array de $routeMiddleware
    //     Users/robertomorgadoluengo/work/code/laravel-blog-vue/app/Http/Kernel.php
    //    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    //    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    //
    // Solo puede editar roles el admin
    Route::middleware('role:Admin')->put('users/{user}/roles', 'UsersRolesController@update')->name('admin.users.roles.update');
    Route::middleware('role:Admin')->put('users/{user}/permissions', 'UsersPermissionsController@update')->name('admin.users.permissions.update');


});

// Hacemos una ruta para mail par poder testear como va a quedar y le pasamos el primer usuario
Route::get('email', function() {
   return new App\Mail\LoginCredentials(App\User::first(), 'asd123');
});

Route::get('test', function()
{
    dd(Config::get('mail'));
});
