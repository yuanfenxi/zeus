<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppInNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("app_instances", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger("app_id");
            $table->bigInteger("node_id");
            $table->string("instance_name", 128)->comment("运行时的实例名字");
            $table->bigInteger("port")->default(0)->comment("在哪个端口上运行");
            $table->string("status", 32)->nullable()->comment("状态，是否在线;running表示在线");
            $table->bigInteger("last_check_at")->default(0)->comment("上次检查时间");
            $table->unique(["node_id", "port"]);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("app_instances");
    }
}
