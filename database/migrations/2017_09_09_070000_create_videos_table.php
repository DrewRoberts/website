<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) { // Organizational and data purposes only. No frontend url unless used in a Post (Tutorial, Trailer, Clip, Extra)
            $table->increments('id');
            $table->unsignedInteger('type_id')->index(); // Allows groupings for video sources (YouTube, FB, Vimeo), styles, purposes, positions in content, features, etc.
            $table->string('slug')->unique()->index(); // Used for video's URL on our frontend.
            $table->string('name')->unique()->index(); // Name = Identifier on external source. Depending on type, it should be the Youtube, Facebook or Vimeo ID and the slug if video is on our server.
            $table->string('title')->nullable(); // What we call the video, not title on external source.
            $table->string('description')->nullable();
            $table->integer('views')->default(0)->unsigned()->index(); // Total views on our created YouTube or other videos. Updated periodically.
            $table->string('videoable_type')->index();
            $table->unsignedInteger('videoable_id')->index();
            $table->unsignedInteger('created_by')->default(1)->index();
            $table->unsignedInteger('updated_by')->default(1);
            $table->unsignedInteger('approved_by')->default(1);
            $table->dateTime('approved_at')->nullable()->useCurrent();  // remove useCurrent() later when approval process finalized
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('videos', function ($table) {
            $table->foreign('type_id')->references('id')->on('types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
