<?php

Route::group(['prefix' => 'admin/options', 'middleware'=>['web']], function()
{

    Route::get('/list', [
        'as' => 'admin.options.list',
        'uses' => 'OptionsController@getList']);
    /*create*/
    Route::get('/create', [
        'as' => 'admin.options.create',
        'uses' => 'OptionsController@getcreate']);

    Route::post('/create', [
        'as' => 'admin.options.create',
        'uses' => 'OptionsController@postcreate']);
    /*update*/
    Route::get('/update', [
        'as' => 'admin.options.update',
        'uses' => 'OptionsController@getupdate']);

    Route::post('/update', [
        'as' => 'admin.options.update',
        'uses' => 'OptionsController@postupdate']);

    Route::post('/layout', [
        'as' => 'admin.options.layout',
        'uses' => 'OptionsController@getlayout']);

    Route::get('/field', [
        'as' => 'admin.options.field',
        'uses' => 'OptionsController@getfield']);

    Route::get('/delete/{id}', [
        'as' => 'admin.options.delete',
        'uses' => 'OptionsController@getdelete']);
});
