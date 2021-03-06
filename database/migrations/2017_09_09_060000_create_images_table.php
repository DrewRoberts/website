<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename')->unique()->index(); // Includes mime type extension - need to force lowercase
            $table->string('path_prefix');
            $table->unsignedInteger('type_id')->index(); // Allows groupings for image styles, purposes, positions in content, features, etc.
            $table->string('imageable_type')->index();
            $table->unsignedInteger('imageable_id')->index();
            $table->enum('mime', ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'psd']); // need to force lowercase
            $table->string('width');
            $table->string('height');
            $table->string('credits')->nullable();
            $table->string('credits_extra')->nullable(); // This is for an extra note that credits can be expanded to show. Such at date and camera used to take photo
            $table->unsignedInteger('created_by')->default(1)->index();
            $table->unsignedInteger('updated_by')->default(1);
            $table->unsignedInteger('approved_by')->default(1);
            $table->dateTime('approved_at')->nullable()->useCurrent();  // remove useCurrent() later when approval process for user submitted images
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('images', function ($table) {
            $table->foreign('type_id')->references('id')->on('types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
