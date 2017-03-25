<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("hosts",function(Blueprint $table){
            $table->bigIncrements("id")->comment("主键");

            $table->timestamps();

            $table->string("hostname",128)->comment("主机名");
            $table->string("agentUser",32)->comment("打通ssh登陆的用户名");
            $table->string("agentPath",255)->comment("在该机器的zeus的部署路径");

            $table->unique('hostname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("hosts");
    }
}
