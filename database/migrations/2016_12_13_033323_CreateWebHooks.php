<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebHooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("web_hooks",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->softDeletes();
            $table->timestamps();

            $table->string("secret",128)->comment("生成的一个随机码,让网址够复杂,跟app_id相关");
            $table->bigInteger("app_id");
            $table->string("hookType",32)->comment("哪种类型的hook,目前只有gogs");
            $table->string("dataType",32)->comment("以哪种类型push数据过来,目前只有json");
        });

        Schema::table("apps",function(Blueprint $table){
            $table->string("git_repo",255)->comment("git仓库地址");
        });
        Schema::table("groups",function(Blueprint $table){
            $table->bigInteger("version")->comment("当前的版本号");
            $table->string("deployPath",255)->comment("发布到哪个路径");
            $table->string("codeBase",255)->comment("该组机器的代码路径");
        });
        Schema::create("hook_events",function(Blueprint $table){
            $table->bigInteger("id");
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger("app_id");
            $table->string("ref",128)->comment("代码分支的名字");
            $table->string("before",64)->comment("提交前的version id");
            $table->string("after",64)->comment("提交后的version id");
            $table->string("compare_url",1024)->comment("两个版本比较的URL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("web_hooks");
        Schema::dropIfExists("hook_events");
        Schema::table("apps",function(Blueprint $table){
           $table->dropColumn(["git_repo"]);
        });
        Schema::table("groups",function(Blueprint $table){
            $table->dropColumn(["version","deployPath","codeBase"]);
        });

    }
}
