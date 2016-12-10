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

Route::group(["prefix" => "config"], function () {
    Route::get("/apps", 'ConfigManager@apps')->name("apps");
    Route::get("/app/v-{id}", 'ConfigManager@apps')->name("app-view");
    Route::get("/app/vars-{appId}-{groupId}", 'ConfigManager@appVars')->name("app-vars");
    Route::get("/env/app-{appName}-group-{groupName}", 'ConfigManager@appEnv')->name("app-env");

    Route::get("/app/add", 'ConfigManager@addApp')->name("app-add");
    Route::post("/app/add", 'ConfigManager@postAddApp')->name("app-post-add");
});
