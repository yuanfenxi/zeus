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
});
Route::get("/env/{appName}/{groupName}", 'ConfigManager@appEnv')->name("app-env");
Route::get("/user", 'ConfigManager@user')->name("user");
Route::group(["prefix" => "config"], function () {
    Route::get("/apps", 'ConfigManager@apps')->name("apps");
    Route::get("/app/v-{id}", 'ConfigManager@appView')->name("app-view");
    Route::get("/app/e-{id}", 'ConfigManager@appEdit')->name("app-edit");
    Route::get("/app/remove-{id}", 'ConfigManager@appRemove')->name("app-remove");
    Route::get("/group/v-{id}", 'ConfigManager@groupView')->name("group-view");
    Route::get('/group/e-{id}', 'ConfigManager@groupEdit')->name("group-edit");
    Route::post('/group/e-{id}', 'ConfigManager@groupPostEdit')->name("group-post-edit");
    Route::post("/app/e-{id}", 'ConfigManager@appPostEdit')->name("app-post-edit");
    Route::get("/app/vars-{appId}-{groupId}", 'ConfigManager@appVars')->name("app-vars");
    Route::get("/group/view-env-{appName}-{groupName}", 'ConfigManager@groupViewEnv')->name("group-view-env");
    Route::post("/app/update-{appName}-{groupName}", 'ConfigManager@appUpdateEnvPost')->name("app-post-update");
    Route::get("/app/add", 'ConfigManager@addApp')->name("app-add");
    Route::post("/app/add", 'ConfigManager@postAddApp')->name("app-post-add");
    Route::get("/group/update-code/{id}", 'ConfigManager@groupUpdateCode')->name("group-update-code");
    Route::get("/group/deploy-code/{id}", 'ConfigManager@groupDeployCode')->name("group-deploy-code");
    Route::get("/group/read-env/{id}", 'ConfigManager@groupReadEnv')->name("group-read-env");
    Route::get("/group/view-env/{id}", 'ConfigManager@groupViewEnv')->name("group-edit-env");
    Route::post("/post-env/{id}",'ConfigManager@postEnv')->name('group-post-env');
    Route::get("/diff/{id}",'ConfigManager@diffEnv')->name('group-diff-env');
    Route::get("/write-env/{id}",'ConfigManager@writeRemote')->name('group-write-remote-env');
});
Route::group(['prefix' => "agent"], function () {
    Route::get("/report", 'Agent@report')->name("agent-report");
});

Route::group(['prefix'=>'host'],function(){
    Route::get("/create",'HostManageController@create');
    Route::post("/create",'HostManagerController@postCreate');
    Route::get("/edit/{id}",'HostManageController@edit');
    Route::post("/edit/{id}",'HostManagerController@postEdit');
    Route::get("/index",'HostManagerController@index');
    Route::get("/remove/{id}",'HostManagerController@remove');

});

Route::group(['prefix'=>'logs'],function(){

    Route::get("/index",'LogController@index');
});

Route::group(['prefix' => 'node'], function () {

    Route::get("/index", 'NodeController@index')->name("node-index");
    Route::get("/new", 'NodeController@create')->name("node-create");
    Route::post("/post", 'NodeController@post')->name("node-post");
    Route::get("/view/{id}", 'NodeController@view')->name("node-view");
});