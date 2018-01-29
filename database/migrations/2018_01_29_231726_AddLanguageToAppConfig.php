<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguageToAppConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("apps", function (Blueprint $table) {
            $table->string("language", 32)->nullable()->default("php")->comment("语言种类,有nodejs,php,java,other等四种。");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("apps", function (Blueprint $table) {
            $table->dropColumn(["language"]);
        });
    }
}
