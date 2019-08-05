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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* 게시판 */
Route::resource('boards', 'BoardsController');

/* 업로드 */
Route::resource('boards/upload', 'BoardFilesController')->only('store', 'destroy');

/* 파일 다운로드 */
Route::get('boards/download/{id}', ['as' => 'boards.download', 'uses' => 'BoardFilesController@download']);

/* 댓글 */
Route::resource('boards/{id}/comments', 'CommentsController')->only('store', 'update', 'destroy');
Route::delete('boards/{id}/comments/forceDestroy/{comment}', ['as' => 'comments.forceDestroy', 'uses' => 'CommentsController@forceDestroy']);
