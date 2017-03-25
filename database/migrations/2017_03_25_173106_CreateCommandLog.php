<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("command_logs",function(Blueprint $table){
            $table->bigIncrements("id")->comment("主键,自增的");
            $table->softDeletes();
            $table->timestamps();

            $table->text("command")->comment("执行过的命令");
            $table->text("output")->comment("执行命令的输出");
            $table->integer("result")->comment("命令返回的结果（$?值）");
            $table->string("email",128)->comment("执行命令人的email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("command_logs");
    }
}
