<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stories', function (Blueprint $table) {
            $table->uuid("id");
            $table->timestamps();
            $table->string("story");
            $table->string("author");
            $table->string("demo")->nullable();
            $table->integer("estimation")->nullable();
            $table->integer("seq")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stories');
    }
}
