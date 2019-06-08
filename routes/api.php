<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->middleware('cors')->group(function () {

    Route::post('/users','UserController@store')->name('users.store');
    Route::post('/login','UserController@login')->name('users.login');
    Route::get('/users','UserController@index')->name('users.index');
    //查询单个用户 以及发布文章总数
    Route::get('/userinfo/{user}','UserController@userinfo')->name('user.info');
    Route::get('/users/{user}','UserController@show')->name('users.show');

    //查询单个用户下面的所有文章
    Route::get('/userarticle/{user}','UserController@UserArticle')->name('user.Article');
    //查看所有话题
    Route::get('/topics','TopicController@index')->name('topic.index');
    //创建话题
    Route::post('topics','TopicController@store')->name('topic.store');
    //查询单条文章
    Route::get('/article/{articles}','ArticleController@index')->name('article.index');
    //查出文章下面的评论
    Route::get('/comment/{article}','CommentController@show')->name('comment.show');
    Route::middleware('api.refresh')->group(function () {
        Route::get('/users/info','UserController@info')->name('users.info');
        //修改个人资料
        Route::post('/users/{user}','UserController@update')->name('users.update');
        Route::post('/upload/avatar','UserController@UploadAvatar')->name('users.avatar');
        Route::post('/password','UserController@Paword')->name('users.password');
        //创建文章
        Route::post('/article','ArticleController@store')->name('article.store');
        //修改文章
        Route::post('/article/{articles}','ArticleController@update')->name('article.update');
        Route::delete('/article/{articles}','ArticleController@delete')->name('article.delete');
        //点赞文章
        Route::get('/article/like/{articles}','ArticleController@ArticleLike')->name('article.like');
        //取消点赞
        Route::get('/article/cancelike/{articles}','ArticleController@CancelLike')->name('like.cance');
        //评论
        Route::post('/comment/{article}','CommentController@articleStore')->name('article.comment');
    });
});
