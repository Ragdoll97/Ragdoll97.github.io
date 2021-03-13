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

Route::get('/', 'App\Http\Controllers\ContentController@getHome')->name('home');

// Modulo Tienda->Productos
Route::get('/product/{id}/{slug}','App\Http\Controllers\ProductController@getProduct')->name('product_single');
Route::get('/cart','App\Http\Controllers\CartController@getCart')->name('cart');
Route::get('/cart/add','App\Http\Controllers\CartController@getCartAdd')->name('cart_add');
Route::post('/cart/product/{id}/add','App\Http\Controllers\CartController@postCartAdd')->name('cart_add');
Route::post('/cart/item/{id}/update','App\Http\Controllers\CartController@postCartItemQuantityUpdate')->name('cart_add');
Route::get('/cart/item/{id}/delete','App\Http\Controllers\CartController@getCartItemDelete');


//Modulo Tienda->Categorias
Route::get('/store','App\Http\Controllers\ContentController@getStore')->name('store'); 
Route::get('/store/category/{id}/{slug}','App\Http\Controllers\ContentController@getCategory')->name('store_category'); 
Route::get('/categories/{id}/{slug}','App\Http\Controllers\ContentController@getCategoriesHome'); 
Route::post('/search','App\Http\Controllers\ContentController@postSearch')->name('search'); 




//Ajax Api Routes
Route::get('/md/api/load/products/{section}', 'App\Http\Controllers\ApiJsController@getProductSection');
Route::post('/md/api/load/user/favorites', 'App\Http\Controllers\ApiJsController@postUserFavorites');
Route::post('/md/api/favorites/add/{object}/{module}', 'App\Http\Controllers\ApiJsController@postFavoriteAdd');
Route::post('/md/api/load/product/inventory/{inv}/variants', 'App\Http\Controllers\ApiJsController@postProductInventoryVariant');


//Modulo UserController <--- control pagina principal
Route::get('/account/edit','App\Http\Controllers\UserController@getAccountEdit')->name('account_edit');
Route::post('/account/edit/password','App\Http\Controllers\UserController@postPasswordEdit')->name('password_edit');
Route::post('/account/edit/avatar','App\Http\Controllers\UserController@postAccountAvatar')->name('account_avatar_edit');
Route::post('/account/edit/info','App\Http\Controllers\UserController@postAccountInfo')->name('account_info_edit');
// Ruta de inicio de sesión de usuarios
// Se obtiene el login y permite iniciar sesión en este.
Route::get('/login', 'App\Http\Controllers\ConnectController@getLogin')->name('login');
Route::post('/login', 'App\Http\Controllers\ConnectController@postLogin')->name('login');

// Ruta del registro de usuarios
// Permite obtener los datos de los usuarios y guardarlos en la Base de datos
Route::get('/register', 'App\Http\Controllers\ConnectController@getRegister')->name('register');
Route::post('/register', 'App\Http\Controllers\ConnectController@postRegister')->name('register');

// Cerrar sesion usuario
Route::get('/logout', 'App\Http\Controllers\ConnectController@getLogout')->name('logout');

// Recuperar Contraseña
Route::get('/reset', 'App\Http\Controllers\ConnectController@getReset')->name('reset');
Route::get('/recover', 'App\Http\Controllers\ConnectController@getRecover')->name('recover');
Route::post('/recover', 'App\Http\Controllers\ConnectController@postRecover')->name('recover');
Route::post('/reset', 'App\Http\Controllers\ConnectController@postReset')->name('reset');

//Gestion de admin
Route::prefix('/admin')->group (function(){
    Route::get('/users/{id}/edit', 'App\Http\Controllers\Admin\UserController@getUserEdit')->name('user_edit');
  
    Route::post('/users/{id}/edit', 'App\Http\Controllers\Admin\UserController@postUserEdit')->name('user_edit');
    Route::get('/','App\Http\Controllers\Admin\DashboardController@getDashboard')->name('dashboard');
    Route::get('/users/{status}', 'App\Http\Controllers\Admin\UserController@getUsers')->name('user_list');
    Route::get('/users/{id}/permissions', 'App\Http\Controllers\Admin\UserController@getUserPermissions')->name('user_permissions');
    Route::get('/users/{id}/banned', 'App\Http\Controllers\Admin\UserController@getUserBanned')->name('user_banned');
    Route::post('/users/{id}/permissions', 'App\Http\Controllers\Admin\UserController@postUserPermissions')->name('user_permissions');
   
    //Modulo de productos
    
    Route::get('/products/add', 'App\Http\Controllers\Admin\ProductController@getProductAdd')->name('product_add');
    Route::get('/products/{id}/delete','App\Http\Controllers\Admin\ProductController@getProductDelete')->name('product_delete');
    Route::get('/products/{id}/edit', 'App\Http\Controllers\Admin\ProductController@getProductEdit')->name('product_edit');
    Route::get('/products/{id}/restore','App\Http\Controllers\Admin\ProductController@getProductRestore')->name('product_delete');
    Route::get('/products/{id}/inventory','App\Http\Controllers\Admin\ProductController@getProductInventory')->name('product_inventory');
    Route::get('/products/{id}/gallery/{gid}/delete','App\Http\Controllers\Admin\ProductController@getProductGalleryDelete')->name('product_gallery_delete');
    Route::post('/products/{id}/inventory','App\Http\Controllers\Admin\ProductController@postProductInventory')->name('product_inventory');
    Route::post('/products/search', 'App\Http\Controllers\Admin\ProductController@postProductSearch')->name('product_search');
    Route::post('/products/add', 'App\Http\Controllers\Admin\ProductController@postProductAdd')->name('product_add');
    Route::post('/products/{id}/edit', 'App\Http\Controllers\Admin\ProductController@postProductEdit')->name('product_edit');
    Route::post('/products/{id}/gallery/add', 'App\Http\Controllers\Admin\ProductController@postProductGalleryAdd')->name('product_gallery_add');
    Route::get('/products/{status}', 'App\Http\Controllers\Admin\ProductController@getHome')->name('products');
   
    //Modulo Inventario
    Route::get('/product/inventory/{id}/edit','App\Http\Controllers\Admin\ProductController@getInventoryEdit' )->name('product_inventory');
    Route::post('/product/inventory/{id}/edit','App\Http\Controllers\Admin\ProductController@postInventoryEdit' )->name('product_inventory');
    Route::post('/product/inventory/{id}/variant','App\Http\Controllers\Admin\ProductController@postInventoryVariantAdd' )->name('product_inventory');
    Route::get('/product/inventory/{id}/delete','App\Http\Controllers\Admin\ProductController@getInventoryDelete' )->name('product_inventory');
    Route::get('/product/variant/{id}/delete','App\Http\Controllers\Admin\ProductController@getVariantDelete' )->name('product_inventory');

    //Categorias
    
    Route::get('/categories/{module}','App\Http\Controllers\Admin\CategoriesController@getHome')->name('categories');
    Route::get('/category/{id}/edit','App\Http\Controllers\Admin\CategoriesController@getCategoryEdit')->name('category_edit');
    Route::get('/category/{id}/subs','App\Http\Controllers\Admin\CategoriesController@getSubCategories')->name('category_edit');
    Route::get('/category/{id}/delete','App\Http\Controllers\Admin\CategoriesController@getCategoryDelete')->name('category_delete');
    Route::post('/categories/add/{module}','App\Http\Controllers\Admin\CategoriesController@postCategoryAdd')->name('category_add');
    Route::post('/category/{id}/edit','App\Http\Controllers\Admin\CategoriesController@postCategoryEdit')->name('category_edit');
    
    //Modulo Settings
    Route::get('/settings','App\Http\Controllers\Admin\SettingController@getHome')->name('settings');
    Route::post('/settings','App\Http\Controllers\Admin\SettingController@postHome')->name('settings');
    
    //Modulo Sliders
    Route::get('/sliders','App\Http\Controllers\Admin\SliderController@getHome')->name('sliders');
    Route::post('/slider/add','App\Http\Controllers\Admin\SliderController@postSliderAdd')->name('slider_add');
    Route::get('/slider/{id}/edit','App\Http\Controllers\Admin\SliderController@getEditSlider')->name('slider_edit');
    Route::post('/slider/{id}/edit','App\Http\Controllers\Admin\SliderController@postEditSlider')->name('slider_edit');
    Route::get('/slider/{id}/deleted','App\Http\Controllers\Admin\SliderController@getDeleteSlider')->name('slider_delete');

    //Modulo Cobertura de envíos
    Route::get('/coverage','App\Http\Controllers\Admin\CoverageController@getList')->name('coverage_list');
    
    Route::post('/coverage/state/add','App\Http\Controllers\Admin\CoverageController@postCoverageAdd')->name('coverage_add');
    Route::get('/coverage/{id}/delete','App\Http\Controllers\Admin\CoverageController@getCoverageDelete')->name('coverage_delete');
    Route::post('/coverage/city/add','App\Http\Controllers\Admin\CoverageController@postCoverageCityAdd')->name('coverage_city_add');
    Route::get('/coverage/city/{id}/edit','App\Http\Controllers\Admin\CoverageController@getCityEdit')->name('coverage_edit');
    Route::post('/coverage/city/{id}/edit','App\Http\Controllers\Admin\CoverageController@postCityEdit')->name('coverage_edit');
    Route::get('/coverage/state/{id}/edit','App\Http\Controllers\Admin\CoverageController@getCoverageEdit')->name('coverage_edit');
    Route::post('/coverage/state/{id}/edit','App\Http\Controllers\Admin\CoverageController@postCoverageEdit')->name('coverage_edit');
    Route::get('/coverage/{id}/cities','App\Http\Controllers\Admin\CoverageController@getCity')->name('coverage_delete');

    
    //JavaScript Subcategorias
    Route::get('/md/api/load/subcategories/{parent}', 'App\Http\Controllers\Admin\ApiController@getSubCategories');
    Route::get('/md/api/load/categories/products', 'App\Http\Controllers\Admin\ApiController@getCategoriesProducts');
});