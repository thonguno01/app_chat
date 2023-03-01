<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Controller;
use App\Http\Controllers\User\LoginController;
use Illuminate\Http\Request;

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

// Route::get('/', function () {
//     echo 1;
// });
Route::get('/', 'HomeController@index');
Route::get('/login', 'User\LoginController@index')->name('login');
Route::post('/login', 'User\LoginController@login')->name('login.post');


Route::get('/register', 'User\RegisterController@index')->name('register');
Route::post('/register', 'User\RegisterController@registerUser')->name('register.post');
Route::get('/email-verify/{id}', 'User\RegisterController@verify')->name('verify.user');
Route::post('/email-verify/{id}', 'User\RegisterController@verifyOTP')->name('verify.user.post');

Route::get('/logout', 'User\LoginController@logout')->name('logout');
// tin nhắn 
Route::get('/chat', 'Chat\ChatController@index')->name('home.chat');
Route::get('/chat/{id}', 'Chat\ChatController@chat')->name('chat.message');
Route::post('/chat/sendMessage', 'Chat\ChatController@sendMessage')->name('chat.post.message');

Route::post('/search-user', 'Chat\SearchController@searchUser')->name('search.list.user');


//Ajax
Route::post('/get-image-message', 'AjaxController@getImageMessage');
