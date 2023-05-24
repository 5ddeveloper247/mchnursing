<?php


use Illuminate\Support\Facades\Route;

Route::prefix('manage')->middleware(['auth'])->group(function () {
    Route::get('blogs', 'BlogController@index')->name('blogs.index')->middleware('RoutePermissionCheck:blogs.index');
    Route::post('blogs', 'BlogController@store')->name('blogs.store')->middleware('RoutePermissionCheck:blogs.store');
    Route::get('blogs/create', 'BlogController@create')->name('blogs.create')->middleware('RoutePermissionCheck:blogs.store');
    Route::get('blogs/edit/{id}', 'BlogController@edit')->name('blogs.edit')->middleware('RoutePermissionCheck:blogs.update');
    Route::post('blogs/update', 'BlogController@update')->name('blogs.update')->middleware('RoutePermissionCheck:blogs.update');
    Route::post('blogs/destroy', 'BlogController@destroy')->name('blogs.destroy')->middleware('RoutePermissionCheck:blogs.destroy');

    Route::get('blog-category', 'BlogCategoryController@index')->name('blog-category.index')->middleware('RoutePermissionCheck:blog-category.index');
    Route::post('blog-category', 'BlogCategoryController@store')->name('blog-category.store')->middleware('RoutePermissionCheck:blog-category.store');
    Route::get('blog-category/{id}', 'BlogCategoryController@edit')->name('blog-category.edit')->middleware('RoutePermissionCheck:blog-category.update');
    Route::post('blog-category/update', 'BlogCategoryController@update')->name('blog-category.update')->middleware('RoutePermissionCheck:blog-category.update');
    Route::get('blog-category/destroy/{id}', 'BlogCategoryController@destroy')->name('blog-category.destroy')->middleware('RoutePermissionCheck:blog-category.destroy');
});

