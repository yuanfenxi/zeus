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
    return redirect("/config/apps");
    //return view('welcome');
});
Route::group(["prefix" => "config"], function () {
    Route::get("/apps", 'ConfigManager@apps')->name("apps");
    Route::get("/app/v-{id}", 'ConfigManager@appView')->name("app-view");
    Route::get("/app/e-{id}", 'ConfigManager@appEdit')->name("app-edit");
    Route::get("/group/v-{id}",'ConfigManager@groupView')->name("group-view");
    Route::get('/group/e-{id}','ConfigManager@groupEdit')->name("group-edit");
    Route::post('/group/e-{id}','ConfigManager@groupPostEdit')->name("group-post-edit");
    Route::post("/app/e-{id}", 'ConfigManager@appPostEdit')->name("app-post-edit");
    Route::get("/app/vars-{appId}-{groupId}", 'ConfigManager@appVars')->name("app-vars");
    Route::get("/env/app-{appName}-group-{groupName}", 'ConfigManager@appEnv')->name("app-env");
    Route::get("/app/update-{appName}-{groupName}", 'ConfigManager@appUpdateEnv')->name("app-update");
    Route::post("/app/update-{appName}-{groupName}", 'ConfigManager@appUpdateEnvPost')->name("app-post-update");
    Route::get("/app/add", 'ConfigManager@addApp')->name("app-add");
    Route::post("/app/add", 'ConfigManager@postAddApp')->name("app-post-add");
});
