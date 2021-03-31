<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('posts', 'PostController');

Route::get('posts/{post}/comments', 'CommentController@index')->name('posts.comments.index');

Route::post('posts/{post}/comments', 'CommentController@store')->name('posts.comments.store');

Route::post('comments/{comment}/replies', 'CommentReplyController@store')->name('comments.comment.store');

