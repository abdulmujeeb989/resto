<?php
 
use Illuminate\Support\Facades\Route;
use app\Helpers\CommonMethods;
use App\Http\Controllers\FoodCart;
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
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    // return what you want
});
Route::get('/test', 'Home@test');


Route::get('/cmenu', 'Home@cmenu');
Route::get('/resto_menu', 'Home@resto_order');
Route::get('/resto_location', 'Home@resto_location');
Route::get('/error', 'Home@error');
Route::get('/','Home@index')->middleware('cacheable:5');;
Route::get('/home', 'HomeController@index')->middleware('cacheable:5');;
//Route::post('/add_cart', 'Home@add_cart');
Route::post('/add_cart', 'FoodCart@add_cart');
Route::get('/remove_token', 'HomeController@delteToken');
Route::post('/getOrderhtml', 'Home@orderDesign');
Route::get('/checkout', 'Home@checkoutpage');
Route::post('/confirm_order', 'Home@confirm_order');
Route::get('/order_status/{id}', 'Home@order_status_page');
Route::get('/waiter', 'Home@waiter_login_page')->middleware('cacheable:5');;
Route::post('/waiter_login', 'Home@check_waiter_login');
Route::get('/waiter_page', 'Home@waiterPage');

Route::post('/conv_json', 'Home@demo');


Route::post('/getCustomize_sessionss', 'Home@get_customize_session');
Route::post('/getCustomeComponent', 'Home@custome_menu_comp');
/*Route::post('/updatecustomization', 'Home@customization_update');*/
Route::post('/updatecustomization', 'FoodCart@add_cart');
Route::post('/updatelastcustom', 'FoodCart@updateLast');
Route::post('/getCustCart', 'Home@cust_cart_html');
Route::post('/update_custome_cart', 'FoodCart@update_cart_items');


Route::get('/cart_html', function() {   
   $html=CommonMethods::showCartList();
   echo $html;
});

Route::get('/cartprice', function() {   
   $result=FoodCart::getTotalamount();
   echo $result;
});
Route::get('/cartqty', function() {   
   $result=FoodCart::getTotalCount();
   return $result;
});
Route::get('/remove_all_cart', function() {   
   $result=CommonMethods::removeAllitem();
   return $result;
});
Route::get('/changeLang/{lang}', function($lang) {   
   $result=CommonMethods::updateLanguage($lang);
   return $result;
});
Route::get('/test1', function() {   
   $result=CommonMethods::getLang();
   echo $result;
});
Route::get('/updateLanguage', function() {   
   $result=CommonMethods::updateLanguage();
   return $result;
});
Route::post('/getOrderdetails', function() {   
   $result=CommonMethods::orderDetails();
   echo json_encode($result);
});
Route::post('/update_order', function() {   
   $result=CommonMethods::updateOrdersItems();
   echo json_encode($result);
});
Route::post('/addItemsOrder', function() {   
   $result=CommonMethods::addItems_order();
   echo json_encode($result,true);
});
Route::post('/latestlist', function() {   
   $result=CommonMethods::LatestList();
   echo json_encode($result);
});
Route::post('/add_orders', function() {   
   $result=CommonMethods::orderUpdate();
   echo json_encode($result);
});
Route::post('/order_newlist', function() {   
   $result=CommonMethods::latestOrder();
   echo json_encode($result);
});
Route::post('/logout', function() {   
   $result=CommonMethods::logout();
   echo $result;
});




