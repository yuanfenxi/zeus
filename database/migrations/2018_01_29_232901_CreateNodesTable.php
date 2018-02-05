<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("nodes", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->string("ip", 20)->comment("IP地址");
            $table->string("status", 16)->nullable()->default("offline")->comment("是否在线，默认offline,可以修改为online");
            $table->string("colo", 32)->nullable()->default("bj")->comment("是哪个集群");
            $table->bigInteger("minPort")->default(5000)->comment("可以拿来分配的最小端口");
            $table->bigInteger("maxPort")->default(10000)->comment("可以拿来分配的最大端口");
            $table->unique("ip");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("nodes");
    }
}
