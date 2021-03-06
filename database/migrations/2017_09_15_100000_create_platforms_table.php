<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platforms', function (Blueprint $table) { // Social Media Platforms/Accounts that I can push blasts/updates/broadcasts to their audiences
            $table->increments('id');
            $table->unsignedInteger('type_id')->index(); // Allows groupings for facebook, twitter, and other types of accounts. Also allows other categories (FB user account)
            $table->unsignedInteger('user_id')->index(); // Essentially the created_by but depending on the type, this could be for the user's account.
            $table->string('title');
            $table->string('username'); // URL on social platform
            $table->string('id_number')->nullable(); // Number used by facebook or twitter for the page
            $table->string('token')->nullable(); // Facebook API token for page
            $table->unsignedInteger('avatar_id')->nullable();
            $table->unsignedInteger('cover_id')->nullable();
            $table->timestamps();
        });

        Schema::table('platforms', function ($table) {
            $table->foreign('type_id')->references('id')->on('types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('avatar_id')->references('id')->on('images')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('cover_id')->references('id')->on('images')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
