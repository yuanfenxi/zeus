<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("apps",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->softDeletes();
            $table->timestamps();
            $table->string("name",32)->comment("应用的名字");
        });
        Schema::create("groups",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->softDeletes();
            $table->timestamps();

            $table->bigInteger("app_id")->comment("应用的名字");
            $table->string("name",32)->comment("组的名字");

        });
        Schema::create("variables",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->softDeletes();
            $table->timestamps();

            $table->bigInteger("app_id")->comment("应用的id");
            $table->string("name",32)->comment("变量名字");

        });

        Schema::create("values",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->softDeletes();
            $table->timestamps();

            $table->bigInteger("app_id")->comment("应用的id");
            $table->bigInteger("group_id")->comment("变量名字");
            $table->bigInteger("variable_id")->comment("是哪个变量的值");
            $table->string("value",255)->comment("变量的值");
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
        Schema::dropIfExists("apps");
        Schema::dropIfExists("groups");
        Schema::dropIfExists("variables");
        Schema::dropIfExists("values");
    }
}
