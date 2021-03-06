<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) { // Various products or services that I recommend. Products do not have own url, but are expanded sections on recommendation pages. Can be included in more than 1 recommendation.
            $table->increments('id');
            $table->unsignedInteger('brand_id')->nullable()->index(); // If brand created, then assign here
            $table->string('title')->unique(); // Name of product for display
            $table->string('description'); // Short excerpt shown before expanded for full content. Only when product included in non-product recommendation.
            $table->unsignedInteger('image_id')->nullable(); // path to edited cover image for the recommendation
            $table->unsignedInteger('video_id')->nullable(); // If video, then include the video id here.
            $table->unsignedInteger('type_id')->nullable(); // Use for primary grouping of products by types. Can use other categories as well
            $table->date('launched')->nullable(); // Estimated date when product first available.
            $table->date('expired')->nullable();
            $table->text('content')->nullable(); // Expanded content section when multiple products included in recommendation. Main article when is a product recommendation.
            $table->string('website')->nullable()->unique(); // URL of external webpage for users to purchase product. Will include affiliate code from brand.
            $table->string('amazon')->nullable()->unique(); // Amazon link to purchase product with View Price button. Will include affiliate code for Amazon.
            $table->string('facebook')->nullable()->unique(); // Username if product has own facebook page
            $table->string('instagram')->nullable()->unique(); // Username if product has own instagram account
            $table->string('twitter')->nullable()->unique(); // Username if product has own twitter account
            $table->string('youtube')->nullable()->unique(); // Username if product has own YouTube channel
            $table->unsignedInteger('created_by')->default(1);
            $table->unsignedInteger('updated_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('products', function ($table) {
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }
}
