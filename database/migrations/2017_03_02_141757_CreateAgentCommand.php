<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentCommand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("agent_commands",function(Blueprint $table){
            $table->bigIncrements("id");
            $table->softDeletes();
            $table->timestamps();

            $table->string("hostname",255)->comment("主机名");
            $table->string("command",255)->comment("执行的命令");
            $table->text("output")->comment("命令的输出");
            $table->integer("result")->comment("命令的返回结果");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("agent_commands");
    }
}
