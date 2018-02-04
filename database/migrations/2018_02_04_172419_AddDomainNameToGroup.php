<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDomainNameToGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("groups", function (Blueprint $table) {
            $table->string("domainName", 128)->nullable()->default("")->comment("对外以哪个域名提供服务");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("groups", function (Blueprint $table) {
            $table->dropColumn(["domainName"]);
        });
    }
}
